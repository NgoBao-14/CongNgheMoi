<?php
// session_start(); 
// $_SESSION['iduser'] = 5;
$dtdk = $data["dtdk"];
$nhom = $data["nhom"];


echo '<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Lại Đề Tài Đăng Ký Khóa Luận</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f7ff;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .bg-red {
            background-color: #dc3545;
        }
        .bg-orange {
            background-color: #fd7e14;
        }
        .bg-teal {
            background-color: #20c997;
        }
        .bg-blue {
            background-color: #0d6efd;
        }
        .btn-emerald {
            background-color: #10b981;
            color: white;
        }
        .btn-emerald:hover {
            background-color: #059669;
            color: white;
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-weight: 600;
        }
        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }
            .status-rejected {
            background-color: #f8d7da; 
        }
        .table-responsive {
            border-radius: 5px;
            overflow: hidden;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            
        }
        .custom-btn {
            margin-top: 30px;
            border: 1px solid #007dc9;
            color: #007dc9;
            background-color: transparent;
            border-radius: 8px;
            transition: 0.3s;
        }

        .custom-btn:hover {
            background-color: #007dc9;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container py-4 border">
        <h1 class="text-center fw-bold mb-5">XEM LẠI ĐỀ TÀI ĐĂNG KÝ KHÓA LUẬN</h1>
        
        <!-- Functional Cards -->
        <div class="row col">
            <div class="col-md-3">
                <div class="card text-center" style="height: 96%;">
                    <div class="card-body">
                        <div class="d-flex justify-content-center mb-3">
                            <div>
                                <h5 class="card-title fw-bold mb-3">THÔNG TIN GIẢNG VIÊN HƯỚNG DẪN</h5>
                            </div>
                        </div>
                        <!-- Thông tin giảng viên -->
                        <div class="mt-2 text-start">
                            <h6 style="color:#9C9C9C;">Họ tên:</h6>
                            <p class="fw-bolder fs-6">Nguyễn</p>
                            <h6 style="color:#9C9C9C;">Số điện thoại:</h6>
                            <p class="fw-bolder fs-6">0123 456 789</p>
                            <h6 style="color:#9C9C9C;">Email:</h6>
                            <p class="fw-bolder fs-6">nguyenvana@example.com</p>
                            <h6 style="color:#9C9C9C;">Khoa:</h6>
                            <p class="fw-bolder fs-6">Công nghệ thông tin</p>
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <!-- Card 2 -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-70 text-center">
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-3">
                                    <div>
                                        <h5 class="card-title fw-bold mb-0">BÁO CÁO TIẾN ĐỘ</h5>
                                        <p class="card-text small">&nbsp</p>
                                    </div>
                                </div>
                                <form action="./NopBaoCaoTD">
                                    <button class="p-1 w-100 custom-btn" name="btnNopBC">Nộp báo cáo</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card 3 -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-70 text-center">
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-3">
                                    <div>
                                        <h5 class="card-title fw-bold mb-0">NỘP QUYỂN KHÓA LUẬN</h5>
                                        <p class="card-text small">Hạn: 2023-12-19 - 2023-12-31</p>
                                    </div>
                                </div>
                                <form action="./NopKhoaLuan">
                                <button class="p-1 w-100 custom-btn" name="btnNopKL">Nộp khóa luận</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card 4 -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-70 text-center">
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-3">
                                    <div>
                                        <h5 class="card-title fw-bold mb-0">ĐĂNG KÝ LỊCH BÁO CÁO</h5>
                                        <p class="card-text">&nbsp;</p>
                                    </div>     
                                </div>
                                <button class="p-1 w-100 custom-btn">Xem chi tiết</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Thesis Information -->
                    <div class="col-12">
                        <h2 class="section-title">THÔNG TIN ĐỀ TÀI ĐĂNG KÝ</h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">';
                                foreach($dtdk as $row){
                                    echo'
                                    <div class="col-md-6 ">
                                        <h6  style="margin:0;color:#9C9C9C;">Tên đề tài</h6>
                                        <p class="fw-semibold fs-6">'.htmlspecialchars($row["TenDeTai"]).'</p>
                                    </div>
                                    <div class="col-md-6 ">
                                        <h6  style="margin:0;color:#9C9C9C;">Giảng viên hướng dẫn</h6>
                                        <p class="fw-semibold fs-6">'.htmlspecialchars($row["GiangVienHuongDan"]).'</p>
                                    </div>
                                    <div class="col-md-6 ">
                                        <h6  style="margin:0;color:#9C9C9C;">Trạng thái đề tài</h6>
                                        <span class="status-badge status-rejected">
                                        '.$row["TrangThaiDK"].'
                                        </span>
                                    </div>
                                    <div class="col-md-6 ">
                                        <h6  style="margin:0;color:#9C9C9C;">Niên khóa</h6>
                                        <p class="fw-semibold fs-6">2020-2024</p>
                                    </div>
                                    <div class="col-md-6 ">
                                        <h6  style="margin:0;color:#9C9C9C;">Khoa/Bộ môn</h6>
                                        <p class="fw-semibold fs-6">'.htmlspecialchars($row["ChuyenNganh"]).'</p>
                                    </div>
                                    <div class="col-md-6 ">
                                        <h6 class="text-muted " style="margin:0;">Hội đồng</h6>
                                        <p class="fw-semibold fs-6">Hội đồng khoa CNTT</p>
                                    </div>
                                </div>
                                <div >
                                    <button class="btn btn-primary me-2 view-details" data-id="'.$row['IDDeTai'].'"
                                                        data-title="'.htmlspecialchars($row['TenDeTai'], ENT_QUOTES).'"
                                                        data-giangvien="'.htmlspecialchars($row['GiangVienHuongDan'], ENT_QUOTES).'"
                                                        data-mota="'.htmlspecialchars($row['MoTa'], ENT_QUOTES).'"
                                                        data-yeucau="'.htmlspecialchars($row['YeuCau'], ENT_QUOTES).'"
                                                        data-sltoida="'.$row['SoLuongTV'].'">
                                        <i class="bi bi-file-text me-1"></i> Xem chi tiết đề tài
                                    </button>
                                    
                                </div>';
                                }
                                echo'
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Group Information -->
        <div class="mb-">
            <h2 class="section-title">THÔNG TIN NHÓM THỰC HIỆN</h2>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">STT</td>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">MSSV</td>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">Họ và tên</td>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">Lớp</td>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">Email</td>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">Vai trò</td>
                                </tr>
                            </thead>
                            <tbody >';
                            $stt=1;
                            foreach($nhom as $row){
                                echo'
                                <tr>
                                    <td class="px-3">'.$stt.'</td>
                                    <td class="px-3">'.htmlspecialchars($row["MaSV"]).'</td>
                                    <td class="px-3">'.htmlspecialchars($row["HoTenSinhVien"]).'</td>
                                    <td class="px-3">'.htmlspecialchars($row["Lop"]).'</td>
                                    <td class="px-3">'.htmlspecialchars($row["Email"]).'</td>
                                    <td class="px-3">Thành viên</td>
                                </tr>';
                                $stt++;
                            }
                            echo'

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>';
echo'             <!-- Project Details Modal -->
            <div class="modal fade" id="projectDetailModal" tabindex="-1" aria-labelledby="projectDetailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="projectDetailModalLabel">Chi tiết đề tài</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="projectDetailContent">
                        </div>
                        <div class="modal-footer"> 
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>';
echo'
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>';
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const detailButtons = document.querySelectorAll(".view-details");

    detailButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            const title = this.dataset.title;
            const giangVien = this.dataset.giangvien;
            const moTa = this.dataset.mota;
            const yeuCau = this.dataset.yeucau;
            const soLuong = this.dataset.sltoida;
            const hanDK = this.dataset.handangky;

            const content = `
                <p><strong>Tên đề tài:</strong> ${title}</p>
                <p><strong>Giảng viên hướng dẫn:</strong> ${giangVien}</p>
                <p><strong>Mô tả:</strong> ${moTa}</p>
                <p><strong>Yêu cầu:</strong> ${yeuCau}</p>
                <p><strong>Số lượng tối đa:</strong> ${soLuong}</p>
            `;
            document.getElementById("projectDetailContent").innerHTML = content;
            const modal = new bootstrap.Modal(document.getElementById("projectDetailModal"));
            modal.show();
        });
    });
});
</script>