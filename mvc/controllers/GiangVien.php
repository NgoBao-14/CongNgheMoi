<?php
class GiangVien extends Controller {
    
    function SayHi(){
        $this ->view("layoutGV2", [
            "Page" => "GV"
        ]);
    }

    function QuanLyNhom(){
        $_SESSION['iduser'] = 3;
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mGiangVien");
        $detai = json_decode($dt->getDanhSachNhom($iduser), true);
        //nếu có thao tác trên nút xem chi tiết thì hiện ra thông tin thành viên nhóm
        if (isset($_POST['btnXemChiTiet'])) {
            $nhom= $this->model("mDKDT");
            $idNhom = $_POST['idNhom'];
            $thongTinTV = json_decode($nhom->getTTTVNhom($idNhom), true);
            $this->view("layoutGV2", [
            "Page" => "qlnhom",
            "nhom" => $detai,
            "thongTinTV" => $thongTinTV
        ]);
        }
        $this->view("layoutGV2", [
            "Page" => "qlnhom",
            "nhom" => $detai
        ]);
    }

    function QuanLyDeTai(){
        $_SESSION['iduser'] = 3;
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mGiangVien");
        $detai = json_decode($dt->getDSDeTai($iduser), true);

        $this->view("layoutGV2", [
            "Page" => "qldetai",
            "dt" => $detai
        ]);
    }

    function TienDoDeTai(){
        $_SESSION['iduser'] = 3;
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mGiangVien");
        $baocao = json_decode($dt->getTTBaoCao($iduser), true);

        $this->view("layoutGV2", [
            "Page" => "qlbaocao",
            "baocao" => $baocao
        ]);
    }

    function QuanLyKhoaLuan(){
        $_SESSION['iduser'] = 3;
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mGiangVien");
        $khoaluan = json_decode($dt->getTTKhoaLuan($iduser), true);

        $this->view("layoutGV2", [
            "Page" => "qlkhoaluan",
            "khoaluan" => $khoaluan
        ]);
    }
}
?>