<?php
/**
 * JWT Authentication Helper cho Web Session
 * Tách riêng để tránh dependency với Controller class
 */

require_once __DIR__ . "/JWT.php";

class JWTAuth {
    private static $jwt_secret = 'NgoBao_WebSecret_2024';
    private static $jwt_expiry = 1800; // 30 phút
    
    /**
     * Tạo JWT token và lưu vào httpOnly cookie
     */
    public static function createToken($userData) {
        $payload = [
            'iduser' => $userData['iduser'],
            'username' => $userData['username'],
            'MaSV' => $userData['MaSV'],
            'MaGV' => $userData['MaGV'],
            'ten' => $userData['HoDem'] . ' ' . $userData['Ten'],
            'role' => $userData['role'],
            'phanquyen' => $userData['PhanQuyen'],
            'idNganh' => $userData['IDNganh'],
            'PQ' => $userData['PQ'],
            'exp' => time() + self::$jwt_expiry
        ];
        
        $token = JWT::encode($payload, self::$jwt_secret);
        
        // Lưu JWT vào httpOnly cookie
        $basePath = defined('BASE_PATH') ? BASE_PATH : '/CongNgheMoi';
        setcookie('auth_token', $token, [
            'expires' => time() + self::$jwt_expiry,
            'path' => $basePath . '/',
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        
        return $token;
    }
    
    /**
     * Xác thực JWT token từ cookie và khôi phục session
     */
    public static function verifyAndRestoreSession() {
        if (!isset($_COOKIE['auth_token'])) {
            return false;
        }
        
        try {
            $payload = JWT::decode($_COOKIE['auth_token'], self::$jwt_secret, true);
            
            // Kiểm tra hết hạn
            if (!isset($payload->exp) || $payload->exp < time()) {
                self::clearToken();
                return false;
            }
            
            // Khôi phục session từ JWT
            $_SESSION['iduser'] = $payload->iduser;
            $_SESSION['username'] = $payload->username;
            $_SESSION['MaSV'] = $payload->MaSV;
            $_SESSION['MaGV'] = $payload->MaGV;
            $_SESSION['ten'] = $payload->ten;
            $_SESSION['role'] = $payload->role;
            $_SESSION['phanquyen'] = $payload->phanquyen;
            $_SESSION['idNganh'] = $payload->idNganh;
            $_SESSION['PQ'] = $payload->PQ;
            
            return true;
        } catch (Exception $e) {
            self::clearToken();
            return false;
        }
    }
    
    /**
     * Xóa JWT cookie
     */
    public static function clearToken() {
        $basePath = defined('BASE_PATH') ? BASE_PATH : '/CongNgheMoi';
        setcookie('auth_token', '', time() - 42000, $basePath . '/');
    }
}
?>
