<?php
/**
 * Config helper - Lấy các giá trị cấu hình từ .env
 */
class Config {
    private static $basePath = null;
    
    /**
     * Lấy BASE_PATH cho URL routing
     * Docker: '' (rỗng)
     * XAMPP: '/CongNgheMoi'
     */
    public static function basePath() {
        if (self::$basePath === null) {
            self::$basePath = defined('BASE_PATH') ? BASE_PATH : ($_ENV['BASE_PATH'] ?? '/CongNgheMoi');
        }
        return self::$basePath;
    }
    
    /**
     * Tạo URL đầy đủ từ path
     * Ví dụ: url('/Admin') => '/CongNgheMoi/Admin' hoặc '/Admin'
     */
    public static function url($path = '') {
        $base = self::basePath();
        if (empty($path) || $path === '/') {
            return $base ?: '/';
        }
        // Đảm bảo path bắt đầu bằng /
        if ($path[0] !== '/') {
            $path = '/' . $path;
        }
        return $base . $path;
    }
}

// Shortcut function để dùng trong view
function base_url($path = '') {
    return Config::url($path);
}
?>
