<?php
    require_once("../Bridge.php");
include("../class/classketnoi.php");
include("../private/AES.php");
$r = new giaimaAES();
	$p = new csdl();
    $id = $_REQUEST['id'];
	$p->getThongTinGVTheoID($id);
?>