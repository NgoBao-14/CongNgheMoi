<?php
    class mAdmin extends DB{
       public function GetSinhVien()
       {
        $str = "SELECT * FROM sinhvien";
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
       }
       public function GetGiangVien()
       {
        $str = "SELECT * FROM giangvien";
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
       }
       public function GetDeTai()
       {
        $str = "SELECT * FROM detai";
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
       }
       public function GetNhom()
       {
        $str = "SELECT * FROM nhom";
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
       }
       public function GetKhoa()
       {
        $str = "SELECT * FROM chuyennganh";
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
       }
       public function GetDeTaiKhoa()
       {
        $str = "SELECT * FROM detai dt join chuyennganh cn on dt.IDNganh = cn.IDNganh"; 
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
       }
       public function GetDeTaiTheoKhoa($id)
       {
        $str = "SELECT * FROM detai dt join chuyennganh cn on dt.ChuyenNganh = cn.IDNganh WHERE cn.IDNganh = $id"; 
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
       }
       public function GetThongTinSV()
       {
        $str = "SELECT * FROM user u JOIN sinhvien sv ON u.iduser=sv.iduser join chuyennganh cn on u.IDNganh=cn.IDNganh"; 
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
       }
       public function GetThongTinSVTheoKhoa($id)
       {
        $str = "SELECT * FROM user u JOIN sinhvien sv ON u.iduser=sv.iduser join chuyennganh cn on u.IDNganh=cn.IDNganh WHERE cn.IDNganh = $id"; 
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
       }
       public function GetThongTinSVTheoID($id)
       {
        $str = "SELECT * FROM user u JOIN sinhvien sv ON u.iduser=sv.iduser join chuyennganh cn on u.IDNganh=cn.IDNganh WHERE u.iduser = $id"; 
        $result = $this->connect->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
       }
       public function UpdateSV($iduser,$lop,$idnhom,$hodem,$ten,$idnganh,$sdt,$email)
       {

        $str1 = "Update sinhvien set Lop='$lop', IDNhom='$idnhom' where iduser = $iduser";
        $str2 = "Update user set HoDem='$hodem', Ten='$ten', IDNganh='$idnganh', SDT='$sdt', Email='$email' where iduser = $iduser";
        $tblPTTT1 = mysqli_query($this->connect, $str1);
        $tblPTTT2 = mysqli_query($this->connect, $str2);
        if ($tblPTTT1 && $tblPTTT2) {
            return true;
        } else {
            return false;
        }
       }
       public function ThemSinhVien($masv,$hodem,$ten,$lop,$idnganh,$sdt,$email)
       {
        $str1 = "INSERT INTO user (HoDem, Ten, IDNganh, SDT, Email) VALUES ('$hodem', '$ten', '$idnganh', '$sdt', '$email')";
        $str2 = "INSERT INTO sinhvien (iduser, MaSV, Lop, IDNhom) VALUES (LAST_INSERT_ID() ,'$masv', '$lop', NULL)";
        $str3 = "INSERT INTO taikhoan (iduser,username,PQ) VALUES (LAST_INSERT_ID(),'$masv', '2')";
        $tblPTTT1 = mysqli_query($this->connect, $str1);
        $tblPTTT2 = mysqli_query($this->connect, $str2);
        $tblPTTT3 = mysqli_query($this->connect, $str3);
        if ($tblPTTT1 && $tblPTTT2 && $tblPTTT3) {
            return true;
        } else {
            return false;
        }
       }
  
    }
?>