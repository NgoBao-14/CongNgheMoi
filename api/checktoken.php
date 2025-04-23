<?php
	$token = $_REQUEST['token'];
	include("../class/classketnoi.php");
	$p = new csdl();
	$p->loginToken($token);
?>