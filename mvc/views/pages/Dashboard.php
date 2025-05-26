<?php
    $dt = json_decode($data['khoa'], true);
    $detaikhoa = json_decode($data['detaikhoa'], true);
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Quản lý khóa luận</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
    <!-- Bảng điều khiển -->
    <li class="nav-item">
      <a href="/CongNgheMoi/Admin/" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
      </a>
    </li>
    
    <!-- Danh sách đăng ký -->
    <li class="nav-item">
      <a href="/CongNgheMoi/Admin/DSDeTai" class="nav-link">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>Danh sách đề tài</p>
      </a>
    </li>
    
    <!-- Sinh viên -->
    <li class="nav-item">
      <a href="/CongNgheMoi/Admin/QuanLySV" class="nav-link">
        <i class="nav-icon fas fa-user-graduate"></i>
        <p>Quản lý sinh viên</p>
      </a>
    </li>
    
    <!-- Giáo viên -->
    <li class="nav-item">
      <a href="/CongNgheMoi/Admin/QuanLyGV" class="nav-link">
        <i class="nav-icon fas fa-chalkboard-teacher"></i>
        <p>Quản lý giảng viên</p>
      </a>
    </li>
    
    
    <!-- Quản lý hội đồng -->
    <!-- <li class="nav-item">
      <a href="/CongNgheMoi/Admin/QuanLyNhom" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>Quản lý nhóm sinh viên</p>
      </a>
    </li> -->
    
    
    
    <!-- Cài đặt hệ thống -->
    <!-- <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cog"></i>
        <p>Cài đặt hệ thống</p>
      </a>
    </li> -->
    <li class="nav-item">
            <a href="/CongNgheMoi/Logout" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Đăng xuất</p>
            </a>
        </li>
  </ul>

</nav>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-primary mb-3">
              <div class="info-box-content">
                <h2 class="info-box-number"><?php echo $data['sinhvien'];?></h2>
                <span class="info-box-text">Sinh viên</span>
                <div class="info-box-icon">
                  <i class="fas fa-user-graduate"></i>
                </div>
                <div class="mt-3">
                  <a href="#" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-success mb-3">
              <div class="info-box-content">
                <h2 class="info-box-number"><?php echo $data['giangvien'];?></h2>
                <span class="info-box-text">Giảng viên</span>
                <div class="info-box-icon">
                  <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="mt-3">
                  <a href="#" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-warning mb-3">
              <div class="info-box-content">
                <h2 class="info-box-number"><?php echo $data['detai'];?></h2>
                <span class="info-box-text">Đề tài</span>
                <div class="info-box-icon">
                  <i class="fas fa-tasks"></i>
                </div>
                <div class="mt-3">
                  <a href="#" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-danger mb-3">
              <div class="info-box-content">
                <h2 class="info-box-number"><?php echo $data['nhom'];?></h2>
                <span class="info-box-text">Nhóm</span> 
                <div class="info-box-icon">
                  <i class="fas fa-users"></i>
                </div>
                <div class="mt-3">
                  <a href="#" class="text-white">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Charts Row -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="flex-grow-1">
                  <h3 class="card-title mb-0">Thống kê đề tài theo khoa</h3>
                </div>
                <div class="d-flex align-items-center">
                <form action="/CongNgheMoi/Admin" method="POST">
                <select name="loc" class="form-select form-select-sm w-auto" style="min-width: 150px;">
                      <option value="cn.IDNganh">Tất cả khoa</option>
                      <?php
                      foreach ($dt as $khoa):
                      echo '<option value="'.$khoa['IDNganh'].'">'.$khoa['ChuyenNganh'].'</option>';
                      endforeach;
                      ?>
                </select>
                <input type="submit" name="btnLoc" value="Lọc" class="btn btn-primary btn-sm" style="margin-left: 8px;">
                </form>
                </div>
              </div>

              <div class="card-body">
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Tên đề tài</th>
                    <th>Khoa</th>
                    <th>Trạng thái</th>
                    <th>Mô tả</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $dem = 1;
                  $i = 0;
                  foreach ($detaikhoa as $index ):
                  $class = ($i % 2 == 0) ? 'bg-light' : 'bg-blue';  
                  echo '<tr class="'.$class.'">
                    <td>'.$dem.'</td>
                    <td>'.$index["TenDeTai"].'</td>
                    <td>'.$index["ChuyenNganh"].'</td>
                    <td>'.$index["TrangThaiDeTai"].'</td>
                    <td style="white-space: normal;">'.$index["MoTa"].'</td>
                  </tr>';
                  $dem++;
                  $i++;
                  endforeach;
                  ?>
                </tbody>
              </table>
              </div>
            </div>
          </div>
        </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->