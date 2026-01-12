<?php
require_once "./mvc/views/components/sidebarAdmin.php";
$dt = json_decode($data["khoa"], true);
$detai = json_decode($data["detai"], true);

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
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15);
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .badge-custom i {
            font-size: 0.7rem;
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
                    <h1 class="h3 fw-bold mb-2" style="color: #0F172A;">Quản lý đề tài</h1>
                    <p class="text-muted mb-0">Danh sách và thông tin đề tài khóa luận</p>
                </div>
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
                    <span class="badge-custom" style="background: #FFFBEB; color: #F59E0B;">
                        <i class="fas fa-book me-2"></i>' . count($detai) . ' đề tài
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
                            <th width="4%">STT</th>
                            <th width="8%">Mã ĐT</th>
                            <th width="28%">Tên đề tài</th>
                            <th width="15%">Giảng viên</th>
                            <th width="13%">Chuyên ngành</th>
                            <th width="10%">Trạng thái</th>
                            <th width="8%">Nhóm</th>
                            <th width="7%">SL TV</th>
                            <th width="7%"></th>
                        </tr>
                    </thead>
                    <tbody>';
                    
$i = 1;
if (!empty($detai)) {
    foreach ($detai as $row) {
        $trangThai = $row['TrangThaiDeTai'];
        
        // Style cho trạng thái với icon
        if ($trangThai == 'Đã duyệt') {
            $badgeStyle = 'background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); color: #059669; border: 1px solid #A7F3D0; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.1);';
            $icon = '<i class="fas fa-check-circle" style="margin-right: 4px;"></i>';
        } else {
            $badgeStyle = 'background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%); color: #D97706; border: 1px solid #FDE68A; box-shadow: 0 2px 4px rgba(245, 158, 11, 0.1);';
            $icon = '<i class="fas fa-clock" style="margin-right: 4px;"></i>';
        }
        
        echo '
        <tr>
            <td class="fw-semibold">' . $i++ . '</td>
            <td><span class="badge-custom" style="background: #EFF6FF; color: #3B82F6;">' . $row['IDDeTai'] . '</span></td>
            <td class="fw-semibold">' . htmlspecialchars($row['TenDeTai']) . '</td>
            <td><span style="font-size: 0.8125rem;">' . htmlspecialchars(isset($row['ten_giang_vien']) ? $row['ten_giang_vien'] : 'N/A') . '</span></td>
            <td><span style="font-size: 0.8125rem;">' . htmlspecialchars($row['ChuyenNganh']) . '</span></td>
            <td><span class="badge-custom" style="' . $badgeStyle . ' font-weight: 600;">' . $icon . $trangThai . '</span></td>
            <td>' . (isset($row['IDNhom']) && $row['IDNhom'] ? '<span class="badge-custom" style="background: #F5F3FF; color: #8B5CF6;">Nhóm ' . $row['IDNhom'] . '</span>' : '<span class="badge-custom" style="background: #F1F5F9; color: #64748B;">-</span>') . '</td>
            <td class="text-center"><span class="badge-custom" style="background: #F1F5F9; color: #334155;">' . (isset($row['SoLuongTV']) ? $row['SoLuongTV'] : '0') . '</span></td>
            <td>
                <div class="d-flex gap-1">
                    <a href="' . base_url('/Admin/CapNhatDT?id=' . $row['IDDeTai']) . '" class="btn btn-sm" style="background: #F8FAFC; color: #4F46E5; border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 0.375rem 0.75rem;" title="Chỉnh sửa">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-xoa-detai" data-id="' . $row['IDDeTai'] . '" data-ten="' . htmlspecialchars($row['TenDeTai']) . '" style="background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; border-radius: 0.5rem; padding: 0.375rem 0.75rem;" title="Xóa">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>';
    }
} else {
    echo '
        <tr>
            <td colspan="9">
                <div class="empty-state">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #CBD5E1; margin-bottom: 1rem;"></i>
                    <h5 style="color: #64748B;">Không có dữ liệu</h5>
                    <p class="text-muted">Chưa có đề tài nào trong hệ thống</p>
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
</div>

<!-- Modal Xác nhận xóa -->
<div class="modal fade" id="modalXoaDeTai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 1rem; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%); border-radius: 1rem 1rem 0 0; border: none;">
                <h5 class="modal-title" style="color: #DC2626;">
                    <i class="fas fa-exclamation-triangle me-2"></i>Xác nhận xóa đề tài
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-3">Bạn có chắc chắn muốn xóa đề tài:</p>
                <div class="alert" style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 0.5rem;">
                    <strong id="tenDeTaiXoa" style="color: #DC2626;"></strong>
                </div>
                <p class="text-muted mb-0" style="font-size: 0.875rem;">
                    <i class="fas fa-info-circle me-1"></i>
                    Hành động này không thể hoàn tác. Tất cả dữ liệu liên quan sẽ bị xóa.
                </p>
            </div>
            <div class="modal-footer" style="border: none;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: #F1F5F9; color: #64748B; border-radius: 0.5rem;">
                    <i class="fas fa-times me-1"></i>Hủy
                </button>
                <form id="formXoaDeTai" method="POST" action="' . base_url('/Admin/XoaDeTai') . '" style="display: inline;">
                    <input type="hidden" name="id" id="idDeTaiXoa">
                    <button type="submit" name="btn_xoa" class="btn" style="background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%); color: white; border-radius: 0.5rem;">
                        <i class="fas fa-trash me-1"></i>Xóa đề tài
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Xử lý click nút xóa
    document.querySelectorAll(".btn-xoa-detai").forEach(function(btn) {
        btn.addEventListener("click", function() {
            var id = this.getAttribute("data-id");
            var ten = this.getAttribute("data-ten");
            
            document.getElementById("idDeTaiXoa").value = id;
            document.getElementById("tenDeTaiXoa").textContent = ten;
            
            var modal = new bootstrap.Modal(document.getElementById("modalXoaDeTai"));
            modal.show();
        });
    });
});
</script>';
?>
