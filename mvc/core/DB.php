<?php
class DB {
    public $connect;
    public $api;
    
    private function getApiUrl() {
        $basePath = defined('BASE_PATH') ? BASE_PATH : ($_ENV['BASE_PATH'] ?? '/CongNgheMoi');
        
        // Trong Docker container, curl cần gọi localhost:80 (Apache trong container)
        // Không dùng HTTP_HOST vì đó là host từ browser
        $isDocker = file_exists('/.dockerenv') || getenv('DOCKER_CONTAINER');
        
        if ($isDocker) {
            // Trong Docker, gọi trực tiếp localhost của container
            $host = 'localhost';
        } else {
            // Ngoài Docker (XAMPP), dùng HTTP_HOST
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        }
        
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        return $protocol . '://' . $host . $basePath . '/mvc/api/';
    }
    
    function __construct() {
        // Load .env file
        $this->loadEnv();
        
        // Lấy config từ .env
        $useCloud = $this->getEnv('USE_CLOUD_SQL', 'false') === 'true';
        
        if ($useCloud) {
            // Dùng Cloud SQL
            $host = $this->getEnv('CLOUD_SQL_HOST', 'localhost');
            $user = $this->getEnv('CLOUD_SQL_USER', 'root');
            $pass = $this->getEnv('CLOUD_SQL_PASS', '');
            $db = $this->getEnv('CLOUD_SQL_NAME', 'thongtinmay');
        } else {
            // Dùng Localhost hoặc Docker MySQL container
            // Trong Docker, host là 'db' (tên service), ngoài Docker là 'localhost'
            $host = $this->getEnv('LOCAL_DB_HOST', 'localhost');
            $user = $this->getEnv('LOCAL_DB_USER', 'bao');
            $pass = $this->getEnv('LOCAL_DB_PASS', '123456');
            $db = $this->getEnv('LOCAL_DB_NAME', 'thongtinmay');
        }
        
        // Kết nối
        $this->connect = mysqli_connect($host, $user, $pass, $db);
        
        if (!$this->connect) {
            die("Kết nối database thất bại: " . mysqli_connect_error());
        }
        
        mysqli_set_charset($this->connect, "utf8mb4");
        
        // Set API URL
        $this->api = $this->getApiUrl();
    }
    
    // Load file .env
    private function loadEnv() {
        $envFile = __DIR__ . '/../../.env';
        
        if (!file_exists($envFile)) {
            return;
        }
        
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
    
    // Lấy giá trị từ .env
    private function getEnv($key, $default = '') {
        $value = getenv($key);
        if ($value === false) {
            $value = isset($_ENV[$key]) ? $_ENV[$key] : $default;
        }
        return $value;
    }
    
    public function docjson($url) {
        $client = curl_init($url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($client, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($client);
        curl_close($client);
        $results = json_decode($response);
        return $results;
    }
}
?>