<?php
class DB {
    public $connect;
    public $api;
    
    // Singleton pattern - giữ 1 connection duy nhất
    private static $instance = null;
    private static $connection = null;
    private static $envLoaded = false;
    
    private function getApiUrl() {
        $basePath = defined('BASE_PATH') ? BASE_PATH : ($_ENV['BASE_PATH'] ?? '/CongNgheMoi');
        
        // Trong Docker, curl gọi từ PHP cần dùng localhost:80 (port nội bộ container)
        // Không phải localhost:8080 (port map ra ngoài)
        if (getenv('DOCKER_ENV') === 'true' || isset($_ENV['DOCKER_ENV'])) {
            $host = 'localhost';
            $protocol = 'http';
        } else {
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        }
        
        return $protocol . '://' . $host . $basePath . '/mvc/api/';
    }
    
    function __construct() {
        // Load .env chỉ 1 lần
        if (!self::$envLoaded) {
            $this->loadEnv();
            self::$envLoaded = true;
        }
        
        // Reuse connection nếu đã có
        if (self::$connection !== null && mysqli_ping(self::$connection)) {
            $this->connect = self::$connection;
        } else {
            $this->createConnection();
        }
        
        $this->api = $this->getApiUrl();
    }
    
    private function createConnection() {
        $useCloud = $this->getEnv('USE_CLOUD_SQL', 'false') === 'true';
        
        if ($useCloud) {
            $host = $this->getEnv('CLOUD_SQL_HOST', 'localhost');
            $user = $this->getEnv('CLOUD_SQL_USER', 'root');
            $pass = $this->getEnv('CLOUD_SQL_PASS', '');
            $db = $this->getEnv('CLOUD_SQL_NAME', 'thongtinmay');
        } else {
            $host = $this->getEnv('LOCAL_DB_HOST', 'localhost');
            $user = $this->getEnv('LOCAL_DB_USER', 'bao');
            $pass = $this->getEnv('LOCAL_DB_PASS', '123456');
            $db = $this->getEnv('LOCAL_DB_NAME', 'thongtinmay');
        }
        
        // Persistent connection với p: prefix
        $this->connect = mysqli_connect('p:' . $host, $user, $pass, $db);
        
        if (!$this->connect) {
            die("Kết nối database thất bại: " . mysqli_connect_error());
        }
        
        mysqli_set_charset($this->connect, "utf8mb4");
        
        // Cache connection
        self::$connection = $this->connect;
    }
    
    private function loadEnv() {
        // Đã load từ index.php bằng Dotenv, không cần load lại
        if (isset($_ENV['LOCAL_DB_HOST'])) {
            return;
        }
        
        $envFile = __DIR__ . '/../../.env';
        if (!file_exists($envFile)) return;
        
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            if (strpos($line, '=') === false) continue;
            
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
    
    private function getEnv($key, $default = '') {
        return $_ENV[$key] ?? getenv($key) ?: $default;
    }
    
    public function docjson($url) {
        $client = curl_init($url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($client, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($client);
        curl_close($client);
        return json_decode($response);
    }
}
?>