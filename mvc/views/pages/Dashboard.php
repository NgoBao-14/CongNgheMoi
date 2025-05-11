<?php
    $dt = json_decode($data['khoa'], true);
    $detaikhoa = json_decode($data['detaikhoa'], true);
?>


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
        
        <!-- Recent Activity -->
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Hoạt động gần đây</h3>
              </div>
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                  <li class="item">
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Nguyễn Văn A
                        <span class="badge badge-success float-right">Đã nộp</span></a>
                      <span class="product-description">
                        Đã nộp báo cáo tiến độ khóa luận
                      </span>
                      <small class="text-muted">2 giờ trước</small>
                    </div>
                  </li>
                  <li class="item">
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Trần Thị B
                        <span class="badge badge-warning float-right">Đang xử lý</span></a>
                      <span class="product-description">
                        Đăng ký đề tài mới
                      </span>
                      <small class="text-muted">5 giờ trước</small>
                    </div>
                  </li>
                  <li class="item">
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Lê Văn C
                        <span class="badge badge-danger float-right">Từ chối</span></a>
                      <span class="product-description">
                        Yêu cầu thay đổi đề tài
                      </span>
                      <small class="text-muted">1 ngày trước</small>
                    </div>
                  </li>
                  <li class="item">
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Phạm Thị D
                        <span class="badge badge-info float-right">Mới</span></a>
                      <span class="product-description">
                        Đăng ký tham gia hội đồng
                      </span>
                      <small class="text-muted">2 ngày trước</small>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">Xem tất cả hoạt động</a>
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lịch bảo vệ sắp tới</h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Sinh viên</th>
                      <th>Đề tài</th>
                      <th>Ngày</th>
                      <th>Phòng</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Nguyễn Văn A</td>
                      <td>Nghiên cứu ứng dụng AI</td>
                      <td>15/05/2023</td>
                      <td>A1.01</td>
                    </tr>
                    <tr>
                      <td>Trần Thị B</td>
                      <td>Phát triển ứng dụng web</td>
                      <td>16/05/2023</td>
                      <td>A2.05</td>
                    </tr>
                    <tr>
                      <td>Lê Văn C</td>
                      <td>Phân tích dữ liệu lớn</td>
                      <td>17/05/2023</td>
                      <td>B3.02</td>
                    </tr>
                    <tr>
                      <td>Phạm Thị D</td>
                      <td>IoT trong nông nghiệp</td>
                      <td>18/05/2023</td>
                      <td>C1.03</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">Xem tất cả lịch bảo vệ</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>