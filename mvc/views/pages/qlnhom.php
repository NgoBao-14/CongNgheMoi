<?php
$nhom = $data['nhom'];
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
            <a href="./QuanLyDeTai" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Danh sách đề tài</p>
            </a>
        </li>

        <!-- Sinh viên -->
        <li class="nav-item">
            <a href="./QuanLyNhom" class="nav-link" style="background-color:rgb(35, 120, 206);">
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
        
                    <div class="card">
                <div class="card-header">
                <h3>Danh sách nhóm</h3>
                </div>
                <div class="card-body p-0">
                <table class="table">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Nhóm</th>
                        <th>Tên đề tài</th>
                        <th>Số thành viên</th>
                        <th>Chức năng</th>
                    </tr>
                    </thead>
                    <tbody>';
                    $stt = 1;
                    foreach ($nhom as $row) {
                        echo '<tr>
                            <td>' . $stt++ . '</td>
                            <td>' . $row['IDNhom'] . '</td>
                            <td>' . $row['TenDeTai'] . '</td>
                            <td>' . $row['SoLuongSinhVien'] . '</td>
                            <form method="POST">
                            <input type="hidden" name="idNhom" value="' . $row['IDNhom'] . '">
                            <td>
                                <button type="submit" name="btnXemChiTiet" class="btn btn-primary">Xem chi tiết</button>
                            </td>
                            </form>
                        </tr>';
                    }
echo'                    
                    </tbody>
                </table>
                </div>
            </div>
        </div>';

        if (isset($data['thongTinTV'])){
echo'    <!-- Group Information -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table  mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-3">STT</th>
                                <th class="px-3">MSSV</th>
                                <th class="px-3">Họ và tên</th>
                                <th class="px-3">Lớp</th>
                                <th class="px-3">Email</th>
                                <th class="px-3">Nhóm</th>
                            </tr>
                        </thead>
                        <tbody>';
                            $stt = 1;
                            foreach ($data['thongTinTV'] as $tv) {
                                echo '
                                <tr>
                                    <td class="px-3">' . $stt++ . '</td>
                                    <td class="px-3">' . htmlspecialchars($tv["MaSV"]) . '</td>
                                    <td class="px-3">' . htmlspecialchars($tv["HoTenSinhVien"]) . '</td>
                                    <td class="px-3">' . htmlspecialchars($tv["Lop"]) . '</td>
                                    <td class="px-3">' . htmlspecialchars($tv["Email"]) . '</td>
                                    <td class="px-3">' . htmlspecialchars($tv["IDNhom"]) . '</td>
                                </tr>';
                            }
echo'
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>';
        }
        else {
            echo '';
        }
echo '
    </section>';
?>