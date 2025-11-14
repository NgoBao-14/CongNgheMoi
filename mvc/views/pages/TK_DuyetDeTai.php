<?php
require_once "./mvc/views/components/sidebarTK.php";
$dt = $data["dt"];
$perPage = 10;
$total = count($dt);
$totalPages = ceil($total / $perPage);

$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages));

$startIndex = ($currentPage - 1) * $perPage;
$dtPage = array_slice($dt, $startIndex, $perPage);

echo '
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    .modern-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .modern-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .modern-table thead th {
        border: none;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    .modern-table tbody tr {
        transition: all 0.3s ease;
    }
    .modern-table tbody tr:hover {
        background: #f8f9fc;
    }
    .modern-table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e3e6f0;
    }
    .btn-modern {
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        border: none;
    }
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>

<div class="container-fluid p-4">
    <div class="page-header">
        <h2 class="mb-0"><i class="fas fa-check-circle me-2"></i>Duyệt đề tài</h2>
        <p class="mb-0 mt-2" style="opacity: 0.9;">Quản lý và phê duyệt các đề tài khóa luận</p>
    </div>
    
    <div class="modern-card">
        <table class="table modern-table mb-0">
            <thead>
                <tr>
                    <th width="5%">STT</th>
                    <th width="12%">Mã đề tài</th>
                    <th width="35%">Tên đề tài</th>
                    <th width="23%">Giảng viên</th>
                    <th width="25%">Thao tác</th>
                </tr>
            </thead>
            <tbody>';

$i = $startIndex + 1;
$coDeTai = false;

foreach ($dtPage as $row) {
    if ($row['TrangThaiDeTai'] === 'Chưa duyệt') {
        $coDeTai = true;
        echo '
        <tr>
            <td>' . $i . '</td>
            <td><span class="badge bg-secondary">' . $row['IDDeTai'] . '</span></td>
            <td><strong>' . htmlspecialchars($row['TenDeTai']) . '</strong></td>
            <td>' . htmlspecialchars($row['ten_giang_vien']) . '</td>
            <td>
                <form method="post" class="d-inline">
                    <button 
                        type="button"
                        class="btn btn-modern btn-sm me-1"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff;"
                        data-id="' . $row['IDDeTai'] . '"
                        data-title="' . htmlspecialchars($row['TenDeTai'], ENT_QUOTES) . '"
                        data-giangvien="' . htmlspecialchars($row['ten_giang_vien'], ENT_QUOTES) . '"
                        data-mota="' . htmlspecialchars($row['MoTa'], ENT_QUOTES) . '"
                        data-yeucau="' . htmlspecialchars($row['YeuCau'], ENT_QUOTES) . '"
                        data-sltoida="' . $row['SoLuongTV'] . '"
                        onclick="showDetails(this)"
                    ><i class="fas fa-eye me-1"></i>Chi tiết</button>
                    
                    <input type="hidden" name="idDetai" value="' . $row['IDDeTai'] . '">
                    <input type="hidden" name="TenDeTai" value="' . $row['TenDeTai'] . '">
                    <button 
                        type="submit" 
                        name="btnDuyet" 
                        class="btn btn-modern btn-sm"
                        style="background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%); color: #fff;"
                        onclick="return confirm(\'Bạn có chắc chắn muốn duyệt đề tài này?\');"
                    ><i class="fas fa-check me-1"></i>Duyệt</button>
                </form>
            </td>
        </tr>';
        $i++;
    }
}

if (!$coDeTai) {
    echo '<tr><td colspan="5" class="text-center py-5">
            <i class="fas fa-inbox" style="font-size: 3rem; color: #e3e6f0; margin-bottom: 15px; display: block;"></i>
            <span class="text-muted">Không có đề tài cần duyệt</span>
          </td></tr>';
}

echo '
            </tbody>
        </table>
    </div>';

if ($totalPages > 1) {
    echo '
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">';
    for ($page = 1; $page <= $totalPages; $page++) {
        $active = ($page == $currentPage) ? 'active' : '';
        echo '<li class="page-item ' . $active . '">
                <a class="page-link" href="?page=' . $page . '" style="border-radius: 10px; margin: 0 3px;">' . $page . '</a>
              </li>';
    }
    echo '
        </ul>
    </nav>';
}

echo '
</div>

<div class="modal fade" id="projectDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Chi tiết đề tài</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="projectDetailContent" style="font-size: 1rem;"></div>
            <div class="modal-footer" style="border: none;">
                <button type="button" class="btn btn-modern" style="background: #858796; color: white;" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
function showDetails(btn) {
    const title = btn.dataset.title;
    const giangVien = btn.dataset.giangvien;
    const moTa = btn.dataset.mota;
    const yeuCau = btn.dataset.yeucau;
    const soLuong = btn.dataset.sltoida;
    
    const content = `
        <div class="mb-3">
            <strong style="color: #667eea;"><i class="fas fa-book me-2"></i>Tên đề tài:</strong>
            <p class="ms-4 mt-2">${title}</p>
        </div>
        <div class="mb-3">
            <strong style="color: #667eea;"><i class="fas fa-user-tie me-2"></i>Giảng viên hướng dẫn:</strong>
            <p class="ms-4 mt-2">${giangVien}</p>
        </div>
        <div class="mb-3">
            <strong style="color: #667eea;"><i class="fas fa-align-left me-2"></i>Mô tả:</strong>
            <p class="ms-4 mt-2">${moTa}</p>
        </div>
        <div class="mb-3">
            <strong style="color: #667eea;"><i class="fas fa-tasks me-2"></i>Yêu cầu:</strong>
            <p class="ms-4 mt-2">${yeuCau}</p>
        </div>
        <div class="mb-3">
            <strong style="color: #667eea;"><i class="fas fa-users me-2"></i>Số lượng tối đa:</strong>
            <p class="ms-4 mt-2">${soLuong} thành viên</p>
        </div>
    `;
    document.getElementById("projectDetailContent").innerHTML = content;
    const modal = new bootstrap.Modal(document.getElementById("projectDetailModal"));
    modal.show();
}
</script>';
?>
