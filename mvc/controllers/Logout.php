<?php
require_once "./mvc/private/JWTAuth.php";

class Logout extends Controller{
    function SayHi(){
        // Xóa tất cả session data
        $_SESSION = array();
        
        // Xóa session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Hủy session
        session_destroy();
        
        // Xóa JWT cookie
        JWTAuth::clearToken();
        
        // Chuyển về trang đăng xuất
        $this->view("layoutDX",[]);
    }
}
?>