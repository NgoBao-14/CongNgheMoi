<?php
require_once "./mvc/private/JWTAuth.php";

class Login extends Controller {
    public function SayHi() {
        if (isset($_POST['btndn'])) {
            try {
                // Validate và sanitize input
                $user = trim($_POST['username']);
                $pass = md5($_POST['pass']);

                // Kiểm tra input rỗng
                if (empty($user) || empty($_POST['pass'])) {
                    throw new Exception("Vui lòng nhập đầy đủ thông tin");
                }

                $p = $this->model("mLogin");
                $login = $p->GetDN($user, $pass);

                if ($login && $r = $login->fetch_assoc()) {
                // Regenerate session ID để chống session fixation
                session_regenerate_id(true);
                
                // Thiết lập session
                $_SESSION['iduser'] = $r['iduser'];
                $_SESSION['username'] = $r['username'];
                $_SESSION['MaSV'] = $r['MaSV'];
                $_SESSION['MaGV'] = $r['MaGV'];
                $_SESSION['ten'] = $r['HoDem'] . ' ' . $r['Ten'];
                $_SESSION['role'] = $r['role'];
                $_SESSION['phanquyen'] = $r['PhanQuyen'];
                $_SESSION['idNganh'] = $r['IDNganh'];
                $_SESSION['PQ'] = $r['PQ'];
                
                // Tạo JWT token và lưu vào cookie
                JWTAuth::createToken($r);

                // Lấy base path (hỗ trợ cả XAMPP và Docker)
                $basePath = defined('BASE_PATH') ? BASE_PATH : '/CongNgheMoi';
                
                // Chuyển hướng theo phân quyền
                switch ($r['PQ']) {
                    case '1':
                        $redirectUrl = $basePath . '/GiangVien/';
                        break;
                    case '2':
                        $redirectUrl = $basePath . '/SinhVien/';
                        break;
                    case '3':
                        $redirectUrl = $basePath . '/Admin/';
                        break;
                    case '4':
                        $redirectUrl = $basePath . '/TruongKhoa/';
                        break;
                    default:
                        $redirectUrl = $basePath . '/';
                        break;
                }
                
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Đăng nhập thành công'];
                header("location: " . $redirectUrl);
                exit;
                } else {
                    $_SESSION['message'] = ['type' => 'error', 'text' => 'Sai tên đăng nhập hoặc mật khẩu'];
                    header("location: Login");
                    exit;
                }
            } catch (Exception $e) {
                // Log lỗi và chuyển đến trang 404
                error_log("Login error: " . $e->getMessage());
                header("Location: /CongNgheMoi/Error404");
                exit;
            }
        }

        // view hiển thị form đăng nhập
        $this->view("layoutLogin");
    }
}
?>
