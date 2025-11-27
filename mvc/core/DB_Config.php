<?php
/**
 * Database Configuration
 * Hỗ trợ nhiều môi trường: local, cloud, production
 * 
 * Cách sử dụng:
 * 1. Copy file này thành DB_Config.php
 * 2. Điền thông tin Cloud SQL của bạn
 * 3. Thay đổi $environment theo môi trường
 */

class DB_Config {
    private static $environment = null;
    private static $envLoaded = false;
    
    /**
     * Load file .env
     */
    private static function loadEnv() {
        if (self::$envLoaded) {
            return;
        }
        
        $envFile = __DIR__ . '/../../.env';
        
        if (!file_exists($envFile)) {
            // Nếu không có .env, dùng giá trị mặc định
            self::$envLoaded = true;
            return;
        }
        
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            
            // Parse line
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                
                // Remove quotes
                $value = trim($value, '"\'');
                
                // Set environment variable
                putenv("$name=$value");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
        
        self::$envLoaded = true;
    }
    
    /**
     * Lấy giá trị từ .env
     */
    private static function env($key, $default = null) {
        self::loadEnv();
        
        $value = getenv($key);
        if ($value === false) {
            $value = isset($_ENV[$key]) ? $_ENV[$key] : $default;
        }
        
        // Convert string boolean
        if (strtolower($value) === 'true') return true;
        if (strtolower($value) === 'false') return false;
        
        return $value;
    }
    
    /**
     * Build config từ .env
     */
    private static function buildConfigs() {
        return [
            // Cấu hình Local (localhost)
            'local' => [
                'host' => self::env('LOCAL_DB_HOST', 'localhost'),
                'username' => self::env('LOCAL_DB_USER', 'bao'),
                'password' => self::env('LOCAL_DB_PASS', '123456'),
                'database' => self::env('LOCAL_DB_NAME', 'thongtinmay'),
                'port' => (int)self::env('LOCAL_DB_PORT', 3306),
                'socket' => null,
                'charset' => 'utf8mb4'
            ],
            
            // Cấu hình Cloud SQL (Public IP)
            'cloud' => [
                'host' => self::env('CLOUD_SQL_HOST', '34.87.123.456'),
                'username' => self::env('CLOUD_SQL_USER', 'app_user'),
                'password' => self::env('CLOUD_SQL_PASS', 'YOUR_CLOUD_SQL_PASSWORD'),
                'database' => self::env('CLOUD_SQL_NAME', 'thongtinmay'),
                'port' => (int)self::env('CLOUD_SQL_PORT', 3306),
                'socket' => null,
                'charset' => 'utf8mb4',
                'ssl' => self::env('CLOUD_SQL_SSL', false)
            ],
            
            // Cấu hình Cloud SQL Proxy
            'cloud_proxy' => [
                'host' => '127.0.0.1',
                'username' => self::env('CLOUD_SQL_USER', 'app_user'),
                'password' => self::env('CLOUD_SQL_PASS', 'YOUR_CLOUD_SQL_PASSWORD'),
                'database' => self::env('CLOUD_SQL_NAME', 'thongtinmay'),
                'port' => 3306,
                'socket' => null,
                'charset' => 'utf8mb4'
            ],
            
            // Cấu hình Cloud SQL Socket (App Engine/Cloud Run)
            'cloud_socket' => [
                'host' => null,
                'username' => self::env('CLOUD_SQL_USER', 'app_user'),
                'password' => self::env('CLOUD_SQL_PASS', 'YOUR_CLOUD_SQL_PASSWORD'),
                'database' => self::env('CLOUD_SQL_NAME', 'thongtinmay'),
                'port' => null,
                'socket' => self::env('CLOUD_SQL_CONNECTION', '/cloudsql/my-project:asia-southeast1:thongtinmay-db'),
                'charset' => 'utf8mb4'
            ]
        ];
    }
    
    /**
     * Lấy config theo môi trường
     * Tự động detect hoặc dùng manual setting
     * 
     * @return array - Database config
     */
    public static function get() {
        self::loadEnv();
        
        // Nếu chưa set environment, tự động detect
        if (self::$environment === null) {
            // Tự động detect môi trường từ .env
            $appEnv = self::env('APP_ENV', 'local');
            
            if ($appEnv === 'cloud' || self::env('USE_CLOUD_SQL') === true) {
                // Kiểm tra dùng proxy hay không
                if (self::env('CLOUD_SQL_PROXY') === true) {
                    self::$environment = 'cloud_proxy';
                } else {
                    self::$environment = 'cloud';
                }
            } elseif (isset($_ENV['GAE_ENV']) || isset($_SERVER['GAE_ENV'])) {
                // Google App Engine
                self::$environment = 'cloud_socket';
            } else {
                // Default: local
                self::$environment = 'local';
            }
        }
        
        $configs = self::buildConfigs();
        return $configs[self::$environment];
    }
    
    /**
     * Set môi trường thủ công
     * 
     * @param string $env - 'local', 'cloud', 'cloud_proxy', 'cloud_socket'
     */
    public static function setEnvironment($env) {
        if (isset(self::$configs[$env])) {
            self::$environment = $env;
        } else {
            throw new Exception("Môi trường '$env' không tồn tại");
        }
    }
    
    /**
     * Lấy môi trường hiện tại
     * 
     * @return string
     */
    public static function getEnvironment() {
        return self::$environment;
    }
    
    /**
     * Kiểm tra kết nối
     * 
     * @return bool
     */
    public static function testConnection() {
        $config = self::get();
        
        try {
            if ($config['socket']) {
                // Kết nối qua socket
                $conn = mysqli_init();
                $success = mysqli_real_connect(
                    $conn,
                    null,
                    $config['username'],
                    $config['password'],
                    $config['database'],
                    null,
                    $config['socket']
                );
            } else {
                // Kết nối qua TCP/IP
                $conn = @mysqli_connect(
                    $config['host'],
                    $config['username'],
                    $config['password'],
                    $config['database'],
                    $config['port']
                );
                $success = $conn !== false;
            }
            
            if ($success) {
                mysqli_close($conn);
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
