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
            background-color: #f5f7fa;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            border: none;
            transition: 0.3s;
        }
        .custom-btn {
            border: 1px solid #007dc9;
            color: #007dc9;
            background-color: transparent;
            border-radius: 8px;
            transition: 0.3s;
            font-weight: 500;
        }
        .custom-btn:hover {
            background-color: #007dc9;
            color: white;
        }
        .section-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
        }
        .status-badge {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
        }
        .status-approved {
            background-color: #c6f6d5;
            color: #22543d;
        }

        .info-label {
            font-size: 0.9rem;
            color: #717171;
            font-weight: 500;
            margin-bottom: 0.4rem;
        }
        .info-value {
            font-size: 1rem;
            color: #1a1a1a;
            font-weight: 600;
            margin-bottom: 1.2rem;
        }
        .detai-header {
            background: linear-gradient(135deg, #007dc9 0%, #0066a1 100%);
            color: white;
            padding: 1rem;
            // border-radius: 10px 10px 0 0;
            // margin-bottom: 1rem;
        }
        .detai-header h5 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.4;
        }
        .detai-content {
            padding: 1.2rem;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e0e0e0;
        }
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .info-item .info-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #717171;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-item .info-value {
            font-size: 1.05rem;
            color: #1a1a1a;
            font-weight: 500;
            margin: 0;
        }
        .details-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        @media (max-width: 992px) {
            .details-section {
                grid-template-columns: 1fr;
            }
        }
        .detail-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #f0f2f5 100%);
            padding: 1.25rem;
            border-radius: 10px;
            border-left: 4px solid #007dc9;
        }
        .detail-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 0.75rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .detail-text {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #555;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin: 0;
        }
        .feature-card {
            // background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid #e6e5e5ff;
            transition: 0.3s;
            
        }
        .feature-card .custom-btn {
            border: 1px solid #b4b4b4ff;
        }
        .feature-card .custom-btn:hover {
            background-color: #007dc9;
            color: white;
        }
        .feature-card h6 {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }
        .feature-card p {
            font-size: 0.9rem;
            color: #717171;
            margin: 0;
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
    <div class="container py-4">
        <h1 class="text-center fw-bold mb-4">THÔNG TIN ĐỀ TÀI ĐĂNG KÝ</h1>
        
        <!-- 3 Khung nổi bật ở trên cùng -->
        <div class="row mb-5">
            <div class="col-md-4 mb-3">
                <div class="feature-card">
                    <h6><i class="bi bi-bell-fill" style="color: #007dc9; margin-right: 0.5rem;"></i>THÔNG BÁO ĐỀ TÀI</h6>
                    <p>Nhận ghi chú từ giảng viên</p>
                    <button class="btn btn-sm custom-btn mt-2 w-100" data-bs-toggle="modal" data-bs-target="#thongBaoModal">
                        <i class="bi bi-eye"></i> Xem thông báo
                    </button>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="feature-card">
                    <h6><i class="bi bi-clipboard-check" style="color: #007dc9; margin-right: 0.5rem;"></i>TIÊU CHÍ ĐÁNH GIÁ</h6>
                    <p>Khung đánh giá khóa luận</p>
                    <button class="btn btn-sm custom-btn mt-2 w-100" data-bs-toggle="modal" data-bs-target="#tieuChiModal">
                        <i class="bi bi-eye"></i> Xem tiêu chí
                    </button>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="feature-card">
                    <h6><i class="bi bi-star-fill" style="color: #007dc9; margin-right: 0.5rem;"></i>KẾT QUẢ CHẤM</h6>
                    <p>Từ giảng viên hướng dẫn</p>
                    <button class="btn btn-sm custom-btn mt-2 w-100" data-bs-toggle="modal" data-bs-target="#ketQuaChamModal">
                        <i class="bi bi-eye"></i> Xem kết quả
                    </button>
                </div>
            </div>
        </div>

        <!-- Thông tin đề tài đăng ký - Gộp GVHD + Đề tài -->
        <h2 class="section-title">THÔNG TIN ĐỀ TÀI & GIẢNG VIÊN HƯỚNG DẪN</h2>
        <div class="card">';
                        foreach($dtdk as $row){
                            echo '
                            <div class="detai-header">
                                <h5>'.htmlspecialchars($row["TenDeTai"]).'</h5>
                            </div>
                            <div class="detai-content">
                                <!-- Info Grid - Gọn gàng -->
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label"><i class="bi bi-person-fill"></i> GVHD</span>
                                        <span class="info-value">'.htmlspecialchars($row["GiangVienHuongDan"]).'</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label"><i class="bi bi-check-circle"></i> Trạng thái</span>
                                        <span class="status-badge status-approved">
                                            '.$row["TrangThaiDK"].'
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label"><i class="bi bi-building"></i> Khoa</span>
                                        <span class="info-value">'.htmlspecialchars($row["ChuyenNganh"]).'</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label"><i class="bi bi-envelope"></i> Email</span>
                                        <span class="info-value">
                                            <a href="mailto:'.htmlspecialchars($row["Email"]).'" style="color: #007dc9; text-decoration: none;">
                                                '.htmlspecialchars($row["Email"]).'
                                            </a>
                                        </span>
                                    </div>
                                </div>

                                <!-- Mô tả và Yêu cầu -->
                                <div class="details-section">
                                    <div class="detail-box">
                                        <h6 class="detail-title"><i class="bi bi-file-text"></i> Mô tả đề tài</h6>
                                        <p class="detail-text">'.htmlspecialchars($row["MoTa"]).'</p>
                                    </div>

                                    <div class="detail-box">
                                        <h6 class="detail-title"><i class="bi bi-list-check"></i> Yêu cầu đề tài</h6>
                                        <p class="detail-text">'.htmlspecialchars($row["YeuCau"]).'</p>
                                    </div>
                                </div>

                            </div>
                            ';
                        }
                        echo '
            </div>
        </div>
        
        <!-- Thông tin nhóm thực hiện -->
        <div class="mb-5">
            <h2 class="section-title">THÔNG TIN THÀNH VIÊN(NHÓM) THỰC HIỆN</h2>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">STT</th>
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">MSSV</th>
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">Họ và tên</th>
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">Lớp</th>
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">Email</th>
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">Nhóm</th>
                                </tr>
                            </thead>
                            <tbody>';
                            $stt=1;
                            if (!empty($nhom)) {
                                foreach($nhom as $row){
                                    echo'
                                    <tr style="border-bottom: 1px solid #e0e0e0;">
                                        <td class="px-4 py-3">'.$stt.'</td>
                                        <td class="px-4 py-3">'.htmlspecialchars($row["MaSV"]).'</td>
                                        <td class="px-4 py-3">'.htmlspecialchars($row["HoTenSinhVien"]).'</td>
                                        <td class="px-4 py-3">'.htmlspecialchars($row["Lop"]).'</td>
                                        <td class="px-4 py-3">'.htmlspecialchars($row["Email"]).'</td>
                                        <td class="px-4 py-3">'.($row["IDNhom"] ? '<strong>'.htmlspecialchars($row["IDNhom"]).'</strong>' : '<span style="color: #dc3545; font-weight: bold;">Làm một mình</span>').'</td>
                                    </tr>';
                                    $stt++;
                                }
                            } else {
                                // Hiển thị thông tin sinh viên hiện tại nếu chưa có nhóm
                                echo'
                                <tr style="border-bottom: 1px solid #e0e0e0;">
                                    <td class="px-4 py-3">1</td>
                                    <td class="px-4 py-3">'.$masv.'</td>
                                    <td class="px-4 py-3">'.$_SESSION['ten'].'</td>
                                    <td class="px-4 py-3">-</td>
                                    <td class="px-4 py-3">-</td>
                                    <td class="px-4 py-3"><span style="color: #dc3545; font-weight: bold;">Làm một mình</span></td>
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
        <div class="mb-5">
            <h2 class="section-title">DANH SÁCH CÁC SINH VIÊN ĐĂNG KÝ CÙNG ĐỀ TÀI</h2>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">STT</th>
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">MSSV</th>
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">Họ Tên</th>
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">Lớp</th>
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">GVHD</th>
                                    <th class="px-4 py-3" style="color: #717171; font-weight: 600;">Nhóm</th>
                                    <th class="px-4 py-3 text-center" style="color: #717171; font-weight: 600;">Chọn Làm Chung Nhóm</th>
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
                                    <tr style="border-bottom: 1px solid #e0e0e0;">
                                        <td class="px-4 py-3">'.$stt.'</td>
                                        <td class="px-4 py-3">'.htmlspecialchars($sv["MaSV"]).'</td>
                                        <td class="px-4 py-3">'.htmlspecialchars($sv["HoTen"]).'</td>
                                        <td class="px-4 py-3">'.htmlspecialchars($sv["Lop"]).'</td>
                                        <td class="px-4 py-3">'.htmlspecialchars($sv["GiangVienHuongDan"]).'</td>
                                        <td class="px-4 py-3">
                                            '.($sv["SoLuongThanhVien"] > 1 ? '<strong style="color: #007dc9;">'.htmlspecialchars($tenNhom).'</strong>' : '<span style="color: #dc3545; font-weight: bold;">'.htmlspecialchars($tenNhom).'</span>').'
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <input type="radio" name="chonNhom" value="'.$sv["MaSV"].'" '.$isDisabled.' '.$checkboxValue.' class="form-check-input">
                                        </td>
                                    </tr>';
                                    $stt++;
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center px-4 py-4">Chỉ có bạn đăng ký đề tài này</td></tr>';
                            }
                            echo'
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="text-end mt-4">';
            
            // Hiển thị nút dựa trên trạng thái nhóm
            if($daCoNhom){
                echo '<button class="btn btn-danger btn-lg" id="btnHuyNhom"><i class="bi bi-trash"></i> Hủy nhóm</button>';
            } else {
                echo '
                <button class="btn btn-danger btn-lg me-2" id="btnHuyDangKy"><i class="bi bi-x-circle"></i> Hủy đăng ký đề tài</button>
                <button class="btn btn-primary btn-lg" id="btnDangKyNhom"><i class="bi bi-check-circle"></i> Đăng ký nhóm</button>';
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
