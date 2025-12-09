<?php
    if($_SESSION["PQ"] != 2){
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Bạn không có quyền truy cập'];
        header("location: " . base_url('/'));
        exit;
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng Đăng Ký Học Phần Sinh Viên - IUH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../public/css/sidebar.css">
    <link rel="stylesheet" href="../public/css/sinhvien.css">
    <link rel="stylesheet" href="../public/css/xemdetai.css">
    <link rel="stylesheet" href="../public/css/loading.css">
    <link rel="stylesheet" href="../public/css/toast.css">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .main-container {
            display: flex;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <button class="mobile-menu-btn" onclick="toggleMobileSidebar()">
        <i class="bi bi-list" style="font-size: 1.5rem;"></i>
    </button>
    
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div class="sidebar-logo-text">University Portal</div>
                <div class="toggle-btn" onclick="toggleSidebar()">
                    <i class="bi bi-chevron-left" id="toggleIcon"></i>
                </div>
            </div>
            
            <div class="sidebar-menu">
                <a href="." class="menu-item <?php echo (!isset($data['Page']) || $data['Page'] == '') ? 'active' : ''; ?>" data-title="Bảng điều khiển">
                    <i class="bi bi-grid-fill"></i>
                    <span>Bảng điều khiển</span>
                </a>
                <a href="./DeTai" class="menu-item <?php echo (isset($data['Page']) && $data['Page'] == 'DeTai') ? 'active' : ''; ?>" data-title="Đăng Ký Đề Tài" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Đăng Ký Đề Tài</span>
                </a>
                <a href="./ThongTinDeTai" class="menu-item <?php echo (isset($data['Page']) && $data['Page'] == 'ThongTinDeTai') ? 'active' : ''; ?>" data-title="Thông Tin Đề Tài" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">
                    <i class="bi bi-info-circle"></i>
                    <span>Thông Tin Đề Tài</span>
                </a>
                <a href="./TieuChiDanhGia" class="menu-item <?php echo (isset($data['Page']) && $data['Page'] == 'TieuChiDanhGia') ? 'active' : ''; ?>" data-title="Tiêu Chí Đánh Giá" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">
                    <i class="bi bi-list-check"></i>
                    <span>Tiêu Chí Đánh Giá</span>
                </a>
                <a href="./LichSuDangKy" class="menu-item <?php echo (isset($data['Page']) && $data['Page'] == 'LichSuDangKy') ? 'active' : ''; ?>" data-title="Lịch Sử Đăng Ký" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">
                    <i class="bi bi-clock-history"></i>
                    <span>Lịch Sử Đăng Ký</span>
                </a>
                <a href="./DoiMatKhau" class="menu-item <?php echo (isset($data['Page']) && $data['Page'] == 'DoiMatKhau') ? 'active' : ''; ?>" data-title="Đổi Mật Khẩu" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">
                    <i class="bi bi-lock"></i>
                    <span>Đổi Mật Khẩu</span>
                </a>
            </div>
            
            <div class="sidebar-footer">
                <a href="/CongNgheMoi/Logout" class="logout-btn" data-title="Đăng Xuất" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang đăng xuất...')">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Đăng Xuất</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <?php require_once "./mvc/views/pages/".$data["Page"].".php" ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/toast.js"></script>
    <script src="../public/js/loading.js"></script>
    <script src="../public/js/sidebar.js"></script>
</body>
</html>
