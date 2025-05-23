<?php
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

                echo "<script>alert('Đăng nhập thành công');</script>";
                if($r['PQ'] == '3') {
                    header("refresh:0; url='/CongNgheMoi/Admin/'");
                    exit;
                }
                else{
                    // Điều hướng theo vai trò
                    switch ($r['role']) {
                        case 'giangvien':
                            header("refresh:0; url='/CongNgheMoi/GiangVien/'");
                            break;
                        case 'sinhvien':
                            header("refresh:0; url='/CongNgheMoi/SinhVien/'");
                            break;
                        default:
                            header("refresh:0; url='/CongNgheMoi'");
                            break;
                    }
                    exit;}
                
            } else {
                echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu');</script>";
                header("refresh:0; url='Login'");
                exit;
            }
        }

        // view hiển thị form đăng nhập
        $this->view("layoutLogin");
    }

}
?>
