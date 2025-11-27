<?php
class mDKDT extends DB {
    
    public function getTTDeTai($iduser) {
        $param = "?key=".$_ENV['API_KEY']."&iduser=$iduser";
            $url = $this->api."getTTDeTai.php".$param;

                $results=$this->docjson($url);
                return json_encode($results);
    }

    // Đăng ký đề tài - lưu vào bảng dangkydetai
    public function dangKyDeTai($MaSV, $IDDeTai) {
        $sql = "INSERT INTO dangkydetai (MaSV, IDDeTai, NgayDangKy) VALUES ('$MaSV', '$IDDeTai', NOW())";
        return mysqli_query($this->connect, $sql);
    }
    
    // Tạo nhóm mới
    public function addNhom($IDDeTai) {
        $sql = "INSERT INTO nhom (IDDeTai) VALUES ('$IDDeTai')";
        if (mysqli_query($this->connect, $sql)) {
            return mysqli_insert_id($this->connect);
        } else {
            return false;
        }
    }

    // Thêm thành viên vào nhóm
    public function addSVNhom($MaSV, $idNhom) {
        $sql = "INSERT INTO thanhviennhom (IDNhom, MaSV, NgayThamGia) VALUES ('$idNhom', '$MaSV', NOW())";
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

    // Kiểm tra sinh viên đã đăng ký đề tài chưa
    public function ktSV($MaSV) {
        $sql = "SELECT IDDangKy FROM dangkydetai WHERE MaSV = '$MaSV'";
        $result = mysqli_query($this->connect, $sql);
        return mysqli_num_rows($result) > 0;
    }
    
    // Kiểm tra sinh viên đã có nhóm chưa
    public function ktSVCoNhom($MaSV) {
        $sql = "SELECT IDNhom FROM thanhviennhom WHERE MaSV = '$MaSV'";
        $result = mysqli_query($this->connect, $sql);
        return mysqli_num_rows($result) > 0;
    }

    public function capNhatTTDeTai($IDDeTai, $idNhom) {
        $sql = "UPDATE detai SET TrangThaiDK = 'Đã đăng ký', IDNhom ='$idNhom', NgayDK = NOW() WHERE IDDeTai = '$IDDeTai'";
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

    // Lấy thông tin đề tài đã đăng ký của sinh viên
    public function getTTDeTaiByIDU($iduser) {
        $str = "SELECT 
                dt.*,
                CONCAT(uGV.HoDem, ' ', uGV.Ten) AS GiangVienHuongDan,
                uGV.SDT, 
                uGV.Email,
                cn.ChuyenNganh,
                sv.MaSV,
                dk.NgayDangKy
                FROM sinhvien sv
                JOIN dangkydetai dk ON sv.MaSV = dk.MaSV
                JOIN detai dt ON dk.IDDeTai = dt.IDDeTai
                JOIN giangvien gv ON dt.IDGV = gv.MaGV
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
    // Lấy IDNhom của sinh viên
    public function getIDNhomByIDUser($iduser) {
        $sql = "SELECT tv.IDNhom 
                FROM thanhviennhom tv
                JOIN sinhvien sv ON tv.MaSV = sv.MaSV
                WHERE sv.iduser = $iduser";
        $result = mysqli_query($this->connect, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['IDNhom'];
        }
        return null;
    }
    
    // Lấy IDNhom theo MaSV
    public function getIDNhomByMaSV($MaSV) {
        $sql = "SELECT IDNhom FROM thanhviennhom WHERE MaSV = '$MaSV'";
        $result = mysqli_query($this->connect, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['IDNhom'];
        }
        return null;
    }


    // Lấy thông tin thành viên nhóm
    public function getTTTVNhom($idNhom) {
        if (!$idNhom) {
            return json_encode(array());
        }
        
        $str = "SELECT 
                sv.MaSV,
                CONCAT(u.HoDem, ' ', u.Ten) AS HoTenSinhVien,
                sv.Lop,
                u.Email,
                tv.NgayThamGia,
                tv.IDNhom
                FROM thanhviennhom tv
                JOIN sinhvien sv ON tv.MaSV = sv.MaSV
                JOIN user u ON sv.iduser = u.iduser
                WHERE tv.IDNhom = $idNhom
                ORDER BY tv.NgayThamGia ASC";
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

    // Lấy thông báo từ giảng viên hướng dẫn
    public function getThongBaoGVHD($idNhom) {
        // Giả sử có bảng thongbao_gvhd hoặc tương tự
        // Nếu không có bảng, sẽ trả về mảng rỗng
        $sql = "SELECT tb.*, 
                CONCAT(u.HoDem, ' ', u.Ten) AS TenGiangVien
                FROM thongbao_gvhd tb
                JOIN nhom n ON tb.IDNhom = n.IDNhom
                JOIN detai dt ON n.IDDeTai = dt.IDDeTai
                JOIN giangvien gv ON dt.IDGV = gv.MaGV
                JOIN user u ON gv.iduser = u.iduser
                WHERE tb.IDNhom = $idNhom
                ORDER BY tb.NgayTao DESC";
        
        $result = mysqli_query($this->connect, $sql);
        
        // Nếu bảng không tồn tại, trả về mảng rỗng thay vì lỗi
        if (!$result) {
            // Giả sử trả về dữ liệu mẫu nếu bảng chưa tồn tại
            return array();
        }
        
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return $mang;
    }

    // Lấy kết quả chấm từ giảng viên hướng dẫn
    public function getKetQuaCham($idNhom) {
        // Giả sử có bảng ketqua_cham hoặc tương tự
        $sql = "SELECT kq.*,
                CONCAT(u.HoDem, ' ', u.Ten) AS TenGiangVien
                FROM ketqua_cham kq
                JOIN nhom n ON kq.IDNhom = n.IDNhom
                JOIN detai dt ON n.IDDeTai = dt.IDDeTai
                JOIN giangvien gv ON dt.IDGV = gv.MaGV
                JOIN user u ON gv.iduser = u.iduser
                WHERE kq.IDNhom = $idNhom
                ORDER BY kq.NgayCham DESC
                LIMIT 1";
        
        $result = mysqli_query($this->connect, $sql);
        
        // Nếu bảng không tồn tại, trả về null
        if (!$result) {
            return null;
        }
        
        $ketqua = mysqli_fetch_assoc($result);
        
        if ($ketqua) {
            // Lấy chi tiết điểm nếu có
            $sqlChiTiet = "SELECT * FROM chitiet_diem 
                          WHERE IDKetQuaCham = " . $ketqua['IDKetQuaCham'];
            $resultChiTiet = mysqli_query($this->connect, $sqlChiTiet);
            
            if ($resultChiTiet) {
                $chiTiet = array();
                while ($row = mysqli_fetch_assoc($resultChiTiet)) {
                    $chiTiet[] = $row;
                }
                $ketqua['ChiTietDiem'] = $chiTiet;
            } else {
                $ketqua['ChiTietDiem'] = array();
            }
        }
        
        return $ketqua;
    }
    
    // Lấy danh sách sinh viên đăng ký cùng đề tài
    public function getDanhSachSVCungDeTai($MaSV) {
        // Lấy IDDeTai của sinh viên hiện tại
        $sqlDeTai = "SELECT IDDeTai FROM dangkydetai WHERE MaSV = '$MaSV'";
        $resultDeTai = mysqli_query($this->connect, $sqlDeTai);
        $rowDeTai = mysqli_fetch_assoc($resultDeTai);
        
        if (!$rowDeTai) {
            return json_encode(array());
        }
        
        $idDeTai = $rowDeTai['IDDeTai'];
        
        // Lấy danh sách sinh viên đăng ký cùng đề tài
        $sql = "SELECT 
                sv.MaSV,
                CONCAT(u.HoDem, ' ', u.Ten) AS HoTen,
                sv.Lop,
                CONCAT(uGV.HoDem, ' ', uGV.Ten) AS GiangVienHuongDan,
                tv.IDNhom,
                (SELECT COUNT(*) FROM thanhviennhom WHERE IDNhom = tv.IDNhom) AS SoLuongThanhVien
                FROM dangkydetai dk
                JOIN sinhvien sv ON dk.MaSV = sv.MaSV
                JOIN user u ON sv.iduser = u.iduser
                JOIN detai dt ON dk.IDDeTai = dt.IDDeTai
                JOIN giangvien gv ON dt.IDGV = gv.MaGV
                JOIN user uGV ON gv.iduser = uGV.iduser
                LEFT JOIN thanhviennhom tv ON sv.MaSV = tv.MaSV
                WHERE dk.IDDeTai = '$idDeTai'
                ORDER BY tv.IDNhom, sv.MaSV";
        
        $result = mysqli_query($this->connect, $sql);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }
    
    // Hủy đăng ký đề tài
    public function huyDangKyDeTai($masv) {
        // Xóa khỏi bảng đăng ký đề tài
        $sql = "DELETE FROM dangkydetai WHERE MaSV = '$masv'";
        return mysqli_query($this->connect, $sql);
    }
    
    // Đăng ký nhóm - tạo nhóm mới và thêm 2 sinh viên vào
    public function dangKyNhom($masv1, $masv2, $idDeTai) {
        // Tạo nhóm mới
        $idNhomMoi = $this->addNhom($idDeTai);
        if (!$idNhomMoi) {
            return false;
        }
        
        // Thêm cả 2 sinh viên vào nhóm
        $this->addSVNhom($masv1, $idNhomMoi);
        $this->addSVNhom($masv2, $idNhomMoi);
        
        return $idNhomMoi;
    }
    
    // Hủy nhóm - xóa tất cả thành viên khỏi nhóm và xóa nhóm
    public function huyNhom($idNhom) {
        // Xóa tất cả thành viên khỏi nhóm
        $sql1 = "DELETE FROM thanhviennhom WHERE IDNhom = $idNhom";
        mysqli_query($this->connect, $sql1);
        
        // Xóa nhóm
        $sql2 = "DELETE FROM nhom WHERE IDNhom = $idNhom";
        return mysqli_query($this->connect, $sql2);
    }
    
    // Lấy lịch sử đăng ký
    public function getLichSuDangKy($iduser) {
        $sql = "SELECT 
                dt.TenDeTai,
                CONCAT(u.HoDem, ' ', u.Ten) AS GiangVienHuongDan,
                dk.NgayDangKy,
                dt.IDDeTai
                FROM sinhvien sv
                JOIN dangkydetai dk ON sv.MaSV = dk.MaSV
                JOIN detai dt ON dk.IDDeTai = dt.IDDeTai
                JOIN giangvien gv ON dt.IDGV = gv.MaGV
                JOIN user u ON gv.iduser = u.iduser
                WHERE sv.iduser = $iduser
                ORDER BY dk.NgayDangKy DESC";
        
        $result = mysqli_query($this->connect, $sql);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }
}   
?>