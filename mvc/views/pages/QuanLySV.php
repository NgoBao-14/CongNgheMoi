<?php
require_once "./mvc/views/components/sidebarAdmin.php";
$dt = json_decode($data["khoa"], true);
$sv = json_decode($data["sinhvien"], true);

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
        
        .filter-section {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #E2E8F0;
        }
        
        .table-container {
            background: white;
            border-radius: 1rem;
            border: 1px solid #E2E8F0;
            overflow: hidden;
            max-height: calc(100vh - 350px);
            display: flex;
            flex-direction: column;
        }
        
        .table-wrapper {
            overflow-y: auto;
            overflow-x: auto;
            flex: 1;
        }
        
        /* Custom scrollbar */
        .table-wrapper::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        .table-wrapper::-webkit-scrollbar-track {
            background: #F1F5F9;
            border-radius: 4px;
        }
        
        .table-wrapper::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 4px;
        }
        
        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }
        
        .data-table {
            margin: 0;
            width: 100%;
        }
        
        .data-table thead {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
        }
        
        .data-table thead th {
            padding: 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: none;
            white-space: nowrap;
        }
        
        .data-table tbody td {
            padding: 1rem;
            font-size: 0.875rem;
            color: #334155;
            border-bottom: 1px solid #F1F5F9;
            vertical-align: middle;
        }
        
        .data-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .data-table tbody tr:hover {
            background: #F8FAFC;
        }
        
        .badge-custom {
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }
    </style>

    <div class="container-fluid p-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-2" style="color: #0F172A;">Quản lý sinh viên</h1>
                    <p class="text-muted mb-0">Danh sách và thông tin sinh viên</p>
                </div>
                <a href="/CongNgheMoi/Admin/ThemSinhVien" class="btn btn-action" style="background: #4F46E5; color: white;">
                    <i class="fas fa-plus me-2"></i>Thêm sinh viên
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="POST" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size: 0.875rem; color: #64748B;">Lọc theo khoa</label>
                    <select name="loc" class="form-select" style="border-radius: 0.5rem;" onchange="this.form.submit()">
                        <option value="">Tất cả khoa</option>';
                        foreach ($dt as $row) {
                            echo '<option value="' . $row['IDNganh'] . '">' . $row['ChuyenNganh'] . '</option>';
                        }
echo '              </select>
                    <input type="hidden" name="btnLoc" value="1">
                </div>
                <div class="col-md-8 text-end">
                    <span class="badge-custom" style="background: #EFF6FF; color: #3B82F6;">
                        <i class="fas fa-users me-2"></i>' . count($sv) . ' sinh viên
                    </span>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="table-wrapper">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th width="5%">STT</th>
                            <th width="12%">MSSV</th>
                            <th width="25%">Họ và tên</th>
                            <th width="12%">Lớp</th>
                            <th width="20%">Chuyên ngành</th>
                            <th width="18%">Email</th>
                            <th width="8%"></th>
                        </tr>
                    </thead>
                    <tbody>';
                    
$i = 1;
if (!empty($sv)) {
    foreach ($sv as $row) {
        echo '
        <tr>
            <td class="fw-semibold">' . $i++ . '</td>
            <td><span class="badge-custom" style="background: #EFF6FF; color: #3B82F6;">' . $row['MaSV'] . '</span></td>
            <td class="fw-semibold">' . htmlspecialchars($row['HoDem'] . ' ' . $row['Ten']) . '</td>
            <td>' . htmlspecialchars($row['Lop']) . '</td>
            <td><span style="font-size: 0.8125rem;">' . htmlspecialchars($row['ChuyenNganh']) . '</span></td>
            <td><span style="font-size: 0.8125rem; color: #64748B;">' . htmlspecialchars(isset($row['Email']) ? $row['Email'] : 'N/A') . '</span></td>
            <td>
                <a href="/CongNgheMoi/Admin/CapNhatSV?id=' . $row['iduser'] . '" class="btn btn-sm" style="background: #F8FAFC; color: #4F46E5; border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 0.375rem 0.75rem;">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
        </tr>';
    }
} else {
    echo '
        <tr>
            <td colspan="7">
                <div class="empty-state">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #CBD5E1; margin-bottom: 1rem;"></i>
                    <h5 style="color: #64748B;">Không có dữ liệu</h5>
                    <p class="text-muted">Chưa có sinh viên nào trong hệ thống</p>
                </div>
            </td>
        </tr>';
}

echo '
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>';
?>
