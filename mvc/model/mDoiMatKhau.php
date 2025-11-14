<?php
class mDoiMatKhau extends DB {
    
    // Kiểm tra mật khẩu cũ
    function checkOldPassword($iduser, $oldPassword) {
        $sql = "SELECT * FROM taikhoan WHERE iduser = '$iduser' AND password = '$oldPassword'";
        $result = mysqli_query($this->connect, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            return json_encode(true);
        }
        return json_encode(false);
    }
    
    // Đổi mật khẩu
    function changePassword($iduser, $newPassword) {
        $sql = "UPDATE taikhoan SET password = '$newPassword' WHERE iduser = '$iduser'";
        $result = mysqli_query($this->connect, $sql);
        
        if ($result) {
            return json_encode(true);
        }
        return json_encode(false);
    }
}
?>
