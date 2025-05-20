<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
	$p = new csdl();
	$iddetai = $_REQUEST['iddetai'];
	$p->xuatdanhsachdiem($iddetai);
?>