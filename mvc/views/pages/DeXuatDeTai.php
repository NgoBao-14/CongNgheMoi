
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

<?php
require_once "./mvc/views/components/sidebarGV.php";
?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Đề xuất đề tài mới</h3>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <div class="form-container">
                                        <div class="form-header">
                                            <h3>Thêm Đề Tài Mới</h3>
                                        </div>

                                        <div id="successMessage" class="success-message d-none">
                                            <i class="fas fa-check-circle me-2"></i>Đề tài đã được thêm thành công!
                                        </div>

                                        <div id="errorMessage" class="error-message d-none">
                                            <i class="fas fa-exclamation-circle me-2"></i>Vui lòng điền đầy đủ thông tin!
                                        </div>

                                        <form id="deTaiForm" action="" method="post">
                                            <div>
                                                <div class="form-floating mb-3">
                                                    <label for="TenDeTai">Tên đề tài</label>
                                                    <input type="text" name="TenDeTai" class="form-control" placeholder="Tên đề tài" required>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <label for="Mota">Mô tả đề tài</label>
                                                    <textarea name="Mota" class="form-control" placeholder="Mô tả đề tài" style="height: 100px;" required></textarea>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="form-floating mb-3">
                                                    <label for="YeuCau">Yêu cầu đề tài</label>
                                                    <textarea name="YeuCau" class="form-control" placeholder="Yêu cầu đề tài" style="height: 100px;" required></textarea>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <label for="soLuongTV">Số lượng thành viên</label>
                                                    <input type="number" name="soLuongTV" class="form-control" placeholder="Số lượng thành viên" min="1" max="5" required>
                                                </div>
                                            </div>

                                            <div class="form-footer text-center">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deTaiForm = document.getElementById('deTaiForm');
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
    });
</script>