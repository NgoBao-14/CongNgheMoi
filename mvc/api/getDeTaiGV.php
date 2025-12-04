<?php
// API lấy danh sách đề tài của giảng viên (chỉ những đề tài có sinh viên đăng ký)
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("../private/AES.php");

$r = new giaimaAES();
$p = new csdl();
$id = $_REQUEST['id'];
$id = $r->giaima($id);

$link = $p->connect;
$sql = "SELECT DISTINCT dt.IDDeTai, dt.TenDeTai, dt.MoTa, dt.TrangThaiDeTai, dt.TrangThaiDK,
        (SELECT COUNT(*) FROM dangkydetai WHERE IDDeTai = dt.IDDeTai) AS SoLuongSVDangKy
        FROM detai dt 
        JOIN giangvien gv ON dt.IDGV = gv.MaGV
        WHERE gv.MaGV = '$id' 
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

header("content-Type:application/json; charset=UTF-8");
echo json_encode($dulieu);
?>
