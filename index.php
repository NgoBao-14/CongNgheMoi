<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Base path: rỗng cho Docker, '/CongNgheMoi' cho XAMPP
// Đặt trong .env: BASE_PATH=/CongNgheMoi hoặc BASE_PATH=
define('BASE_PATH', $_ENV['BASE_PATH'] ?? '/CongNgheMoi');

// Cấu hình session bảo mật
ini_set('session.cookie_httponly', 1); // Chống XSS đọc cookie
ini_set('session.cookie_samesite', 'Strict'); // Chống CSRF
ini_set('session.use_strict_mode', 1); // Chỉ chấp nhận session ID do server tạo

session_start();

// Session timeout (30 phút không hoạt động)
$session_timeout = 1800;
$needJWTRestore = false;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    session_unset();
    session_destroy();
    session_start();
    $needJWTRestore = true;
}
$_SESSION['last_activity'] = time();

// Nếu chưa đăng nhập nhưng có JWT cookie hợp lệ -> tự động đăng nhập
if ($needJWTRestore || (!isset($_SESSION['iduser']) && isset($_COOKIE['auth_token']))) {
    require_once "./mvc/private/JWTAuth.php";
    JWTAuth::verifyAndRestoreSession();
}

// Kiểm tra User-Agent để chống session hijacking
if (isset($_SESSION['user_agent'])) {
    if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        session_unset();
        session_destroy();
        session_start();
    }
} else {
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
}

require_once "./mvc/Bridge.php";
$myApp = new App();

?>