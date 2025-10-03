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
            $url = $this->api."getDeTaiKhoa.php";
            $results=$this->docjson($url);
            return json_encode($results);
       }
   
       public function GetDeTaiTheoKhoa($id)
       {
        $param = "?id=$id";
        $url = $this->api."getDeTaiTheoKhoa.php".$param;

            $results=$this->docjson($url);
            return json_encode($results);
       }
       public function GetThongTinSV()
       {
        $param = "";
        $url = $this->api."getThongTinSV.php".$param;

            $results=$this->docjson($url);
            return json_encode($results);
       }
       public function GetThongTinSVTheoKhoa($id)
       {
        $param = "?id=$id";
        $url = $this->api."getThongTinSVTheoKhoa.php".$param;

            $results=$this->docjson($url);
            return json_encode($results);
       }
       public function GetThongTinSVTheoID($id)
       {
        $param = "?id=$id";
        $url = $this->api."getThongTinSinhVienTheoID.php".$param;

            $results=$this->docjson($url);
            return json_encode($results);
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
       public function GetThongTinGV()
       {
        $param = "";
        $url = $this->api."getThongTinGV.php".$param;

            $results=$this->docjson($url);
            return json_encode($results);
       }
       public function GetThongTinGVTheoKhoa($id)
       {
        $param = "?id=$id";
        $url = $this->api."getThongTinGVTheoKhoa.php".$param;

            $results=$this->docjson($url);
            return json_encode($results);
       }
       public function GetThongTinGVTheoID($id)
        {
            $param = "?id=$id";
            $url = $this->api."getThongTinGVTheoID.php".$param;

                $results=$this->docjson($url);
                return json_encode($results);
        }
        public function UpdateGV($iduser,$hodem,$ten,$idnganh,$sdt,$email,$chucvu)
        {
        $str1 = "Update user set HoDem='$hodem', Ten='$ten', IDNganh='$idnganh', SDT='$sdt', Email='$email' where iduser = $iduser";
        $str2 = "Update taikhoan set PQ ='$chucvu' where iduser = '$iduser'";
        $tblPTTT1 = mysqli_query($this->connect, $str1);
        $tblPTTT2 = mysqli_query($this->connect, $str2);
        if ($tblPTTT1 && $tblPTTT2) {
            return true;
        } else {
            return false;
        }
        }
        public function ThemGiangVien($msgv,$hodem,$ten,$idnganh,$sdt,$email,$chucvu)
        {
            $str1 = "INSERT INTO user (HoDem, Ten, IDNganh, SDT, Email) VALUES ('$hodem', '$ten', '$idnganh', '$sdt', '$email')";
            $str2 = "INSERT INTO giangvien (iduser, MaGV) VALUES (LAST_INSERT_ID() ,'$msgv')";
            $str3 = "INSERT INTO taikhoan (iduser,username,PQ) VALUES (LAST_INSERT_ID(),'$msgv', '$chucvu')";
            $tblPTTT1 = mysqli_query($this->connect, $str1);
            $tblPTTT2 = mysqli_query($this->connect, $str2);
            $tblPTTT3 = mysqli_query($this->connect, $str3);
            if ($tblPTTT1 && $tblPTTT2 && $tblPTTT3) {
                return true;
            } else {
                return false;
            }
        }
        public function GetDSDetai()
        {
           $param = "";
            $url = $this->api."getDSDetai.php".$param;

                $results=$this->docjson($url);
                return json_encode($results);
        }
        public function GetDeTaiTheoID($id)
        {
            $param = "?id=$id";
            $url = $this->api."getDeTaiTheoID.php".$param;

                $results=$this->docjson($url);
                return json_encode($results);
        }
        public function UpdateDeTai($id,$tendetai,$mota,$idnganh,$trangthaidetai,$ngaydangky,$trangthaidk,$idnhom,$yeucau,$soluong)
        {
            $str1 = "Update detai set TenDeTai='$tendetai', MoTa='$mota', IDNganh='$idnganh',TrangThaiDeTai='$trangthaidetai',NgayDK='$ngaydangky',TrangThaiDK='$trangthaidk',IDNhom='$idnhom',YeuCau='$yeucau',SoLuongTV='$soluong'  where IDDeTai = $id";
            $tblPTTT1 = mysqli_query($this->connect, $str1);
            if ($tblPTTT1) {
                return true;
            } else {
                return false;
            }
        }
        public function GetChucVu()
        {
            $str = "SELECT * FROM phanquyen order by PhanQuyen";
            $result = $this->connect->query($str);
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return json_encode($data);
        }
  
    }
?>