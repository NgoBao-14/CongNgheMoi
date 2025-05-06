<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");

	$p = new csdl();
	$id = $_REQUEST['id'];
	$p->xuatdanhsachdetai($id);
?>