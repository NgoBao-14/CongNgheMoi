<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");

$p = new csdl();
$id = $_REQUEST['id'];
if($p->themxoasua("Delete from detai where IDDeTai = '$id'"))
{
    echo "<script>alert('Xóa đề tài thành công'); window.location='/CongNgheMoi/Admin/DSDeTai';</script>";
} else {
    echo "<script>alert('Xóa thất bại'); window.location='/CongNgheMoi/Admin/DSDeTai';</script>";
}
?>