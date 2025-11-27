<?php
require_once "./mvc/helpers/ToastHelper.php";

class Login extends Controller {
    public function SayHi() {
        if (isset($_POST['btndn'])) {
            $user = $_POST['username'];
            $pass = md5($_POST['pass']);

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

                // Chuyển hướng theo phân quyền
                switch ($r['PQ']) {
                    case '1':
                        ToastHelper::success('Đăng nhập thành công!', '/CongNgheMoi/GiangVien/');
                        break;
                    case '2':
                        ToastHelper::success('Đăng nhập thành công!', '/CongNgheMoi/SinhVien/');
                        break;
                    case '3':
                        ToastHelper::success('Đăng nhập thành công!', '/CongNgheMoi/Admin/');
                        break;
                    case '4':
                        ToastHelper::success('Đăng nhập thành công!', '/CongNgheMoi/TruongKhoa/');
                        break;
                    default:
                        ToastHelper::success('Đăng nhập thành công!', '/CongNgheMoi/');
                        break;
                }
                exit;
            } else {
                ToastHelper::error('Sai tên đăng nhập hoặc mật khẩu!', 'Login');
                exit;
            }
        }

        // view hiển thị form đăng nhập
        $this->view("layoutLogin");
    }
}
?>
