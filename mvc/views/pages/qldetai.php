<?php
$dt = $data['dt'];
echo '
    <div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link">Contact</a>
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
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Quản lý khóa luận</span>
    </a>


    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="" class="d-block">Giảng Viên</a>
        </div>
        </div>

    <div>
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <!-- Bảng điều khiển -->
        <li class="nav-item" >
            <a href="./" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Bảng điều khiển</p>
            </a>
        </li>
        <!-- Đề xuất đề tài  -->
        <li class="nav-item">
            <a href="./DeXuatDeTai" class="nav-link" >
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Đề xuất đề tài</p>
            </a>
        </li>

        <!-- Danh sách đăng ký -->
        <li class="nav-item">
            <a href="./QuanLyDeTai" class="nav-link" style="background-color:rgb(35, 120, 206);">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Danh sách đề tài</p>
            </a>
        </li>

        <!-- Sinh viên -->
        <li class="nav-item">
            <a href="./QuanLyNhom" class="nav-link">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Quản lý nhóm</p>
            </a>
        </li>

        <!-- Giáo viên -->
        <li class="nav-item">
            <a href="./TienDoDeTai" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Tiến độ đề tài</p>
            </a>
        </li>

        
        <li class="nav-item">
            <a href="./QuanLyKhoaLuan" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Báo cáo khóa luận</p>
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

    <div class="content-wrapper ">

<section class="content">
        <div class="container-fluid">
            <div class="card-header">
            <h3 >Danh sách đề tài</h3>
            </div>
            <div class="project-list">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">STT</th>
                            <th width="15%">Mã đề tài</th>
                            <th width="40%">Tên đề tài</th>
                            <th width="25%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>';
                            $i = 1;
                            foreach($dt as $row){
                                echo '<tr>
                                <td>'.$i.'</td>
                                <td>'.$row['IDDeTai'].'</td>
                                <td>'.$row['TenDeTai'].'</td>
                                <td>
                                        <button 
                                            class="btn view-details btn-primary" 
                                            data-id="'.$row['IDDeTai'].'"
                                            data-title="'.$row['TenDeTai'].'"
                                            data-mota="'.$row['MoTa'].'"
                                            data-yeucau="'.$row['YeuCau'].'"
                                            data-sltoida="'.$row['SoLuongTV'].'"
                                        >Xem chi tiết</button>
                                    </td>
                                </tr>';
                                $i++;
                            }
echo '
                    </tbody>
                </table>
            </div>

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
            
        </div>
    </section>';
?>
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
</script>