<?php
/**
 * API: Trao đổi AES Key
 * 
 * Luồng:
 * 1. Client tạo AES key + IV ngẫu nhiên
 * 2. Client mã hóa AES key bằng RSA Public Key
 * 3. Client gửi encrypted AES key + IV lên API này
 * 4. Server giải mã bằng RSA Private Key
 * 5. Server lưu AES key vào session
 * 6. Server trả về session_id để client dùng cho các request sau
 */

header("Content-Type: application/json; charset=UTF-8");

require_once("../Bridge.php");
require_once("../private/RSA.php");

try {
    // Lấy dữ liệu từ request
    $encryptedAESKey = $_POST['encrypted_aes_key'] ?? $_GET['encrypted_aes_key'] ?? '';
    $aesIv = $_POST['aes_iv'] ?? $_GET['aes_iv'] ?? '';
    
    if (empty($encryptedAESKey) || empty($aesIv)) {
        http_response_code(400);
        echo json_encode([
            'success' => 0,
            'error' => 'Thiếu encrypted_aes_key hoặc aes_iv'
        ]);
        exit();
    }
    
    // Giải mã AES key bằng RSA Private Key
    $rsa = new RSAKeyExchange();
    $aesKey = $rsa->decryptAESKey($encryptedAESKey);
    
    // Validate AES key (phải đúng 32 bytes cho AES-256)
    if (strlen($aesKey) !== 32) {
        http_response_code(400);
        echo json_encode([
            'success' => 0,
            'error' => 'AES key phải có độ dài 32 bytes (256 bits)'
        ]);
        exit();
    }
    
    // Validate IV (phải đúng 16 bytes)
    $ivDecoded = base64_decode($aesIv);
    if (strlen($ivDecoded) !== 16) {
        http_response_code(400);
        echo json_encode([
            'success' => 0,
            'error' => 'AES IV phải có độ dài 16 bytes (128 bits)'
        ]);
        exit();
    }
    
    // Tạo session ID unique
    $sessionId = bin2hex(random_bytes(32));
    
    // Lưu vào database hoặc file (tùy chọn)
    // Ở đây dùng file để đơn giản
    $sessionData = [
        'aes_key' => base64_encode($aesKey),
        'aes_iv' => $aesIv,
        'created_at' => time(),
        'expires_at' => time() + 3600 // 1 giờ
    ];
    
    $sessionsDir = __DIR__ . '/../private/sessions';
    if (!is_dir($sessionsDir)) {
        mkdir($sessionsDir, 0700, true);
    }
    
    file_put_contents(
        $sessionsDir . '/' . $sessionId . '.json',
        json_encode($sessionData)
    );
    
    echo json_encode([
        'success' => 1,
        'session_id' => $sessionId,
        'expires_in' => 3600,
        'message' => 'Key exchange thành công. Dùng session_id này cho các request tiếp theo.'
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => 0,
        'error' => $e->getMessage()
    ]);
}
?>
