<?php
class DB{
    //đừng thay đổi gì hết
    public $connect;
    protected $servername = "localhost";
    protected $username = "bao";
    protected $password = "123456";
    protected $dbname = "thongtinmay";

    public $api = "http://localhost:8080/CongNgheMoi/mvc/api/";

    function __construct(){
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password);
        mysqli_select_db($this->connect, $this->dbname);
        mysqli_query($this->connect, "SET NAMES 'utf8'");
    }
    public function docjson($url)
    {
        $client=curl_init($url);
		curl_setopt($client,CURLOPT_RETURNTRANSFER,1);
		$response=curl_exec($client);
		$results=json_decode($response);
		return $results; 

    }
}

?>