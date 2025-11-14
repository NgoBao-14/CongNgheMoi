<?php
require_once "./mvc/controllers/GiangVien.php";

class TruongKhoa extends GiangVien {
    function SayHi(){
        if($_SESSION["PQ"] != 4){
            echo "<script>alert('Bạn không có quyền truy cập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
        }
        $this ->view("layoutTK", [
            "Page" => "TK",
            "active" => "dashboard"
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
            "Page" => "TK_DuyetDeTai",
            "active" => "duyetdetai",
            "dt" => $detai
        ]);
    }

    function DSDeTai(){
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mTruongKhoa");
        $detai = json_decode($dt->GetDanhSachDeTai($iduser), true);
        
        $this->view("layoutTK", [
            "Page" => "TK_DSDeTai",
            "active" => "dsdetai",
            "dt" => $detai
        ]);
    }

    function DiemKhoaLuanCacNhom(){
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mTruongKhoa");
        $detai = json_decode($dt->GetDanhSachDeTaiDaDangKy($iduser), true);
        
        $this->view("layoutTK", [
            "Page" => "TK_DSDeTaiDaDangKy",
            "active" => "diemkhoaluan",
            "dt" => $detai
        ]);
    }

    function HoiDongBaoVe(){
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mTruongKhoa");
        
        
        $this->view("layoutTK", [
            "Page" => "TK_HoiDongBaoVe",
            "active" => "hoidong"
        
        ]);
    }

    // Override các method từ GiangVien để cho phép PQ = 4 (Trưởng khoa)
    function QuanLyNhom(){
        if($_SESSION["PQ"] != 4 && $_SESSION["PQ"] != 1){
            echo "<script>alert('Bạn không có quyền truy cập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
            return;
        }
        
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mGiangVien");
        $detai = json_decode($dt->getDanhSachNhom($iduser), true);
        
        if (isset($_POST['btnXemChiTiet'])) {
            $nhom= $this->model("mDKDT");
            $idNhom = $_POST['idNhom'];
            $thongTinTV = json_decode($nhom->getTTTVNhom($idNhom), true);
            $this->view("layoutTK", [
                "Page" => "TK_qlnhom",
                "active" => "qlnhom",
                "nhom" => $detai,
                "thongTinTV" => $thongTinTV
            ]);
            return;
        }
        
        $this->view("layoutTK", [
            "Page" => "TK_qlnhom",
            "active" => "qlnhom",
            "nhom" => $detai
        ]);
    }

    function QuanLyDeTai(){
        if($_SESSION["PQ"] != 4 && $_SESSION["PQ"] != 1){
            echo "<script>alert('Bạn không có quyền truy cập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
            return;
        }
        
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mGiangVien");
        $detai = json_decode($dt->getDSDeTai($iduser), true);

        $this->view("layoutTK", [
            "Page" => "TK_qldetai",
            "active" => "qldetai",
            "dt" => $detai
        ]);
    }

    function TienDoDeTai(){
        if($_SESSION["PQ"] != 4 && $_SESSION["PQ"] != 1){
            echo "<script>alert('Bạn không có quyền truy cập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
            return;
        }
        
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mGiangVien");
        $baocao = json_decode($dt->getTTBaoCao($iduser), true);

        $this->view("layoutTK", [
            "Page" => "TK_qlbaocao",
            "active" => "tiendodetai",
            "baocao" => $baocao
        ]);
    }

    function QuanLyKhoaLuan(){
        if($_SESSION["PQ"] != 4 && $_SESSION["PQ"] != 1){
            echo "<script>alert('Bạn không có quyền truy cập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
            return;
        }
        
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mGiangVien");
        $khoaluan = json_decode($dt->getTTKhoaLuan($iduser), true);

        $this->view("layoutTK", [
            "Page" => "TK_qlkhoaluan",
            "active" => "qlkhoaluan",
            "khoaluan" => $khoaluan
        ]);
    }

    function DeXuatDeTai(){
        if($_SESSION["PQ"] != 4 && $_SESSION["PQ"] != 1){
            echo "<script>alert('Bạn không có quyền truy cập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
            return;
        }
        
        $IDGV = $_SESSION['MaGV'];
        $dt= $this->model("mGiangVien");
        
        if (isset($_POST['btnDeXuat'])) {
            $TenDeTai = $_POST['TenDeTai'];
            $Mota = $_POST['Mota'];
            $IDNganh = $_SESSION['idNganh'];
            $YeuCau = $_POST['YeuCau'];
            $soLuongTV = $_POST['soLuongTV'];
            $detai = json_decode($dt->addDeTai($TenDeTai, $Mota, $IDGV, $IDNganh, $YeuCau, $soLuongTV), true);
            
            if ($detai) {
                echo "<script>alert('Thêm đề tài thành công');</script>";
                header("refresh:0; url='/CongNgheMoi/TruongKhoa/DeXuatDeTai'");
            } else {
                echo "<script>alert('Thêm đề tài thất bại');</script>";
            }
        }
        
        $this->view("layoutTK", [
            "Page" => "TK_DeXuatDeTai",
            "active" => "dexuatdetai"
        ]);
    }

}
?>