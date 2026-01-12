<?php
/**
 * API: Lấy RSA Public Key
 * 
 * Client gọi API này để lấy public key
 * Sau đó dùng public key để mã hóa AES key trước khi gửi lên server
 */

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once("../private/RSA.php");

try {
    $rsa = new RSAKeyExchange();
    $publicKey = $rsa->getPublicKey();
    
    echo json_encode([
        'success' => 1,
        'public_key' => $publicKey,
        'algorithm' => 'RSA-2048',
        'padding' => 'OAEP',
        'message' => 'Dùng key này để mã hóa AES key trước khi gửi'
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => 0,
        'error' => $e->getMessage()
    ]);
}
?>
