<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng Thông Tin Sinh Viên - Đại Học</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Toast CSS -->
    <link rel="stylesheet" href="./public/css/toast.css">
    <style>
        body {
            background-color: #Fatal error: Uncaught mysqli_sql_exception: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'c4ca4238a0b923820dcc509a6f75849b'' at line 17 in C:\xampp\htdocs\CongNgheMoi\mvc\model\mLogin.php:21 Stack trace: #0 C:\xampp\htdocs\CongNgheMoi\mvc\model\mLogin.php(21): mysqli_query(Object(mysqli), 'SELECT \r\n ...') #1 C:\xampp\htdocs\CongNgheMoi\mvc\controllers\Login.php(9): mLogin->GetDN('' or 1=1 --', 'c4ca4238a0b9238...') #2 C:\xampp\htdocs\CongNgheMoi\mvc\core\App.php(28): Login->SayHi() #3 C:\xampp\htdocs\CongNgheMoi\index.php(7): App->__construct() #4 {main} thrown in C:\xampp\htdocs\CongNgheMoi\mvc\model\mLogin.php on line 21;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-tabs {
            background-color: #0d6efd;
            color: white;
            padding: 10px 0;
        }
        .tab-item {
            background-color: #0d6efd;
            color: white;
            padding: 8px 20px;
            margin-right: 2px;
            text-decoration: none;
            border-radius: 5px 5px 0 0;
        }
        .tab-item.active {
            background-color: white;
            color: #0d6efd;
        }
        .news-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .news-item {
            border-bottom: 1px solid #eee;
            padding: 15px;
        }
        .news-item:last-child {
            border-bottom: none;
        }
        .news-date {
            background-color: #0d6efd;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-right: 10px;
            min-width: 60px;
            text-align: center;
        }
        .news-day {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .news-title {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }
        .news-title:hover {
            text-decoration: underline;
        }
        .news-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        .view-details {
            color: #dc3545;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .view-details:hover {
            text-decoration: underline;
        }
        .login-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .login-header {
            background-color: #0d6efd;
            color: white;
            padding: 10px 15px;
            margin: -20px -20px 20px -20px;
            border-radius: 8px 8px 0 0;
            font-weight: bold;
        }
        .form-control {
            border-radius: 4px;
            padding: 10px;
        }
        .btn-login {
            background-color: #ff5722;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-weight: bold;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #e64a19;
            color: white;
        }
        .btn-parent {
            background-color: #20c997;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            font-size: 0.9rem;
            width: 100%;
            margin-top: 10px;
        }
        .btn-parent:hover {
            background-color: #1aa085;
            color: white;
        }
        .app-section {
            text-align: center;
            margin-top: 20px;
        }
        .qr-code {
            width: 80px;
            height: 80px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .app-buttons img {
            width: 100px;
            margin: 5px;
        }
        .btn-guide {
            background-color: #20c997;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            font-size: 0.9rem;
            width: 100%;
            margin-top: 10px;
        }
        .btn-guide:hover {
            background-color: #1aa085;
            color: white;
        }
        .captcha-container {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px;
            margin: 10px 0;
            background-color: #f8f9fa;
        }
        .new-badge {
            background-color: #dc3545;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 5px;
        }
        .hot-badge {
            background-color: #ff5722;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <!-- Toast Message -->
    <?php if(isset($_SESSION['message'])): ?>
    <div class="position-fixed" style="top: 20px; right: 20px; z-index: 9999;">
        <div class="alert alert-<?= $_SESSION['message']['type'] == 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <i class="bi <?= $_SESSION['message']['type'] == 'success' ? 'bi-check-circle' : 'bi-exclamation-circle' ?> me-2"></i>
            <?= $_SESSION['message']['text'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <script>
        setTimeout(function() {
            var alert = document.querySelector('.alert');
            if(alert) alert.style.display = 'none';
        }, 3000);
    </script>
    <?php unset($_SESSION['message']); endif; ?>

    <div class="container-fluid">
        <!-- Header Tabs -->
        <div class="header-tabs">
            <div class="container">
                <div class="d-flex">
                    <a href="#" class="tab-item active">TIN TỨC - SỰ KIỆN</a>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row">
                <!-- News Section -->
                <div class="col-lg-8">
                    <div class="news-section">
                        <!-- News Item 1 -->
                        <div class="news-item">
                            <div class="d-flex">
                                <div class="news-date">
                                    <div>Tháng 05</div>
                                    <div class="news-day">21</div>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="#" class="news-title">V/v MỞ CỔNG ĐĂNG KÝ LHP HK3 2024-2025 TRỞ LẠI</a>
                                    <span class="new-badge">NEW</span>
                                    <div class="news-subtitle">V/v Đăng ký LHP HK3 2024-2025</div>
                                    <a href="#" class="view-details">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>

                        <!-- News Item 2 -->
                        <div class="news-item">
                            <div class="d-flex">
                                <div class="news-date">
                                    <div>Tháng 05</div>
                                    <div class="news-day">20</div>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="#" class="news-title">THÔNG BÁO VỀ VIỆC KHÔNG TỔ CHỨC LỚP HỌC KỲ 3 NĂM 2024-2025 TẠI PHÂN HIỆU QUẢNG NGÃI</a>
                                    <span class="hot-badge">HOT</span>
                                    <div class="news-subtitle">THÔNG BÁO VỀ VIỆC KHÔNG TỔ CHỨC LỚP HỌC KỲ 3 NĂM 2024-2025 TẠI PHÂN HIỆU QUẢNG NGÃI</div>
                                    <a href="#" class="view-details">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>

                        <!-- News Item 3 -->
                        <div class="news-item">
                            <div class="d-flex">
                                <div class="news-date">
                                    <div>Tháng 05</div>
                                    <div class="news-day">13</div>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="#" class="news-title">Thông báo thời gian mở cổng đăng ký học phần HK1 2025-2026</a>
                                    <span class="hot-badge">HOT</span>
                                    <div class="news-subtitle">Thông báo thời gian mở cổng đăng ký học phần</div>
                                    <a href="#" class="view-details">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>

                        <!-- News Item 4 -->
                        <div class="news-item">
                            <div class="d-flex">
                                <div class="news-date">
                                    <div>Tháng 05</div>
                                    <div class="news-day">08</div>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="#" class="news-title">THÔNG BÁO VỀ VIỆC ĐĂNG KÝ HỌC PHẦN HỌC KỲ 1 NĂM HỌC 2025-2026</a>
                                    <div class="news-subtitle">THÔNG BÁO VỀ VIỆC ĐĂNG KÝ HỌC PHẦN HỌC KỲ 1 NĂM HỌC 2025-2026</div>
                                    <a href="#" class="view-details">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>

                        <!-- News Item 5 -->
                        <div class="news-item">
                            <div class="d-flex">
                                <div class="news-date">
                                    <div>Tháng 02</div>
                                    <div class="news-day">24</div>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="#" class="news-title">Thông báo mở các lớp bồi dưỡng tiếng Anh A1, A2, B1, khai giảng ngày 03/03/2024</a>
                                    <span class="new-badge">NEW</span>
                                    <a href="#" class="view-details">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>

                        <!-- News Item 6 -->
                        <div class="news-item">
                            <div class="d-flex">
                                <div class="news-date">
                                    <div>Tháng 01</div>
                                    <div class="news-day">07</div>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="#" class="news-title">Thông báo về việc xóa đăng ký học phần HK2 2024-2025 (đối với các lớp đã khóa)</a>
                                    <div class="news-subtitle">Thông báo về việc xóa đăng ký học phần HK2 2024-2025 (đối với các lớp đã khóa)</div>
                                    <a href="#" class="view-details">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>

                        <!-- News Item 7 -->
                        <div class="news-item">
                            <div class="d-flex">
                                <div class="news-date">
                                    <div>Tháng 12</div>
                                    <div class="news-day">--</div>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="#" class="news-title">Thông báo về việc đóng học phí HK2 2024-2025</a>
                                    <a href="#" class="view-details">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="#" class="text-danger fw-bold">XEM THÊM</a>
                    </div>
                </div>

                <!-- Login Section -->
                <div class="col-lg-4">
                    <div class="login-section">
                        <div class="login-header">
                            CỔNG THÔNG TIN
                        </div>
                        <h5 class="text-primary mb-3">ĐĂNG NHẬP HỆ THỐNG</h5>
                        
                        <form action="" method="POST">
                            <div class="mb-3">
                                <input id="username" name="username" type="text" class="form-control" placeholder="Nhập mã sinh viên" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" id="pass" name="pass" class="form-control" placeholder="Nhập mật khẩu" required>
                            </div>
                            <div class="mb-3">
                            </div>
                            

                            
                            <button type="submit" name="btndn" class="btn-login">ĐĂNG NHẬP</button>
                            <!-- <button type="button" class="btn-parent">Dành cho phụ huynh</button> -->
                        </form>

                        <!-- <div class="app-section">
                            <p class="fw-bold">Tải App Mobile sinh viên:</p>
                            <div class="qr-code">
                                <i class="bi bi-qr-code fs-1"></i>
                            </div>
                            <div class="app-buttons">
                                <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="Download on App Store">
                                <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Get it on Google Play">
                            </div>
                            <button type="button" class="btn-guide">Hướng dẫn sử dụng App OneList</button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toast JS -->
    <script src="./public/js/toast.js"></script>
</body>
</html>