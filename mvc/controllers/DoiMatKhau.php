<?php
require_once "./mvc/helpers/ToastHelper.php";

class DoiMatKhau extends Controller {
    
    function SayHi(){
        // Kiểm tra đã đăng nhập chưa
        if(!isset($_SESSION["iduser"])){
            ToastHelper::error('Vui lòng đăng nhập', '/CongNgheMoi');
            return;
        }

        $iduser = $_SESSION['iduser'];
        $model = $this->model("mDoiMatKhau");

        // Xử lý form đổi mật khẩu
        if (isset($_POST['btnDoiMatKhau'])) {
            $matKhauCu = md5($_POST['matKhauCu']);
            $matKhauMoi = $_POST['matKhauMoi'];
            $xacNhanMatKhau = $_POST['xacNhanMatKhau'];

            // Kiểm tra mật khẩu mới và xác nhận có khớp không
            if ($matKhauMoi !== $xacNhanMatKhau) {
                ToastHelper::error('Mật khẩu mới và xác nhận mật khẩu không khớp!');
            } else {
                // Kiểm tra mật khẩu cũ
                $checkOldPass = json_decode($model->checkOldPassword($iduser, $matKhauCu), true);
                
                if ($checkOldPass) {
                    // Đổi mật khẩu
                    $matKhauMoiMD5 = md5($matKhauMoi);
                    $result = json_decode($model->changePassword($iduser, $matKhauMoiMD5), true);
                    
                    if ($result) {
                        ToastHelper::success('Đổi mật khẩu thành công!', '/CongNgheMoi/DoiMatKhau');
                    } else {
                        ToastHelper::error('Đổi mật khẩu thất bại!');
                    }
                } else {
                    ToastHelper::error('Mật khẩu cũ không đúng!');
                }
            }
        }

        // Hiển thị view tương ứng với phân quyền
        $pq = $_SESSION["PQ"];
        
        if ($pq == 1) {
            // Giảng viên
            $this->view("layoutGV2", [
                "Page" => "DoiMatKhau"
            ]);
        } elseif ($pq == 2) {
            // Sinh viên
            $this->view("layoutSinhVien", [
                "Page" => "SV_DoiMatKhau"
            ]);
        } elseif ($pq == 4) {
            // Trưởng khoa
            $this->view("layoutTK", [
                "Page" => "TK_DoiMatKhau",
                "active" => "doimatkhau"
            ]);
        } else {
            // Mặc định
            $this->view("layoutGV2", [
                "Page" => "DoiMatKhau"
            ]);
        }
    }
}
?>
