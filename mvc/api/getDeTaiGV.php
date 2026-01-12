<?php
/**
 * API lấy danh sách đề tài của giảng viên (chỉ những đề tài có sinh viên đăng ký)
 */
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("../private/AES.php");

header("Content-Type: application/json; charset=UTF-8");

$r = new giaimaAES();
$p = new csdl();

// Lấy và giải mã tham số
$id = $_REQUEST['id'] ?? '';
if (empty($id)) {
    echo json_encode([]);
    exit();
}

$id = $r->giaima($id);
$link = $p->connect;
mysqli_set_charset($link, "utf8mb4");
$id_safe = mysqli_real_escape_string($link, $id);

$sql = "SELECT DISTINCT dt.IDDeTai, dt.TenDeTai, dt.MoTa, dt.TrangThaiDeTai, dt.TrangThaiDK,
        (SELECT COUNT(*) FROM dangkydetai WHERE IDDeTai = dt.IDDeTai) AS SoLuongSVDangKy
        FROM detai dt 
        JOIN giangvien gv ON dt.IDGV = gv.MaGV
        WHERE gv.MaGV = '$id_safe' 
        AND EXISTS (SELECT 1 FROM dangkydetai dk WHERE dk.IDDeTai = dt.IDDeTai)
        ORDER BY dt.IDDeTai";

$ketqua = mysqli_query($link, $sql);
$dulieu = array();

if ($ketqua && mysqli_num_rows($ketqua) > 0) {
    while ($row = mysqli_fetch_array($ketqua)) {
        $dulieu[] = array(
            'IDDeTai' => $row["IDDeTai"],
            'TenDeTai' => $row["TenDeTai"],
            'MoTa' => $row["MoTa"],
            'TrangThaiDeTai' => $row["TrangThaiDeTai"],
            'TrangThaiDK' => $row["TrangThaiDK"],
            'SoLuongSVDangKy' => $row["SoLuongSVDangKy"]
        );
    }
}

echo json_encode($dulieu, JSON_UNESCAPED_UNICODE);
?>
