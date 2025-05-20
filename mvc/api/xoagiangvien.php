<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");

$p = new csdl();
$id = $_REQUEST['id'];
if($p->themxoasua("Delete from giangvien where iduser = '$id'"))
{
    echo "<script>alert('Xóa giảng viên thành công'); window.location='/CongNgheMoi/Admin/QuanLyGV';</script>";
} else {
    echo "<script>alert('Xóa thất bại'); window.location='/CongNgheMoi/Admin/QuanLyGV';</script>";
}
?>