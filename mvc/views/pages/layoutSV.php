<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng Đăng Ký Học Phần Sinh Viên - IUH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="./public/css/sinhvien.css"> -->
</head>
<body>
    <div class="container p-0">
        <!-- Header -->
        <?php include "blocks/header.php" ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="row m-0">
                <!-- Left Sidebar -->
                <div class="col-md-3">
                    <div class="sidebar">
                        <div class="welcome-text">Xin chào!</div>
                        <div class="student-name">Nguyễn Châu Tinh</div>
                        
                        <div class="student-info">
                            <div class="info-row">
                                <div class="info-label">Giới tính:</div>
                                <div class="info-value">Nam</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">MSSV:</div>
                                <div class="info-value">21049361</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Trạng thái:</div>
                                <div class="info-value">Đang học</div>
                            </div>
                        </div>
                        
                        <button class="btn btn-warning logout-btn w-100">Đăng xuất</button>
                    </div>
                </div>
                
                <!-- Student Photo -->
                <div class="col-md-2">
                    <!-- <div class="student-photo-container">
                        <img src="student-photo.jpg" alt="Ảnh sinh viên" class="student-photo">
                    </div> -->
                </div>
                
                <!-- Right Content -->
                <div class="col-md-7">
                    <div class="student-details">
                        <div class="section-title text-primary">THÔNG TIN SINH VIÊN</div>
                        <div class="detail-item text-primary"><a href="./DeTai">ĐĂNG KÝ ĐỀ TÀI</a></div>
                    
                        <!-- <div class="detail-item text-primary">CHƯƠNG TRÌNH KHUNG</div> -->
                    </div>
                </div>
            </div>
            
            <!-- Student Information Section -->
            <div class="student-info-section">
                <h3 class="text-center text-primary my-4">THÔNG TIN SINH VIÊN</h3>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <span class="label">Khóa:</span>
                            <span class="value">2021 - 2022</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Bậc đào tạo:</span>
                            <span class="value">Đại học</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Ngành:</span>
                            <span class="value">Kỹ thuật phần mềm</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Khoa:</span>
                            <span class="value">Khoa Công nghệ Thông tin</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <span class="label">Lớp:</span>
                            <span class="value">Đại học Kỹ thuật phần mềm 17B - 7480103</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Loại hình đào tạo:</span>
                            <span class="value">Chính quy</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Chuyên ngành:</span>
                            <span class="value">Kỹ thuật phần mềm</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Cơ sở:</span>
                            <span class="value">Cơ sở 1 (Thành phố Hồ Chí Minh)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <?php include "blocks/footer.php" ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>