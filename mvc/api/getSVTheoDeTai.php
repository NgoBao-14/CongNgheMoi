<?php
// API lấy danh sách sinh viên đăng ký theo đề tài (bao gồm thông tin nhóm)
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("../private/AES.php");

$r = new giaimaAES();
$p = new csdl();
$id = $_REQUEST['id'];
$id = $r->giaima($id);

$link = $p->connect;
$sql = "SELECT dk.IDDangKy, dk.MaSV, dk.NgayDangKy,
        u.HoDem, u.Ten, sv.Lop,
        tv.IDNhom,
        (SELECT COUNT(*) FROM thanhviennhom WHERE IDNhom = tv.IDNhom) AS SoThanhVienNhom
        FROM dangkydetai dk
        JOIN sinhvien sv ON dk.MaSV = sv.MaSV
        JOIN user u ON sv.iduser = u.iduser
        LEFT JOIN thanhviennhom tv ON dk.MaSV = tv.MaSV
        WHERE dk.IDDeTai = '$id'
        ORDER BY tv.IDNhom, u.HoDem, u.Ten";

$ketqua = mysqli_query($link, $sql);
$dulieu = array();

if ($ketqua && mysqli_num_rows($ketqua) > 0) {
    while ($row = mysqli_fetch_array($ketqua)) {
        $idNhom = $row["IDNhom"];
        $soThanhVien = $row["SoThanhVienNhom"];
        
        // Xác định tên nhóm hiển thị
        if ($idNhom == null || $soThanhVien <= 1) {
            $tenNhom = "Làm một mình";
        } else {
            $tenNhom = "Nhóm " . $idNhom;
        }
        
        $dulieu[] = array(
            'IDDangKy' => $row["IDDangKy"],
            'MaSV' => $row["MaSV"],
            'HoDem' => $row["HoDem"],
            'Ten' => $row["Ten"],
            'HoTen' => $row["HoDem"] . " " . $row["Ten"],
            'Lop' => $row["Lop"],
            'IDNhom' => $idNhom,
            'TenNhom' => $tenNhom,
            'NgayDangKy' => $row["NgayDangKy"]
        );
    }
}

header("content-Type:application/json; charset=UTF-8");
echo json_encode($dulieu);
?>
