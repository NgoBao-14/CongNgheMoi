<?php

  $sinhvien = json_decode($data["detai"], true);
  $dt = json_decode($data["khoa"], true);
  $nhomtt = json_decode($data["nhom"], true);
?>


<style>
        
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        .form-container:hover {
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            color: #0d6efd;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 15px;
        }
        .form-footer {
            border-top: 2px solid #e9ecef;
            padding-top: 20px;
            margin-top: 20px;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
            transform: translateY(-2px);
        }
        .btn-outline-secondary {
            transition: all 0.3s ease;
        }
        .btn-outline-secondary:hover {
            transform: translateY(-2px);
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .form-label {
            font-weight: 500;
        }
        .success-message {
            display: none;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .error-message {
            display: none;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-floating {
            margin-bottom: 20px;
        }
    </style>


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
            <h1>Quản lý đề tài</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Quản lý Đề tài</li>
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
              <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="form-container">
                    <div class="form-header">
                        <h2><i class="fas fa-user-graduate me-2"></i>Cập Nhật Thông Tin Đề Tài</h2>
                    </div>
                    
                    <div id="successMessage" class="success-message">
                        <i class="fas fa-check-circle me-2"></i>Thông tin sinh viên đã được cập nhật thành công!
                    </div>
                    
                    <div id="errorMessage" class="error-message">
                        <i class="fas fa-exclamation-circle me-2"></i>Vui lòng điền đầy đủ thông tin!
                    </div>
                    
                    <form id="studentForm" action="" method="post">
                        <div class="row">
                            <!-- Cột bên trái -->
                            <div class="col-md-6">   
                                <?php
                                foreach ($sinhvien as $sv) :
                                    $iddetai = $sv['IDDeTai'];
                                    $tendetai = $sv['TenDeTai'];
                                    $mota = $sv['MoTa'];
                                    $trangthaidetai = $sv['TrangThaiDeTai'];
                                    $ngaydk = $sv['NgayDK'];
                                    $trangthaidk = $sv['TrangThaiDK'];
                                    $nhom = $sv['IDNhom'];
                                    $hodem = $sv['HoDem'];
                                    $ten = $sv['Ten'];
                                    $chuyenNganh = $sv['ChuyenNganh'];
                                    $yeucau = $sv['YeuCau'];
                                    $soluongTV = $sv['SoLuongTV'];

                                ?>
                                <div class="form-floating">
                                    <label for="mssv">ID Đề tài</label>
                                    <input type="text" name="id" class="form-control" id="mssv" value="<?php echo $iddetai?>" placeholder="MSSV" readonly>
                                   
                                </div>
                                

                                <div class="form-floating">
                                    <label for="stt">Trạng thái đề tài</label>
                                    <select name="trangthaidetai" class="form-control" style="min-width: 150px;">
                                          <option value="cn.IDNganh" disabled>Trạng thái</option>
                                          <option value="Đã duyệt" <?php echo $sv['TrangThaiDeTai'] == 'Đã duyệt' ? 'selected' : ''  ?> >Đã duyệt</option>
                                          <option value="Chờ duyệt" <?php echo $sv['TrangThaiDeTai'] == 'Chờ duyệt' ? 'selected' : ''  ?> >Chờ duyệt</option>
                                    </select>
                                </div>

                                <div class="form-floating">
                                    <label for="stt">Nhóm đảm nhiệm</label>
                                    <select name="nhom" class="form-control" style="min-width: 150px;">
                                          <option value="cn.IDNhom" disabled>Nhóm</option>
                                          <?php
                                          foreach ($nhomtt as $n):
                                          echo '<option value="'.$n['IDNhom'].'" '.($sv['IDNhom'] == $n['IDNhom'] ? 'selected' : '').'>'.$n['IDNhom'].'</option>';
                                          endforeach;
                                          ?>
                                    </select>
                                </div>

                                <div class="form-floating">
                                    <label for="stt">Ngày đăng ký đề tài</label>
                                    <input type="date" name="ngaydk" class="form-control" id="sdt" value="<?php echo $ngaydk?>" placeholder="Số điện thoại">
                                    
                                </div>

                                <div class="form-floating">
                                    <label for="stt">Yêu cầu đề tài</label>
                                    <input type="text" name="yeucau" class="form-control" id="sdt" value="<?php echo $yeucau?>" placeholder="Số điện thoại">
                                    
                                </div>

                                
                            </div>
                            
                            <!-- Cột bên phải -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <label for="stt">Giảng viên đảm nhiệm</label>
                                    <input type="text" name="email" class="form-control" id="stt" value="<?php echo $hodem . " " . $ten;?>" placeholder="Email" readonly>
                                    
                                </div>          

                                <div class="form-floating">
                                    <label for="ten">Tên đề tài</label>
                                    <input type="text" name="ten" class="form-control" id="ten" value="<?php echo $tendetai?>" placeholder="Tên">
                                   
                                </div>
                                
                                
                                
                                <div class="form-floating">
                                  <label for="chuyenNganh">Chuyên Ngành</label>
                                    <select name="chuyennganh" class="form-control" style="min-width: 150px;">
                                          <option value="cn.IDNganh" disabled>Chuyên ngành</option>
                                          <?php
                                          foreach ($dt as $khoa):
                                          echo '<option value="'.$khoa['IDNganh'].'" '.($sv['IDNganh'] == $khoa['IDNganh'] ? 'selected' : '').'>'.$khoa['ChuyenNganh'].'</option>';
                                          endforeach;
                                          ?>
                                    </select>
                                      
                                </div>
                                <div class="form-floating">
                                    <label for="stt">Trạng thái đăng ký</label>
                                    <select name="trangthaidk" class="form-control" style="min-width: 150px;">
                                          <option value="cn.IDNganh" disabled>Trạng thái</option>
                                          <option value="Đã được đăng ký" <?php echo $sv['TrangThaiDK'] == 'Đã được đăng ký' ? 'selected' : ''  ?>>Đã được đăng ký</option>
                                          <option value="Chờ sinh viên đăng ký" <?php echo $sv['TrangThaiDK'] == 'Chờ sinh viên đăng ký' ? 'selected' : ''  ?>>Chờ sinh viên đăng ký</option>
                                    </select>
                                </div>

                                <div class="form-floating">
                                  <label for="hoDem">Thành viên tối đa</label>
                                    <input type="text" name="soluong" class="form-control" id="hoDem" value="<?php echo $soluongTV?>" placeholder="Họ đệm">
                                    
                                </div>

                                
                                
                            </div>
                            
                        </div>
                        <div class="row justify-content-center mt-3">
                                  <div class="col-md-10">
                                    <div class="form-floating">
                                      <label for="moTa">Mô tả</label>
                                      <textarea name="mota" class="form-control" id="moTa" placeholder="Mô tả" style="height: 150px;"><?php echo $mota; ?></textarea>
                                    </div>
                                  </div>
                                </div>
                                  <?php
                                    endforeach; 
                                  ?>
                        
                        <div class="form-footer text-center">
                            <button type="submit" name="btn_CapNhat" class="btn btn-primary btn-lg px-5 me-3">
                                <i class="fas fa-check me-2"></i> Xác nhận
                            </button>
                            <button type="button" id="cancelBtn" class="btn btn-outline-secondary btn-lg px-5">
                                <i class="fas fa-times me-2"></i> Hủy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

  <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentForm = document.getElementById('studentForm');
            const cancelBtn = document.getElementById('cancelBtn');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');
            
            
            
            // Cancel button
            cancelBtn.addEventListener('click', function() {
                studentForm.reset();
                successMessage.style.display = 'none';
                errorMessage.style.display = 'none';
            });
            
            // Add animation to form fields on focus
            const formInputs = document.querySelectorAll('.form-control');
            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-5px)';
                    this.parentElement.style.transition = 'transform 0.3s ease';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });
        });
    </script>