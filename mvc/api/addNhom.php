<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("../private/AES.php");
Auth::checkApiKey();
$r = new giaimaAES();
	$p = new csdl();
	$IDDeTai = $_REQUEST['IDDeTai'];
	$p->addNhom($IDDeTai);
?>