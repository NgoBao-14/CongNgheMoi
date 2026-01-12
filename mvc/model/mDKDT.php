<?php
class mDKDT extends DB {
    
    public function getTTDeTai($iduser) {
        // Đảm bảo charset UTF-8
        mysqli_set_charset($this->connect, "utf8mb4");
        
        // Lấy danh sách đề tài và đếm số lượng sinh viên đã đăng ký
        $sql = "SELECT 
                dt.*,
                CONCAT(u.HoDem, ' ', u.Ten) AS ten_giang_vien,
                (SELECT COUNT(*) FROM dangkydetai WHERE IDDeTai = dt.IDDeTai) AS SoLuongDaDangKy
                FROM detai dt
                JOIN giangvien gv ON dt.IDGV = gv.MaGV
                JOIN user u ON gv.iduser = u.iduser
                WHERE dt.TrangThaiDeTai = 'Đã duyệt'
                ORDER BY dt.IDDeTai";
        
        $result = mysqli_query($this->connect, $sql);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            // Đảm bảo encoding UTF-8 cho tất cả các trường text
            foreach ($row as $key => $value) {
                if (is_string($value)) {
                    $row[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
            $mang[] = $row;
        }
        return json_encode($mang, JSON_UNESCAPED_UNICODE);
    }

    // Đăng ký đề tài - lưu vào bảng dangkydetai và tạo bản ghi điểm
    public function dangKyDeTai($MaSV, $IDDeTai) {
        $sql = "INSERT INTO dangkydetai (MaSV, IDDeTai, NgayDangKy) VALUES ('$MaSV', '$IDDeTai', NOW())";
        $result = mysqli_query($this->connect, $sql);
        
        if ($result) {
            // Lấy IDDangKy mới nhất vừa insert
            $idDangKy = mysqli_insert_id($this->connect);
            
            // Insert vào bảng điểm với các cột có value = 0
            $sqlDiem = "INSERT INTO diem (IDDangKy, Muc1, Muc2, `Muc3.1`, `Muc3.2`, `Muc3.3`, `Muc4.1`, `Muc4.2`, `Muc5.1`, `Muc5.2`, `Muc6.1`, `Muc6.2`, `Muc6.3`) 
                        VALUES ('$idDangKy', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
            mysqli_query($this->connect, $sqlDiem);
        }
        
        return $result;
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
        mysqli_set_charset($this->connect, "utf8mb4");
        
        $str = "SELECT * FROM sinhvien sv
        JOIN user u on sv.iduser=u.iduser
        JOIN chuyennganh cn on u.IDNganh= cn.IDNganh
        WHERE sv.MaSV= $masv";
        $result = mysqli_query($this->connect, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang, JSON_UNESCAPED_UNICODE);
    }

    // Lấy thông tin đề tài đã đăng ký của sinh viên
    public function getTTDeTaiByIDU($iduser) {
        // Đảm bảo charset UTF-8
        mysqli_set_charset($this->connect, "utf8mb4");
        
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
        return json_encode($mang, JSON_UNESCAPED_UNICODE);
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
        
        mysqli_set_charset($this->connect, "utf8mb4");
        
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
        return json_encode($mang, JSON_UNESCAPED_UNICODE);
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

    // Lấy kết quả chấm từ giảng viên hướng dẫn theo MaSV
    public function getKetQuaChamByMaSV($masv) {
        // Lấy IDDangKy của sinh viên
        $sqlDK = "SELECT IDDangKy FROM dangkydetai WHERE MaSV = '$masv'";
        $resultDK = mysqli_query($this->connect, $sqlDK);
        
        if (!$resultDK || mysqli_num_rows($resultDK) == 0) {
            return null;
        }
        
        $rowDK = mysqli_fetch_assoc($resultDK);
        $idDangKy = $rowDK['IDDangKy'];
        
        // Lấy điểm từ bảng diem
        $sql = "SELECT d.*, 
                CONCAT(uGV.HoDem, ' ', uGV.Ten) AS TenGiangVien,
                dt.TenDeTai
                FROM diem d
                JOIN dangkydetai dk ON d.IDDangKy = dk.IDDangKy
                JOIN detai dt ON dk.IDDeTai = dt.IDDeTai
                JOIN giangvien gv ON dt.IDGV = gv.MaGV
                JOIN user uGV ON gv.iduser = uGV.iduser
                WHERE d.IDDangKy = '$idDangKy'";
        
        $result = mysqli_query($this->connect, $sql);
        
        if (!$result || mysqli_num_rows($result) == 0) {
            return null;
        }
        
        $ketqua = mysqli_fetch_assoc($result);
        
        if ($ketqua) {
            // Tính điểm tổng kết theo tỷ trọng
            $chiTietDiem = array(
                array('TenTieuChi' => 'Hình thành và phát triển ý tưởng nghiên cứu', 'Diem' => $ketqua['Muc1'], 'TyTrong' => 15),
                array('TenTieuChi' => 'Cấu trúc báo cáo KLTN hợp lý khi thuyết trình', 'Diem' => $ketqua['Muc2'], 'TyTrong' => 15),
                array('TenTieuChi' => 'Sự tương tác giữa SV và CBHD', 'Diem' => $ketqua['Muc3.1'], 'TyTrong' => 10),
                array('TenTieuChi' => 'Sự tương tác giữa các thành viên nhóm', 'Diem' => $ketqua['Muc3.2'], 'TyTrong' => 10),
                array('TenTieuChi' => 'Hoàn thành nội dung được phân công', 'Diem' => $ketqua['Muc3.3'], 'TyTrong' => 5),
                array('TenTieuChi' => 'Thu nhận kết quả và xử lý số liệu', 'Diem' => $ketqua['Muc4.1'], 'TyTrong' => 15),
                array('TenTieuChi' => 'Thảo luận nghiên cứu', 'Diem' => $ketqua['Muc4.2'], 'TyTrong' => 15),
                array('TenTieuChi' => 'Tóm tắt kết quả nghiên cứu', 'Diem' => $ketqua['Muc5.1'], 'TyTrong' => 5),
                array('TenTieuChi' => 'Kiến nghị', 'Diem' => $ketqua['Muc5.2'], 'TyTrong' => 5),
                array('TenTieuChi' => 'Tài liệu tham khảo', 'Diem' => $ketqua['Muc6.1'], 'TyTrong' => 5),
                array('TenTieuChi' => 'Chu tích hình ảnh, bảng biểu', 'Diem' => $ketqua['Muc6.2'], 'TyTrong' => 5),
                array('TenTieuChi' => 'Chính tả, định dạng, thuật ngữ', 'Diem' => $ketqua['Muc6.3'], 'TyTrong' => 5)
            );
            
            // Tính điểm tổng kết
            $tongDiem = 0;
            $coDiem = false;
            foreach ($chiTietDiem as $ct) {
                if ($ct['Diem'] !== null && $ct['Diem'] !== '') {
                    $tongDiem += floatval($ct['Diem']) * $ct['TyTrong'] / 100;
                    $coDiem = true;
                }
            }
            
            $ketqua['TongDiem'] = $coDiem ? round($tongDiem, 2) : null;
            $ketqua['ChiTietDiem'] = $chiTietDiem;
        }
        
        return $ketqua;
    }
    
    // Lấy kết quả chấm từ giảng viên hướng dẫn (giữ lại cho tương thích)
    public function getKetQuaCham($idNhom) {
        return null; // Deprecated - sử dụng getKetQuaChamByMaSV thay thế
    }
    
    // Lấy danh sách sinh viên đăng ký cùng đề tài
    public function getDanhSachSVCungDeTai($MaSV) {
        mysqli_set_charset($this->connect, "utf8mb4");
        
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
        return json_encode($mang, JSON_UNESCAPED_UNICODE);
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
        mysqli_set_charset($this->connect, "utf8mb4");
        
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
        return json_encode($mang, JSON_UNESCAPED_UNICODE);
    }
}   
?>