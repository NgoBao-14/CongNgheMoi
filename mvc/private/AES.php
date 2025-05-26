<?php
	class giaimaAES
	{
		private $key = "12345678901234567890123456789012";
		private $iv = "1234567890123456";
		
		public function giaima($str)
		{
			$giaima = base64_decode($str);
			return openssl_decrypt ($giaima,'AES-256-CBC',$this->key,OPENSSL_RAW_DATA,$this->iv);
		}
		public function mahoa($str)
		{
			$mahoa = openssl_encrypt($str,'AES-256-CBC',$this->key,OPENSSL_RAW_DATA,$this->iv);
			return base64_encode($mahoa);
		}
	}


?>