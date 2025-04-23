<?php
include("../class/classketnoi.php");
$p = new csdl();
include("../private/Bridge.php");
$r = new giaimaAES();

$username = $_REQUEST["username"];
$pass = $_REQUEST["password"];
$tenmay=$_REQUEST["tenmay"];
$tencpu=$_REQUEST["tencpu"];
$os=$_REQUEST["os"];

$ram1 = $_REQUEST['ram1'];
$ram1 = $r->giaima($ram1);
$ram2 = $_REQUEST['ram2'];
$ram2 = $r->giaima($ram2);
$rom1 = $_REQUEST['rom1'];
$rom1 = $r->giaima($rom1);
$rom2 = $_REQUEST['rom2'];
$rom2 = $r->giaima($rom2);

$username = $r->giaima($username);
$pass = $r->giaima($pass);
$tenmay= $r->giaima($tenmay);
$tencpu= $r->giaima($tencpu);
$os= $r->giaima($os);


$p->checklogin($username,$pass,$tenmay,$ram1,$ram2,$rom1,$rom2,$os,$tencpu);
?>