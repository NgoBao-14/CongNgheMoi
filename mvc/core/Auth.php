<?php
    class Auth {
        
    public static function checkApiKey() {
        // Nếu .env chưa được load, tự load lại 1 lần
        if (!isset($_ENV['API_KEY'])) {
            $envPath = dirname(__DIR__, 2) . '/.env'; // quay về thư mục gốc
            if (file_exists($envPath)) {
                $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    if (strpos(trim($line), '#') === 0) continue;
                    [$name, $value] = explode('=', $line, 2);
                    $_ENV[trim($name)] = trim($value, "\"' ");
                }
            }
        }

        $validKey = $_ENV['API_KEY'];
        $headers = getallheaders();
        $apiKey = $_GET['key'] ?? ($headers['Authorization'] ?? '');
        if (str_starts_with($apiKey, 'Bearer ')) {
            $apiKey = trim(substr($apiKey, 7));
        }
        if ($apiKey !== $validKey) {
            http_response_code(401);
            echo json_encode(["error" => "Unauthorized"]);
            exit;
        }

    }
}
