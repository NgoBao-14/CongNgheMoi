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
       
       public function GetSVDaDangKy()
       {
        $str = "SELECT DISTINCT MaSV FROM dangkydetai";
        $result = $this->connect->query($str);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
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
            $param = "?key=".$_ENV['API_KEY']."";
            $url = $this->api."getDeTaiKhoa.php".$param;
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
        $tblPTTT1 = mysqli_query($this->connect, $str1);
        
        if ($tblPTTT1) {
            $iduser = mysqli_insert_id($this->connect);
            $str2 = "INSERT INTO sinhvien (iduser, MaSV, Lop, IDNhom) VALUES ($iduser, '$masv', '$lop', NULL)";
            $str3 = "INSERT INTO taikhoan (iduser, username, PQ) VALUES ($iduser, '$masv', '2')";
            $tblPTTT2 = mysqli_query($this->connect, $str2);
            $tblPTTT3 = mysqli_query($this->connect, $str3);
            
            if ($tblPTTT2 && $tblPTTT3) {
                return true;
            }
        }
        return false;
       }
       public function GetThongTinGV()
       {
        // Query trực tiếp để lấy cả giảng viên (PQ=1) và trưởng khoa (PQ=4)
        $str = "SELECT gv.MaGV, u.iduser, u.HoDem, u.Ten, u.SDT, u.Email, u.IDNganh, 
                       cn.ChuyenNganh as TenChuyenNganh, tk.PQ,
                       CASE 
                           WHEN tk.PQ = 4 THEN 'Trưởng khoa'
                           ELSE 'Giảng viên'
                       END as VaiTro
                FROM giangvien gv
                JOIN user u ON gv.iduser = u.iduser
                JOIN taikhoan tk ON u.iduser = tk.iduser
                LEFT JOIN chuyennganh cn ON u.IDNganh = cn.IDNganh
                WHERE tk.PQ IN (1, 4)
                ORDER BY tk.PQ DESC, u.HoDem, u.Ten";
        $result = mysqli_query($this->connect, $str);
        $data = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return json_encode($data);
       }
       public function GetThongTinGVTheoKhoa($id)
       {
        $id = intval($id);
        $str = "SELECT gv.MaGV, u.iduser, u.HoDem, u.Ten, u.SDT, u.Email, u.IDNganh, 
                       cn.ChuyenNganh as TenChuyenNganh, tk.PQ,
                       CASE 
                           WHEN tk.PQ = 4 THEN 'Trưởng khoa'
                           ELSE 'Giảng viên'
                       END as VaiTro
                FROM giangvien gv
                JOIN user u ON gv.iduser = u.iduser
                JOIN taikhoan tk ON u.iduser = tk.iduser
                LEFT JOIN chuyennganh cn ON u.IDNganh = cn.IDNganh
                WHERE tk.PQ IN (1, 4) AND u.IDNganh = $id
                ORDER BY tk.PQ DESC, u.HoDem, u.Ten";
        $result = mysqli_query($this->connect, $str);
        $data = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return json_encode($data);
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
            $tblPTTT1 = mysqli_query($this->connect, $str1);
            
            if ($tblPTTT1) {
                $iduser = mysqli_insert_id($this->connect);
                $str2 = "INSERT INTO giangvien (iduser, MaGV) VALUES ($iduser, '$msgv')";
                $str3 = "INSERT INTO taikhoan (iduser, username, PQ) VALUES ($iduser, '$msgv', '$chucvu')";
                $tblPTTT2 = mysqli_query($this->connect, $str2);
                $tblPTTT3 = mysqli_query($this->connect, $str3);
                
                if ($tblPTTT2 && $tblPTTT3) {
                    return true;
                }
            }
            return false;
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
            $param = "?key=".$_ENV['API_KEY']."&id=$id";
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
            // Tạo bảng chucvu nếu chưa tồn tại
            $createTable = "CREATE TABLE IF NOT EXISTS chucvu (
                idCV INT AUTO_INCREMENT PRIMARY KEY,
                ChucVu VARCHAR(100) NOT NULL
            )";
            $this->connect->query($createTable);
            
            // Kiểm tra và thêm dữ liệu mẫu nếu bảng rỗng
            $checkData = "SELECT COUNT(*) as total FROM chucvu";
            $result = $this->connect->query($checkData);
            $row = $result->fetch_assoc();
            
            if ($row['total'] == 0) {
                $insertData = "INSERT INTO chucvu (ChucVu) VALUES 
                    ('Giảng viên'),
                    ('Giảng viên chính'),
                    ('Phó Giáo sư'),
                    ('Giáo sư'),
                    ('Trưởng khoa'),
                    ('Phó trưởng khoa')";
                $this->connect->query($insertData);
            }
            
            $str = "SELECT * FROM chucvu ORDER BY ChucVu";
            $result = $this->connect->query($str);
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return json_encode($data);
        }
  
    }
?>