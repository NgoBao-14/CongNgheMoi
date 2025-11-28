<style>
    .password-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }
    .password-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
    }
    .password-header h3 {
        color: #1f2937;
        font-weight: 700;
        margin: 0;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
    }
    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        width: 100%;
        transition: all 0.2s;
        font-size: 0.95rem;
    }
    .form-control:focus {
        border-color: #2563eb;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .btn-change-password {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        border: none;
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        width: 100%;
        transition: all 0.2s;
        margin-top: 1rem;
        cursor: pointer;
        font-size: 1rem;
    }
    .btn-change-password:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    .password-requirements {
        background: #f3f4f6;
        border-left: 4px solid #2563eb;
        padding: 1rem 1.25rem;
        margin-top: 1.5rem;
        border-radius: 6px;
    }
    .password-requirements h6 {
        color: #1f2937;
        margin-bottom: 0.75rem;
        font-weight: 600;
        font-size: 0.95rem;
    }
    .password-requirements ul {
        margin: 0;
        padding-left: 1.25rem;
    }
    .password-requirements li {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 1.5rem;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: #9ca3af;
    }
    .breadcrumb-item a {
        color: #6b7280;
        text-decoration: none;
    }
    .breadcrumb-item a:hover {
        color: #2563eb;
    }
    .breadcrumb-item.active {
        color: #1f2937;
        font-weight: 500;
    }
</style>

<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/CongNgheMoi/SinhVien">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Đổi mật khẩu</li>
        </ol>
    </nav>

    <div class="password-container">
        <div class="password-header">
            <h3><i class="bi bi-lock"></i> Đổi mật khẩu</h3>
        </div>

        <form method="POST" action="" id="changePasswordForm">
            <div class="form-group">
                <label class="form-label" for="matKhauCu">
                    <i class="bi bi-shield-lock me-2"></i>Mật khẩu cũ
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
                    <i class="bi bi-key me-2"></i>Mật khẩu mới
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
                    <i class="bi bi-check-circle me-2"></i>Xác nhận mật khẩu mới
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

            <button type="submit" name="btnDoiMatKhau" class="btn-change-password">
                <i class="bi bi-check-lg me-2"></i>Đổi mật khẩu
            </button>
        </form>

        <div class="password-requirements">
            <h6><i class="bi bi-info-circle me-2"></i>Lưu ý khi đổi mật khẩu:</h6>
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
    const form = document.getElementById("changePasswordForm");
    const matKhauMoi = document.getElementById("matKhauMoi");
    const xacNhanMatKhau = document.getElementById("xacNhanMatKhau");

    form.addEventListener("submit", function(e) {
        if (matKhauMoi.value !== xacNhanMatKhau.value) {
            e.preventDefault();
            if (typeof showToast === 'function') {
                showToast('Mật khẩu mới và xác nhận mật khẩu không khớp!', 'error');
            } else {
                alert("Mật khẩu mới và xác nhận mật khẩu không khớp!");
            }
            return false;
        }
        
        if (matKhauMoi.value.length < 6) {
            e.preventDefault();
            if (typeof showToast === 'function') {
                showToast('Mật khẩu phải có ít nhất 6 ký tự!', 'error');
            } else {
                alert("Mật khẩu phải có ít nhất 6 ký tự!");
            }
            return false;
        }

        if (typeof LoadingSpinner !== 'undefined') {
            LoadingSpinner.show('Đang đổi mật khẩu...');
        }
    });
});
</script>
