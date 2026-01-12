<?php
/**
 * API xem danh sách điểm theo IDDangKy
 */
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("../private/AES.php");

header("Content-Type: application/json; charset=UTF-8");

$r = new giaimaAES();
$p = new csdl();

$id = $_REQUEST['id'] ?? '';
if (empty($id)) {
    echo json_encode([]);
    exit();
}

$id = $r->giaima($id);
$p->xuatdanhsachdiem($id);
?>
