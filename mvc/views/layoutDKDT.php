<?php
    if($_SESSION["PQ"] != 2){
        echo "<script>alert('Bạn không có quyền truy cập')</script>";
        header("refresh: 0; url='/CongNgheMoi'");
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng Đăng Ký Học Phần Sinh Viên - IUH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../public/css/sinhvien.css">
    <link rel="stylesheet" href="../public/css/xemdetai.css">
    <link rel="stylesheet" href="../public/css/loading.css">
    <link rel="stylesheet" href="../public/css/toast.css">
</head>
<body>
    <div class="container p-0">
        <!-- Header -->
        <?php include "blocks/header.php" ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="row m-0">
            <?php require_once "./mvc/views/pages/".$data["Page"].".php" ?>
            </div>
        </div>
        <!-- Footer -->
        <?php include "blocks/footer.php" ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/toast.js"></script>
    <script src="../public/js/loading.js"></script>
    
</body>
</html>