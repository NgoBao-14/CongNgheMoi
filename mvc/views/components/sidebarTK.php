<?php
$active = isset($data['active']) ? $data['active'] : '';
?>
<style>
    :root {
        --primary: #4F46E5;
        --primary-dark: #4338CA;
        --primary-light: #6366F1;
        --sidebar-bg: #0F172A;
        --sidebar-hover: #1E293B;
        --text-light: #94A3B8;
        --text-white: #F8FAFC;
    }
    
    body { font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
    .main-sidebar { background: var(--sidebar-bg) !important; border-right: 1px solid rgba(255,255,255,0.05); box-shadow: none; }
    .brand-link { background: transparent !important; border-bottom: 1px solid rgba(255,255,255,0.08) !important; padding: 1.5rem 1.25rem !important; display: flex; align-items: center; justify-content: center; flex-direction: column; }
    .brand-image { width: 45px; height: 45px; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2); }
    .brand-text { font-weight: 700 !important; font-size: 1.25rem !important; color: var(--text-white) !important; margin-top: 0.75rem; letter-spacing: -0.02em; }
    .user-panel { border-bottom: 1px solid rgba(255,255,255,0.08) !important; padding: 1.25rem 1rem !important; margin: 0 !important; }
    .user-panel .image img { border: 2px solid var(--primary); width: 40px; height: 40px; }
    .user-panel .info a { color: var(--text-white) !important; font-weight: 600; font-size: 0.95rem; }
    .nav-header { color: var(--text-light) !important; font-size: 0.65rem !important; font-weight: 700 !important; letter-spacing: 0.1em; margin-top: 1.5rem !important; padding: 0.5rem 1.25rem !important; text-transform: uppercase; }
    .nav-sidebar .nav-link { color: var(--text-light) !important; border-radius: 0.5rem !important; margin: 0.15rem 0.75rem !important; padding: 0.75rem 1rem !important; transition: all 0.2s ease !important; font-size: 0.875rem; font-weight: 500; }
    .nav-sidebar .nav-link:hover { background: var(--sidebar-hover) !important; color: var(--text-white) !important; transform: translateX(3px); }
    .nav-sidebar .nav-link.active { background: var(--primary) !important; color: var(--text-white) !important; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); font-weight: 600; }
    .nav-sidebar .nav-link i { width: 20px; text-align: center; margin-right: 0.75rem; font-size: 0.9rem; }
    .main-header { background: #fff !important; border-bottom: 1px solid #E2E8F0 !important; box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important; }
    .content-wrapper { background: #F8FAFC !important; }
</style>

<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
            <li class="nav-item d-none d-sm-inline-block"><a href="<?= base_url('/TruongKhoa') ?>" class="nav-link"><i class="fas fa-home me-1"></i>Trang chủ</a></li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><span class="nav-link"><strong>TK: <?= $_SESSION['ten'] ?></strong></span></li>
            <li class="nav-item"><a class="nav-link" data-widget="fullscreen" href="#" role="button"><i class="fas fa-expand-arrows-alt"></i></a></li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?= base_url('/TruongKhoa') ?>" class="brand-link">
            <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text">Quản lý khóa luận</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image"><img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"></div>
                <div class="info"><a href="#">TBM: <?= $_SESSION['ten'] ?></a></div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                    <!-- <li class="nav-item"><a href="<?= base_url('/TruongKhoa') ?>" class="nav-link <?= $active == 'dashboard' ? 'active' : '' ?>"><i class="nav-icon fas fa-tachometer-alt"></i><p>Bảng điều khiển</p></a></li> -->
                    <li class="nav-header">QUẢN LÝ TRƯỞNG KHOA</li>
                    <li class="nav-item"><a href="<?= base_url('/TruongKhoa/DSDeTai') ?>" class="nav-link <?= $active == 'dsdetai' ? 'active' : '' ?>"><i class="nav-icon fas fa-list-alt"></i><p>Danh sách đề tài</p></a></li>

                    <li class="nav-item"><a href="<?= base_url('/TruongKhoa/DXDeTai') ?>" class="nav-link <?= $active == 'duyetdetai' ? 'active' : '' ?>"><i class="nav-icon fas fa-check-circle"></i><p>Duyệt đề tài</p></a></li>
                    <!-- <li class="nav-item"><a href="<?= base_url('/TruongKhoa/DiemKhoaLuanCacNhom') ?>" class="nav-link <?= $active == 'diemkhoaluan' ? 'active' : '' ?>"><i class="nav-icon fas fa-star"></i><p>Điểm khóa luận</p></a></li> -->
                    <li class="nav-header">CHỨC NĂNG GIẢNG VIÊN</li>
                    <li class="nav-item"><a href="<?= base_url('/TruongKhoa/QuanLyDeTai') ?>" class="nav-link <?= $active == 'qldetai' ? 'active' : '' ?>"><i class="nav-icon fas fa-clipboard-list"></i><p>Đề tài của tôi</p></a></li>
                    <li class="nav-item"><a href="<?= base_url('/TruongKhoa/ThongBaoDeTai') ?>" class="nav-link <?= $active == 'thongbaodetai' ? 'active' : '' ?>"><i class="nav-icon fas fa-bullhorn"></i><p>Tạo thông báo</p></a></li>
                    <li class="nav-item"><a href="<?= base_url('/TruongKhoa/QuanLyNhom') ?>" class="nav-link <?= $active == 'qlnhom' ? 'active' : '' ?>"><i class="nav-icon fas fa-user-graduate"></i><p>Quản lý nhóm</p></a></li>

                    <li class="nav-item"><a href="<?= base_url('/TruongKhoa/DeXuatDeTai') ?>" class="nav-link <?= $active == 'dexuatdetai' ? 'active' : '' ?>"><i class="nav-icon fas fa-lightbulb"></i><p>Đề xuất đề tài</p></a></li>

                    <!-- <li class="nav-item"><a href="<?= base_url('/TruongKhoa/TienDoDeTai') ?>" class="nav-link <?= $active == 'tiendodetai' ? 'active' : '' ?>"><i class="nav-icon fas fa-tasks"></i><p>Tiến độ đề tài</p></a></li> -->
                    <!-- <li class="nav-item"><a href="<?= base_url('/TruongKhoa/QuanLyKhoaLuan') ?>" class="nav-link <?= $active == 'qlkhoaluan' ? 'active' : '' ?>"><i class="nav-icon fas fa-file-alt"></i><p>Báo cáo khóa luận</p></a></li> -->
                    <li class="nav-header">CÀI ĐẶT</li>
                    <li class="nav-item"><a href="<?= base_url('/DoiMatKhau') ?>" class="nav-link <?= $active == 'doimatkhau' ? 'active' : '' ?>"><i class="nav-icon fas fa-key"></i><p>Đổi mật khẩu</p></a></li>
                    <li class="nav-item"><a href="<?= base_url('/Logout') ?>" class="nav-link"><i class="nav-icon fas fa-sign-out-alt"></i><p>Đăng xuất</p></a></li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
