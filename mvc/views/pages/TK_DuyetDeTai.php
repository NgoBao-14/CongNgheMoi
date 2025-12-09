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
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-0"><i class="fas fa-check-circle me-2"></i>Duyệt đề tài</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-3" width="5%">STT</th>
                                <th class="px-3" width="10%">Mã đề tài</th>
                                <th class="px-3" width="30%">Tên đề tài</th>
                                <th class="px-3" width="20%">Giảng viên</th>
                                <th class="px-3 text-center" width="25%">Thao tác</th>
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
                <td class="px-3">' . $i . '</td>
                <td class="px-3"><span class="badge bg-secondary">' . $row['IDDeTai'] . '</span></td>
                <td class="px-3">' . htmlspecialchars($row['TenDeTai']) . '</td>
                <td class="px-3">' . htmlspecialchars($row['ten_giang_vien']) . '</td>
                <td class="px-3 text-center">
                    <button 
                        type="button"
                        class="btn btn-sm btn-info me-1 view-details"
                        data-id="' . $row['IDDeTai'] . '"
                        data-title="' . htmlspecialchars($row['TenDeTai'], ENT_QUOTES) . '"
                        data-giangvien="' . htmlspecialchars($row['ten_giang_vien'], ENT_QUOTES) . '"
                        data-mota="' . htmlspecialchars($row['MoTa'], ENT_QUOTES) . '"
                        data-yeucau="' . htmlspecialchars($row['YeuCau'], ENT_QUOTES) . '"
                        data-sltoida="' . $row['SoLuongTV'] . '"
                    ><i class="fas fa-eye"></i> Chi tiết</button>
                    
                    <form method="post" class="d-inline">
                        <input type="hidden" name="idDetai" value="' . $row['IDDeTai'] . '">
                        <input type="hidden" name="TenDeTai" value="' . htmlspecialchars($row['TenDeTai'], ENT_QUOTES) . '">
                        <button 
                            type="submit" 
                            name="btnDuyet" 
                            class="btn btn-sm btn-success"
                            onclick="return confirm(\'Bạn có chắc chắn muốn duyệt đề tài này?\');"
                        ><i class="fas fa-check"></i> Duyệt</button>
                    </form>
                </td>
            </tr>';
        $i++;
    }
}

if (!$coDeTai) {
    echo '<tr><td colspan="5" class="text-center py-4">
            <i class="fas fa-inbox text-muted" style="font-size: 2rem;"></i>
            <p class="mt-2 text-muted">Không có đề tài cần duyệt</p>
          </td></tr>';
}

echo '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>';

if ($totalPages > 1) {
    echo '
        <nav aria-label="Page navigation" class="mt-3">
            <ul class="pagination justify-content-center">';
    for ($page = 1; $page <= $totalPages; $page++) {
        $active = ($page == $currentPage) ? 'active' : '';
        echo '<li class="page-item ' . $active . '">
                <a class="page-link" href="?page=' . $page . '">' . $page . '</a>
              </li>';
    }
    echo '
            </ul>
        </nav>';
}

echo '
    </div>
</section>

<!-- Modal Chi tiết -->
<div class="modal fade" id="projectDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Chi tiết đề tài</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="projectDetailContent"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".view-details").forEach(function(btn) {
        btn.addEventListener("click", function() {
            const title = this.dataset.title;
            const giangVien = this.dataset.giangvien;
            const moTa = this.dataset.mota;
            const yeuCau = this.dataset.yeucau;
            const soLuong = this.dataset.sltoida;
            
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
</script>';
?>
