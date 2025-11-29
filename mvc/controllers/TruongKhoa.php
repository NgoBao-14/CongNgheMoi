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
        $dt = $this->model("mGiangVien");
        
        // Lấy danh sách tất cả sinh viên đã đăng ký đề tài
        $danhSachSV = json_decode($dt->getDanhSachSinhVienDangKy($iduser), true);
        
        $this->view("layoutTK", [
            "Page" => "TK_qlnhom",
            "active" => "qlnhom",
            "danhSachSV" => $danhSachSV
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
        
        // Kiểm tra MaGV có tồn tại không
        if(!isset($_SESSION['MaGV']) || empty($_SESSION['MaGV'])){
            echo "<script>alert('Bạn chưa được gán mã giảng viên. Vui lòng liên hệ Admin.');</script>";
            $this->view("layoutTK", [
                "Page" => "TK_DeXuatDeTai",
                "active" => "dexuatdetai"
            ]);
            return;
        }
        
        $IDGV = $_SESSION['MaGV'];
        $dt = $this->model("mGiangVien");
        
        if (isset($_POST['btnDeXuat'])) {
            $TenDeTai = $_POST['TenDeTai'];
            $Mota = $_POST['Mota'];
            $IDNganh = isset($_SESSION['idNganh']) ? $_SESSION['idNganh'] : 1;
            $YeuCau = $_POST['YeuCau'];
            $soLuongTV = $_POST['soLuongTV'];
            $result = $dt->addDeTai($TenDeTai, $Mota, $IDGV, $IDNganh, $YeuCau, $soLuongTV);
            
            if ($result) {
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

    function ThongBaoDeTai(){
        if($_SESSION["PQ"] != 4 && $_SESSION["PQ"] != 1){
            echo "<script>alert('Bạn không có quyền truy cập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
            return;
        }
        
        $iduser = $_SESSION['iduser'];
        $dt = $this->model("mGiangVien");
        
        // Xử lý cập nhật thông báo
        if (isset($_POST['btnCapNhat'])) {
            header('Content-Type: application/json');
            $IDDeTai = isset($_POST['IDDeTai']) ? intval($_POST['IDDeTai']) : null;
            $ThongBao = isset($_POST['ThongBao']) ? trim($_POST['ThongBao']) : '';
            
            if (!$IDDeTai || $IDDeTai <= 0) {
                echo json_encode(["success" => false, "message" => "Đề tài không hợp lệ"]);
                exit;
            }
            
            if (!$dt->checkGVQuyen($IDDeTai, $iduser)) {
                echo json_encode(["success" => false, "message" => "Bạn không có quyền sửa đề tài này"]);
                exit;
            }
            
            if (strlen($ThongBao) > 5000) {
                echo json_encode(["success" => false, "message" => "Thông báo quá dài (tối đa 5000 ký tự)"]);
                exit;
            }
            
            $result = $dt->capNhatThongBao($IDDeTai, $ThongBao);
            echo $result;
            exit;
        }
        
        // Lấy danh sách đề tài để tạo thông báo
        $dsDeTai = json_decode($dt->getDSDeTaiThongBao($iduser), true);
        
        $this->view("layoutTK", [
            "Page" => "TK_ThongBaoDeTai",
            "active" => "thongbaodetai",
            "dsDeTai" => $dsDeTai
        ]);
    }

    function getKetQuaDanhGia() {
        header('Content-Type: application/json');
        
        if (!isset($_GET['masv'])) {
            echo json_encode(["success" => false, "message" => "Không tìm thấy mã sinh viên"]);
            return;
        }
        
        $masv = $_GET['masv'];
        $dt = $this->model("mGiangVien");
        $ketqua = $dt->getKetQuaDanhGia($masv);
        
        if ($ketqua) {
            echo json_encode(["success" => true, "ketqua" => $ketqua]);
        } else {
            echo json_encode(["success" => false, "message" => "Chưa có kết quả đánh giá"]);
        }
    }

}
?>