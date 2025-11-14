<?php
//     class Auth {
        
//     public static function checkApiKey() {
//         // Nếu .env chưa được load, tự load lại 1 lần
//         if (!isset($_ENV['API_KEY'])) {
//             $envPath = dirname(__DIR__, 2) . '/.env'; // quay về thư mục gốc
//             if (file_exists($envPath)) {
//                 $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//                 foreach ($lines as $line) {
//                     if (strpos(trim($line), '#') === 0) continue;
//                     [$name, $value] = explode('=', $line, 2);
//                     $_ENV[trim($name)] = trim($value, "\"' ");
//                 }
//             }
//         }

//         $validKey = $_ENV['API_KEY'];
//         $headers = getallheaders();
//         $apiKey = $_GET['key'] ?? ($headers['Authorization'] ?? '');
//         if (str_starts_with($apiKey, 'Bearer ')) {
//             $apiKey = trim(substr($apiKey, 7));
//         }
//         if ($apiKey !== $validKey) {
//             http_response_code(401);
//             echo json_encode(["error" => "Unauthorized"]);
//             exit;
//         }

//         // Giới hạn 1 request / phút
//         session_start();
//         if (!isset($_SESSION['last_call'])) $_SESSION['last_call'] = [];
//         $lastCall = $_SESSION['last_call'][$apiKey] ?? 0;

//         if (time() - $lastCall < 60) {
//             http_response_code(429); // Too Many Requests
//             echo json_encode(["error" => "Too many requests. Try again in 1 minute."]);
//             exit;
//         }

//         // Cập nhật lại thời gian gọi
//         $_SESSION['last_call'][$apiKey] = time();

//     }


// }

class Auth {
    public static function checkApiKey() {

        //Nếu .env chưa được load, tự load lại 1 lần
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
        header('Content-Type: application/json; charset=utf-8');

        // 1️⃣ Lấy API Key từ .env
        $validKey = $_ENV['API_KEY'] ?? null;
        if (!$validKey) {
            self::sendError(500, "Server configuration error", "Missing API_KEY in environment.");
        }

        // 2️⃣ Lấy key client gửi lên
        $headers = getallheaders();
        $apiKey = $_GET['key'] ?? ($headers['Authorization'] ?? '');
        if (str_starts_with($apiKey, 'Bearer ')) {
            $apiKey = trim(substr($apiKey, 7));
        }

        // 3️⃣ Không gửi key
        if (empty($apiKey)) {
            self::sendError(400, "Missing API Key", "You must provide an API key via query (?apikey=) or Authorization header.");
        }

        // 4️⃣ Sai key
        if ($apiKey !== $validKey) {
            self::sendError(401, "Unauthorized", "Invalid API Key. Please check your credentials.");
        }

        // 5️⃣ Giới hạn tần suất 1 lần/phút
        session_start();
        if (!isset($_SESSION['last_call'])) $_SESSION['last_call'] = [];

        $lastCall = $_SESSION['last_call'][$apiKey] ?? 0;
        $elapsed = time() - $lastCall;
        $limitSeconds = 60; // 1 phút

        if ($elapsed < $limitSeconds) {
            $wait = $limitSeconds - $elapsed;
            self::sendError(429, "Too Many Requests", "Please wait $wait seconds before next request.", [
                "retry_after" => $wait
            ]);
        }

        $_SESSION['last_call'][$apiKey] = time();
    }

    // 🔧 Hàm tiện ích trả lỗi chuẩn JSON
    private static function sendError($status, $message, $hint, $extra = []) {
        http_response_code($status);
        $response = [
            "success" => false,
            "error" => [
                "code" => $status,
                "message" => $message,
                "hint" => $hint,
                "timestamp" => date("Y-m-d H:i:s"),
                "request_id" => uniqid("req_", true)
            ]
        ];
        if (!empty($extra)) {
            $response["error"] = array_merge($response["error"], $extra);
        }

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
}
