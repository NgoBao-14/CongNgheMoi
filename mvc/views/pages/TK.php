<?php
echo'
        <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- thu phóng -->
        <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
        </li>

    </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Quản lý khóa luận</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <h5 class="d-block">Trưởng khoa</h5>
        </div>
        </div>

    <!-- Sidebar Menu -->
    <div>
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <!-- Bảng điều khiển -->
        <li class="nav-item">
            <a href="./" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Bảng điều khiển</p>
            </a>
        </li>
        <!-- Đề xuất đề tài  -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/DXDeTai" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Duyệt đề tài</p>
            </a>
        </li>

        <!-- Danh sách đăng ký -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/DSDeTai" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Danh sách đề tài</p>
            </a>
        </li>

        <!-- Danh sách đề tài đã đăng ký -->
        <li class="nav-item">
            <a href="./DiemKhoaLuanCacNhom" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>Điểm khóa luận</p>
            </a>
        </li>

        <!-- Hội đồng bảo vệ -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/HoiDongBaoVe" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Hội đồng bảo vệ</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="/CongNgheMoi/Logout" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Đăng xuất</p>
            </a>
        </li>
        </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-primary mb-3">
                <div class="info-box-content">
                
                <span class="info-box-text">Duyệt đề tài</span>
                <div class="mt-3">
                    <a href="./DXDeTai" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-success mb-3">
                <div class="info-box-content">
                
                <span class="info-box-text">Danh sách đề tài</span>
                <div class="mt-3">
                    <a href="./DSDeTai" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-danger mb-3 ">
                <div class="info-box-content">
                <span class="info-box-text">Điểm khóa luận</span> 
                <div class="mt-3">
                    <a href="./DiemKhoaLuanCacNhom" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-warning mb-3 disabled-overlay">
                <div class="info-box-content">
                <span class="info-box-text">Ngày báo cáo</span>
                <div class="mt-3">
                    <a href="./" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row">
            <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Hoạt động gần đây</h3>
                </div>
                <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    <p class="text-center mt-4 mb-4 text-muted">Không có hoạt động gần đây</p>
                </ul>
                </div>
                <div class="card-footer text-center">
                
                </div>
            </div>
            </div>
            
            <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Lịch bảo vệ sắp tới</h3>
                </div>
                <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Sinh viên</th>
                        <th>Đề tài</th>
                        <th>Ngày</th>
                        <th>Phòng</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="4" class="text-center text-muted mt-4 mb-4">Không có lịch bảo vệ sắp tới!</td>
                    </tbody>
                </table>
                </div>
                <div class="card-footer text-center">
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
';
?>