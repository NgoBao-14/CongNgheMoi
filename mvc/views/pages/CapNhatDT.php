<?php
require_once "./mvc/views/components/sidebarAdmin.php";
$detai = json_decode($data['detai'], true);
$dt = json_decode($data['khoa'], true);
$nhom = json_decode($data['nhom'], true);

// Kiểm tra dữ liệu
if (empty($detai) || !isset($detai[0])) {
    echo '<div class="content-wrapper"><div class="container-fluid p-4"><div class="alert alert-danger">Không tìm thấy đề tài!</div><a href="' . base_url('/Admin/DSDeTai') . '" class="btn btn-primary">Quay lại</a></div></div>';
    return;
}
$detai = $detai[0]; // Lấy phần tử đầu tiên

echo '
<div class="content-wrapper">
    <style>
        .page-header {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            border: 1px solid #E2E8F0;
        }
        
        .form-container {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            border: 1px solid #E2E8F0;
        }
        
        .info-badge {
            background: #FFFBEB;
            color: #F59E0B;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-block;
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-control, .form-select {
            border-radius: 0.5rem !important;
            border: 1px solid #E2E8F0 !important;
            padding: 0.625rem 0.875rem !important;
            font-size: 0.875rem !important;
            transition: all 0.2s;
            width: 100%;
            background-color: white !important;
            background-image: none !important;
        }
        
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 16 16%27%3e%3cpath fill=%27none%27 stroke=%27%23334155%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M2 5l6 6 6-6%27/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.75rem center !important;
            background-size: 16px 12px !important;
            padding-right: 2.5rem !important;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #4F46E5 !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
            outline: none !important;
        }
        
        textarea.form-control {
            min-height: 100px;
        }
        
        .btn-submit {
            background: #4F46E5;
            color: white;
            border: none;
            padding: 0.625rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        
        .btn-submit:hover {
            background: #4338CA;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        
        .btn-cancel {
            background: #F8FAFC;
            color: #64748B;
            border: 1px solid #E2E8F0;
            padding: 0.625rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        
        .btn-cancel:hover {
            background: #F1F5F9;
            color: #334155;
        }
        
        .required {
            color: #EF4444;
        }
    </style>

    <div class="container-fluid p-4">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="h3 fw-bold mb-2" style="color: #0F172A;">Cập nhật thông tin đề tài</h1>
            <p class="text-muted mb-0">Chỉnh sửa thông tin đề tài khóa luận</p>
        </div>

        <!-- Form -->
        <div class="form-container">
            <div class="info-badge">
                <i class="fas fa-hashtag me-2"></i>Mã đề tài: ' . $detai['IDDeTai'] . '
            </div>

            <form method="POST" action="">
                <input type="hidden" name="id" value="' . $detai['IDDeTai'] . '">
                
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label">Tên đề tài <span class="required">*</span></label>
                        <input type="text" name="ten" class="form-control" value="' . htmlspecialchars($detai['TenDeTai']) . '" required>
                    </div>
                </div>
                
                <div class="row g-4 mt-2">
                    <div class="col-md-12">
                        <label class="form-label">Mô tả <span class="required">*</span></label>
                        <textarea name="mota" class="form-control" required>' . htmlspecialchars($detai['MoTa']) . '</textarea>
                    </div>
                </div>
                
                <div class="row g-4 mt-2">
                    <div class="col-md-12">
                        <label class="form-label">Yêu cầu <span class="required">*</span></label>
                        <textarea name="yeucau" class="form-control" required>' . htmlspecialchars($detai['YeuCau']) . '</textarea>
                    </div>
                </div>
                
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Chuyên ngành <span class="required">*</span></label>
                        <select name="chuyennganh" class="form-select" required>
                            <option value="">Chọn chuyên ngành</option>';
                            foreach ($dt as $row) {
                                $selected = ($detai['IDNganh'] == $row['IDNganh']) ? 'selected' : '';
                                echo '<option value="' . $row['IDNganh'] . '" ' . $selected . '>' . $row['ChuyenNganh'] . '</option>';
                            }
echo '                  </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Số lượng thành viên <span class="required">*</span></label>
                        <input type="number" name="soluong" class="form-control" value="' . (isset($detai['SoLuongTV']) ? $detai['SoLuongTV'] : '1') . '" min="1" max="5" required>
                    </div>
                </div>
                
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Trạng thái đề tài <span class="required">*</span></label>
                        <select name="trangthaidetai" class="form-select" required>
                            <option value="Chưa duyệt" ' . ($detai['TrangThaiDeTai'] == 'Chưa duyệt' ? 'selected' : '') . '>Chưa duyệt</option>
                            <option value="Đã duyệt" ' . ($detai['TrangThaiDeTai'] == 'Đã duyệt' ? 'selected' : '') . '>Đã duyệt</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Trạng thái đăng ký <span class="required">*</span></label>
                        <select name="trangthaidk" class="form-select" required>
                            <option value="Chưa đăng ký" ' . ($detai['TrangThaiDK'] == 'Chưa đăng ký' ? 'selected' : '') . '>Chưa đăng ký</option>
                            <option value="Đã đăng ký" ' . ($detai['TrangThaiDK'] == 'Đã đăng ký' ? 'selected' : '') . '>Đã đăng ký</option>
                        </select>
                    </div>
                </div>
                
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Ngày đăng ký</label>
                        <input type="date" name="ngaydk" class="form-control" value="' . (isset($detai['NgayDK']) ? $detai['NgayDK'] : '') . '">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Nhóm</label>
                        <select name="nhom" class="form-select">
                            <option value="">Chưa có nhóm</option>';
                            foreach ($nhom as $row) {
                                $selected = (isset($detai['IDNhom']) && $detai['IDNhom'] == $row['IDNhom']) ? 'selected' : '';
                                echo '<option value="' . $row['IDNhom'] . '" ' . $selected . '>Nhóm ' . $row['IDNhom'] . '</option>';
                            }
echo '                  </select>
                    </div>
                </div>
                
                <div class="d-flex gap-2 justify-content-end mt-4 pt-4" style="border-top: 1px solid #E2E8F0;">
                    <a href="' . base_url('/Admin/DSDeTai') . '" class="btn btn-cancel">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" name="btn_CapNhat" class="btn btn-submit">
                        <i class="fas fa-save me-2"></i>Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>';
?>
