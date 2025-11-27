<?php
$iduser = $_SESSION['iduser'];
$masv = $_SESSION['MaSV'];
$dt = $this->model("mDKDT");

// Kiểm tra nếu sinh viên chưa đăng ký đề tài
if (!$dt->ktSV($masv)) {
    echo '
    <div class="col-md-3">
        <div class="navigation-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=".">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thông tin đề tài</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <!-- Modal thông báo chưa đăng ký -->
    <div class="modal fade show" id="chuaDangKyModal" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Thông báo</h5>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-info-circle text-warning" style="font-size: 3rem;"></i>
                    <p class="mt-3 fs-5">Bạn chưa đăng ký đề tài cho học kỳ này!</p>
                    <p class="text-muted">Vui lòng đăng ký đề tài trước khi xem thông tin.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="./DeTai" class="btn btn-primary" onclick="LoadingSpinner.show(\'Đang chuyển trang...\')">Đăng ký đề tài ngay</a>
                    <a href="." class="btn btn-secondary" onclick="LoadingSpinner.show(\'Đang tải...\')">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    ';
    return;
}

// Nếu đã đăng ký, hiển thị thông tin đề tài
$dtdk = json_decode($dt->getTTDeTaiByIDU($iduser), true);
$idNhom = $dt->getIDNhomByMaSV($masv);
$nhom = json_decode($dt->getTTTVNhom($idNhom), true);
$danhSachSVCungDeTai = json_decode($dt->getDanhSachSVCungDeTai($masv), true);

echo '<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Đề Tài</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../public/css/loading.css">
    <style>
        body {
            background-color: #f0f7ff;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
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
    </style>
</head>
<body>
    <div class="col-md-3">
        <div class="navigation-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=".">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thông tin đề tài</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container py-4 border">
        <h1 class="text-center fw-bold mb-5">THÔNG TIN ĐỀ TÀI ĐĂNG KÝ</h1>
        
        <div class="row col">
            <div class="col-md-3">
                <div class="card text-center" style="height: 96%;">
                    <div class="card-body">
                        <div class="d-flex justify-content-center mb-3">
                            <div>
                                <h5 class="card-title fw-bold mb-3">THÔNG TIN GIẢNG VIÊN HƯỚNG DẪN</h5>
                            </div>
                        </div>';
                        foreach($dtdk as $row):
echo'
                        <div class="mt-2 text-start">
                            <h6 style="color:#9C9C9C;">Họ tên:</h6>
                            <p class="fw-bolder fs-6">'.htmlspecialchars($row["GiangVienHuongDan"]).'</p>
                            <h6 style="color:#9C9C9C;">Số điện thoại:</h6>
                            <p class="fw-bolder fs-6">'.htmlspecialchars($row["SDT"]).'</p>
                            <h6 style="color:#9C9C9C;">Email:</h6>
                            <p class="fw-bolder fs-6">'.htmlspecialchars($row["Email"]).'</p>
                            <h6 style="color:#9C9C9C;">Khoa:</h6>
                            <p class="fw-bolder fs-6">'.htmlspecialchars($row["ChuyenNganh"]).'</p>
                        </div>';
                        endforeach;
echo'
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-70 text-center">
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-3">
                                    <div>
                                        <h5 class="card-title fw-bold mb-0">THÔNG BÁO ĐỀ TÀI TỪ GVHD</h5>
                                        <p class="card-text small">Nhận ghi chú từ giảng viên</p>
                                    </div>
                                </div>
                                <button class="p-1 w-100 custom-btn" data-bs-toggle="modal" data-bs-target="#thongBaoModal">Xem thông báo</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-70 text-center">
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-3">
                                    <div>
                                        <h5 class="card-title fw-bold mb-0">TIÊU CHÍ ĐÁNH GIÁ</h5>
                                        <p class="card-text small">Khung đánh giá khóa luận</p>
                                    </div>
                                </div>
                                <button class="p-1 w-100 custom-btn" data-bs-toggle="modal" data-bs-target="#tieuChiModal">Xem tiêu chí</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-70 text-center">
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-3">
                                    <div>
                                        <h5 class="card-title fw-bold mb-0">KẾT QUẢ CHẤM</h5>
                                        <p class="card-text small">Từ giảng viên hướng dẫn</p>
                                    </div>     
                                </div>
                                <button class="p-1 w-100 custom-btn" data-bs-toggle="modal" data-bs-target="#ketQuaChamModal">Xem kết quả</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
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
                                        <p class="fw-semibold fs-6">2024-2025</p>
                                    </div>
                                    <div class="col-md-6 ">
                                        <h6  style="margin:0;color:#9C9C9C;">Khoa/Bộ môn</h6>
                                        <p class="fw-semibold fs-6">'.htmlspecialchars($row["ChuyenNganh"]).'</p>
                                    </div>
                                    <div class="col-md-6 ">
                                        <h6 class="text-muted " style="margin:0;">Hội đồng</h6>
                                        <p class="fw-semibold fs-6">Hội đồng khoa '.htmlspecialchars($row["ChuyenNganh"]).'</p>
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
        
        <!-- Thông tin nhóm thực hiện -->
        <div class="mb-4">
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
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">Nhóm</td>
                                </tr>
                            </thead>
                            <tbody >';
                            $stt=1;
                            if (!empty($nhom)) {
                                foreach($nhom as $row){
                                    echo'
                                    <tr>
                                        <td class="px-3">'.$stt.'</td>
                                        <td class="px-3">'.htmlspecialchars($row["MaSV"]).'</td>
                                        <td class="px-3">'.htmlspecialchars($row["HoTenSinhVien"]).'</td>
                                        <td class="px-3">'.htmlspecialchars($row["Lop"]).'</td>
                                        <td class="px-3">'.htmlspecialchars($row["Email"]).'</td>
                                        <td class="px-3">'.($row["IDNhom"] ? $row["IDNhom"] : '<span style="color: #dc3545; font-weight: bold;">Làm một mình</span>').'</td>
                                    </tr>';
                                    $stt++;
                                }
                            } else {
                                // Hiển thị thông tin sinh viên hiện tại nếu chưa có nhóm
                                echo'
                                <tr>
                                    <td class="px-3">1</td>
                                    <td class="px-3">'.$masv.'</td>
                                    <td class="px-3">'.$_SESSION['ten'].'</td>
                                    <td class="px-3">-</td>
                                    <td class="px-3">-</td>
                                    <td class="px-3"><span style="color: #dc3545; font-weight: bold;">Làm một mình</span></td>
                                </tr>';
                            }
                            echo'
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Danh sách sinh viên đăng ký cùng đề tài -->
        <div class="mb-4">
            <h2 class="section-title">DANH SÁCH CÁC SINH VIÊN ĐĂNG KÝ CÙNG ĐỀ TÀI</h2>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">STT</td>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">MSSV</td>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">Họ Tên</td>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">Lớp</td>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">GVHD</td>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">Nhóm</td>
                                    <td class="px-3"style="background-color:#E8E8E8;color:#9C9C9C;">Chọn Làm Chung Nhóm</td>
                                </tr>
                            </thead>
                            <tbody>';
                            $stt=1;
                            $currentUserMaSV = $_SESSION['MaSV'];
                            $currentUserNhom = null;
                            
                            // Tìm nhóm của user hiện tại
                            foreach($nhom as $row){
                                if($row["MaSV"] == $currentUserMaSV){
                                    $currentUserNhom = $row["IDNhom"];
                                    break;
                                }
                            }
                            
                            // Kiểm tra xem user hiện tại đã có nhóm với người khác chưa
                            $daCoNhom = count($nhom) > 1;
                            
                            if(!empty($danhSachSVCungDeTai)){
                                foreach($danhSachSVCungDeTai as $sv){
                                    // Không hiển thị bản thân
                                    if($sv["MaSV"] == $currentUserMaSV) continue;
                                    
                                    $tenNhom = $sv["IDNhom"] == $currentUserNhom ? $sv["IDNhom"] : ($sv["SoLuongThanhVien"] > 1 ? $sv["IDNhom"] : "Làm một mình");
                                    $isDisabled = $daCoNhom || ($sv["SoLuongThanhVien"] > 1) ? 'disabled' : '';
                                    $checkboxValue = $daCoNhom ? '' : ($sv["IDNhom"] == $currentUserNhom ? 'checked' : '');
                                    
                                    echo'
                                    <tr>
                                        <td class="px-3">'.$stt.'</td>
                                        <td class="px-3">'.htmlspecialchars($sv["MaSV"]).'</td>
                                        <td class="px-3">'.htmlspecialchars($sv["HoTen"]).'</td>
                                        <td class="px-3">'.htmlspecialchars($sv["Lop"]).'</td>
                                        <td class="px-3">'.htmlspecialchars($sv["GiangVienHuongDan"]).'</td>
                                        <td class="px-3 text-danger fw-bold">'.$tenNhom.'</td>
                                        <td class="px-3 text-center">
                                            <input type="radio" name="chonNhom" value="'.$sv["MaSV"].'" '.$isDisabled.' '.$checkboxValue.' class="form-check-input">
                                        </td>
                                    </tr>';
                                    $stt++;
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">Chỉ có bạn đăng ký đề tài này</td></tr>';
                            }
                            echo'
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="text-end mt-3">';
            
            // Hiển thị nút dựa trên trạng thái nhóm
            if($daCoNhom){
                echo '<button class="btn btn-danger" id="btnHuyNhom">Hủy nhóm</button>';
            } else {
                echo '
                <button class="btn btn-danger me-2" id="btnHuyDangKy">Hủy đăng ký đề tài</button>
                <button class="btn btn-primary" id="btnDangKyNhom">Đăng ký nhóm</button>';
            }
            
            echo '
            </div>
        </div>
    </div>
    
    <!-- Modals -->';

include 'DeTaiDK_Modals.php';

echo '
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/loading.js"></script>
</body>
</html>';
?>
