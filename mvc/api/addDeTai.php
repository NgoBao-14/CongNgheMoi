<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("../private/AES.php");
// Auth::checkApiKey();
$r = new giaimaAES();
	$p = new csdl();
	$TenDeTai = $_REQUEST['TenDeTai'];
	$MoTa = $_REQUEST['MoTa'];
	$IDGV = $_REQUEST['IDGV'];
	$IDNganh = $_REQUEST['IDNganh'];
	$YeuCau = $_REQUEST['YeuCau'];
	$SoLuongTV = $_REQUEST['SoLuongTV'];
	$p->addDeTai($TenDeTai, $MoTa, $IDGV, $IDNganh, $YeuCau, $SoLuongTV);
?>