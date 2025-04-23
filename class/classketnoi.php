<?php
require("../private/JWT.php");
	class csdl 
	{
		private function connect()
		{
			$conn = mysqli_connect("localhost","bao","123456","thongtinmay");
			if(!$conn)
			{
				echo "Khong the ket noi";
				exit();
			}
			else{
				return $conn;
			}
		}
		public function xuatdanhsachdetai($id)
		{
			$link = $this->connect();
			$sql = "select * from giangvien gv JOIN detai dt on gv.iduser= dt.IDGV JOIN user u on gv.iduser = u.iduser join nhom n on n.IDDeTai=dt.IDDeTai where gv.iduser = '$id'";
			$ketqua = mysqli_query($link,$sql);
			$i = mysqli_num_rows($ketqua);
			if($i>0)
			{
				$dulieu = array();
				while($row = mysqli_fetch_array($ketqua))
				{
					$IDDeTai = $row["IDDeTai"];
					$TenDeTai = $row["TenDeTai"];
					$TrangThaiDeTai = $row["TrangThaiDeTai"];
					$idnhom = $row["IDNhom"];
					$dulieu[] = array('IDDeTai'=>$IDDeTai,
									  'TenDeTai'=>$TenDeTai,
									  'TrangThaiDeTai'=>$TrangThaiDeTai,
									  'idnhom'=>$idnhom
									);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}
		public function xuatdanhsachsinhvien($iddetai,$idnhom)
		{
			$link = $this->connect();
			$sql = "SELECT * FROM sinhvien sv join user u on sv.iduser = u.iduser
					join nhom n on sv.IDNhom = n.IDNhom
					join detai dt on n.IDDeTai=dt.IDDeTai
					where dt.IDDeTai = '$iddetai' AND n.IDNhom = '$idnhom'";
			$ketqua = mysqli_query($link,$sql);
			$i = mysqli_num_rows($ketqua);
			if($i>0)
			{
				$dulieu = array();
				while($row = mysqli_fetch_array($ketqua))
				{
					$iduser = $row["iduser"];
					$MaSV = $row["MaSV"];
					$HoDem = $row["HoDem"];
					$Ten = $row["Ten"];
					$Lop = $row["Lop"];
					$Diem = $row["Diem"];
				
					$dulieu[] = array(
						'iduser'=>$iduser,
						'MaSV'=>$MaSV,
						'HoDem'=>$HoDem,
						'Ten'=>$Ten,
						'Lop'=>$Lop,
						'Diem'=>$Diem,

						);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}

		public function themxoasua($sql){
			$link=$this->connect();
			if(mysqli_query($link,$sql)){
				return 1;	
			}
			else{
				return 0;
			}
		}
		public function mylogin($username,$pass,$tenmay,$ram1,$ram2,$rom1,$rom2,$os,$cpu)
		{
			
//			$pass = md5($pass);
			$sql = "select tk.iduser
			from taikhoan tk join thongtin tt 
			on tk.iduser=tt.iduser 
			where 
				username='$username' and 
				password='$pass' and 
				tenmay='$tenmay' and 
				ram1='$ram1' and 
				ram2='$ram2' and 
				rom1='$rom1' and 
				rom2='$rom2' and 
				tencpu='$cpu' and
				os='$os' 
			limit 1";
			$link = $this->connect();
			$ketqua = mysqli_query($link,$sql);
			$i = mysqli_num_rows($ketqua);
			$time = time();
			if($i==1)
			{
				$dulieu = array();
				$rows = mysqli_fetch_array($ketqua);
				$iduser = $rows["iduser"];
				$sql2 = "select * from taikhoan tk join thongtin tt on tk.iduser=tt.iduser 
								join giangvien gv on tk.iduser = gv.iduser
								join user u on gv.iduser=u.iduser
								where tk.iduser = '$iduser' limit 1";
				$kq = mysqli_query($link,$sql2);
				
				$i2 = mysqli_num_rows($kq);
				if($i2==1)
				{
					$row = mysqli_fetch_array($kq);
					$username = $row["username"];
					$pass = $row["password"];
					$PQ = $row["PQ"];
					$tenmay = $row["tenmay"];
					$tencpu = $row["tencpu"];
					$os = $row["os"];
					$name = $row["Ten"];
				
					$token = array();
					$token['iduser'] = $iduser;
					$token['username'] = $username;
					$token['PQ'] = $PQ;
					$token['tenmay'] = $tenmay;
					$token['tencpu'] = $tencpu;
					$token['os'] = $os;
					$token['name'] = $name;
					$jsonwebtoken = JWT::encode($token,"NgoBao");
					
					$dulieu[] =array(
							"iduser"=>$iduser,
							"name"=>$name,
							"PQ"=>$PQ,
							"token"=>$jsonwebtoken,
							"time"=> $time + 3600,
							"Response" => 102
						);
					header("content-Type:application/json; charset=UTF-8");
					echo json_encode($dulieu);
					// exit();
				}
			}
		}
		public function checklogin($username,$pass,$tenmay,$ram1,$ram2,$rom1,$rom2,$os,$cpu)
		{
			$pass = md5($pass);
			$link = $this->connect();
			$sql = "select iduser from taikhoan where username='$username' and password='$pass' limit 1";
			$ketqua = mysqli_query($link,$sql);
			$i = mysqli_num_rows($ketqua);
			if($i==1)
			{
				$dulieu1 = array();
				$row = mysqli_fetch_array($ketqua);
				$iduser = $row["iduser"];
				$sql2 = "select * from taikhoan tk join thongtin tt on tk.iduser=tt.iduser where tk.iduser = '$iduser' limit 1 ";
				$kq = mysqli_query($link,$sql2);
				$i2 = mysqli_num_rows($kq);
				if($i2==1)
				{
					
					$this->mylogin($username,$pass,$tenmay,$ram1,$ram2,$rom1,$rom2,$os,$cpu);
					return;
				}
				else{
					$sql3 = "select * from taikhoan tk join user u on tk.iduser=u.iduser where tk.iduser = '$iduser' limit 1";
					$kq1 = mysqli_query($link,$sql3);
					$i3 = mysqli_num_rows($kq1);
					if($i3==1)
					{
						$row1 = mysqli_fetch_array($kq1);
						$name = $row1["Ten"];
						$PQ = $row1["PQ"];
						$dulieu1[]=array(
							"iduser"=> $iduser,
							"name"=>$name,
							"PQ"=>$PQ,
							"Response" => 101
						);
						header("content-Type:application/json; charset=UTF-8");
						echo json_encode($dulieu1);
						exit();
					}
				}
				
			}
		}
		
		
		public function loginToken($token)
		{
			$json = JWT::decode($token,"NgoBao",true);
			$dulieu= json_decode(json_encode($json),true);

			$iduser = $dulieu['iduser'];
			$username = $dulieu['username'];
			$PQ = $dulieu['PQ'];
			$tenmay = $dulieu['tenmay'];
			$tencpu = $dulieu['tencpu'];
			$os = $dulieu['os'];
			$name = $dulieu['name'];
			
			$sql = "select tk.iduser, PQ from taikhoan tk join thongtin tt on tk.iduser=tt.iduser where tk.iduser = '$iduser' and username = '$username' and PQ = '$PQ' and tenmay = '$tenmay' and tencpu = '$tencpu' and os = '$os' limit 1";
			$link = $this->connect();
			$ketqua = mysqli_query($link,$sql);
			$i = mysqli_num_rows($ketqua);
			if($i==1)
			{
				$row = mysqli_fetch_array($ketqua);
				$iduser = $row["iduser"];
				$PQ = $row["PQ"];
				$dulieu = array();
				$dulieu[] = array(
					'iduser' => $iduser,
					'PQ' => $PQ,
					'name'=> $name
				);
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
			}
			

			

			
			
		}
			
	}
	

?>