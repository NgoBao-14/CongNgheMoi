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

$username = $r->giaima($username);
$pass = $r->giaima($pass);
$tenmay= $r->giaima($tenmay);
$tencpu= $r->giaima($tencpu);
$os= $r->giaima($os);

echo $username;
echo "<br>";
echo $pass;
echo "<br>";
echo $tenmay;
echo "<br>";
echo $tencpu;
echo "<br>";
echo $os;

?>