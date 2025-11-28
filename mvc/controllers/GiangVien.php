<?php
class GiangVien extends Controller {
    
    function SayHi(){
        if($_SESSION["PQ"] != 1 && $_SESSION["PQ"] != 4){
            echo "<script>alert('Bạn không có quyền truy cập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
        }
        $this ->view("layoutGV2", [
            "Page" => "GV"
        ]);
    }

    function QuanLyNhom(){
        $iduser = $_SESSION['iduser'];
        $dt = $this->model("mGiangVien");
        
        // Lấy danh sách tất cả sinh viên đã đăng ký đề tài
        $danhSachSV = json_decode($dt->getDanhSachSinhVienDangKy($iduser), true);
        
        $this->view("layoutGV2", [
            "Page" => "qlnhom",
            "danhSachSV" => $danhSachSV
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

    function QuanLyDeTai(){
        // $_SESSION['iduser'];
        $iduser = $_SESSION['iduser'];
        $dt= $this->model("mGiangVien");
        $detai = json_decode($dt->getDSDeTai($iduser), true);

        $this->view("layoutGV2", [
            "Page" => "qldetai",
            "dt" => $detai
        ]);
    }

    // COMMENTED OUT - Feature removed from sidebar
    // function TienDoDeTai(){
    //     // $_SESSION['iduser'] = 3;
    //     $iduser = $_SESSION['iduser'];
    //     $dt= $this->model("mGiangVien");
    //     $baocao = json_decode($dt->getTTBaoCao($iduser), true);

    //     $this->view("layoutGV2", [
    //         "Page" => "qlbaocao",
    //         "baocao" => $baocao
    //     ]);
    // }

    // COMMENTED OUT - Feature removed from sidebar
    // function QuanLyKhoaLuan(){
    //     // $_SESSION['iduser'] = 3;
    //     $iduser = $_SESSION['iduser'];
    //     $dt= $this->model("mGiangVien");
    //     $khoaluan = json_decode($dt->getTTKhoaLuan($iduser), true);

    //     $this->view("layoutGV2", [
    //         "Page" => "qlkhoaluan",
    //         "khoaluan" => $khoaluan
    //     ]);
    // }

    function DeXuatDeTai(){
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
                header("refresh:0; url='/CongNgheMoi/GiangVien/DeXuatDeTai'");
            } else {
                echo "<script>alert('Thêm đề tài thất bại');</script>";
            }
        }
        $this->view("layoutGV2", [
            "Page" => "DeXuatDeTai",
            
        ]);
        
    }

    function ThongBaoDeTai(){
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
        
        $this->view("layoutGV2", [
            "Page" => "ThongBaoDeTai",
            "dsDeTai" => $dsDeTai
        ]);
    }
}
?>
