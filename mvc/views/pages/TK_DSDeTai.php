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
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Danh sách đề tài đã duyệt</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-3" width="5%">STT</th>
                                <th class="px-3" width="10%">Mã đề tài</th>
                                <th class="px-3" width="35%">Tên đề tài</th>
                                <th class="px-3" width="25%">Giảng viên hướng dẫn</th>
                                <th class="px-3 text-center" width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>';

$i = $startIndex + 1;
$coDeTai = false;

foreach ($dtPage as $row) {
    if ($row['TrangThaiDeTai'] === 'Đã duyệt') {
        $coDeTai = true;
        echo '
            <tr>
                <td class="px-3">' . $i . '</td>
                <td class="px-3"><span class="badge bg-info">' . $row['IDDeTai'] . '</span></td>
                <td class="px-3">' . htmlspecialchars($row['TenDeTai']) . '</td>
                <td class="px-3">' . htmlspecialchars($row['ten_giang_vien']) . '</td>
                <td class="px-3 text-center">
                    <button 
                        type="button"
                        class="btn btn-sm btn-primary view-details"
                        data-id="' . $row['IDDeTai'] . '"
                        data-title="' . htmlspecialchars($row['TenDeTai'], ENT_QUOTES) . '"
                        data-giangvien="' . htmlspecialchars($row['ten_giang_vien'], ENT_QUOTES) . '"
                        data-mota="' . htmlspecialchars($row['MoTa'], ENT_QUOTES) . '"
                        data-yeucau="' . htmlspecialchars($row['YeuCau'], ENT_QUOTES) . '"
                        data-sltoida="' . $row['SoLuongTV'] . '"
                    ><i class="fas fa-eye"></i> Xem chi tiết</button>
                </td>
            </tr>';
        $i++;
    }
}

if (!$coDeTai) {
    echo '<tr><td colspan="5" class="text-center py-4">Không có đề tài đã duyệt</td></tr>';
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
<div class="modal fade" id="projectDetailModal" tabindex="-1" aria-labelledby="projectDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="projectDetailModalLabel">Chi tiết đề tài</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
    document.querySelectorAll(".view-details").forEach(function(button) {
        button.addEventListener("click", function() {
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
