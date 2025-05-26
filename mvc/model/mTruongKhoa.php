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
        $str = "SELECT d.*, CONCAT(u.hodem, ' ', u.ten) AS ten_giang_vien,
       (0.15 *di.Muc1 + 0.15 *di.Muc2 + 0.1 *di.`Muc3.1` + 0.05 *di.`Muc3.2` +
        0.05 *di.`Muc3.3` + 0.05 *di.`Muc4.1` + 0.15 *di.`Muc4.2` +
        0.05 *di.`Muc5.1` + 0.05 *di.`Muc5.2` + 0.05 *di.`Muc6.1` +
        0.05 *di.`Muc6.2` + 0.05 *di.`Muc6.3`) AS tongdiem
        FROM detai d
        JOIN giangvien gv ON d.IDGV = gv.MaGV
        JOIN diem di ON d.IDDeTai = di.IDDeTai
        JOIN user u ON gv.iduser = u.iduser
        WHERE d.TrangThaiDeTai = 'Đã duyệt'
        AND d.TrangThaiDK = 'Đã đăng ký'
        AND d.IDNganh = (
            SELECT IDNganh FROM user WHERE iduser = $iduser
        );
        "; 
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
    }

    public function AddDiemDeTai($idDetai) {
        $str = "INSERT INTO `diem` (`IDDeTai`, `Muc1`, `Muc2`, `Muc3.1`, `Muc3.2`, `Muc3.3`, `Muc4.1`, `Muc4.2`, `Muc5.1`, `Muc5.2`, `Muc6.1`, `Muc6.2`, `Muc6.3`)
        VALUES ($idDetai, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');"; 
        $result = $this->connect->query($str);
        return $result; 
    }
}
    
?>