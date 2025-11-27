<?php
/**
 * Authentication Middleware
 * Xử lý xác thực và phân quyền cho API
 */

require_once(__DIR__ . "/../../private/JWT_Helper.php");

class AuthMiddleware {
    
    /**
     * Xác thực request
     * Kiểm tra JWT token có hợp lệ không
     * 
     * @return object|false - User data hoặc false nếu không hợp lệ
     * 
     * Ví dụ sử dụng:
     * $user = AuthMiddleware::authenticate();
     * if (!$user) {
     *     exit(); // Middleware đã gửi response lỗi
     * }
     */
    public static function authenticate() {
        // Lấy token từ header
        $token = JWT_Helper::getBearerToken();
        
        if (!$token) {
            self::sendUnauthorized("Token không được cung cấp. Vui lòng đăng nhập.");
            return false;
        }
        
        // Verify token
        $user_data = JWT_Helper::verifyToken($token);
        
        if (!$user_data) {
            self::sendUnauthorized("Token không hợp lệ hoặc đã hết hạn. Vui lòng đăng nhập lại.");
            return false;
        }
        
        // Log access (optional)
        self::logAccess($user_data);
        
        return $user_data;
    }
    
    /**
     * Phân quyền - Kiểm tra role
     * 
     * @param object $user_data - Dữ liệu user từ token
     * @param array $allowed_roles - Các role được phép truy cập
     *                               0 = Admin, 1 = Giảng viên, 2 = Sinh viên, 3 = Trưởng khoa
     * @return bool - True nếu có quyền, False nếu không
     * 
     * Ví dụ sử dụng:
     * // Chỉ cho phép Admin và Giảng viên
     * if (!AuthMiddleware::authorize($user, [0, 1])) {
     *     exit();
     * }
     */
    public static function authorize($user_data, $allowed_roles = []) {
        // Nếu không chỉ định role, cho phép tất cả
        if (empty($allowed_roles)) {
            return true;
        }
        
        // Kiểm tra role của user
        if (!isset($user_data->role)) {
            self::sendForbidden("Thông tin quyền không hợp lệ");
            return false;
        }
        
        if (!in_array($user_data->role, $allowed_roles)) {
            self::sendForbidden("Bạn không có quyền truy cập chức năng này");
            return false;
        }
        
        return true;
    }
    
    /**
     * Kiểm tra quyền sở hữu resource
     * User chỉ có thể truy cập resource của chính mình
     * Admin có thể truy cập tất cả
     * 
     * @param object $user_data - Dữ liệu user từ token
     * @param int $resource_owner_id - ID chủ sở hữu resource
     * @return bool
     * 
     * Ví dụ sử dụng:
     * // Kiểm tra user có quyền xem đề tài này không
     * if (!AuthMiddleware::checkOwnership($user, $detai_owner_id)) {
     *     exit();
     * }
     */
    public static function checkOwnership($user_data, $resource_owner_id) {
        // Admin (role = 0) có thể truy cập mọi resource
        if ($user_data->role == 0) {
            return true;
        }
        
        // User chỉ có thể truy cập resource của mình
        if ($user_data->user_id != $resource_owner_id) {
            self::sendForbidden("Bạn không có quyền truy cập dữ liệu này");
            return false;
        }
        
        return true;
    }
    
    /**
     * Kiểm tra quyền theo khoa
     * Trưởng khoa chỉ có thể truy cập dữ liệu khoa của mình
     * 
     * @param object $user_data - Dữ liệu user từ token
     * @param int $resource_khoa_id - ID khoa của resource
     * @param int $user_khoa_id - ID khoa của user
     * @return bool
     */
    public static function checkKhoaAccess($user_data, $resource_khoa_id, $user_khoa_id) {
        // Admin có thể truy cập tất cả
        if ($user_data->role == 0) {
            return true;
        }
        
        // Trưởng khoa chỉ xem được khoa của mình
        if ($user_data->role == 3 && $resource_khoa_id != $user_khoa_id) {
            self::sendForbidden("Bạn chỉ có thể truy cập dữ liệu khoa của mình");
            return false;
        }
        
        return true;
    }
    
    /**
     * Rate limiting - Giới hạn số request
     * 
     * @param object $user_data - Dữ liệu user
     * @param int $max_requests - Số request tối đa
     * @param int $time_window - Thời gian (giây)
     * @return bool
     */
    public static function checkRateLimit($user_data, $max_requests = 100, $time_window = 3600) {
        // Tạo key dựa trên user_id
        $key = "rate_limit_" . $user_data->user_id;
        $file = sys_get_temp_dir() . "/" . $key . ".txt";
        
        // Đọc số request hiện tại
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            $requests = $data['requests'];
            $start_time = $data['start_time'];
            
            // Reset nếu hết time window
            if (time() - $start_time > $time_window) {
                $requests = 0;
                $start_time = time();
            }
            
            // Kiểm tra limit
            if ($requests >= $max_requests) {
                self::sendTooManyRequests("Bạn đã vượt quá giới hạn request. Vui lòng thử lại sau.");
                return false;
            }
            
            $requests++;
        } else {
            $requests = 1;
            $start_time = time();
        }
        
        // Lưu lại
        file_put_contents($file, json_encode([
            'requests' => $requests,
            'start_time' => $start_time
        ]));
        
        return true;
    }
    
    /**
     * Log access (ghi log truy cập)
     */
    private static function logAccess($user_data) {
        $log_file = __DIR__ . "/../../logs/api_access.log";
        $log_dir = dirname($log_file);
        
        // Tạo thư mục logs nếu chưa có
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        
        $log_entry = sprintf(
            "[%s] User: %s (ID: %s, Role: %s) | Endpoint: %s | IP: %s | User-Agent: %s\n",
            date('Y-m-d H:i:s'),
            isset($user_data->username) ? $user_data->username : 'N/A',
            isset($user_data->user_id) ? $user_data->user_id : 'N/A',
            isset($user_data->role) ? $user_data->role : 'N/A',
            $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR'],
            isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'N/A'
        );
        
        file_put_contents($log_file, $log_entry, FILE_APPEND);
    }
    
    /**
     * Gửi response 401 Unauthorized
     */
    private static function sendUnauthorized($message) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(array(
            "success" => false,
            "error" => "Unauthorized",
            "message" => $message
        ));
        exit();
    }
    
    /**
     * Gửi response 403 Forbidden
     */
    private static function sendForbidden($message) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(array(
            "success" => false,
            "error" => "Forbidden",
            "message" => $message
        ));
        exit();
    }
    
    /**
     * Gửi response 429 Too Many Requests
     */
    private static function sendTooManyRequests($message) {
        http_response_code(429);
        header('Content-Type: application/json');
        echo json_encode(array(
            "success" => false,
            "error" => "Too Many Requests",
            "message" => $message
        ));
        exit();
    }
}
?>
