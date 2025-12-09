<?php
require_once "./mvc/controllers/GiangVien.php";

class TruongKhoa extends GiangVien {
    
    private function checkPermission() {
        if($_SESSION["PQ"] != 4 && $_SESSION["PQ"] != 1){
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Bạn không có quyền truy cập'];
            header("location: " . base_url('/'));
            exit;
        }
    }
    
    function SayHi(){
        if($_SESSION["PQ"] != 4){
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Bạn không có quyền truy cập'];
            header("location: " . base_url('/'));
            exit;
        }
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mTruongKhoa");
        $detai = json_decode($dt->GetDanhSachDeTai($iduser), true);
        $this->view("layoutTK", [
            "Page" => "TK_DSDeTai",
            "active" => "dsdetai",
            "dt" => $detai
        ]);
    }

    function DXDeTai(){
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mTruongKhoa");
        $detai = json_decode($dt->GetDT($iduser), true);

        if (isset($_POST['btnDuyet'])) {
            $idDetai = $_POST['idDetai'];
            $dt->CapNhatDeTai($idDetai);
            $dt->AddDiemDeTai($idDetai);
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Duyệt đề tài thành công'];
            header("Location: " . base_url('/TruongKhoa/DXDeTai'));
            exit;
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
        $this->view("layoutTK", [
            "Page" => "TK_HoiDongBaoVe",
            "active" => "hoidong"
        ]);
    }

    // Override các method từ GiangVien để cho phép PQ = 4 (Trưởng khoa)
    function QuanLyNhom(){
        $this->checkPermission();
        
        $iduser = $_SESSION['iduser'];
        $dt = $this->model("mGiangVien");
        $danhSachSV = json_decode($dt->getDanhSachSinhVienDangKy($iduser), true);
        
        $this->view("layoutTK", [
            "Page" => "TK_qlnhom",
            "active" => "qlnhom",
            "danhSachSV" => $danhSachSV
        ]);
    }

    function QuanLyDeTai(){
        $this->checkPermission();
        
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
        $this->checkPermission();
        
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
        $this->checkPermission();
        
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
        $this->checkPermission();
        
        // Kiểm tra MaGV có tồn tại không
        if(!isset($_SESSION['MaGV']) || empty($_SESSION['MaGV'])){
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Bạn chưa được gán mã giảng viên. Vui lòng liên hệ Admin.'];
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
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Thêm đề tài thành công'];
            } else {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Thêm đề tài thất bại'];
            }
            header("location: " . base_url('/TruongKhoa/DeXuatDeTai'));
            exit;
        }
        
        $this->view("layoutTK", [
            "Page" => "TK_DeXuatDeTai",
            "active" => "dexuatdetai"
        ]);
    }

    function ThongBaoDeTai(){
        $this->checkPermission();
        
        $iduser = $_SESSION['iduser'];
        $dt = $this->model("mGiangVien");
        
        // Xử lý cập nhật thông báo (AJAX)
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
