<?php
require_once "./mvc/helpers/ToastHelper.php";

class SinhVien extends Controller {
    
    function SayHi(){
        if($_SESSION["PQ"] != 2){
            ToastHelper::error('Bạn không có quyền truy cập', '/CongNgheMoi');
            return;
        }
        $iduser= $_SESSION['iduser'];
        $masv = $_SESSION['MaSV'];
        $dt= $this->model("mDKDT");
        $nhom = $dt->getIDNhomByIDUser($iduser);
        $ttsv = json_decode($dt->TTSV($masv), true);
        $this->view("layoutSV", [
            "nhom" => $nhom,
            "ttsv" => $ttsv
        ]);
    }

    function DeTai(){
        $iduser= $_SESSION['iduser'];
        $masv = $_SESSION['MaSV'];
        $dt= $this->model("mDKDT");
        $detai = $dt->getTTDeTai($iduser);
        
        // Kiểm tra sinh viên đã đăng ký đề tài chưa
        $daDangKy = $dt->ktSV($masv);
        
        // page cũ DeTai, layoutDKDT
        $this->view("layoutDKDT", [
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
        ToastHelper::error('Nhóm trưởng đã thuộc một nhóm khác.');
        return;
    }
    $idnganhUser = $nhomModel->layIDNganhUser($iduser); 
    // Kiểm tra các thành viên còn lại 
    foreach ($members as $member) {
    $mssv = $member['mssv'];
    $hoten = trim($member['hoten']);

    $sv = $nhomModel->timSV($mssv);

    if (!$sv) {
        ToastHelper::error("MSSV $mssv không tồn tại.");
        return;
    }

    if (trim($sv['HoTen']) !== $hoten) {
        ToastHelper::error("Tên không khớp với MSSV $mssv.");
        return;
    }

    if ($sv['IDNganh'] != $idnganhUser) {
        ToastHelper::error("Sinh viên $mssv không cùng ngành.");
        return;
    }

    if ($nhomModel->ktSV($mssv)) {
        ToastHelper::error("Sinh viên $mssv đã thuộc một nhóm khác.");
        return;
    }
}

    // Tạo nhóm mới
    $idNhomMoi = $nhomModel->addNhom($IDDeTai);
    if (!$idNhomMoi) {
        ToastHelper::error('Lỗi khi tạo nhóm.');
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
    ToastHelper::success('Đăng ký nhóm thành công!', './DeTaiDK');
    }

    }

    function DeTaiDK() {
    $iduser= $_SESSION['iduser'];
    $dtdk = $this->model("mDKDT");
    $idNhom = $dtdk->getIDNhomByIDUser($iduser);

    $detaidk = json_decode($dtdk->getTTDeTaiByIDU($iduser), true);
    $nhom = json_decode($dtdk->getTTTVNhom($idNhom), true);

    $this->view("layoutDKDT", [
        "Page" => "DeTaiDK",
        "dtdk" => $detaidk,
        "nhom" => $nhom
    ]);
    }
    
    function ThongTinDeTai() {
        $this->view("layoutDKDT", [
            "Page" => "ThongTinDeTai"
        ]);
    }
    
    function DangKyDeTaiMoi() {
        if (!isset($_GET['iddetai'])) {
            ToastHelper::error('Không tìm thấy đề tài!', './DeTai');
            return;
        }
        
        $iduser = $_SESSION['iduser'];
        $masv = $_SESSION['MaSV'];
        $idDeTai = $_GET['iddetai'];
        
        $dt = $this->model("mDKDT");
        
        // Kiểm tra sinh viên đã đăng ký đề tài chưa
        if ($dt->ktSV($masv)) {
            ToastHelper::warning('Bạn đã đăng ký đề tài rồi!', './ThongTinDeTai');
            return;
        }
        
        // Đăng ký đề tài (chưa tạo nhóm, làm một mình)
        $result = $dt->dangKyDeTai($masv, $idDeTai);
        
        if ($result) {
            ToastHelper::success('Đăng ký đề tài thành công!', './ThongTinDeTai');
        } else {
            ToastHelper::error('Có lỗi xảy ra khi đăng ký!', './DeTai');
        }
    }
    
    function HuyDangKyDeTai() {
        $iduser = $_SESSION['iduser'];
        $masv = $_SESSION['MaSV'];
        $dt = $this->model("mDKDT");
        
        // Kiểm tra đã đăng ký chưa
        if (!$dt->ktSV($masv)) {
            ToastHelper::warning('Bạn chưa đăng ký đề tài!', './DeTai');
            return;
        }
        
        // Kiểm tra xem có đang trong nhóm không
        if ($dt->ktSVCoNhom($masv)) {
            ToastHelper::warning('Bạn đang trong nhóm, vui lòng hủy nhóm trước!', './ThongTinDeTai');
            return;
        }
        
        // Hủy đăng ký
        $result = $dt->huyDangKyDeTai($masv);
        if ($result) {
            ToastHelper::success('Hủy đăng ký đề tài thành công!', './DeTai');
        } else {
            ToastHelper::error('Có lỗi xảy ra!', './ThongTinDeTai');
        }
    }
    
    function DangKyNhom() {
        if (!isset($_GET['masv'])) {
            ToastHelper::error('Không tìm thấy thông tin sinh viên!', './ThongTinDeTai');
            return;
        }
        
        $iduser = $_SESSION['iduser'];
        $masv = $_SESSION['MaSV'];
        $masvChon = $_GET['masv'];
        
        $dt = $this->model("mDKDT");
        
        // Kiểm tra cả 2 đã đăng ký đề tài chưa
        if (!$dt->ktSV($masv) || !$dt->ktSV($masvChon)) {
            ToastHelper::warning('Cả 2 sinh viên phải đăng ký đề tài trước!', './ThongTinDeTai');
            return;
        }
        
        // Kiểm tra cả 2 đều chưa có nhóm
        if ($dt->ktSVCoNhom($masv) || $dt->ktSVCoNhom($masvChon)) {
            ToastHelper::warning('Một trong hai sinh viên đã có nhóm!', './ThongTinDeTai');
            return;
        }
        
        // Lấy IDDeTai của sinh viên hiện tại
        $sqlDeTai = "SELECT IDDeTai FROM dangkydetai WHERE MaSV = '$masv'";
        $resultDeTai = mysqli_query($dt->connect, $sqlDeTai);
        $rowDeTai = mysqli_fetch_assoc($resultDeTai);
        $idDeTai = $rowDeTai['IDDeTai'];
        
        // Tạo nhóm mới và thêm 2 sinh viên
        $result = $dt->dangKyNhom($masv, $masvChon, $idDeTai);
        
        if ($result) {
            ToastHelper::success('Đăng ký nhóm thành công!', './ThongTinDeTai');
        } else {
            ToastHelper::error('Có lỗi xảy ra!', './ThongTinDeTai');
        }
    }
    
    function HuyNhom() {
        $iduser = $_SESSION['iduser'];
        $masv = $_SESSION['MaSV'];
        $dt = $this->model("mDKDT");
        
        $idNhom = $dt->getIDNhomByMaSV($masv);
        if (!$idNhom) {
            ToastHelper::warning('Bạn chưa có nhóm!', './ThongTinDeTai');
            return;
        }
        
        // Kiểm tra nhóm có nhiều hơn 1 người không
        $nhom = json_decode($dt->getTTTVNhom($idNhom), true);
        if (count($nhom) <= 1) {
            ToastHelper::info('Bạn đang làm một mình!', './ThongTinDeTai');
            return;
        }
        
        // Hủy nhóm
        $result = $dt->huyNhom($idNhom);
        if ($result) {
            ToastHelper::success('Hủy nhóm thành công! Các thành viên đã trở về làm một mình.', './ThongTinDeTai');
        } else {
            ToastHelper::error('Có lỗi xảy ra!', './ThongTinDeTai');
        }
    }
    
    function TieuChiDanhGia() {
        $this->view("layoutDKDT", [
            "Page" => "TieuChiDanhGia"
        ]);
    }
    
    function LichSuDangKy() {
        $iduser = $_SESSION['iduser'];
        $dt = $this->model("mDKDT");
        $lichsu = json_decode($dt->getLichSuDangKy($iduser), true);
        
        $this->view("layoutDKDT", [
            "Page" => "LichSuDangKy",
            "lichsu" => $lichsu
        ]);
    }

    function NopBaoCaoTD() {
    $iduser= $_SESSION['iduser'];
    $dtdk = $this->model("mDKDT");
    $idNhom = $dtdk->getIDNhomByIDUser($iduser);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if a file is uploaded
        if (!isset($_FILES['fileBC']) || $_FILES['fileBC']['error'] == UPLOAD_ERR_NO_FILE) {
            ToastHelper::warning('Vui lòng chọn một file để nộp!');
        } else {
            $fileBC = $_FILES['fileBC']['name'];
            $tmp_name = $_FILES['fileBC']['tmp_name'];
            $file_size = $_FILES['fileBC']['size'];
            $file_ext = strtolower(pathinfo($fileBC, PATHINFO_EXTENSION));
            $allowed_exts = ['doc', 'docx', 'pdf'];

            if (!in_array($file_ext, $allowed_exts)) {
                ToastHelper::error('Chỉ chấp nhận file Word (.doc, .docx) hoặc PDF!');
                return;
            }

            if ($file_size > 10 * 1024 * 1024) {
                ToastHelper::error('File quá lớn! Kích thước tối đa là 10MB.');
                return;
            }

            $target_dir = "public/uploads/";

            // Làm sạch tên file
            $base_name = pathinfo($fileBC, PATHINFO_FILENAME);
            // Thay khoảng trắng và ký tự đặc biệt bằng '_', loại bỏ ký tự không an toàn
            $base_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $base_name);
            // Loại bỏ nhiều dấu '_' liên tiếp
            $base_name = preg_replace('/_+/', '_', $base_name);
            // Xóa dấu '_' ở đầu hoặc cuối
            $base_name = trim($base_name, '_');

            $new_name = $base_name;
            $i = 1;
            $target_file = $target_dir . $new_name . '.' . $file_ext;

            // Xử lý trùng tên
            while (file_exists($target_file)) {
                $new_name = $base_name . "_" . $i++;
                $target_file = $target_dir . $new_name . '.' . $file_ext;
            }

            if (move_uploaded_file($tmp_name, $target_file)) {
                $dt = $this->model("mDKDT");
                $file_name = basename($target_file);
                $dt->nopBaoCao($idNhom, $file_name);
                ToastHelper::success('Nộp báo cáo thành công!', './NopBaoCaoTD');
            } else {
                ToastHelper::error('Lỗi khi tải file lên.');
            }
        }
    }

    $baocao = json_decode($dtdk->getTTBaoCao($idNhom), true);
    $this->view("layoutDKDT", [
        "Page" => "NopBaoCaoTD",
        "baocao" => $baocao
    ]);
    }

    function NopKhoaLuan() {
    $iduser= $_SESSION['iduser'];
    $dtdk = $this->model("mDKDT");
    $idNhom = $dtdk->getIDNhomByIDUser($iduser);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if a file is uploaded
        if (!isset($_FILES['fileBC']) || $_FILES['fileBC']['error'] == UPLOAD_ERR_NO_FILE) {
            ToastHelper::warning('Vui lòng chọn một file để nộp!');
        } else {
            $fileBC = $_FILES['fileBC']['name'];
            $tmp_name = $_FILES['fileBC']['tmp_name'];
            $file_size = $_FILES['fileBC']['size'];
            $file_ext = strtolower(pathinfo($fileBC, PATHINFO_EXTENSION));
            $allowed_exts = ['doc', 'docx', 'pdf'];

            if (!in_array($file_ext, $allowed_exts)) {
                ToastHelper::error('Chỉ chấp nhận file Word (.doc, .docx) hoặc PDF!');
                return;
            }

            if ($file_size > 10 * 1024 * 1024) {
                ToastHelper::error('File quá lớn! Kích thước tối đa là 10MB.');
                return;
            }

            $target_dir = "public/khoaluan/";

            // Làm sạch tên file
            $base_name = pathinfo($fileBC, PATHINFO_FILENAME);
            // Thay khoảng trắng và ký tự đặc biệt bằng '_', loại bỏ ký tự không an toàn
            $base_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $base_name);
            // Loại bỏ nhiều dấu '_' liên tiếp
            $base_name = preg_replace('/_+/', '_', $base_name);
            // Xóa dấu '_' ở đầu hoặc cuối
            $base_name = trim($base_name, '_');

            $new_name = $base_name;
            $i = 1;
            $target_file = $target_dir . $new_name . '.' . $file_ext;

            // Xử lý trùng tên
            while (file_exists($target_file)) {
                $new_name = $base_name . "_" . $i++;
                $target_file = $target_dir . $new_name . '.' . $file_ext;
            }

            if (move_uploaded_file($tmp_name, $target_file)) {
                $dt = $this->model("mDKDT");
                $file_name = basename($target_file);
                $dt->NopKhoaLuan($idNhom, $file_name);
                ToastHelper::success('Nộp báo cáo thành công!', './NopKhoaLuan');
            } else {
                ToastHelper::error('Lỗi khi tải file lên.');
            }
        }
    }

    $khoaluan = json_decode($dtdk->getTTKhoaLuan($idNhom), true);
    $this->view("layoutDKDT", [
        "Page" => "NopKhoaLuan",
        "khoaluan" => $khoaluan
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

    function getKetQuaCham() {
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
        
        $ketqua = $dtdk->getKetQuaCham($idNhom);
        echo json_encode(["success" => true, "ketqua" => $ketqua]);
    }

}
?>