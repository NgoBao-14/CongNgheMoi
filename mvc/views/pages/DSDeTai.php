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

    <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- thu phóng -->
        <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
        </li>

    </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Quản lý khóa luận</span>
    </div>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <h5 class="d-block">Trưởng khoa</h5>
        </div>
        </div>

    <div>
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <!-- Bảng điều khiển -->
        <li class="nav-item">
            <a href="./" class="nav-link ative">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Bảng điều khiển</p>
            </a>
        </li>
        <!-- Đề xuất đề tài  -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/DXDeTai" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Duyệt đề tài</p>
            </a>
        </li>

        <!-- Danh sách đăng ký -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/DSDeTai" class="nav-link active">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Danh sách đề tài</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="/CongNgheMoi/Logout" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Đăng xuất</p>
            </a>
        </li>
        </ul>
        </nav>
    </div>
    </aside>

    <div class="content-wrapper">
<div class= "container-fluid">
    <div id="deTaiSection" class="project-section">
        <h3 class="text-center  my-4">Danh sách đề tài</h3>
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
                        if ($row['TrangThaiDeTai'] === 'Đã duyệt') {
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
                                    </td>
                                </form>
                            </tr>';
                            $i++;
                        }
                    }

                    if (!$coDeTai) {
                        echo '<tr><td colspan="5">Không có đề tài</td></tr>';
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
</script>
