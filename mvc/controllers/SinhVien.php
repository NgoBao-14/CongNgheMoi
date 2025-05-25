<?php
class SinhVien extends Controller {
    
    function SayHi(){
        if($_SESSION["PQ"] != 2){
            echo "<script>alert('Bạn không có quyền truy cập')</script>";
            header("refresh: 0; url='/CongNgheMoi'");
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
        $dt= $this->model("mDKDT");
        $detai = json_decode($dt->getTTDeTai($iduser), true);
        
        $this->view("layoutDKDT", [
            "Page" => "DeTai",
            "dt" => $detai
        ]);

        if (isset($_POST['btnDKN'])) {
    $nhomModel = $this->model("mDKDT");

    $IDDeTai = $_POST['selectedProjectId'];
    $leaderMaSV = $_POST['leaderMssv'];
    $members = $_POST['members'];

    if ($nhomModel->ktSV($leaderMaSV)) {
        echo "<script>alert('Nhóm trưởng đã thuộc một nhóm khác.');</script>";
        return;
    }
    $idnganhUser = $nhomModel->layIDNganhUser($iduser); 
    // Kiểm tra các thành viên còn lại 
    foreach ($members as $member) {
    $mssv = $member['mssv'];
    $hoten = trim($member['hoten']);

    $sv = $nhomModel->timSV($mssv);

    if (!$sv) {
        echo "<script>alert('MSSV $mssv không tồn tại.');</script>";
        return;
    }

    if (trim($sv['HoTen']) !== $hoten) {
        echo "<script>alert('Tên không khớp với MSSV $mssv.');</script>";
        return;
    }

    if ($sv['IDNganh'] != $idnganhUser) {
        echo "<script>alert('Sinh viên $mssv không cùng ngành.');</script>";
        return;
    }

    if ($nhomModel->ktSV($mssv)) {
        echo "<script>alert('Sinh viên $mssv đã thuộc một nhóm khác.');</script>";
        return;
    }
}

    // Tạo nhóm mới
    $idNhomMoi = $nhomModel->addNhom($IDDeTai);
    if (!$idNhomMoi) {
        echo "<script>alert('Lỗi khi tạo nhóm.');</script>";
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
    echo "<script>
    alert('Đăng ký nhóm thành công!');
    window.location.href = './DeTaiDK';
    </script>";
    }

    }

    function DeTaiDK() {
    //giả định iduser
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

    function NopBaoCaoTD() {
    $iduser= $_SESSION['iduser'];
    $dtdk = $this->model("mDKDT");
    $idNhom = $dtdk->getIDNhomByIDUser($iduser);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if a file is uploaded
        if (!isset($_FILES['fileBC']) || $_FILES['fileBC']['error'] == UPLOAD_ERR_NO_FILE) {
            echo "<script>alert('Vui lòng chọn một file để nộp!');</script>";
        } else {
            $fileBC = $_FILES['fileBC']['name'];
            $tmp_name = $_FILES['fileBC']['tmp_name'];
            $file_size = $_FILES['fileBC']['size'];
            $file_ext = strtolower(pathinfo($fileBC, PATHINFO_EXTENSION));
            $allowed_exts = ['doc', 'docx', 'pdf'];

            if (!in_array($file_ext, $allowed_exts)) {
                echo "<script>alert('Chỉ chấp nhận file Word (.doc, .docx) hoặc PDF!');</script>";
                return;
            }

            if ($file_size > 10 * 1024 * 1024) {
                echo "<script>alert('File quá lớn! Kích thước tối đa là 10MB.');</script>";
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
                echo "<script>alert('Nộp báo cáo thành công!'); location.href='./NopBaoCaoTD';</script>";
            } else {
                echo "<script>alert('Lỗi khi tải file lên.');</script>";
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
            echo "<script>alert('Vui lòng chọn một file để nộp!');</script>";
        } else {
            $fileBC = $_FILES['fileBC']['name'];
            $tmp_name = $_FILES['fileBC']['tmp_name'];
            $file_size = $_FILES['fileBC']['size'];
            $file_ext = strtolower(pathinfo($fileBC, PATHINFO_EXTENSION));
            $allowed_exts = ['doc', 'docx', 'pdf'];

            if (!in_array($file_ext, $allowed_exts)) {
                echo "<script>alert('Chỉ chấp nhận file Word (.doc, .docx) hoặc PDF!');</script>";
                return;
            }

            if ($file_size > 10 * 1024 * 1024) {
                echo "<script>alert('File quá lớn! Kích thước tối đa là 10MB.');</script>";
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
                echo "<script>alert('Nộp báo cáo thành công!'); location.href='./NopKhoaLuan';</script>";
            } else {
                echo "<script>alert('Lỗi khi tải file lên.');</script>";
            }
        }
    }

    $khoaluan = json_decode($dtdk->getTTKhoaLuan($idNhom), true);
    $this->view("layoutDKDT", [
        "Page" => "NopKhoaLuan",
        "khoaluan" => $khoaluan
    ]);
    }

}
?>