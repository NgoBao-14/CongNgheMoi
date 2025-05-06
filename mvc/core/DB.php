<?php
class DB{
    //đừng thay đổi gì hết
    public $connect;
    protected $servername = "localhost";
    protected $username = "bao";
    protected $password = "123456";
    protected $dbname = "thongtinmay";

    function __construct(){
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password);
        mysqli_select_db($this->connect, $this->dbname);
        mysqli_query($this->connect, "SET NAMES 'utf8'");
    }
}

?>