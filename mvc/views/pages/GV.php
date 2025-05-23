<?php
echo'
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-primary mb-3">
                <div class="info-box-content">
                <h2 class="info-box-number">150</h2>
                <span class="info-box-text">Quản lý nhóm</span>
                <div class="mt-3">
                    <a href="./QuanLyNhom" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-success mb-3">
                <div class="info-box-content">
                <h2 class="info-box-number">42</h2>
                <span class="info-box-text">Danh sách đề tài</span>
                <div class="mt-3">
                    <a href="/CongNgheMoi/GiangVien/QuanLyDeTai" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-warning mb-3">
                <div class="info-box-content">
                <h2 class="info-box-number">65</h2>
                <span class="info-box-text">Tiến độ đề tài</span>
                <div class="mt-3">
                    <a href="/CongNgheMoi/GiangVien/TienDoDeTai" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-danger mb-3">
                <div class="info-box-content">
                <h2 class="info-box-number">12</h2>
                <span class="info-box-text">Quyển khóa luận</span> 
                <div class="mt-3">
                    <a href="/CongNgheMoi/GiangVien/QuanLyKhoaLuan" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
            </div>
        </div>
        
        <!-- Charts Row -->
        <div class="row">
            <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Thống kê đề tài theo khoa</h3>
                </div>
                <div class="card-body">
                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            </div>
            <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Phân bố đề tài</h3>
                </div>
                <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
                    <li class="item">
                    <div class="product-info">
                        <a href="javascript:void(0)" class="product-title">Nguyễn Văn A
                        <span class="badge badge-success float-right">Đã nộp</span></a>
                        <span class="product-description">
                        Đã nộp báo cáo tiến độ khóa luận
                        </span>
                        <small class="text-muted">2 giờ trước</small>
                    </div>
                    </li>
                    <li class="item">
                    <div class="product-info">
                        <a href="javascript:void(0)" class="product-title">Trần Thị B
                        <span class="badge badge-warning float-right">Đang xử lý</span></a>
                        <span class="product-description">
                        Đăng ký đề tài mới
                        </span>
                        <small class="text-muted">5 giờ trước</small>
                    </div>
                    </li>
                    <li class="item">
                    <div class="product-info">
                        <a href="javascript:void(0)" class="product-title">Lê Văn C
                        <span class="badge badge-danger float-right">Từ chối</span></a>
                        <span class="product-description">
                        Yêu cầu thay đổi đề tài
                        </span>
                        <small class="text-muted">1 ngày trước</small>
                    </div>
                    </li>
                    <li class="item">
                    <div class="product-info">
                        <a href="javascript:void(0)" class="product-title">Phạm Thị D
                        <span class="badge badge-info float-right">Mới</span></a>
                        <span class="product-description">
                        Đăng ký tham gia hội đồng
                        </span>
                        <small class="text-muted">2 ngày trước</small>
                    </div>
                    </li>
                </ul>
                </div>
                <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">Xem tất cả hoạt động</a>
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
                        <td>Nguyễn Văn A</td>
                        <td>Nghiên cứu ứng dụng AI</td>
                        <td>15/05/2023</td>
                        <td>A1.01</td>
                    </tr>
                    <tr>
                        <td>Trần Thị B</td>
                        <td>Phát triển ứng dụng web</td>
                        <td>16/05/2023</td>
                        <td>A2.05</td>
                    </tr>
                    <tr>
                        <td>Lê Văn C</td>
                        <td>Phân tích dữ liệu lớn</td>
                        <td>17/05/2023</td>
                        <td>B3.02</td>
                    </tr>
                    <tr>
                        <td>Phạm Thị D</td>
                        <td>IoT trong nông nghiệp</td>
                        <td>18/05/2023</td>
                        <td>C1.03</td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">Xem tất cả lịch bảo vệ</a>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
';
?>