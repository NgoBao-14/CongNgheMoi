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
}
?>