<?php
require_once "./mvc/views/components/sidebarTK.php";
echo '
<style>
    .form-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-top: 20px;
    }
    .form-header {
        text-align: center;
        margin-bottom: 30px;
        color: #0d6efd;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 15px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="form-container">
                <div class="form-header">
                    <h3>Thêm Đề Tài Mới</h3>
                </div>

                <form action="" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" name="TenDeTai" class="form-control" placeholder="Tên đề tài" required>
                        <label for="TenDeTai">Tên đề tài</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea name="Mota" class="form-control" placeholder="Mô tả đề tài" style="height: 100px;" required></textarea>
                        <label for="Mota">Mô tả đề tài</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea name="YeuCau" class="form-control" placeholder="Yêu cầu đề tài" style="height: 100px;" required></textarea>
                        <label for="YeuCau">Yêu cầu đề tài</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" name="soLuongTV" class="form-control" placeholder="Số lượng thành viên" min="1" max="5" required>
                        <label for="soLuongTV">Số lượng thành viên</label>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" name="btnDeXuat" class="btn btn-primary btn-lg px-5 me-3">
                            <i class="fas fa-plus me-2"></i> Thêm đề tài
                        </button>
                        <button type="reset" class="btn btn-outline-secondary btn-lg px-5">
                            <i class="fas fa-times me-2"></i> Hủy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';
?>
