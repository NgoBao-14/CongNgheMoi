<?php
//Đừng có đụng dô đụng dô không cần thay đổi gì hết
// Xác định đường dẫn tuyệt đối
$rootPath = $rootPath = realpath(__DIR__);

// Process URL from browser
require_once $rootPath . "/core/App.php";

// How controllers call Views & Models
require_once $rootPath . "/core/Controller.php";

// Connect Database
require_once $rootPath . "/core/DB.php";

// Connect Pagination
require_once $rootPath . "/core/Pagination.php";
?>