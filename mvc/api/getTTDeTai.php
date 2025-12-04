<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("../private/AES.php");
Auth::checkApiKey();
$r = new giaimaAES();
	$p = new csdl();
    $iduser = $_REQUEST['iduser'];
	$p->getTTDeTai($iduser);
?>