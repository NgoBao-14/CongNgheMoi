<?php
$active = isset($data['active']) ? $data['active'] : '';
echo '
<style>
    :root {
        --primary-color: #4e73df;
        --primary-dark: #2e59d9;
        --sidebar-bg: #1a1d29;
        --sidebar-hover: #2a2d3a;
    }
    
    .main-sidebar {
        background: linear-gradient(180deg, var(--sidebar-bg) 0%, #0f1116 100%) !important;
        box-shadow: 0 0 30px rgba(0,0,0,0.3);
    }
    
    .brand-link {
        background: rgba(255,255,255,0.05) !important;
        border-bottom: 1px solid rgba(255,255,255,0.1) !important;
        padding: 1rem !important;
    }
    
    .brand-text {
        font-weight: 600 !important;
        font-size: 1.1rem !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .user-panel {
        border-bottom: 1px solid rgba(255,255,255,0.1) !important;
    }
    
    .user-panel .info a {
        color: #fff !important;
        font-weight: 600;
    }
    
    .nav-header {
        color: #858796 !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        letter-spacing: 1px;
        margin-top: 1rem !important;
    }
    
    .nav-sidebar .nav-link {
        color: rgba(255,255,255,0.8) !important;
        border-radius: 8px !important;
        margin: 0.2rem 0.5rem !important;
        padding: 0.7rem 1rem !important;
        transition: all 0.3s ease !important;
    }
    
    .nav-sidebar .nav-link:hover {
        background: var(--sidebar-hover) !important;
        color: #fff !important;
        transform: translateX(5px);
    }
    
    .nav-sidebar .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.4);
    }
    
    .main-header {
        background: #fff !important;
        border-bottom: 1px solid #e3e6f0 !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
    }
    
    .content-wrapper {
        background: #f8f9fc !important;
    }
</style>

<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/CongNgheMoi/TruongKhoa" class="nav-link">
                    <i class="fas fa-home me-1"></i>Trang chủ
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">
                    <i class="fas fa-user-tie me-2"></i>
                    <strong>Trưởng khoa</strong>
                </span>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/CongNgheMoi/TruongKhoa" class="brand-link">
            <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text">Quản lý khóa luận</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#">Trưởng khoa</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                    <li class="nav-item">
                        <a href="/CongNgheMoi/TruongKhoa" class="nav-link ' . ($active == 'dashboard' ? 'active' : '') . '">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Bảng điều khiển</p>
                        </a>
                    </li>

                    <li class="nav-header">QUẢN LÝ TRƯỞNG KHOA</li>
                    
                    <li class="nav-item">
                        <a href="/CongNgheMoi/TruongKhoa/DXDeTai" class="nav-link ' . ($active == 'duyetdetai' ? 'active' : '') . '">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>Duyệt đề tài</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/CongNgheMoi/TruongKhoa/DSDeTai" class="nav-link ' . ($active == 'dsdetai' ? 'active' : '') . '">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Danh sách đề tài</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/CongNgheMoi/TruongKhoa/DiemKhoaLuanCacNhom" class="nav-link ' . ($active == 'diemkhoaluan' ? 'active' : '') . '">
                            <i class="nav-icon fas fa-star"></i>
                            <p>Điểm khóa luận</p>
                        </a>
                    </li>

                    <li class="nav-header">CHỨC NĂNG GIẢNG VIÊN</li>

                    <li class="nav-item">
                        <a href="/CongNgheMoi/TruongKhoa/DeXuatDeTai" class="nav-link ' . ($active == 'dexuatdetai' ? 'active' : '') . '">
                            <i class="nav-icon fas fa-lightbulb"></i>
                            <p>Đề xuất đề tài</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/CongNgheMoi/TruongKhoa/QuanLyDeTai" class="nav-link ' . ($active == 'qldetai' ? 'active' : '') . '">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Đề tài của tôi</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/CongNgheMoi/TruongKhoa/QuanLyNhom" class="nav-link ' . ($active == 'qlnhom' ? 'active' : '') . '">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <p>Quản lý nhóm</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/CongNgheMoi/TruongKhoa/TienDoDeTai" class="nav-link ' . ($active == 'tiendodetai' ? 'active' : '') . '">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Tiến độ đề tài</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/CongNgheMoi/TruongKhoa/QuanLyKhoaLuan" class="nav-link ' . ($active == 'qlkhoaluan' ? 'active' : '') . '">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Báo cáo khóa luận</p>
                        </a>
                    </li>

                    <li class="nav-header">CÀI ĐẶT</li>

                    <li class="nav-item">
                        <a href="/CongNgheMoi/DoiMatKhau" class="nav-link ' . ($active == 'doimatkhau' ? 'active' : '') . '">
                            <i class="nav-icon fas fa-key"></i>
                            <p>Đổi mật khẩu</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/CongNgheMoi/Logout" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Đăng xuất</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">';
?>
