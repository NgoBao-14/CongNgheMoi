<?php
class SinhVien extends Controller {
    
    function SayHi(){
        if($_SESSION["PQ"] != 2){
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Bạn không có quyền truy cập'];
            header("location: " . base_url('/'));
            exit;
        }
        $iduser= $_SESSION['iduser'];
        $masv = $_SESSION['MaSV'];
        $dt= $this->model("mDKDT");
        $nhom = $dt->getIDNhomByIDUser($iduser);
        $ttsv = json_decode($dt->TTSV($masv), true);
        $this->view("layoutSinhVien", [
            "nhom" => $nhom,
            "ttsv" => $ttsv
        ]);
    }

    function DeTai(){
        $iduser= $_SESSION['iduser'];
        $masv = $_SESSION['MaSV'];
        $dt= $this->model("mDKDT");
        
        // Kiểm tra sinh viên đã đăng ký đề tài chưa
        $daDangKy = $dt->ktSV($masv);
        
        // Nếu đã đăng ký, redirect về trang thông tin đề tài
        if ($daDangKy) {
            $_SESSION['message'] = ['type' => 'info', 'text' => 'Bạn đã đăng ký đề tài rồi!'];
            header("location: " . base_url('/SinhVien/ThongTinDeTai'));
            exit;
        }
        
        $detai = $dt->getTTDeTai($iduser);
        
        $this->view("layoutSinhVien", [
            "Page" => "DeTai",
            "dt" => $detai,
            "daDangKy" => $daDangKy
        ]);

        if (isset($_POST['btnDKN'])) {
            $nhomModel = $this->model("mDKDT");

            $IDDeTai = $_POST['selectedProjectId'];
            $leaderMaSV = $_POST['leaderMssv'];
            $members = $_POST['members'];

            if ($nhomModel->ktSV($leaderMaSV)) {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Nhóm trưởng đã thuộc một nhóm khác.'];
                return;
            }
            $idnganhUser = $nhomModel->layIDNganhUser($iduser); 
            
            foreach ($members as $member) {
                $mssv = $member['mssv'];
                $hoten = trim($member['hoten']);

                $sv = $nhomModel->timSV($mssv);

                if (!$sv) {
                    $_SESSION['message'] = ['type' => 'error', 'text' => "MSSV $mssv không tồn tại."];
                    return;
                }

                if (trim($sv['HoTen']) !== $hoten) {
                    $_SESSION['message'] = ['type' => 'error', 'text' => "Tên không khớp với MSSV $mssv."];
                    return;
                }

                if ($sv['IDNganh'] != $idnganhUser) {
                    $_SESSION['message'] = ['type' => 'error', 'text' => "Sinh viên $mssv không cùng ngành."];
                    return;
                }

                if ($nhomModel->ktSV($mssv)) {
                    $_SESSION['message'] = ['type' => 'error', 'text' => "Sinh viên $mssv đã thuộc một nhóm khác."];
                    return;
                }
            }

            // Tạo nhóm mới
            $idNhomMoi = $nhomModel->addNhom($IDDeTai);
            if (!$idNhomMoi) {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Lỗi khi tạo nhóm.'];
                return;
            }

            // Gán nhóm cho nhóm trưởng
            $nhomModel->addSVNhom($leaderMaSV, $idNhomMoi);

            // Gán nhóm cho từng thành viên còn lại
            foreach ($members as $member) {
                $nhomModel->addSVNhom($member['mssv'], $idNhomMoi);
            }
            // Cập nhật trạng thái đề tài
            $nhomModel->capNhatTTDeTai($IDDeTai, $idNhomMoi);
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Đăng ký nhóm thành công!'];
            header("location: " . base_url('/SinhVien/DeTaiDK'));
            exit;
        }
    }

    function DeTaiDK() {
        $iduser= $_SESSION['iduser'];
        $dtdk = $this->model("mDKDT");
        $idNhom = $dtdk->getIDNhomByIDUser($iduser);

        $detaidk = json_decode($dtdk->getTTDeTaiByIDU($iduser), true);
        $nhom = json_decode($dtdk->getTTTVNhom($idNhom), true);

        $this->view("layoutSinhVien", [
            "Page" => "DeTaiDK",
            "dtdk" => $detaidk,
            "nhom" => $nhom
        ]);
    }
    
    function ThongTinDeTai() {
        $this->view("layoutSinhVien", [
            "Page" => "ThongTinDeTai"
        ]);
    }
    
    function DangKyDeTaiMoi() {
        if (!isset($_GET['iddetai'])) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Không tìm thấy đề tài!'];
            header("location: " . base_url('/SinhVien/DeTai'));
            exit;
        }
        
        $iduser = $_SESSION['iduser'];
        $masv = $_SESSION['MaSV'];
        $idDeTai = $_GET['iddetai'];
        
        $dt = $this->model("mDKDT");
        
        // Kiểm tra sinh viên đã đăng ký đề tài chưa
        if ($dt->ktSV($masv)) {
            $_SESSION['message'] = ['type' => 'warning', 'text' => 'Bạn đã đăng ký đề tài rồi!'];
            header("location: " . base_url('/SinhVien/ThongTinDeTai'));
            exit;
        }
        
        // Kiểm tra đề tài đã đủ số lượng chưa
        $sqlCheck = "SELECT 
                        dt.SoLuongTV,
                        (SELECT COUNT(*) FROM dangkydetai WHERE IDDeTai = dt.IDDeTai) AS SoLuongDaDangKy
                     FROM detai dt
                     WHERE dt.IDDeTai = '$idDeTai'";
        $resultCheck = mysqli_query($dt->connect, $sqlCheck);
        $rowCheck = mysqli_fetch_assoc($resultCheck);
        
        if ($rowCheck && $rowCheck['SoLuongDaDangKy'] >= $rowCheck['SoLuongTV']) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Đề tài này đã đủ số lượng sinh viên đăng ký!'];
            header("location: " . base_url('/SinhVien/DeTai'));
            exit;
        }
        
        // Đăng ký đề tài
        $result = $dt->dangKyDeTai($masv, $idDeTai);
        
        if ($result) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Đăng ký đề tài thành công!'];
            header("location: " . base_url('/SinhVien/ThongTinDeTai'));
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Có lỗi xảy ra khi đăng ký!'];
            header("location: " . base_url('/SinhVien/DeTai'));
        }
        exit;
    }
    
    function HuyDangKyDeTai() {
        $masv = $_SESSION['MaSV'];
        $dt = $this->model("mDKDT");
        
        // Kiểm tra đã đăng ký chưa
        if (!$dt->ktSV($masv)) {
            $_SESSION['message'] = ['type' => 'warning', 'text' => 'Bạn chưa đăng ký đề tài!'];
            header("location: " . base_url('/SinhVien/DeTai'));
            exit;
        }
        
        // Kiểm tra xem có đang trong nhóm không
        if ($dt->ktSVCoNhom($masv)) {
            $_SESSION['message'] = ['type' => 'warning', 'text' => 'Bạn đang trong nhóm, vui lòng hủy nhóm trước!'];
            header("location: " . base_url('/SinhVien/ThongTinDeTai'));
            exit;
        }
        
        // Hủy đăng ký
        $result = $dt->huyDangKyDeTai($masv);
        if ($result) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Hủy đăng ký đề tài thành công!'];
            header("location: " . base_url('/SinhVien/DeTai'));
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Có lỗi xảy ra!'];
            header("location: " . base_url('/SinhVien/ThongTinDeTai'));
        }
        exit;
    }
    
    function DangKyNhom() {
        if (!isset($_GET['masv'])) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Không tìm thấy thông tin sinh viên!'];
            header("location: " . base_url('/SinhVien/ThongTinDeTai'));
            exit;
        }
        
        $masv = $_SESSION['MaSV'];
        $masvChon = $_GET['masv'];
        
        $dt = $this->model("mDKDT");
        
        // Kiểm tra cả 2 đã đăng ký đề tài chưa
        if (!$dt->ktSV($masv) || !$dt->ktSV($masvChon)) {
            $_SESSION['message'] = ['type' => 'warning', 'text' => 'Cả 2 sinh viên phải đăng ký đề tài trước!'];
            header("location: " . base_url('/SinhVien/ThongTinDeTai'));
            exit;
        }
        
        // Kiểm tra cả 2 đều chưa có nhóm
        if ($dt->ktSVCoNhom($masv) || $dt->ktSVCoNhom($masvChon)) {
            $_SESSION['message'] = ['type' => 'warning', 'text' => 'Một trong hai sinh viên đã có nhóm!'];
            header("location: " . base_url('/SinhVien/ThongTinDeTai'));
            exit;
        }
        
        // Lấy IDDeTai của sinh viên hiện tại
        $sqlDeTai = "SELECT IDDeTai FROM dangkydetai WHERE MaSV = '$masv'";
        $resultDeTai = mysqli_query($dt->connect, $sqlDeTai);
        $rowDeTai = mysqli_fetch_assoc($resultDeTai);
        $idDeTai = $rowDeTai['IDDeTai'];
        
        // Tạo nhóm mới và thêm 2 sinh viên
        $result = $dt->dangKyNhom($masv, $masvChon, $idDeTai);
        
        if ($result) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Đăng ký nhóm thành công!'];
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Có lỗi xảy ra!'];
        }
        header("location: " . base_url('/SinhVien/ThongTinDeTai'));
        exit;
    }
    
    function HuyNhom() {
        $masv = $_SESSION['MaSV'];
        $dt = $this->model("mDKDT");
        
        $idNhom = $dt->getIDNhomByMaSV($masv);
        if (!$idNhom) {
            $_SESSION['message'] = ['type' => 'warning', 'text' => 'Bạn chưa có nhóm!'];
            header("location: " . base_url('/SinhVien/ThongTinDeTai'));
            exit;
        }
        
        // Kiểm tra nhóm có nhiều hơn 1 người không
        $nhom = json_decode($dt->getTTTVNhom($idNhom), true);
        if (count($nhom) <= 1) {
            $_SESSION['message'] = ['type' => 'info', 'text' => 'Bạn đang làm một mình!'];
            header("location: " . base_url('/SinhVien/ThongTinDeTai'));
            exit;
        }
        
        // Hủy nhóm
        $result = $dt->huyNhom($idNhom);
        if ($result) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Hủy nhóm thành công! Các thành viên đã trở về làm một mình.'];
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Có lỗi xảy ra!'];
        }
        header("location: " . base_url('/SinhVien/ThongTinDeTai'));
        exit;
    }
    
    function TieuChiDanhGia() {
        $this->view("layoutSinhVien", [
            "Page" => "TieuChiDanhGia"
        ]);
    }
    
    function LichSuDangKy() {
        $iduser = $_SESSION['iduser'];
        $dt = $this->model("mDKDT");
        $lichsu = json_decode($dt->getLichSuDangKy($iduser), true);
        
        $this->view("layoutSinhVien", [
            "Page" => "LichSuDangKy",
            "lichsu" => $lichsu
        ]);
    }

    function getThongBaoGVHD() {
        header('Content-Type: application/json');
        if($_SESSION["PQ"] != 2){
            echo json_encode(["success" => false, "message" => "Bạn không có quyền truy cập"]);
            return;
        }
        
        $iduser = $_SESSION['iduser'];
        $dtdk = $this->model("mDKDT");
        $idNhom = $dtdk->getIDNhomByIDUser($iduser);
        
        if (!$idNhom) {
            echo json_encode(["success" => false, "message" => "Không tìm thấy nhóm"]);
            return;
        }
        
        $thongbao = $dtdk->getThongBaoGVHD($idNhom);
        echo json_encode(["success" => true, "thongbao" => $thongbao]);
    }

    function getThongBaoDeTai() {
        header('Content-Type: application/json');
        if($_SESSION["PQ"] != 2){
            echo json_encode(["success" => false, "message" => "Bạn không có quyền truy cập"]);
            return;
        }
        
        $iduser = $_SESSION['iduser'];
        $dtdk = $this->model("mDKDT");
        
        $detaiInfo = json_decode($dtdk->getTTDeTaiByIDU($iduser), true);
        
        if (empty($detaiInfo)) {
            echo json_encode(["success" => false, "thongbao" => ""]);
            return;
        }
        
        $thongbao = isset($detaiInfo[0]['ThongBao']) ? $detaiInfo[0]['ThongBao'] : "";
        echo json_encode(["success" => true, "thongbao" => $thongbao]);
    }

    function getTTDeTaiForDashboard() {
        header('Content-Type: application/json');
        if($_SESSION["PQ"] != 2){
            echo json_encode(["success" => false, "message" => "Bạn không có quyền truy cập"]);
            return;
        }
        
        $iduser = $_SESSION['iduser'];
        $dtdk = $this->model("mDKDT");
        
        $detaiInfo = json_decode($dtdk->getTTDeTaiByIDU($iduser), true);
        
        if (empty($detaiInfo)) {
            echo json_encode(["success" => false, "data" => null]);
            return;
        }
        
        $thesis = $detaiInfo[0];
        echo json_encode([
            "success" => true, 
            "data" => [
                "TenDeTai" => $thesis['TenDeTai'] ?? "",
                "GiangVienHuongDan" => $thesis['GiangVienHuongDan'] ?? "",
                "TrangThaiDK" => $thesis['TrangThaiDK'] ?? "",
                "MoTa" => $thesis['MoTa'] ?? "",
                "YeuCau" => $thesis['YeuCau'] ?? "",
                "ChuyenNganh" => $thesis['ChuyenNganh'] ?? "",
                "Email" => $thesis['Email'] ?? "",
                "ThongBao" => $thesis['ThongBao'] ?? ""
            ]
        ]);
    }

    function getKetQuaCham() {
        header('Content-Type: application/json');
        if($_SESSION["PQ"] != 2){
            echo json_encode(["success" => false, "message" => "Bạn không có quyền truy cập"]);
            return;
        }
        
        $masv = $_SESSION['MaSV'];
        $dtdk = $this->model("mDKDT");
        
        if (!$dtdk->ktSV($masv)) {
            echo json_encode(["success" => false, "message" => "Bạn chưa đăng ký đề tài"]);
            return;
        }
        
        $ketqua = $dtdk->getKetQuaChamByMaSV($masv);
        echo json_encode(["success" => true, "ketqua" => $ketqua]);
    }

    function DoiMatKhau() {
        header("location: " . base_url('/DoiMatKhau'));
        exit;
    }
}
?>
