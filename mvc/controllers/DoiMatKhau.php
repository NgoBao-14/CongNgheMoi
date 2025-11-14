<?php
class DoiMatKhau extends Controller {
    
    function SayHi(){
        // Kiểm tra đã đăng nhập chưa
        if(!isset($_SESSION["iduser"])){
            echo "<script>alert('Vui lòng đăng nhập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
            return;
        }

        // Không cho phép admin đổi mật khẩu (nếu có PQ = 5 hoặc khác)
        // Hiện tại cho phép tất cả PQ = 1, 2, 3, 4

        $iduser = $_SESSION['iduser'];
        $model = $this->model("mDoiMatKhau");

        // Xử lý form đổi mật khẩu
        if (isset($_POST['btnDoiMatKhau'])) {
            $matKhauCu = md5($_POST['matKhauCu']);
            $matKhauMoi = $_POST['matKhauMoi'];
            $xacNhanMatKhau = $_POST['xacNhanMatKhau'];

            // Kiểm tra mật khẩu mới và xác nhận có khớp không
            if ($matKhauMoi !== $xacNhanMatKhau) {
                echo "<script>alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');</script>";
            } else {
                // Kiểm tra mật khẩu cũ
                $checkOldPass = json_decode($model->checkOldPassword($iduser, $matKhauCu), true);
                
                if ($checkOldPass) {
                    // Đổi mật khẩu
                    $matKhauMoiMD5 = md5($matKhauMoi);
                    $result = json_decode($model->changePassword($iduser, $matKhauMoiMD5), true);
                    
                    if ($result) {
                        echo "<script>alert('Đổi mật khẩu thành công!');</script>";
                        header("refresh: 0; url='/CongNgheMoi/DoiMatKhau'");
                    } else {
                        echo "<script>alert('Đổi mật khẩu thất bại!');</script>";
                    }
                } else {
                    echo "<script>alert('Mật khẩu cũ không đúng!');</script>";
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
            $this->view("layoutSV", [
                "Page" => "DoiMatKhau"
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
