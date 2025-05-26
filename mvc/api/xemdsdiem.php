<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("../private/AES.php");
$r = new giaimaAES();
	$p = new csdl();
	$iddetai = $_REQUEST['iddetai'];
	$iddetai = $r->giaima($iddetai);
	$p->xuatdanhsachdiem($iddetai);
?>