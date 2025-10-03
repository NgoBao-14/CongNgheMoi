<?php
require("../private/JWT.php");
	class csdl extends DB
	{
		
		public function xuatdanhsachdetai($id)
		{
			$link = $this->connect;
			$sql = "select * from giangvien gv JOIN detai dt on gv.MaGV= dt.IDGV JOIN user u on gv.iduser = u.iduser join nhom n on n.IDDeTai=dt.IDDeTai where gv.iduser = '$id'";
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
		public function xuatdanhsachdiem($iddetai)
		{
			$link = $this->connect;
			$sql = "SELECT * FROM diem d JOIN detai dt ON d.IDDeTai=dt.IDDeTai WHERE d.IDDeTai = '$iddetai'";
			$ketqua = mysqli_query($link,$sql);
			$i = mysqli_num_rows($ketqua);
			if($i>0)
			{
				$dulieu = array();
				while($row = mysqli_fetch_array($ketqua))
				{
					$muc1 = $row["Muc1"];
					$muc2 = $row["Muc2"];
					$muc31 = $row["Muc3.1"];
					$muc32 = $row["Muc3.2"];
					$muc33 = $row["Muc3.3"];
					$muc41 = $row["Muc4.1"];
					$muc42 = $row["Muc4.2"];
					$muc51 = $row["Muc5.1"];
					$muc52 = $row["Muc5.2"];
					$muc61 = $row["Muc6.1"];
					$muc62 = $row["Muc6.2"];
					$muc63 = $row["Muc6.3"];
				
					$dulieu[] = array(
						'Muc1'=>$muc1,
						'Muc2'=>$muc2,
						'Muc3.1'=>$muc31,
						'Muc3.2'=>$muc32,
						'Muc3.3'=>$muc33,
						'Muc4.1'=>$muc41,
						'Muc4.2'=>$muc42,
						'Muc5.1'=>$muc51,
						'Muc5.2'=>$muc52,
						'Muc6.1'=>$muc61,
						'Muc6.2'=>$muc62,
						'Muc6.3'=>$muc63

						);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}

		public function themxoasua($sql){
			$link=$this->connect;
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
			$link = $this->connect;
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
			$link = $this->connect;
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
			$link = $this->connect;
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

		public function getDeTaiKhoa()
		{
			$sql = "SELECT * FROM detai dt join chuyennganh cn on dt.IDNganh = cn.IDNganh";
			$link = $this->connect;
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
					$chuyennganh = $row["ChuyenNganh"];
					$mota = $row ["MoTa"];
					$dulieu[] = array('IDDeTai'=>$IDDeTai,
									  'TenDeTai'=>$TenDeTai,
									  'TrangThaiDeTai'=>$TrangThaiDeTai,
									  'chuyennganh'=>$chuyennganh,
									  'mota'=>$mota,
									);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}

		public function GetDeTaiTheoKhoa($id)
		{
			$sql = "SELECT * FROM detai dt join chuyennganh cn on dt.IDNganh = cn.IDNganh WHERE cn.IDNganh = '$id'";
			$link = $this->connect;
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
					$chuyennganh = $row["ChuyenNganh"];
					$mota = $row ["MoTa"];
					$dulieu[] = array('IDDeTai'=>$IDDeTai,
									  'TenDeTai'=>$TenDeTai,
									  'TrangThaiDeTai'=>$TrangThaiDeTai,
									  'chuyennganh'=>$chuyennganh,
									  'mota'=>$mota,
									);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}
		
		public function getThongTinSV()
		{
			$sql = "SELECT * FROM user u JOIN sinhvien sv ON u.iduser=sv.iduser join chuyennganh cn on u.IDNganh=cn.IDNganh";
			$link = $this->connect;
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
					$ChuyenNganh = $row["ChuyenNganh"];
					$dulieu[] = array('MaSV'=>$MaSV,
									  'HoDem'=>$HoDem,
									  'Ten'=>$Ten,
									  'Lop'=>$Lop,
									  'ChuyenNganh'=>$ChuyenNganh,
									  'iduser'=>$iduser
									);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}
		public function getThongTinSVTheoKhoa($id)
		{
			$sql = "SELECT * FROM user u JOIN sinhvien sv ON u.iduser=sv.iduser join chuyennganh cn on u.IDNganh=cn.IDNganh WHERE cn.IDNganh = $id";
			$link = $this->connect;
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
					$ChuyenNganh = $row["ChuyenNganh"];
					$dulieu[] = array('MaSV'=>$MaSV,
									  'HoDem'=>$HoDem,
									  'Ten'=>$Ten,
									  'Lop'=>$Lop,
									  'ChuyenNganh'=>$ChuyenNganh,
									  'iduser'=>$iduser
									);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}
		public function getThongTinSVTheoID($id)
		{
			$sql = "SELECT * FROM user u JOIN sinhvien sv ON u.iduser=sv.iduser join chuyennganh cn on u.IDNganh=cn.IDNganh WHERE u.iduser = $id";
			$link = $this->connect;
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
					$SDT = $row["SDT"];	
					$email = $row["Email"];
					$ChuyenNganh = $row["ChuyenNganh"];
					$dulieu[] = array('MaSV'=>$MaSV,
									  'HoDem'=>$HoDem,
									  'Ten'=>$Ten,
									  'Lop'=>$Lop,
									  'ChuyenNganh'=>$ChuyenNganh,
									  'iduser'=>$iduser,
									  'SDT'=>$SDT,
									  'Email'=>$email
									);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}

		public function getThongTinGV()
		{
			$sql = "SELECT * FROM user u JOIN giangvien gv ON u.iduser=gv.iduser join chuyennganh cn on u.IDNganh=cn.IDNganh join taikhoan tk on u.iduser=tk.iduser join phanquyen pq on tk.PQ=pq.idPQ";
			$link = $this->connect;
			$ketqua = mysqli_query($link,$sql);
			$i = mysqli_num_rows($ketqua);
			if($i>0)
			{
				$dulieu = array();
				while($row = mysqli_fetch_array($ketqua))
				{
					$iduser = $row["iduser"];
					$MaGV = $row["MaGV"];
					$HoDem = $row["HoDem"];
					$Ten = $row["Ten"];
					$ChuyenNganh = $row["ChuyenNganh"];
					$PhanQuyen = $row["PhanQuyen"];
					$dulieu[] = array(
									  'MaGV'=>$MaGV,
									  'HoDem'=>$HoDem,
									  'Ten'=>$Ten,
									  'ChuyenNganh'=>$ChuyenNganh,
									  'PhanQuyen'=>$PhanQuyen,
									  'iduser'=>$iduser
									);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}
		public function getThongTinGVTheoKhoa($id)
		{
			$sql = "SELECT * FROM user u JOIN giangvien gv ON u.iduser=gv.iduser join chuyennganh cn on u.IDNganh=cn.IDNganh join taikhoan tk on u.iduser=tk.iduser join phanquyen pq on tk.PQ=pq.idPQ WHERE cn.IDNganh = $id";
			$link = $this->connect;
			$ketqua = mysqli_query($link,$sql);
			$i = mysqli_num_rows($ketqua);
			if($i>0)
			{
				$dulieu = array();
				while($row = mysqli_fetch_array($ketqua))
				{
					$iduser = $row["iduser"];
					$MaGV = $row["MaGV"];
					$HoDem = $row["HoDem"];
					$Ten = $row["Ten"];
					$ChuyenNganh = $row["ChuyenNganh"];
					$PhanQuyen = $row["PhanQuyen"];
					$dulieu[] = array(
									  'MaGV'=>$MaGV,
									  'HoDem'=>$HoDem,
									  'Ten'=>$Ten,
									  'ChuyenNganh'=>$ChuyenNganh,
									  'PhanQuyen'=>$PhanQuyen,
									  'iduser'=>$iduser
									);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}
		public function getThongTinGVTheoID($id)
		{
			$sql = "SELECT * FROM user u JOIN giangvien gv ON u.iduser=gv.iduser join chuyennganh cn on u.IDNganh=cn.IDNganh join taikhoan tk on u.iduser=tk.iduser join phanquyen pq on tk.PQ=pq.idPQ WHERE u.iduser = $id";
			$link = $this->connect;
			$ketqua = mysqli_query($link,$sql);
			$i = mysqli_num_rows($ketqua);
			if($i>0)
			{
				$dulieu = array();
				while($row = mysqli_fetch_array($ketqua))
				{
					$iduser = $row["iduser"];
					$MaGV = $row["MaGV"];
					$HoDem = $row["HoDem"];
					$Ten = $row["Ten"];
					$SDT = $row["SDT"];	
					$email = $row["Email"];
					$ChuyenNganh = $row["ChuyenNganh"];
					$PhanQuyen = $row["PhanQuyen"];
					$dulieu[] = array(
									  'MaGV'=>$MaGV,
									  'HoDem'=>$HoDem,
									  'Ten'=>$Ten,
									  'ChuyenNganh'=>$ChuyenNganh,
									  'PhanQuyen'=>$PhanQuyen,
									  'iduser'=>$iduser,
									  'SDT'=>$SDT,
									  'Email'=>$email
									);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}

		public function getDSDetai()
		{
			$sql = "SELECT * FROM detai dt join chuyennganh cn on dt.IDNganh = cn.IDNganh join giangvien gv on dt.IDGV = gv.MaGV join user u on gv.iduser = u.iduser"; 
			$link = $this->connect;
			$ketqua = mysqli_query($link,$sql);
			$i = mysqli_num_rows($ketqua);
			if($i>0)
			{
				$dulieu = array();
				while($row = mysqli_fetch_array($ketqua))
				{
					$TenDeTai = $row["TenDeTai"];
					$MoTa = $row["MoTa"];
					$Ten = $row["Ten"];
					$ChuyenNganh = $row["ChuyenNganh"];
					$TrangThaiDeTai = $row["TrangThaiDeTai"];
					$NgayDK = $row["NgayDK"];
					$TrangThaiDK = $row["TrangThaiDK"];
					$IDNhom = $row["IDNhom"];
					$IDDeTai = $row["IDDeTai"];
					$dulieu[] = array(	
									  'TenDeTai'=>$TenDeTai,
									  'MoTa'=>$MoTa,
									  'Ten'=>$Ten,
									  'ChuyenNganh'=>$ChuyenNganh,
									  'TrangThaiDeTai'=>$TrangThaiDeTai,
									  'NgayDK'=>$NgayDK,
									  'TrangThaiDK'=>$TrangThaiDK,
									  'IDNhom'=>$IDNhom,
									  'IDDeTai'=>$IDDeTai

									);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}
		public function getDeTaiTheoID($id)
		{
			$sql="SELECT *,dt.IDNganh FROM detai dt join chuyennganh cn on dt.IDNganh = cn.IDNganh join giangvien gv on dt.IDGV = gv.MaGV join user u on gv.iduser = u.iduser WHERE dt.IDDeTai = $id";
			$link = $this->connect;
			$ketqua = mysqli_query($link,$sql);
			$i = mysqli_num_rows($ketqua);
			if($i>0)
			{
				$dulieu = array();
				while($row = mysqli_fetch_array($ketqua))
				{
					$TenDeTai = $row["TenDeTai"];
					$MoTa = $row["MoTa"];
					$Ten = $row["Ten"];
					$ChuyenNganh = $row["ChuyenNganh"];
					$TrangThaiDeTai = $row["TrangThaiDeTai"];
					$NgayDK = $row["NgayDK"];
					$TrangThaiDK = $row["TrangThaiDK"];
					$IDNhom = $row["IDNhom"];
					$IDDeTai = $row["IDDeTai"];
					$HoDem = $row["HoDem"];
					$YeuCau = $row["YeuCau"];
					$SoLuongTV = $row["SoLuongTV"];
					$IDNganh = $row["IDNganh"];
					$dulieu[] = array(	
									  'TenDeTai'=>$TenDeTai,
									  'MoTa'=>$MoTa,
									  'Ten'=>$Ten,
									  'ChuyenNganh'=>$ChuyenNganh,
									  'TrangThaiDeTai'=>$TrangThaiDeTai,
									  'NgayDK'=>$NgayDK,
									  'TrangThaiDK'=>$TrangThaiDK,
									  'IDNhom'=>$IDNhom,
									  'IDDeTai'=>$IDDeTai,
									  'HoDem'=>$HoDem,
									  'YeuCau'=>$YeuCau,
									  'SoLuongTV'=>$SoLuongTV,
									  'IDNganh'=>$IDNganh

									);
					
				}
				header("content-Type:application/json; charset=UTF-8");
				echo json_encode($dulieu);
				
			}
		}			
	}
	

?>