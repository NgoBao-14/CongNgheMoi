<?php
    $dt = json_decode($data["khoa"], true);
    $detai = json_decode($data["detai"], true);
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
      <a href="/CongNgheMoi/Admin/" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
      </a>
    </li>
    
    <!-- Danh sách đăng ký -->
    <li class="nav-item">
      <a href="/CongNgheMoi/Admin/DSDeTai" class="nav-link active">
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
      <a href="/CongNgheMoi/Admin/QuanLyGV" class="nav-link ">
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
  <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cog"></i>
        <p>Cài đặt hệ thống</p>
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
            <h1>Quản lý đề tài</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Quản lý đề tài</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    
        
        <!-- Charts Row -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="flex-grow-1" >
                  <h3 class="card-title mb-0">Danh sách để tài</h3>
                  
                </div>
                <div class="d-flex align-items-center">
                <form action="/CongNgheMoi/Admin/QuanLyGV" method="POST">
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
                    <th>Mô tả</th>
                    <th>Giảng viên</th>
                    <th>Chuyên Ngành</th>
                    <th>Trạng thái đề tài</th>
                    <th>Ngày đăng ký</th>
                    <th>Trạng thái đăng ký</th>
                    <th>Nhóm đăng ký</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $dem = 1;
                  foreach ($detai as $index): 
                  echo '<tr class="bg-light">
                    <td>'.$dem.'</td>
                    <td>'.$index["TenDeTai"].'</td>
                    <td>'.$index["MoTa"].'</td>
                    <td style="text-align:center;">'.$index["Ten"].'</td>
                    <td>'.$index["ChuyenNganh"].'</td>
                    <td>'.$index["TrangThaiDeTai"].'</td>
                    <td style="text-align:center;">'.$index["NgayDK"].'</td>
                    <td style="text-align:center;">'.$index["TrangThaiDK"].'</td>
                    <td style="text-align:center;">'.$index["IDNhom"].'</td>
                    <td>
                      <a href="/CongNgheMoi/Admin/CapNhatDT?id='.$index["IDDeTai"].'" class="btn btn-primary btn-sm">Cập nhật</a>
                      <a href="/CongNgheMoi/mvc/api/xoadetai.php?id='.$index["IDDeTai"].'" onclick="return confirm(\'Bạn có chắc chắn muốn xóa giảng viên này không?\')" class="btn btn-danger btn-sm">Xóa</a>
                  </tr>';
                  $dem++;
                  endforeach;
                  ?>
                </tbody>
              </table>
              </div>
            </div>
          </div>
        </div>
        
        
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->