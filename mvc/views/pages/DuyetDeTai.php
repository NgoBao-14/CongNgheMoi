<?php
$dt = $data["dt"];
$perPage = 10;
$total = count($dt);
$totalPages = ceil($total / $perPage);

// Trang hiện tại
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages));

// Lấy đề tài cho trang hiện tại
$startIndex = ($currentPage - 1) * $perPage;
$dtPage = array_slice($dt, $startIndex, $perPage);
?>


<div id="deTaiSection" class="project-section">
    <h3 class="text-center  my-4">Duyệt đề tài</h3>
    <div class="project-list">
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th width="5%">STT</th>
                    <th width="15%">Mã đề tài</th>
                    <th width="40%">Tên đề tài</th>
                    <th width="15%">Giảng viên hướng dẫn</th>
                    <th width="25%">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = $startIndex + 1;
                $coDeTai = false;

                foreach ($dtPage as $row) {
                    if ($row['TrangThaiDeTai'] === 'Chưa duyệt') {
                        $coDeTai = true;
                        echo '
                        <tr>
                            <form method="post">
                                <td>' . $i . '</td>
                                <td>' . $row['IDDeTai'] . '</td>
                                <td>' . htmlspecialchars($row['TenDeTai']) . '</td>
                                <td>' . htmlspecialchars($row['ten_giang_vien']) . '</td>
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

                                    <input type="hidden" name="idDetai" value="' . $row['IDDeTai'] . '">
                                        <button 
                                        type="submit" 
                                        name="btnDuyet" 
                                        class="btn btn-success btn-sm"
                                        onclick="return confirm(\'Bạn có chắc chắn muốn duyệt đề tài này?\');"
                                    >Duyệt</button>
                                </td>
                            </form>
                        </tr>';
                        $i++;
                    }
                }

                if (!$coDeTai) {
                    echo '<tr><td colspan="5">Không có đề tài nào cần duyệt</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                <li class="page-item <?php echo ($page == $currentPage) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<!-- Project Details Modal -->
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

<!-- JavaScript for modal -->
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
</script>
