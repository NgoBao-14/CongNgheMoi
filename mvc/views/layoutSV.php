<?php
    if($_SESSION["PQ"] != 2){
        echo "<script>alert('Bạn không có quyền truy cập')</script>";
        header("refresh: 0; url='/CongNgheMoi'");
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng Đăng Ký Học Phần Sinh Viên - IUH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/loading.css">
    <link rel="stylesheet" href="./public/css/toast.css">
</head>
<body>
    <div class="container p-0">
        <!-- Header -->
        <?php include "blocks/header.php" ?>

        <!-- Main Content -->
<?php
$ten = $_SESSION['ten'];
$maSV = $_SESSION['MaSV'];
echo'
        <div class="main-content border">
            <div class="row m-0">
                <!-- Left Sidebar -->
                <div class="col-md-3">
                    <div class="sidebar">
                        <div class="welcome-text">Xin chào!</div>
                        <div class="student-name">' . $ten . '</div>                    
                        <div class="student-info">
                            <div class="info-row">
                                <div class="info-label">Hoạt động:</div>
                                <div class="info-value">Online</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">MSSV:</div>
                                <div class="info-value">'. $maSV .'</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Trạng thái:</div>
                                <div class="info-value">Đang học</div>
                            </div>
                        </div>
                        
                        <div class="logout-btn">
                            <a href="/CongNgheMoi/Logout" class="btn btn-warning w-100">Đăng xuất</a>
                        
                        <div class="logout-icon">
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                        </div>';
        ?>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="student-details">
                        <div class="detail-item text-primary"><a href="./DeTai" style="text-decoration: none;" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">ĐĂNG KÝ ĐỀ TÀI</a></div>
                        <div class="detail-item text-primary"><a href="./ThongTinDeTai" style="text-decoration: none;" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">THÔNG TIN ĐỀ TÀI</a></div>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="student-details">
                        <div class="detail-item text-primary"><a href="./TieuChiDanhGia" style="text-decoration: none;" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">TIÊU CHÍ ĐÁNH GIÁ</a></div>
                        <div class="detail-item text-primary"><a href="./LichSuDangKy" style="text-decoration: none;" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">LỊCH SỬ ĐĂNG KÝ</a></div>
                        <div class="detail-item text-primary"><a href="./DoiMatKhau" style="text-decoration: none;" onclick="if(typeof LoadingSpinner !== 'undefined') LoadingSpinner.show('Đang tải...')">ĐỔI MẬT KHẨU</a></div>
                    </div>
                </div>
            </div>
            
            <div class="student-info-section">
                <h3 class="text-center text-primary my-4">THÔNG TIN SINH VIÊN</h3>
                <?php
                $ttsv = $data['ttsv'];
                foreach($ttsv as $row):
                echo '
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <span class="label">Khóa:</span>
                            <span class="value">2024 - 2025</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Bậc đào tạo:</span>
                            <span class="value">Đại học</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Chuyên Ngành:</span>
                            <span class="value">' . $row['ChuyenNganh'] . '</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <span class="label">Lớp:</span>
                            <span class="value">' . $row['Lop'] . '</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Loại hình đào tạo:</span>
                            <span class="value">Chính quy</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Cơ sở:</span>
                            <span class="value">Cơ sở 1 (Thành phố Hồ Chí Minh)</span>
                        </div>
                    </div>
                </div>';
                endforeach;
                ?>
            </div>
        </div>
        
        <!-- Footer -->
        <?php include "blocks/footer.php" ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./public/js/toast.js"></script>
    <script src="./public/js/loading.js"></script>
    <script src="script.js"></script>
</body>
</html>