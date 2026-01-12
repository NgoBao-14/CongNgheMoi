<?php
/**
 * RSA Key Exchange Helper
 * Dùng để trao đổi AES Key an toàn giữa Client và Server
 * 
 * Luồng:
 * 1. Server tạo cặp RSA key (public/private)
 * 2. Client lấy public key từ server
 * 3. Client tạo AES key ngẫu nhiên, mã hóa bằng RSA public key
 * 4. Server giải mã bằng RSA private key → có AES key
 * 5. Cả 2 dùng AES key để mã hóa dữ liệu
 */

class RSAKeyExchange {
    
    private $privateKeyPath;
    private $publicKeyPath;
    private $keySize = 2048;
    
    public function __construct() {
        // Lưu key trong thư mục private (không public)
        $this->privateKeyPath = __DIR__ . '/keys/private_key.pem';
        $this->publicKeyPath = __DIR__ . '/keys/public_key.pem';
        
        // Tạo thư mục keys nếu chưa có
        $keysDir = __DIR__ . '/keys';
        if (!is_dir($keysDir)) {
            mkdir($keysDir, 0700, true);
        }
    }
    
    /**
     * Tạo cặp RSA key mới (chỉ chạy 1 lần khi setup)
     */
    public function generateKeyPair() {
        $config = array(
            "digest_alg" => "sha256",
            "private_key_bits" => $this->keySize,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        
        // Tạo key pair
        $res = openssl_pkey_new($config);
        
        if (!$res) {
            throw new Exception("Không thể tạo RSA key: " . openssl_error_string());
        }
        
        // Lấy private key
        openssl_pkey_export($res, $privateKey);
        
        // Lấy public key
        $publicKeyDetails = openssl_pkey_get_details($res);
        $publicKey = $publicKeyDetails["key"];
        
        // Lưu vào file
        file_put_contents($this->privateKeyPath, $privateKey);
        file_put_contents($this->publicKeyPath, $publicKey);
        
        // Bảo vệ private key
        chmod($this->privateKeyPath, 0600);
        
        return array(
            'public_key' => $publicKey,
            'message' => 'RSA key pair đã được tạo thành công'
        );
    }
    
    /**
     * Lấy Public Key để gửi cho Client
     */
    public function getPublicKey() {
        if (!file_exists($this->publicKeyPath)) {
            $this->generateKeyPair();
        }
        return file_get_contents($this->publicKeyPath);
    }
    
    /**
     * Lấy Private Key (chỉ dùng nội bộ server)
     */
    private function getPrivateKey() {
        if (!file_exists($this->privateKeyPath)) {
            throw new Exception("Private key không tồn tại. Chạy generateKeyPair() trước.");
        }
        return file_get_contents($this->privateKeyPath);
    }
    
    /**
     * Giải mã AES Key được mã hóa bằng RSA Public Key
     * Client gửi: RSA_Encrypt(AES_KEY, PublicKey)
     * Server giải: RSA_Decrypt(encrypted, PrivateKey) → AES_KEY
     */
    public function decryptAESKey($encryptedAESKey) {
        $privateKey = $this->getPrivateKey();
        
        // Decode base64
        $encrypted = base64_decode($encryptedAESKey);
        
        // Giải mã bằng private key
        $decrypted = '';
        $success = openssl_private_decrypt($encrypted, $decrypted, $privateKey, OPENSSL_PKCS1_OAEP_PADDING);
        
        if (!$success) {
            throw new Exception("Không thể giải mã AES key: " . openssl_error_string());
        }
        
        return $decrypted;
    }
    
    /**
     * Mã hóa dữ liệu bằng RSA Public Key (dùng để test)
     */
    public function encryptWithPublicKey($data) {
        $publicKey = $this->getPublicKey();
        
        $encrypted = '';
        $success = openssl_public_encrypt($data, $encrypted, $publicKey, OPENSSL_PKCS1_OAEP_PADDING);
        
        if (!$success) {
            throw new Exception("Không thể mã hóa: " . openssl_error_string());
        }
        
        return base64_encode($encrypted);
    }
}

/**
 * Session Key Manager
 * Quản lý AES key cho mỗi session/user
 */
class SessionKeyManager {
    
    private $db;
    
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    
    /**
     * Lưu AES key cho session
     */
    public function storeSessionKey($sessionId, $aesKey, $aesIv, $userId = null) {
        $sessionId = mysqli_real_escape_string($this->db, $sessionId);
        $aesKeyHash = hash('sha256', $aesKey); // Lưu hash để verify, không lưu key thật
        $aesKeyEncrypted = base64_encode(openssl_encrypt($aesKey, 'AES-256-CBC', 
            getenv('MASTER_KEY') ?: 'default_master_key_change_this', 
            OPENSSL_RAW_DATA, 
            substr(hash('sha256', 'iv_salt'), 0, 16)));
        $aesIvEncrypted = base64_encode($aesIv);
        $expiry = date('Y-m-d H:i:s', time() + 3600); // 1 giờ
        
        $sql = "INSERT INTO session_keys (session_id, aes_key_encrypted, aes_iv, user_id, expires_at, created_at) 
                VALUES ('$sessionId', '$aesKeyEncrypted', '$aesIvEncrypted', " . ($userId ? "'$userId'" : "NULL") . ", '$expiry', NOW())
                ON DUPLICATE KEY UPDATE 
                aes_key_encrypted = '$aesKeyEncrypted', 
                aes_iv = '$aesIvEncrypted',
                expires_at = '$expiry'";
        
        return mysqli_query($this->db, $sql);
    }
    
    /**
     * Lấy AES key từ session
     */
    public function getSessionKey($sessionId) {
        $sessionId = mysqli_real_escape_string($this->db, $sessionId);
        
        $sql = "SELECT aes_key_encrypted, aes_iv FROM session_keys 
                WHERE session_id = '$sessionId' AND expires_at > NOW()";
        $result = mysqli_query($this->db, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $aesKey = openssl_decrypt(
                base64_decode($row['aes_key_encrypted']), 
                'AES-256-CBC',
                getenv('MASTER_KEY') ?: 'default_master_key_change_this',
                OPENSSL_RAW_DATA,
                substr(hash('sha256', 'iv_salt'), 0, 16)
            );
            return array(
                'key' => $aesKey,
                'iv' => base64_decode($row['aes_iv'])
            );
        }
        
        return null;
    }
    
    /**
     * Xóa session key hết hạn
     */
    public function cleanupExpiredKeys() {
        $sql = "DELETE FROM session_keys WHERE expires_at < NOW()";
        return mysqli_query($this->db, $sql);
    }
}
?>
