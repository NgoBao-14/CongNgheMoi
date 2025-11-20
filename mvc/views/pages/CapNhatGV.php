<?php
require_once "./mvc/views/components/sidebarAdmin.php";
$gv = json_decode($data['giangvien'], true);
$dt = json_decode($data['khoa'], true);
$chucvu = json_decode($data['chucvu'], true);

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
            background: #ECFDF5;
            color: #10B981;
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
            background-image: url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 16 16\'%3e%3cpath fill=\'none\' stroke=\'%23334155\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M2 5l6 6 6-6\'/%3e%3c/svg%3e") !important;
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
            <h1 class="h3 fw-bold mb-2" style="color: #0F172A;">Cập nhật thông tin giảng viên</h1>
            <p class="text-muted mb-0">Chỉnh sửa thông tin giảng viên trong hệ thống</p>
        </div>

        <!-- Form -->
        <div class="form-container">
            <div class="info-badge">
                <i class="fas fa-id-card me-2"></i>Mã GV: ' . $gv[0]['MaGV'] . '
            </div>

            <form method="POST" action="">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Họ đệm <span class="required">*</span></label>
                        <input type="text" name="hodem" class="form-control" value="' . htmlspecialchars($gv[0]['HoDem']) . '" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Tên <span class="required">*</span></label>
                        <input type="text" name="ten" class="form-control" value="' . htmlspecialchars($gv[0]['Ten']) . '" required>
                    </div>
                </div>
                
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Chuyên ngành <span class="required">*</span></label>
                        <select name="chuyennganh" class="form-select" required>
                            <option value="">Chọn chuyên ngành</option>';
                            foreach ($dt as $row) {
                                $selected = ($gv[0]['IDNganh'] == $row['IDNganh']) ? 'selected' : '';
                                echo '<option value="' . $row['IDNganh'] . '" ' . $selected . '>' . $row['ChuyenNganh'] . '</option>';
                            }
echo '                  </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Chức vụ <span class="required">*</span></label>
                        <select name="chucvu" class="form-select" required>
                            <option value="">Chọn chức vụ</option>';
                            foreach ($chucvu as $row) {
                                $selected = (isset($gv[0]['idCV']) && $gv[0]['idCV'] == $row['idCV']) ? 'selected' : '';
                                echo '<option value="' . $row['idCV'] . '" ' . $selected . '>' . $row['ChucVu'] . '</option>';
                            }
echo '                  </select>
                    </div>
                </div>
                
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Số điện thoại <span class="required">*</span></label>
                        <input type="tel" name="sdt" class="form-control" value="' . htmlspecialchars($gv[0]['SDT']) . '" required pattern="[0-9]{10}">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control" value="' . htmlspecialchars($gv[0]['Email']) . '" required>
                    </div>
                </div>
                
                <div class="d-flex gap-2 justify-content-end mt-4 pt-4" style="border-top: 1px solid #E2E8F0;">
                    <a href="/CongNgheMoi/Admin/QuanLyGV" class="btn btn-cancel">
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
