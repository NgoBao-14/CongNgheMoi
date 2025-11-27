<?php
$active = isset($data['active']) ? $data['active'] : '';
$base = base_url('');
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
    
    body {
        font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    
    .main-sidebar {
        background: var(--sidebar-bg) !important;
        border-right: 1px solid rgba(255,255,255,0.05);
        box-shadow: none;
    }
    
    .brand-link {
        background: transparent !important;
        border-bottom: 1px solid rgba(255,255,255,0.08) !important;
        padding: 1.5rem 1.25rem !important;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    
    .brand-image {
        width: 45px;
        height: 45px;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .brand-text {
        font-weight: 700 !important;
        font-size: 1.25rem !important;
        color: var(--text-white) !important;
        margin-top: 0.75rem;
        letter-spacing: -0.02em;
    }
    
    .user-panel {
        border-bottom: 1px solid rgba(255,255,255,0.08) !important;
        padding: 1.25rem 1rem !important;
        margin: 0 !important;
    }
    
    .user-panel .image img {
        border: 2px solid var(--primary);
        width: 40px;
        height: 40px;
    }
    
    .user-panel .info a {
        color: var(--text-white) !important;
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .user-panel .info small {
        color: var(--text-light);
        font-size: 0.75rem;
    }
    
    .nav-header {
        color: var(--text-light) !important;
        font-size: 0.65rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.1em;
        margin-top: 1.5rem !important;
        padding: 0.5rem 1.25rem !important;
        text-transform: uppercase;
    }
    
    .nav-sidebar .nav-link {
        color: var(--text-light) !important;
        border-radius: 0.5rem !important;
        margin: 0.25rem 1rem !important;
        padding: 0.75rem 1rem !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        font-weight: 500;
        font-size: 0.9rem;
        border: 1px solid transparent;
    }
    
    .nav-sidebar .nav-link:hover {
        background: var(--sidebar-hover) !important;
        color: var(--text-white) !important;
        border-color: rgba(255,255,255,0.05);
    }
    
    .nav-sidebar .nav-link.active {
        background: var(--primary) !important;
        color: white !important;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
    }
    
    .nav-sidebar .nav-link i {
        width: 20px;
        text-align: center;
        margin-right: 0.75rem;
        font-size: 1rem;
    }
    
    .main-header {
        background: white !important;
        border-bottom: 1px solid #E2E8F0 !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
    }
    
    .content-wrapper {
        background: #F8FAFC !important;
        min-height: 100vh;
    }
    
    .sidebar::-webkit-scrollbar {
        width: 5px;
    }
    
    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(79, 70, 229, 0.3);
        border-radius: 10px;
    }
    
    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(79, 70, 229, 0.5);
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-0">
    <a href="<?= base_url('/Admin') ?>" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-2">
        <span class="brand-text">Admin Panel</span>
    </a>

    <div class="sidebar">
        <div class="user-panel d-flex align-items-center">
            <div class="image">
                <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-1" alt="User">
            </div>
            <div class="info ms-3">
                <a href="#" class="d-block">Administrator</a>
                <small>
                    <i class="fas fa-circle text-success" style="font-size: 0.4rem;"></i> Online
                </small>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <li class="nav-item">
                    <a href="<?= base_url('/Admin') ?>" class="nav-link <?= $active == 'dashboard' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">Quản lý người dùng</li>
                
                <li class="nav-item">
                    <a href="<?= base_url('/Admin/QuanLySV') ?>" class="nav-link <?= $active == 'quanlysv' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Sinh viên</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('/Admin/ThemSinhVien') ?>" class="nav-link <?= $active == 'themsv' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>Thêm sinh viên</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('/Admin/QuanLyGV') ?>" class="nav-link <?= $active == 'quanlygv' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>Giảng viên</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('/Admin/ThemGiangVien') ?>" class="nav-link <?= $active == 'themgv' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>Thêm giảng viên</p>
                    </a>
                </li>

                <li class="nav-header">Quản lý đề tài</li>

                <li class="nav-item">
                    <a href="<?= base_url('/Admin/DSDeTai') ?>" class="nav-link <?= $active == 'dsdetai' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Đề tài</p>
                    </a>
                </li>

                <li class="nav-header">Hệ thống</li>

                <li class="nav-item">
                    <a href="<?= base_url('/Logout') ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Đăng xuất</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
