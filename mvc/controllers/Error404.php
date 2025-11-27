<?php
class Error404 extends Controller {
    public function SayHi() {
        http_response_code(404);
        require_once "./mvc/views/pages/404.php";
    }
}
?>
