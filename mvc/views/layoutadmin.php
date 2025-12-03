<?php
    if($_SESSION["PQ"] != 3){
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Bạn không có quyền truy cập'];
        header("location: " . base_url('/'));
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quản lý khóa luận</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body class="hold-transition">
<!-- Site wrapper -->
<div class="wrapper">

<!-- Toast Message -->
<?php if(isset($_SESSION['message'])): ?>
<div class="position-fixed" style="top: 20px; right: 20px; z-index: 9999;">
    <div class="toast show" role="alert">
        <div class="toast-header <?= $_SESSION['message']['type'] == 'success' ? 'bg-success' : 'bg-danger' ?> text-white">
            <strong class="mr-auto">
                <i class="fas <?= $_SESSION['message']['type'] == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?> mr-2"></i>
                <?= $_SESSION['message']['type'] == 'success' ? 'Thành công' : 'Lỗi' ?>
            </strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">
                <span>&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <?= $_SESSION['message']['text'] ?>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        document.querySelector('.toast').style.display = 'none';
    }, 3000);
</script>
<?php unset($_SESSION['message']); endif; ?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url('/Admin/') ?>" class="nav-link">Home</a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->

      
      <!-- thu phóng -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  
    <?php include "./mvc/views/pages/".$data["Page"].".php" ?>
    

  <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2023-2024 <a href="#">Quản lý khóa luận</a>.</strong>
    All rights reserved.
  </footer> -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<!-- Custom JS -->
<script src="../../public/js/script.js"></script>

</body>
</html>