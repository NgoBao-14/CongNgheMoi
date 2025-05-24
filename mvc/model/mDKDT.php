<?php
class mDKDT extends DB {
    
    public function getTTDeTai($iduser) {
        $str = "SELECT d.*, CONCAT(u.hodem, ' ', u.ten) AS ten_giang_vien
        FROM detai d
        JOIN giangvien gv ON d.IDGV = gv.MaGV
        JOIN user u ON gv.iduser = u.iduser
        WHERE d.IDNganh = (
            SELECT IDNganh FROM user WHERE iduser = $iduser
        )";
        $detai = mysqli_query($this->connect, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($detai)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    public function addNhom($IDDeTai) {
        $sql = "INSERT INTO nhom (IDDeTai) VALUES ('$IDDeTai')";
        if (mysqli_query($this->connect, $sql)) {
            return mysqli_insert_id($this->connect);
        } else {
            return false;
        }
    }

    public function addSVNhom($MaSV, $idNhom) {
        $sql = "UPDATE sinhvien SET IDNhom = '$idNhom' WHERE MaSV = '$MaSV'";
        return mysqli_query($this->connect, $sql);   
    }

    public function timSV($MaSV) {
        $sql = "SELECT sv.*, 
        CONCAT(u.HoDem, ' ', u.Ten) AS HoTen,
        u.IDNganh
        FROM sinhvien sv 
        JOIN user u on sv.iduser=u.iduser
        WHERE MaSV = $MaSV";
        $result = mysqli_query($this->connect, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function ktSV($MaSV) {
        $sql = "SELECT idNhom FROM sinhvien WHERE MaSV = '$MaSV' AND IDNhom IS NOT NULL";
        $result = mysqli_query($this->connect, $sql);
        return mysqli_num_rows($result) > 0;
    }

    public function capNhatTTDeTai($IDDeTai, $idNhom) {
        $sql = "UPDATE detai SET TrangThaiDK = 'Đã đăng ký', IDNhom ='$idNhom' WHERE IDDeTai = '$IDDeTai'";
        $result = mysqli_query($this->connect, $sql);
    }

    public function layIDNganhUser($iduser) {
        $sql = "SELECT IDNganh FROM user WHERE iduser = '$iduser'";
        $result = mysqli_query($this->connect, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['IDNganh'] ?? null;
    }

    public function TTSV($masv){
        $str = "SELECT * FROM sinhvien sv
        JOIN user u on sv.iduser=u.iduser
        JOIN chuyennganh cn on u.IDNganh= cn.IDNganh
        WHERE sv.MaSV= $masv";
        $result = mysqli_query($this->connect, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    public function getTTDeTaiByIDU($iduser) {
        $str = "SELECT 
        dt.*,
        CONCAT(uGV.HoDem, ' ', uGV.Ten) AS GiangVienHuongDan,
        uGV.SDT, uGV.Email,
        cn.ChuyenNganh,
        sv.MaSV,
        CONCAT(uSV.HoDem, ' ', uSV.Ten) AS HoTenSinhVien,
        sv.Lop,
        uSV.Email
        FROM sinhvien sv
        JOIN nhom n ON sv.IDNhom = n.IDNhom
        JOIN detai dt ON n.IDDeTai = dt.IDDeTai
        JOIN giangvien gv ON dt.IDGV = gv.MaGV
        JOIN user uSV ON sv.iduser = uSV.iduser
        JOIN user uGV ON gv.iduser = uGV.iduser
        JOIN chuyennganh cn ON dt.IDNganh = cn.IDNganh
        WHERE sv.iduser = $iduser";
            $result = mysqli_query($this->connect, $str);
            $mang = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $mang[] = $row;
            }
            return json_encode($mang);
    }
    public function getIDNhomByIDUser($iduser) {
        $str = "SELECT IDNhom FROM sinhvien WHERE iduser = $iduser";
        $result = mysqli_query($this->connect, $str);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['IDNhom'];
        }
        return null;
    }


    //lấy thông tin thành viên nhóm bởi ID nhóm
    public function getTTTVNhom($idNhom) {
        $str = "SELECT *, 
        CONCAT(u.HoDem, ' ', u.Ten) AS HoTenSinhVien
        FROM sinhvien sv JOIN nhom n on sv.IDNhom=n.IDNhom
        JOIN user u on sv.iduser=u.iduser
        WHERE n.IDNhom=$idNhom";
        $result = mysqli_query($this->connect, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    public function nopBaoCao($idNhom, $file) {
        $sql = "INSERT INTO baocaotiendo (IDNhom, DuongDan, NgayNop) 
            VALUES ($idNhom, '$file', NOW())";
        return mysqli_query($this->connect, $sql);
    }

    public function getTTBaoCao($idNhom) {
        $str = "SELECT * FROM baocaotiendo WHERE IDNhom = $idNhom";
        $result = mysqli_query($this->connect, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    public function getTTKhoaLuan($idNhom) {
        $str = "SELECT * FROM khoaluan WHERE IDNhom = $idNhom";
        $result = mysqli_query($this->connect, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    public function nopKhoaLuan($idNhom, $file) {
        $sql = "INSERT INTO khoaluan (IDNhom, DuongDan, NgayNop) 
            VALUES ($idNhom, '$file', NOW())";
        return mysqli_query($this->connect, $sql);
    }
}   
?>