<?php
class mGiangVien extends DB {

    public function getDanhSachNhom($iduser) {
        $str = "SELECT 
    dt.*,
    n.IDNhom,
    COUNT(sv.iduser) AS SoLuongSinhVien
    FROM detai dt
    JOIN nhom n ON dt.IDDeTai = n.IDDeTai
    JOIN sinhvien sv ON n.IDNhom = sv.IDNhom
    JOIN giangvien gv ON dt.IDGV = gv.MaGV
    WHERE gv.iduser = $iduser
    GROUP BY dt.IDDeTai, dt.TenDeTai, n.IDNhom;
    ";
        $detai = mysqli_query($this->connect, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($detai)) {
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
}
?>