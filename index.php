<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Base path: rỗng cho Docker, '/CongNgheMoi' cho XAMPP
// Đặt trong .env: BASE_PATH=/CongNgheMoi hoặc BASE_PATH=
define('BASE_PATH', $_ENV['BASE_PATH'] ?? '/CongNgheMoi');

session_start();
require_once "./mvc/Bridge.php";
$myApp = new App();

?>