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
<div class="container-fluid">
    <div id="deTaiSection" class="project-section">
        <h3 class="text-center my-4">Danh sách điểm khóa luận theo đề tài</h3>
        <div class="project-list">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th width="5%">STT</th>
                        <th width="10%">Mã đề tài</th>
                        <th width="30%">Tên đề tài</th>
                        <th width="20%">Giảng viên hướng dẫn</th>
                        <th width="10%">Nhóm</th>
                        <th width="10%">Điểm</th>
                        <th width="25%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>';

$i = $startIndex + 1;
$coDeTai = false;

foreach ($dtPage as $row) {
    if ($row['TrangThaiDeTai'] === 'Đã duyệt' && $row['TrangThaiDK'] === 'Đã đăng ký') {
        $coDeTai = true;
        echo '
        <tr>
            <form method="post">
                <td>' . $i . '</td>
                <td>' . $row['IDDeTai'] . '</td>
                <td>' . htmlspecialchars($row['TenDeTai']) . '</td>
                <td>' . htmlspecialchars($row['ten_giang_vien']) . '</td>
                <td>' . ($row['IDNhom']) . '</td>
                <td>' . ($row['tongdiem'] ? $row['tongdiem'] : 'Chưa có điểm') . '</td>
                <td>
                    <button 
                        type="button"
                        class="btn btn-info btn-sm view-details"
                        style="background-color: #EE7600; border-color: #EE7600; color: #fff;"
                        data-id="' . $row['IDDeTai'] . '"
                        data-title="' . htmlspecialchars($row['TenDeTai'], ENT_QUOTES) . '"
                        data-giangvien="' . htmlspecialchars($row['ten_giang_vien'], ENT_QUOTES) . '"
                        data-mota="' . htmlspecialchars($row['MoTa'], ENT_QUOTES) . '"
                        data-yeucau="' . htmlspecialchars($row['YeuCau'], ENT_QUOTES) . '"
                        data-sltoida="' . $row['SoLuongTV'] . '"
                    >Xem chi tiết</button>
                </td>
            </form>
        </tr>';
        $i++;
    }
}

if (!$coDeTai) {
    echo '<tr><td colspan="7">Không có đề tài</td></tr>';
}

echo '
                </tbody>
            </table>
        </div>';

if ($totalPages > 1) {
    echo '
        <nav aria-label="Page navigation">
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
</div>

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
    const detailButtons = document.querySelectorAll(".view-details");
    detailButtons.forEach(function(button) {
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
