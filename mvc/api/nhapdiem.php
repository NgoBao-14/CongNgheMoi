<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
$p = new csdl();
include("../private/AES.php");
$r = new giaimaAES();

$diem = $_REQUEST["diem"];
$iduser = $_REQUEST["iduser"];
$MaSV = $_REQUEST["MaSV"];
$Lop = $_REQUEST["Lop"];

// $diem = $r->giaima($diem);
// $iduser = $r->giaima($iduser);
// $MaSV = $r->giaima($MaSV);
// $Lop = $r->giaima($Lop);

if($diem != '' and $iduser != '' and $MaSV != '' and $Lop != '')
{
$p->themxoasua("UPDATE sinhvien SET Diem='$diem' WHERE iduser = '$iduser' AND MaSV = '$MaSV' AND Lop = '$Lop'");
}

?>