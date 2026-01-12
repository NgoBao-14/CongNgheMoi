<?php
/**
 * API lấy danh sách sinh viên đăng ký theo đề tài
 */
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("../private/AES.php");

header("Content-Type: application/json; charset=UTF-8");

$r = new giaimaAES();
$p = new csdl();

$id = $_REQUEST['id'] ?? '';
if (empty($id)) {
    echo json_encode([]);
    exit();
}

$id = $r->giaima($id);
$link = $p->connect;
mysqli_set_charset($link, "utf8mb4");
$id_safe = mysqli_real_escape_string($link, $id);

$sql = "SELECT dk.IDDangKy, dk.MaSV, dk.NgayDangKy,
        u.HoDem, u.Ten, sv.Lop,
        tv.IDNhom,
        (SELECT COUNT(*) FROM thanhviennhom WHERE IDNhom = tv.IDNhom) AS SoThanhVienNhom
        FROM dangkydetai dk
        JOIN sinhvien sv ON dk.MaSV = sv.MaSV
        JOIN user u ON sv.iduser = u.iduser
        LEFT JOIN thanhviennhom tv ON dk.MaSV = tv.MaSV
        WHERE dk.IDDeTai = '$id_safe'
        ORDER BY tv.IDNhom, u.HoDem, u.Ten";

$ketqua = mysqli_query($link, $sql);
$dulieu = array();

if ($ketqua && mysqli_num_rows($ketqua) > 0) {
    while ($row = mysqli_fetch_array($ketqua)) {
        $idNhom = $row["IDNhom"];
        $soThanhVien = $row["SoThanhVienNhom"];
        
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

echo json_encode($dulieu, JSON_UNESCAPED_UNICODE);
?>
