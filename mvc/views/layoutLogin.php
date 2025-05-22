<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Hệ Thống Quản Lý Khóa Luận</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        .login-form {
            padding: 40px;
        }
        .login-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
        }
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
        }
        .input-group-text {
            background-color: transparent;
            border-right: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }
        .form-control:not(:placeholder-shown) {
            border-color: #0d6efd;
        }
        .form-control {
            border-left: none;
        }
        .login-btn {
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
        }
        .login-btn:hover {
            background-color: #0b5ed7;
        }
        .forgot-password {
            text-align: center;
            margin-top: 15px;
        }
        .forgot-password a {
            color: #0d6efd;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
        .login-image {
            background-color: #e6f7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-image img {
            max-width: 100%;
            height: auto;
        }
        .captcha-container {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 10px;
            margin-top: 20px;
        }
        .captcha-checkbox {
            margin-right: 10px;
        }
        .captcha-text {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .captcha-logo {
            height: 40px;
            width: auto;
        }
        @media (max-width: 768px) {
            .login-image {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="login-form">
                        <h1 class="login-title">Đăng nhập</h1>
                        <form method = "POST">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Nhập mã sinh viên" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Nhập mật khẩu" required>
                                </div>
                            </div>
                            
                            <div class="captcha-container d-flex align-items-center">
                                <div class="d-flex align-items-center flex-grow-1">
                                    <input type="checkbox" class="captcha-checkbox" id="captcha">
                                    <label for="captcha" class="captcha-text mb-0">Tôi không phải là robot</label>
                                </div>
                                <div>
                                    <img src="https://www.gstatic.com/recaptcha/api2/logo_48.png" alt="reCAPTCHA logo" class="captcha-logo">
                                </div>
                            </div>
                            
                            <button type="submit" class="login-btn" name="btndn" id= "btndn">Đăng nhập</button>
                            
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="login-image">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-GvNR8Uob3ZgjEsuVirIrUNMxyJi8Kn.png" alt="Login illustration">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>