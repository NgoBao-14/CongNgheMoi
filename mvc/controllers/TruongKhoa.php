<?php
class TruongKhoa extends Controller {
    function SayHi(){
        if($_SESSION["PQ"] != 4){
            echo "<script>alert('Bạn không có quyền truy cập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
        }
        $this ->view("layoutTK", [
            "Page" => "TK"
        ]);
    }

    function DXDeTai(){
        
    $iduser = $_SESSION['iduser'];
    $dt= $this->model("mTruongKhoa");
    $detai = json_decode($dt->GetDT($iduser), true);

    if (isset($_POST['btnDuyet'])) {
        $idDetai = $_POST['idDetai'];
        $tenDeTai = $_POST['TenDeTai']; // Lấy tên đề tài từ form

        $dt->CapNhatDeTai($idDetai);
        $dt->AddDiemDeTai($idDetai);
        header("Location: ./DXDeTai");
        exit();
        }

        $this->view("layoutTK", [
            "Page" => "DuyetDeTai",
            "dt" => $detai
        ]);
    }

    function DSDeTai(){
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mTruongKhoa");
        $detai = json_decode($dt->GetDanhSachDeTai($iduser), true);
        
        $this->view("layoutTK", [
            "Page" => "DSDeTai",
            "dt" => $detai
        ]);
    }

    function DiemKhoaLuanCacNhom(){
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mTruongKhoa");
        $detai = json_decode($dt->GetDanhSachDeTaiDaDangKy($iduser), true);
        
        $this->view("layoutTK", [
            "Page" => "DSDeTaiDaDangKy",
            "dt" => $detai
        ]);
    }

}
?>