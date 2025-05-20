<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
$p = new csdl();
include("../private/AES.php");
$r = new giaimaAES();

$muc1 = $_REQUEST["Muc1"];
$muc2 = $_REQUEST["Muc2"];
$muc31 = $_REQUEST["Muc3_1"];
$muc32 = $_REQUEST["Muc3_2"];
$muc33 = $_REQUEST["Muc3_3"];
$muc41 = $_REQUEST["Muc4_1"];
$muc42 = $_REQUEST["Muc4_2"];
$muc51 = $_REQUEST["Muc5_1"];
$muc52 = $_REQUEST["Muc5_2"];
$muc61 = $_REQUEST["Muc6_1"];
$muc62 = $_REQUEST["Muc6_2"];
$muc63 = $_REQUEST["Muc6_3"];
$iddetai = $_REQUEST["iddetai"];

if(isset($iddetai))
{
$p->themxoasua("UPDATE `diem` SET `Muc1` = '$muc1', `Muc2` = '$muc2', `Muc3.1` = '$muc31', `Muc3.2` = '$muc32', `Muc3.3` = '$muc33', `Muc4.1` = '$muc41', `Muc4.2` = '$muc42', `Muc5.1` = '$muc51', `Muc5.2` = '$muc52', `Muc6.1` = '$muc61', `Muc6.2` = '$muc62', `Muc6.3` = '$muc63' WHERE `diem`.`iddetai` = $iddetai;");
}

?>