<?php

  $sinhvien = json_decode($data["sinhvien"], true);
  $dt = json_decode($data["khoa"], true);
  $nhom = json_decode($data["nhom"], true);
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


<?php include './mvc/views/components/sidebarAdmin.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Quản lý sinh viên</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Quản lý sinh viên</li>
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
                        <h2><i class="fas fa-user-graduate me-2"></i>Cập Nhật Thông Tin Sinh Viên</h2>
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
                                    $mssv = $sv['MaSV'];
                                    $hoDem = $sv['HoDem'];
                                    $ten = $sv['Ten'];
                                    $lop = $sv['Lop'];
                                    $stt = $sv['SDT'];
                                    $email = $sv['Email'];
                                    $chuyenNganh = $sv['ChuyenNganh'];
                                ?>
                                <div class="form-floating">
                                    <label for="mssv">MSSV</label>
                                    <input type="text" class="form-control" id="mssv" value="<?php echo $mssv?>" placeholder="MSSV" readonly>
                                   
                                </div>
                                
                                <div class="form-floating">
                                  <label for="hoDem">Họ đệm</label>
                                    <input type="text" name="hodem" class="form-control" id="hoDem" value="<?php echo $hoDem?>" placeholder="Họ đệm">
                                    
                                </div>

                                <div class="form-floating">
                                    <label for="stt">Số điện thoại</label>
                                    <input type="text" name="sdt" class="form-control" id="sdt" value="<?php echo $stt?>" placeholder="Số điện thoại">
                                    
                                </div>

                                <div class="form-floating">
                                    <label for="stt">Email</label>
                                    <input type="text" name="email" class="form-control" id="stt" value="<?php echo $email?>" placeholder="Email">
                                    
                                </div>
                            </div>
                            
                            <!-- Cột bên phải -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <label for="ten">Tên</label>
                                    <input type="text" name="ten" class="form-control" id="ten" value="<?php echo $ten?>" placeholder="Tên">
                                   
                                </div>
                                
                                <div class="form-floating">
                                    <label for="lop">Lớp</label>
                                    <input type="text" name="lop" class="form-control" id="lop" value="<?php echo $lop?>" placeholder="Lớp">
                                    
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
                                    <label for="Nhom">Nhóm</label>
                                    <select name="idnhom" class="form-control" style="min-width: 150px;">
                                          <option value="cn.IDNganh" disabled>Nhóm</option>
                                          <?php
                                          foreach ($nhom as $idnhom):
                                          echo '<option value="'.$idnhom['IDNhom'].'" '.($sv['IDNhom'] == $idnhom['IDNhom'] ? 'selected' : '').'>'.$idnhom['IDNhom'].'</option>';
                                          endforeach;
                                          ?>
                                    </select>
                                </div>
                                  <?php
                                    endforeach; 
                                  ?>
                                
                            </div>
                        </div>
                        
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