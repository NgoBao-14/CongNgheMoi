<?php
require_once "./mvc/views/components/sidebarTK.php";
$dt = $data['dt'];
echo '
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Danh sách đề tài của tôi</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-3" width="5%">STT</th>
                                <th class="px-3" width="10%">Mã đề tài</th>
                                <th class="px-3" width="45%">Tên đề tài</th>
                                <th class="px-3 text-center" width="20%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>';
$i = 1;
if (!empty($dt)) {
    foreach ($dt as $row) {
        echo '<tr>
            <td class="px-3">' . $i . '</td>
            <td class="px-3"><span class="badge bg-info">' . $row['IDDeTai'] . '</span></td>
            <td class="px-3">' . htmlspecialchars($row['TenDeTai']) . '</td>
            <td class="px-3 text-center">
                <button 
                    class="btn btn-sm btn-primary view-details" 
                    data-id="' . $row['IDDeTai'] . '"
                    data-title="' . htmlspecialchars($row['TenDeTai'], ENT_QUOTES) . '"
                    data-mota="' . htmlspecialchars($row['MoTa'] ?? '', ENT_QUOTES) . '"
                    data-yeucau="' . htmlspecialchars($row['YeuCau'] ?? '', ENT_QUOTES) . '"
                    data-sltoida="' . ($row['SoLuongTV'] ?? 1) . '"
                ><i class="fas fa-eye"></i> Xem chi tiết</button>
            </td>
        </tr>';
        $i++;
    }
} else {
    echo '<tr><td colspan="4" class="text-center py-4">Chưa có đề tài nào</td></tr>';
}
echo '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Project Details Modal -->
<div class="modal fade" id="projectDetailModal" tabindex="-1" aria-labelledby="projectDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="projectDetailModalLabel">Chi tiết đề tài</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="projectDetailContent">
            </div>
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
            const idDeTai = this.dataset.id;
            const title = this.dataset.title;
            const moTa = this.dataset.mota;
            const yeuCau = this.dataset.yeucau;
            const soLuong = this.dataset.sltoida;
            const content = `
                <p><strong>Mã đề tài:</strong> ${idDeTai}</p>
                <p><strong>Tên đề tài:</strong> ${title}</p>
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
