<?php
/**
 * JWT Helper Class
 * Xử lý tạo và verify JWT Token
 * 
 * Yêu cầu: composer require firebase/php-jwt
 * Hoặc download từ: https://github.com/firebase/php-jwt
 */

// Nếu dùng Composer
// require_once __DIR__ . '/../../vendor/autoload.php';

// Nếu không dùng Composer, download và include thủ công
// require_once __DIR__ . '/jwt/JWT.php';
// require_once __DIR__ . '/jwt/Key.php';

// use Firebase\JWT\JWT;
// use Firebase\JWT\Key;

class JWT_Helper {
    // ⚠️ QUAN TRỌNG: Thay đổi secret key này và lưu trong .env
    private static $secret_key = "YOUR_SECRET_KEY_CHANGE_THIS_TO_RANDOM_STRING_123456789";
    private static $algorithm = 'HS256';
    
    /**
     * Tạo JWT Token
     * 
     * @param array $data - Dữ liệu cần mã hóa
     *                      Ví dụ: ['user_id' => 123, 'role' => 1, 'name' => 'John']
     * @param int $expire_time - Thời gian hết hạn (giây). Mặc định: 3600 (1 giờ)
     * @return string - JWT Token
     * 
     * Ví dụ sử dụng:
     * $token = JWT_Helper::createToken(['user_id' => 123, 'role' => 1], 86400);
     */
    public static function createToken($data, $expire_time = 3600) {
        $issued_at = time();
        $expiration_time = $issued_at + $expire_time;
        
        $payload = array(
            "iat" => $issued_at,              // Issued at: thời gian tạo
            "exp" => $expiration_time,        // Expire: thời gian hết hạn
            "data" => $data                   // Dữ liệu user
        );
        
        // Nếu dùng firebase/php-jwt
        // return JWT::encode($payload, self::$secret_key, self::$algorithm);
        
        // Nếu không có library, dùng manual encoding
        return self::manualEncode($payload);
    }
    
    /**
     * Verify và decode JWT Token
     * 
     * @param string $token - JWT Token cần verify
     * @return object|false - Dữ liệu user hoặc false nếu invalid
     * 
     * Ví dụ sử dụng:
     * $user_data = JWT_Helper::verifyToken($token);
     * if ($user_data) {
     *     echo "User ID: " . $user_data->user_id;
     * }
     */
    public static function verifyToken($token) {
        try {
            // Nếu dùng firebase/php-jwt
            // $decoded = JWT::decode($token, new Key(self::$secret_key, self::$algorithm));
            // return $decoded->data;
            
            // Nếu không có library, dùng manual decoding
            return self::manualDecode($token);
        } catch (Exception $e) {
            error_log("JWT Verify Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy token từ Authorization header
     * 
     * @return string|null - Token hoặc null nếu không có
     * 
     * Header format: "Authorization: Bearer <token>"
     */
    public static function getBearerToken() {
        $headers = null;
        
        // Lấy headers
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
        } elseif (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
        } else {
            // Fallback cho nginx
            $headers = array();
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
        }
        
        // Tìm Authorization header
        if (isset($headers['Authorization'])) {
            $matches = array();
            if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                return $matches[1];
            }
        }
        
        // Fallback: lấy từ query string (không khuyến khích)
        if (isset($_GET['token'])) {
            return $_GET['token'];
        }
        
        return null;
    }
    
    /**
     * Manual JWT encoding (không cần library)
     * Chỉ dùng khi không có firebase/php-jwt
     */
    private static function manualEncode($payload) {
        $header = array(
            "typ" => "JWT",
            "alg" => self::$algorithm
        );
        
        $header_encoded = self::base64UrlEncode(json_encode($header));
        $payload_encoded = self::base64UrlEncode(json_encode($payload));
        
        $signature = hash_hmac('sha256', $header_encoded . "." . $payload_encoded, self::$secret_key, true);
        $signature_encoded = self::base64UrlEncode($signature);
        
        return $header_encoded . "." . $payload_encoded . "." . $signature_encoded;
    }
    
    /**
     * Manual JWT decoding (không cần library)
     * Chỉ dùng khi không có firebase/php-jwt
     */
    private static function manualDecode($token) {
        $parts = explode('.', $token);
        
        if (count($parts) !== 3) {
            return false;
        }
        
        list($header_encoded, $payload_encoded, $signature_encoded) = $parts;
        
        // Verify signature
        $signature = self::base64UrlDecode($signature_encoded);
        $expected_signature = hash_hmac('sha256', $header_encoded . "." . $payload_encoded, self::$secret_key, true);
        
        if (!hash_equals($signature, $expected_signature)) {
            return false;
        }
        
        // Decode payload
        $payload = json_decode(self::base64UrlDecode($payload_encoded));
        
        if (!$payload) {
            return false;
        }
        
        // Check expiration
        if (isset($payload->exp) && $payload->exp < time()) {
            return false;
        }
        
        return isset($payload->data) ? $payload->data : false;
    }
    
    /**
     * Base64 URL encode
     */
    private static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    /**
     * Base64 URL decode
     */
    private static function base64UrlDecode($data) {
        return base64_decode(strtr($data, '-_', '+/'));
    }
    
    /**
     * Refresh token (tạo token mới từ token cũ)
     * 
     * @param string $old_token - Token cũ
     * @param int $expire_time - Thời gian hết hạn mới
     * @return string|false - Token mới hoặc false nếu token cũ invalid
     */
    public static function refreshToken($old_token, $expire_time = 3600) {
        $user_data = self::verifyToken($old_token);
        
        if (!$user_data) {
            return false;
        }
        
        // Chuyển object thành array
        $data_array = json_decode(json_encode($user_data), true);
        
        return self::createToken($data_array, $expire_time);
    }
}
?>
