<?php
class SinhVien extends Controller {
    
    function SayHi(){
        $this ->view("layoutSV");
    }

    function DeTai(){
        $dt= $this->model("mDKDT");
        $detai = json_decode($dt->getTTDeTai(), true);
        //nếu như đã đăng ký đề tài thì không cho đăng ký nữa mà chuyển sang trang DeTaiDK
        if (isset($_SESSION['iduser'])) {
            $iduser = $_SESSION['iduser'];
            $nhom = $dt->getIDNhomByIDUser($iduser);
            if ($nhom) {
                header("Location: ./DeTaiDK");
                exit();
            }
        }
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

    // Kiểm tra các thành viên còn lại đã thuộc nhóm nào chưa
    foreach ($members as $member) {
        if ($nhomModel->ktSV($member['mssv'])) {
            echo "<script>alert('Sinh viên {$member['hoten']} đã thuộc một nhóm khác.');</script>";
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
    window.location.href = './DeTaiDK'; // hoặc sử dụng controller tự chuyển hướng
    </script>";
    }

    }

    function DeTaiDK() {
    //giả định iduser
    $_SESSION['iduser'] = 8;
    $dtdk = $this->model("mDKDT");
    
    $iduser = $_SESSION['iduser'];
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
    $_SESSION['iduser'] = 8;
    $dtdk = $this->model("mDKDT");
    $iduser = $_SESSION['iduser'];
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
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
                if (!is_dir($target_dir)) {
                    echo "<script>alert('Không thể tạo thư mục lưu trữ.');</script>";
                    return;
                }
            }

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
    $_SESSION['iduser'] = 8;
    $dtdk = $this->model("mDKDT");
    $iduser = $_SESSION['iduser'];
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
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
                if (!is_dir($target_dir)) {
                    echo "<script>alert('Không thể tạo thư mục lưu trữ.');</script>";
                    return;
                }
            }

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