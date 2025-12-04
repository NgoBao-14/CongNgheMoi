<?php
class mTruongKhoa extends DB {
    public function GetDT($iduser){
        $str = "SELECT d.*, CONCAT(u.hodem, ' ', u.ten) AS ten_giang_vien
        FROM detai d
        JOIN giangvien gv ON d.IDGV = gv.MaGV
        JOIN user u ON gv.iduser = u.iduser
        WHERE d.TrangThaiDeTai='Chưa duyệt' AND d.IDNganh = (
            SELECT IDNganh FROM user WHERE iduser = $iduser
        )"; 
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
    }

    public function CapNhatDeTai($idDetai){
        $str = "UPDATE `detai` SET TrangThaiDeTai = 'Đã duyệt' WHERE IDDeTai = $idDetai"; 
        $result = $this->connect->query($str);
        return $result;
    }

    public function GetDanhSachDeTai($iduser) {
        $str = "SELECT d.*, CONCAT(u.hodem, ' ', u.ten) AS ten_giang_vien
        FROM detai d
        JOIN giangvien gv ON d.IDGV = gv.MaGV
        JOIN user u ON gv.iduser = u.iduser
        WHERE d.TrangThaiDeTai='Đã duyệt' AND d.IDNganh = (
            SELECT IDNganh FROM user WHERE iduser = $iduser
        )"; 
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
    }

    public function GetDanhSachDeTaiDaDangKy($iduser) {
        $str = "SELECT d.*, dk.IDDangKy, CONCAT(u.hodem, ' ', u.ten) AS ten_giang_vien,
                CONCAT(usv.HoDem, ' ', usv.Ten) AS ten_sinh_vien, sv.MaSV,
                COALESCE((0.15 * di.Muc1 + 0.15 * di.Muc2 + 0.1 * di.`Muc3.1` + 0.1 * di.`Muc3.2` +
                0.05 * di.`Muc3.3` + 0.15 * di.`Muc4.1` + 0.15 * di.`Muc4.2` +
                0.05 * di.`Muc5.1` + 0.05 * di.`Muc5.2` + 0.05 * di.`Muc6.1` +
                0.05 * di.`Muc6.2` + 0.05 * di.`Muc6.3`), 0) AS tongdiem
        FROM detai d
        JOIN giangvien gv ON d.IDGV = gv.MaGV
        JOIN user u ON gv.iduser = u.iduser
        JOIN dangkydetai dk ON d.IDDeTai = dk.IDDeTai
        JOIN sinhvien sv ON dk.MaSV = sv.MaSV
        JOIN user usv ON sv.iduser = usv.iduser
        LEFT JOIN diem di ON dk.IDDangKy = di.IDDangKy
        WHERE d.TrangThaiDeTai = 'Đã duyệt'
        AND d.TrangThaiDK = 'Đã đăng ký'
        AND d.IDNganh = (
            SELECT IDNganh FROM user WHERE iduser = $iduser
        )
        ORDER BY d.TenDeTai, sv.MaSV"; 
        $result = $this->connect->query($str);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return json_encode($data);
    }

    public function AddDiemDeTai($idDetai) {
        // Lấy tất cả IDDangKy của đề tài này và tạo record điểm cho mỗi sinh viên
        $sqlDK = "SELECT IDDangKy FROM dangkydetai WHERE IDDeTai = $idDetai";
        $resultDK = $this->connect->query($sqlDK);
        
        if ($resultDK) {
            while ($row = $resultDK->fetch_assoc()) {
                $idDangKy = $row['IDDangKy'];
                // Kiểm tra đã có điểm chưa
                $checkSql = "SELECT * FROM diem WHERE IDDangKy = $idDangKy";
                $checkResult = $this->connect->query($checkSql);
                
                if ($checkResult && $checkResult->num_rows == 0) {
                    $str = "INSERT INTO `diem` (`IDDangKy`, `Muc1`, `Muc2`, `Muc3.1`, `Muc3.2`, `Muc3.3`, `Muc4.1`, `Muc4.2`, `Muc5.1`, `Muc5.2`, `Muc6.1`, `Muc6.2`, `Muc6.3`)
                    VALUES ($idDangKy, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')"; 
                    $this->connect->query($str);
                }
            }
        }
        return true; 
    }
}
    
?>