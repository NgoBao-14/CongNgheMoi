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

        <!-- CHỨC NĂNG TRƯỞNG KHOA -->
        <li class="nav-header">QUẢN LÝ TRƯỞNG KHOA</li>
        
        <!-- Duyệt đề tài  -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/DXDeTai" class="nav-link">
            <i class="nav-icon fas fa-check-circle"></i>
            <p>Duyệt đề tài</p>
            </a>
        </li>

        <!-- Danh sách đề tài -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/DSDeTai" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>Danh sách đề tài</p>
            </a>
        </li>

        <!-- Điểm khóa luận các nhóm -->
        <li class="nav-item">
            <a href="./DiemKhoaLuanCacNhom" class="nav-link">
            <i class="nav-icon fas fa-star"></i>
            <p>Điểm khóa luận</p>
            </a>
        </li>

        <!-- Hội đồng bảo vệ -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/HoiDongBaoVe" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Hội đồng bảo vệ</p>
            </a>
        </li>

        <!-- CHỨC NĂNG GIẢNG VIÊN (KẾ THỪA) -->
        <li class="nav-header">CHỨC NĂNG GIẢNG VIÊN</li>

        <!-- Đề xuất đề tài -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/DeXuatDeTai" class="nav-link">
            <i class="nav-icon fas fa-lightbulb"></i>
            <p>Đề xuất đề tài</p>
            </a>
        </li>

        <!-- Quản lý đề tài của mình -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/QuanLyDeTai" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Đề tài của tôi</p>
            </a>
        </li>

        <!-- Quản lý nhóm -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/QuanLyNhom" class="nav-link">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Quản lý nhóm</p>
            </a>
        </li>

        <!-- Tiến độ đề tài -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/TienDoDeTai" class="nav-link">
            <i class="nav-icon fas fa-tasks"></i>
            <p>Tiến độ đề tài</p>
            </a>
        </li>

        <!-- Báo cáo khóa luận -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/QuanLyKhoaLuan" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Báo cáo khóa luận</p>
            </a>
        </li>

        <!-- Đăng xuất -->
        <li class="nav-item">
            <a href="/CongNgheMoi/Logout" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
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
        <style>
            .stat-card {
                background: white;
                border-radius: 15px;
                padding: 25px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.08);
                transition: all 0.3s ease;
                border-left: 4px solid;
                position: relative;
                overflow: hidden;
            }
            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            }
            .stat-card::before {
                content: "";
                position: absolute;
                top: 0;
                right: 0;
                width: 100px;
                height: 100px;
                border-radius: 50%;
                opacity: 0.1;
                transform: translate(30%, -30%);
            }
            .stat-card.primary {
                border-left-color: #4e73df;
            }
            .stat-card.primary::before {
                background: #4e73df;
            }
            .stat-card.success {
                border-left-color: #1cc88a;
            }
            .stat-card.success::before {
                background: #1cc88a;
            }
            .stat-card.danger {
                border-left-color: #e74a3c;
            }
            .stat-card.danger::before {
                background: #e74a3c;
            }
            .stat-card.warning {
                border-left-color: #f6c23e;
            }
            .stat-card.warning::before {
                background: #f6c23e;
            }
            .stat-icon {
                font-size: 2.5rem;
                opacity: 0.3;
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
            }
            .stat-title {
                font-size: 0.85rem;
                color: #858796;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-bottom: 10px;
            }
            .stat-value {
                font-size: 1.8rem;
                font-weight: 700;
                color: #5a5c69;
                margin-bottom: 15px;
            }
            .stat-link {
                color: #4e73df;
                text-decoration: none;
                font-weight: 600;
                font-size: 0.9rem;
                transition: all 0.3s ease;
            }
            .stat-link:hover {
                color: #2e59d9;
                transform: translateX(5px);
            }
        </style>
        
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3 mb-4">
                <div class="stat-card primary">
                    <i class="fas fa-check-circle stat-icon text-primary"></i>
                    <div class="stat-title">Duyệt đề tài</div>
                    <div class="stat-value">--</div>
                    <a href="./DXDeTai" class="stat-link">
                        Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-3 mb-4">
                <div class="stat-card success">
                    <i class="fas fa-list-alt stat-icon text-success"></i>
                    <div class="stat-title">Danh sách đề tài</div>
                    <div class="stat-value">--</div>
                    <a href="./DSDeTai" class="stat-link">
                        Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-3 mb-4">
                <div class="stat-card danger">
                    <i class="fas fa-star stat-icon text-danger"></i>
                    <div class="stat-title">Điểm khóa luận</div>
                    <div class="stat-value">--</div>
                    <a href="./DiemKhoaLuanCacNhom" class="stat-link">
                        Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-3 mb-4">
                <div class="stat-card warning">
                    <i class="fas fa-lightbulb stat-icon text-warning"></i>
                    <div class="stat-title">Đề xuất đề tài</div>
                    <div class="stat-value">--</div>
                    <a href="./DeXuatDeTai" class="stat-link">
                        Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card" style="border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: none;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; padding: 20px;">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Hoạt động gần đây</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-5">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #e3e6f0; margin-bottom: 15px;"></i>
                            <p class="text-muted mb-0">Không có hoạt động gần đây</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card" style="border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: none;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 15px 15px 0 0; padding: 20px;">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Lịch bảo vệ sắp tới</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: #f8f9fc;">
                                    <tr>
                                        <th style="border: none; padding: 15px;">Sinh viên</th>
                                        <th style="border: none; padding: 15px;">Đề tài</th>
                                        <th style="border: none; padding: 15px;">Ngày</th>
                                        <th style="border: none; padding: 15px;">Phòng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <i class="fas fa-calendar-times" style="font-size: 3rem; color: #e3e6f0; margin-bottom: 15px; display: block;"></i>
                                            <span class="text-muted">Không có lịch bảo vệ sắp tới</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
';
?>