<?php
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

                echo "<script>alert('Đăng nhập thành công');</script>";

                // Chuyển hướng theo phân quyền
                switch ($r['PQ']) {
                    case '1':
                        header("refresh:0; url='/CongNgheMoi/GiangVien/'");
                        break;
                    case '2':
                        header("refresh:0; url='/CongNgheMoi/SinhVien/'");
                        break;
                    case '3':
                        header("refresh:0; url='/CongNgheMoi/Admin/'");
                        break;
                    case '4':
                        header("refresh:0; url='/CongNgheMoi/TruongKhoa/'");
                        break;
                    default:
                        header("refresh:0; url='/CongNgheMoi/'");
                        break;

                }
                    exit;
                } else {
                    echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu');</script>";
                    header("refresh:0; url='Login'");
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
