<?php
class DB {
    public $connect;
    public $api = "http://localhost:8080/CongNgheMoi/mvc/api/";
    
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
            // Dùng Localhost
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