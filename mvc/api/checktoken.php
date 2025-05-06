<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
	$token = $_REQUEST['token'];
	$p = new csdl();
	$p->loginToken($token);
?>