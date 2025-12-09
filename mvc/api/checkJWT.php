<?php
// File debug - XÓA SAU KHI TEST XONG
session_start();
require_once "../private/JWT.php";

header('Content-Type: application/json; charset=utf-8');

$secret = 'NgoBao_WebSecret_2024';

$result = [
    'has_cookie' => isset($_COOKIE['auth_token']),
    'session_iduser' => $_SESSION['iduser'] ?? null,
    'session_PQ' => $_SESSION['PQ'] ?? null
];

if (isset($_COOKIE['auth_token'])) {
    try {
        $payload = JWT::decode($_COOKIE['auth_token'], $secret, true);
        
        $result['jwt_valid'] = true;
        $result['jwt_payload'] = $payload;
        $result['jwt_expired'] = ($payload->exp < time());
        $result['exp_time'] = date('Y-m-d H:i:s', $payload->exp);
        $result['time_remaining'] = $payload->exp - time() . ' giây';
    } catch (Exception $e) {
        $result['jwt_valid'] = false;
        $result['error'] = $e->getMessage();
    }
}

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
