<?php
/**
 * API Nhập Điểm
 */
require_once("../Bridge.php");
include("../class/classketnoi.php");
$p = new csdl();

header("Content-Type: application/json; charset=UTF-8");

$muc1 = $_REQUEST["Muc1"] ?? '';
$muc2 = $_REQUEST["Muc2"] ?? '';
$muc31 = $_REQUEST["Muc3_1"] ?? '';
$muc32 = $_REQUEST["Muc3_2"] ?? '';
$muc33 = $_REQUEST["Muc3_3"] ?? '';
$muc41 = $_REQUEST["Muc4_1"] ?? '';
$muc42 = $_REQUEST["Muc4_2"] ?? '';
$muc51 = $_REQUEST["Muc5_1"] ?? '';
$muc52 = $_REQUEST["Muc5_2"] ?? '';
$muc61 = $_REQUEST["Muc6_1"] ?? '';
$muc62 = $_REQUEST["Muc6_2"] ?? '';
$muc63 = $_REQUEST["Muc6_3"] ?? '';
$iddetai = $_REQUEST["iddetai"] ?? '';

if (!empty($iddetai)) {
    $link = $p->connect;
    mysqli_set_charset($link, "utf8mb4");
    
    // Escape input
    $iddetai = mysqli_real_escape_string($link, $iddetai);
    $muc1 = mysqli_real_escape_string($link, $muc1);
    $muc2 = mysqli_real_escape_string($link, $muc2);
    $muc31 = mysqli_real_escape_string($link, $muc31);
    $muc32 = mysqli_real_escape_string($link, $muc32);
    $muc33 = mysqli_real_escape_string($link, $muc33);
    $muc41 = mysqli_real_escape_string($link, $muc41);
    $muc42 = mysqli_real_escape_string($link, $muc42);
    $muc51 = mysqli_real_escape_string($link, $muc51);
    $muc52 = mysqli_real_escape_string($link, $muc52);
    $muc61 = mysqli_real_escape_string($link, $muc61);
    $muc62 = mysqli_real_escape_string($link, $muc62);
    $muc63 = mysqli_real_escape_string($link, $muc63);
    
    $check = mysqli_query($link, "SELECT * FROM diem WHERE IDDangKy = '$iddetai'");
    $exists = $check && mysqli_num_rows($check) > 0;
    
    if ($exists) {
        $sql = "UPDATE `diem` SET `Muc1` = '$muc1', `Muc2` = '$muc2', `Muc3.1` = '$muc31', `Muc3.2` = '$muc32', `Muc3.3` = '$muc33', `Muc4.1` = '$muc41', `Muc4.2` = '$muc42', `Muc5.1` = '$muc51', `Muc5.2` = '$muc52', `Muc6.1` = '$muc61', `Muc6.2` = '$muc62', `Muc6.3` = '$muc63' WHERE `IDDangKy` = '$iddetai'";
    } else {
        $sql = "INSERT INTO `diem` (`IDDangKy`, `Muc1`, `Muc2`, `Muc3.1`, `Muc3.2`, `Muc3.3`, `Muc4.1`, `Muc4.2`, `Muc5.1`, `Muc5.2`, `Muc6.1`, `Muc6.2`, `Muc6.3`) VALUES ('$iddetai', '$muc1', '$muc2', '$muc31', '$muc32', '$muc33', '$muc41', '$muc42', '$muc51', '$muc52', '$muc61', '$muc62', '$muc63')";
    }
    
    $result = mysqli_query($link, $sql);
    $affected = mysqli_affected_rows($link);
    $error = mysqli_error($link);
    
    echo json_encode([
        'success' => $result ? 1 : 0,
        'affected_rows' => $affected,
        'action' => $exists ? 'UPDATE' : 'INSERT',
        'error' => $error
    ]);
} else {
    echo json_encode([
        'success' => 0,
        'error' => 'Thiếu iddetai'
    ]);
}
?>
