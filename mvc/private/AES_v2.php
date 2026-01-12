<?php
/**
 * AES v2 - Hỗ trợ Dynamic Key Exchange
 * 
 * Khác biệt với AES v1:
 * - v1: Key cố định (hardcode)
 * - v2: Key được trao đổi qua RSA, mỗi session có key riêng
 */

class AESv2 {
    
    private $key;
    private $iv;
    private $sessionId;
    
    /**
     * Constructor với session-based key
     * @param string $sessionId - Session ID từ key exchange
     */
    public function __construct($sessionId = null) {
        $this->sessionId = $sessionId;
        
        if ($sessionId) {
            $this->loadSessionKey($sessionId);
        }
    }
    
    /**
     * Load key từ session
     */
    private function loadSessionKey($sessionId) {
        $sessionFile = __DIR__ . '/sessions/' . $sessionId . '.json';
        
        if (!file_exists($sessionFile)) {
            throw new Exception("Session không tồn tại hoặc đã hết hạn");
        }
        
        $sessionData = json_decode(file_get_contents($sessionFile), true);
        
        // Kiểm tra hết hạn
        if (time() > $sessionData['expires_at']) {
            unlink($sessionFile); // Xóa session hết hạn
            throw new Exception("Session đã hết hạn");
        }
        
        $this->key = base64_decode($sessionData['aes_key']);
        $this->iv = base64_decode($sessionData['aes_iv']);
    }
    
    /**
     * Set key thủ công (dùng khi không có session)
     */
    public function setKey($key, $iv) {
        $this->key = $key;
        $this->iv = $iv;
    }
    
    /**
     * Mã hóa dữ liệu
     */
    public function encrypt($plaintext) {
        if (!$this->key || !$this->iv) {
            throw new Exception("Chưa có key. Gọi loadSessionKey() hoặc setKey() trước.");
        }
        
        $encrypted = openssl_encrypt(
            $plaintext,
            'AES-256-CBC',
            $this->key,
            OPENSSL_RAW_DATA,
            $this->iv
        );
        
        return base64_encode($encrypted);
    }
    
    /**
     * Giải mã dữ liệu
     */
    public function decrypt($ciphertext) {
        if (!$this->key || !$this->iv) {
            throw new Exception("Chưa có key. Gọi loadSessionKey() hoặc setKey() trước.");
        }
        
        $decoded = base64_decode($ciphertext);
        
        $decrypted = openssl_decrypt(
            $decoded,
            'AES-256-CBC',
            $this->key,
            OPENSSL_RAW_DATA,
            $this->iv
        );
        
        if ($decrypted === false) {
            throw new Exception("Giải mã thất bại - key không đúng hoặc dữ liệu bị corrupt");
        }
        
        return $decrypted;
    }
    
    /**
     * Mã hóa với IV ngẫu nhiên (an toàn hơn)
     * IV được prepend vào ciphertext
     */
    public function encryptWithRandomIV($plaintext) {
        if (!$this->key) {
            throw new Exception("Chưa có key.");
        }
        
        // Tạo IV ngẫu nhiên cho mỗi lần mã hóa
        $randomIV = random_bytes(16);
        
        $encrypted = openssl_encrypt(
            $plaintext,
            'AES-256-CBC',
            $this->key,
            OPENSSL_RAW_DATA,
            $randomIV
        );
        
        // Prepend IV vào ciphertext
        return base64_encode($randomIV . $encrypted);
    }
    
    /**
     * Giải mã với IV trong ciphertext
     */
    public function decryptWithRandomIV($ciphertext) {
        if (!$this->key) {
            throw new Exception("Chưa có key.");
        }
        
        $decoded = base64_decode($ciphertext);
        
        // Tách IV (16 bytes đầu) và ciphertext
        $iv = substr($decoded, 0, 16);
        $encrypted = substr($decoded, 16);
        
        $decrypted = openssl_decrypt(
            $encrypted,
            'AES-256-CBC',
            $this->key,
            OPENSSL_RAW_DATA,
            $iv
        );
        
        if ($decrypted === false) {
            throw new Exception("Giải mã thất bại");
        }
        
        return $decrypted;
    }
    
    /**
     * Tạo AES key ngẫu nhiên
     */
    public static function generateKey() {
        return random_bytes(32); // 256 bits
    }
    
    /**
     * Tạo IV ngẫu nhiên
     */
    public static function generateIV() {
        return random_bytes(16); // 128 bits
    }
}

/**
 * Helper function để dùng nhanh
 */
function getAESv2FromSession($sessionId) {
    return new AESv2($sessionId);
}
?>
