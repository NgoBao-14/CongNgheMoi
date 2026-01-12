<?php
class DoiMatKhau extends Controller {
    
    function SayHi(){
        // Kiểm tra đã đăng nhập chưa
        if(!isset($_SESSION["iduser"])){
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Vui lòng đăng nhập'];
            header("location: " . base_url('/'));
            exit;
        }

        $iduser = $_SESSION['iduser'];
        $model = $this->model("mDoiMatKhau");

        // Xử lý form  mật khẩu
        if (isset($_POST['btnDoiMatKhau'])) {
            $matKhauCu = md5($_POST['matKhauCu']);
            $matKhauMoi = $_POST['matKhauMoi'];
            $xacNhanMatKhau = $_POST['xacNhanMatKhau'];

            // Kiểm tra mật khẩu mới và xác nhận có khớp không
            if ($matKhauMoi !== $xacNhanMatKhau) {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Mật khẩu mới và xác nhận mật khẩu không khớp!'];
            } else {
                // Kiểm tra mật khẩu cũ
                $checkOldPass = json_decode($model->checkOldPassword($iduser, $matKhauCu), true);
                
                if ($checkOldPass) {
                    //  mật khẩu
                    $matKhauMoiMD5 = md5($matKhauMoi);
                    $result = json_decode($model->changePassword($iduser, $matKhauMoiMD5), true);
                    
                    if ($result) {
                        $_SESSION['message'] = ['type' => 'success', 'text' => 'Đổi mật khẩu thành công!'];
                        header("location: " . base_url('/DoiMatKhau'));
                        exit;
                    } else {
                        $_SESSION['message'] = ['type' => 'error', 'text' => 'Đổi mật khẩu thất bại!'];
                    }
                } else {
                    $_SESSION['message'] = ['type' => 'error', 'text' => 'Mật khẩu cũ không đúng!'];
                }
            }
        }

        // Hiển thị view tương ứng với phân quyền
        $pq = intval($_SESSION["PQ"]);
        
        if ($pq == 4) {
            // Trưởng khoa
            $this->view("layoutTK", [
                "Page" => "TK_DoiMatKhau",
                "active" => "doimatkhau"
            ]);
        } elseif ($pq == 1) {
            // Giảng viên
            $this->view("layoutGV2", [
                "Page" => "DoiMatKhau",
                "active" => "doimatkhau"
            ]);
        } elseif ($pq == 2) {
            // Sinh viên
            $this->view("layoutSinhVien", [
                "Page" => "SV_DoiMatKhau"
            ]);
        } else {
            // Mặc định
            $this->view("layoutGV2", [
                "Page" => "DoiMatKhau",
                "active" => "doimatkhau"
            ]);
        }
    }
}
?>
