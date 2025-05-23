<?php
class TruongKhoa extends Controller {
    function SayHi(){
        if($_SESSION["PQ"] != 4){
            echo "<script>alert('Bạn không có quyền truy cập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
        }
        $this ->view("layoutTK", [
            "Page" => "GV"
        ]);
    }

    function DXDeTai(){
    $iduser = $_SESSION['iduser'];
    $dt= $this->model("mTruongKhoa");
    $detai = json_decode($dt->GetDT($iduser), true);

    if (isset($_POST['btnDuyet'])) {
        $idDetai = $_POST['idDetai'];
        $tenDeTai = $_POST['tenDeTai']; // Lấy tên đề tài từ form

        $dt->CapNhatDeTai($idDetai);
        header("Location: ./DXDeTai");
        exit();
    }

        $this->view("layoutTK", [
            "Page" => "DuyetDeTai",
            "dt" => $detai
        ]);
        }

}
?>