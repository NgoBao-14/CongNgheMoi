<!-- Sidebar for Student -->
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
        <a href="/CongNgheMoi/SinhVien" class="menu-item <?php echo (!isset($data['Page']) || $data['Page'] == '') ? 'active' : ''; ?>" data-title="Bảng điều khiển">
            <i class="bi bi-grid-fill"></i>
            <span>Bảng điều khiển</span>
        </a>
        <a href="/CongNgheMoi/SinhVien/DeTai" class="menu-item <?php echo (isset($data['Page']) && $data['Page'] == 'DeTai') ? 'active' : ''; ?>" data-title="Đăng Ký Đề Tài" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">
            <i class="bi bi-file-earmark-text"></i>
            <span>Đăng Ký Đề Tài</span>
        </a>
        <a href="/CongNgheMoi/SinhVien/ThongTinDeTai" class="menu-item <?php echo (isset($data['Page']) && $data['Page'] == 'ThongTinDeTai') ? 'active' : ''; ?>" data-title="Thông Tin Đề Tài" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">
            <i class="bi bi-info-circle"></i>
            <span>Thông Tin Đề Tài</span>
        </a>
        <a href="/CongNgheMoi/SinhVien/TieuChiDanhGia" class="menu-item <?php echo (isset($data['Page']) && $data['Page'] == 'TieuChiDanhGia') ? 'active' : ''; ?>" data-title="Tiêu Chí Đánh Giá" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">
            <i class="bi bi-list-check"></i>
            <span>Tiêu Chí Đánh Giá</span>
        </a>
        <a href="/CongNgheMoi/SinhVien/LichSuDangKy" class="menu-item <?php echo (isset($data['Page']) && $data['Page'] == 'LichSuDangKy') ? 'active' : ''; ?>" data-title="Lịch Sử Đăng Ký" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">
            <i class="bi bi-clock-history"></i>
            <span>Lịch Sử Đăng Ký</span>
        </a>
        <a href="/CongNgheMoi/DoiMatKhau" class="menu-item <?php echo (isset($data['Page']) && $data['Page'] == 'DoiMatKhau') ? 'active' : ''; ?>" data-title="Đổi Mật Khẩu" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">
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
