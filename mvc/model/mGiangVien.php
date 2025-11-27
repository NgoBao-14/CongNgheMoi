<?php
class mGiangVien extends DB {

    // Lấy danh sách tất cả sinh viên đã đăng ký đề tài của giảng viên
    public function getDanhSachSinhVienDangKy($iduser) {
        $str = "SELECT 
                sv.MaSV,
                CONCAT(u.HoDem, ' ', u.Ten) AS HoTenSinhVien,
                sv.Lop,
                tv.IDNhom,
                dt.TenDeTai,
                dt.IDDeTai,
                dk.NgayDangKy
                FROM dangkydetai dk
                JOIN sinhvien sv ON dk.MaSV = sv.MaSV
                JOIN user u ON sv.iduser = u.iduser
                JOIN detai dt ON dk.IDDeTai = dt.IDDeTai
                JOIN giangvien gv ON dt.IDGV = gv.MaGV
                LEFT JOIN thanhviennhom tv ON sv.MaSV = tv.MaSV
                WHERE gv.iduser = $iduser
                ORDER BY dt.TenDeTai, tv.IDNhom, sv.MaSV";
        $result = mysqli_query($this->connect, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    //danh sách đề tài theo mã giảng viên
    public function getDSDeTai($iduser) {
        $str = "SELECT dt.*
        FROM detai dt
        JOIN giangvien gv ON dt.IDGV = gv.MaGV
        JOIN user u ON gv.IDUser = u.IDUser
        WHERE u.IDUser = $iduser and dt.TrangThaiDeTai = 'Đã duyệt'
        ";
        $detai = mysqli_query($this->connect, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($detai)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    //lấy báo cáo tiến độ của các nhóm
    public function getTTBaoCao($iduser) {
        $str = "SELECT 
            detai.IDNhom,
            detai.TenDeTai,
            baocaotiendo.DuongDan,
            baocaotiendo.NgayNop
        FROM 
            baocaotiendo
        JOIN detai ON baocaotiendo.IDNhom = detai.IDNhom
        JOIN giangvien ON detai.IDGV = giangvien.MaGV
        JOIN user ON giangvien.IDUser = user.IDUser
        WHERE 
            user.IDUser = $iduser
        ORDER BY 
            detai.IDNhom, baocaotiendo.NgayNop;
        ";
        $result = mysqli_query($this->connect, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    public function getTTKhoaLuan($iduser) {
        $str = "SELECT 
            detai.IDNhom,
            detai.TenDeTai,
            khoaluan.DuongDan,
            khoaluan.NgayNop
        FROM 
            khoaluan
        JOIN detai ON khoaluan.IDNhom = detai.IDNhom
        JOIN giangvien ON detai.IDGV = giangvien.MaGV
        JOIN user ON giangvien.IDUser = user.IDUser
        WHERE 
            user.IDUser = $iduser
        ORDER BY 
            detai.IDNhom, khoaluan.NgayNop;
        ";
        $result = mysqli_query($this->connect, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    public function addDeTai($TenDeTai, $Mota, $IDGV, $IDNganh, $YeuCau, $soLuongTV) {
        $str = "INSERT INTO detai (TenDeTai, MoTa, IDGV, IDNganh, TrangThaiDeTai, TrangThaiDK, YeuCau, SoLuongTV)
        VALUES ('$TenDeTai', '$Mota', $IDGV, $IDNganh, 'Chưa duyệt', 'Chưa được đăng ký', '$YeuCau', $soLuongTV)";
        $result = mysqli_query($this->connect, $str);
        return $result;
    }
    
    // Lấy kết quả đánh giá của sinh viên theo đề tài
    public function getKetQuaDanhGia($MaSV) {
        // Lấy IDDeTai của sinh viên
        $sqlDeTai = "SELECT IDDeTai FROM dangkydetai WHERE MaSV = '$MaSV'";
        $resultDeTai = mysqli_query($this->connect, $sqlDeTai);
        $rowDeTai = mysqli_fetch_assoc($resultDeTai);
        
        if (!$rowDeTai) {
            return null;
        }
        
        $idDeTai = $rowDeTai['IDDeTai'];
        
        // Lấy điểm từ bảng diem
        $sql = "SELECT * FROM diem WHERE IDDeTai = '$idDeTai'";
        $result = mysqli_query($this->connect, $sql);
        
        if (!$result) {
            // Nếu bảng không tồn tại hoặc lỗi, trả về cấu trúc rỗng
            return array(
                'IDDeTai' => $idDeTai,
                'Muc1' => null,
                'Muc2' => null,
                'Muc3_1' => null,
                'Muc3_2' => null,
                'Muc3_3' => null,
                'Muc4_1' => null,
                'Muc4_2' => null,
                'Muc5_1' => null,
                'Muc5_2' => null,
                'Muc6_1' => null,
                'Muc6_2' => null,
                'Muc6_3' => null
            );
        }
        
        $diem = mysqli_fetch_assoc($result);
        
        if (!$diem) {
            // Nếu chưa có điểm, trả về cấu trúc rỗng
            return array(
                'IDDeTai' => $idDeTai,
                'Muc1' => null,
                'Muc2' => null,
                'Muc3_1' => null,
                'Muc3_2' => null,
                'Muc3_3' => null,
                'Muc4_1' => null,
                'Muc4_2' => null,
                'Muc5_1' => null,
                'Muc5_2' => null,
                'Muc6_1' => null,
                'Muc6_2' => null,
                'Muc6_3' => null
            );
        }
        
        return $diem;
    }
}
?>