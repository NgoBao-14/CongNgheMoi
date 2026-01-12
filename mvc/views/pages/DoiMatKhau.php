<?php
require_once "./mvc/views/components/sidebarGV.php";
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-key me-2"></i>Đổi mật khẩu</h3>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form method="POST" action="" id="formDoiMatKhau">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="matKhauCu">
                                    <i class="fas fa-lock me-2"></i>Mật khẩu cũ
                                </label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="matKhauCu" 
                                    name="matKhauCu" 
                                    placeholder="Nhập mật khẩu cũ"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="matKhauMoi">
                                    <i class="fas fa-lock me-2"></i>Mật khẩu mới
                                </label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="matKhauMoi" 
                                    name="matKhauMoi" 
                                    placeholder="Nhập mật khẩu mới"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="xacNhanMatKhau">
                                    <i class="fas fa-lock me-2"></i>Xác nhận mật khẩu mới
                                </label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="xacNhanMatKhau" 
                                    name="xacNhanMatKhau" 
                                    placeholder="Nhập lại mật khẩu mới"
                                    required
                                >
                            </div>

                            <button type="submit" name="btnDoiMatKhau" class="btn btn-primary w-100">
                                <i class="fas fa-check me-2"></i>Đổi mật khẩu
                            </button>
                        </form>

                        <div class="alert alert-info mt-4">
                            <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Lưu ý:</h6>
                            <ul class="mb-0 ps-3">
                                <li>Mật khẩu nên có ít nhất 6 ký tự</li>
                                <li>Nên kết hợp chữ hoa, chữ thường và số</li>
                                <li>Không chia sẻ mật khẩu với người khác</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("formDoiMatKhau");
    const matKhauMoi = document.getElementById("matKhauMoi");
    const xacNhanMatKhau = document.getElementById("xacNhanMatKhau");

    form.addEventListener("submit", function(e) {
        if (matKhauMoi.value !== xacNhanMatKhau.value) {
            e.preventDefault();
            if (typeof Toast !== 'undefined') {
                Toast.error("Mật khẩu mới và xác nhận mật khẩu không khớp!");
            } else {
                alert("Mật khẩu mới và xác nhận mật khẩu không khớp!");
            }
            return false;
        }
        
        if (matKhauMoi.value.length < 6) {
            e.preventDefault();
            if (typeof Toast !== 'undefined') {
                Toast.error("Mật khẩu phải có ít nhất 6 ký tự!");
            } else {
                alert("Mật khẩu phải có ít nhất 6 ký tự!");
            }
            return false;
        }
    });
});
</script>
