<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");

$p = new csdl();
$id = $_REQUEST['id'];
if($p->themxoasua("Delete from sinhvien where iduser = '$id'"))
{
    echo "<script>alert('Xóa sinh viên thành công'); window.location='/CongNgheMoi/Admin/QuanLySV';</script>";
} else {
    echo "<script>alert('Xóa thất bại'); window.location='/CongNgheMoi/Admin/QuanLySV';</script>";
}
?>