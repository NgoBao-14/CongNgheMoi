<?php
require_once "./mvc/views/components/sidebarTK.php";
echo '
<style>
    .password-container {
        max-width: 600px;
        margin: 50px auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }
    .password-header {
        text-align: center;
        margin-bottom: 30px;
        color: #0d6efd;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 15px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .btn-change-password {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border: none;
        color: white;
        padding: 12px 40px;
        border-radius: 25px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        margin-top: 20px;
    }
    .btn-change-password:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
    }
    .password-requirements {
        background: #f8f9fa;
        border-left: 4px solid #0d6efd;
        padding: 15px;
        margin-top: 20px;
        border-radius: 5px;
    }
    .password-requirements h6 {
        color: #0d6efd;
        margin-bottom: 10px;
    }
    .password-requirements ul {
        margin: 0;
        padding-left: 20px;
    }
    .password-requirements li {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }
</style>

<div class="container-fluid">
    <div class="password-container">
        <div class="password-header">
            <h3><i class="fas fa-key me-2"></i>Đổi mật khẩu</h3>
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label class="form-label" for="matKhauCu">
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

            <div class="form-group">
                <label class="form-label" for="matKhauMoi">
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

            <div class="form-group">
                <label class="form-label" for="xacNhanMatKhau">
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

            <button type="submit" name="btnDoiMatKhau" class="btn btn-change-password">
                <i class="fas fa-check me-2"></i>Đổi mật khẩu
            </button>
        </form>

        <div class="password-requirements">
            <h6><i class="fas fa-info-circle me-2"></i>Lưu ý khi đổi mật khẩu:</h6>
            <ul>
                <li>Mật khẩu nên có ít nhất 6 ký tự</li>
                <li>Nên kết hợp chữ hoa, chữ thường và số</li>
                <li>Không chia sẻ mật khẩu với người khác</li>
                <li>Thay đổi mật khẩu định kỳ để bảo mật</li>
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const matKhauMoi = document.getElementById("matKhauMoi");
    const xacNhanMatKhau = document.getElementById("xacNhanMatKhau");

    form.addEventListener("submit", function(e) {
        if (matKhauMoi.value !== xacNhanMatKhau.value) {
            e.preventDefault();
            alert("Mật khẩu mới và xác nhận mật khẩu không khớp!");
            return false;
        }
        
        if (matKhauMoi.value.length < 6) {
            e.preventDefault();
            alert("Mật khẩu phải có ít nhất 6 ký tự!");
            return false;
        }
    });
});
</script>';
?>
