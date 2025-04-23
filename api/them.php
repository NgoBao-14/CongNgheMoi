<?php
include("../class/classketnoi.php");
$p = new csdl();
include("../private/Bridge.php");
$r = new giaimaAES();
$tenmay = $_REQUEST['tenmay'];
$tenmay = $r->giaima($tenmay);
$ram1 = $_REQUEST['ram1'];
$ram1 = $r->giaima($ram1);
$ram2 = $_REQUEST['ram2'];
$ram2 = $r->giaima($ram2);
$rom1 = $_REQUEST['rom1'];
$rom1 = $r->giaima($rom1);
$rom2 = $_REQUEST['rom2'];
$rom2 = $r->giaima($rom2);
$tencpu = $_REQUEST['tencpu'];
$tencpu = $r->giaima($tencpu);
$os = $_REQUEST['os'];
$os = $r->giaima($os);
$iduser = $_REQUEST['iduser'];
$iduser = $r->giaima($iduser);


if($tenmay != '' && $ram1 != '' && $ram2 != '' && $rom1 != '' && $rom2 != '' && $tencpu != '' && $os != '' && $iduser!='')
{
$p->themxoasua("INSERT INTO thongtin(tenmay, ram1, ram2, rom1, rom2, tencpu, os, iduser)VALUES('$tenmay','$ram1','$ram2','$rom1','$rom2', '$tencpu','$os', $iduser)");
}


?>