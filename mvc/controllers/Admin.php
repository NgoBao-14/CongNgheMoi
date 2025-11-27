<?php
    class admin extends Controller{
        public function SayHi(){
            if($_SESSION["PQ"] != 3){
                echo "<script>alert('Bạn không có quyền truy cập')</script>";
                header("refresh: 0; url='/CongNgheMoi'");
            }
            $admin = $this->model("mAdmin");
            $kq = $admin->GetSinhVien();
            $sinhvien = count(json_decode($kq, true));
            $kq = $admin->GetGiangVien();
            $giangvien = count(json_decode($kq, true));
            $kq = $admin->GetDeTai();
            $detai = count(json_decode($kq, true));
            $kq = $admin->GetNhom();
            $nhom = count(json_decode($kq, true));
            $khoa = $admin->GetKhoa();
            $detaikhoa = $admin->GetDeTaiKhoa();
            if(isset($_POST['btnLoc']))
            {
                $id = $_POST['loc'];
                $detaikhoa = $admin->GetDeTaiTheoKhoa($id);
            }
            $this->view("layoutadmin", [
                "Page" => "Dashboard",
                "active" => "dashboard",
                "sinhvien" => $sinhvien,
                "giangvien" => $giangvien,
                "detai" => $detai,
                "nhom" => $nhom,
                "khoa" => $khoa,
                "detaikhoa" => $detaikhoa,
            ]);
        }
        public function QuanLySV()
        {
            $admin = $this->model("mAdmin");
            $khoa = $admin->GetKhoa();
            $sinhvien = $admin->GetThongTinSV();
            if(isset($_POST['btnLoc']))
            {
                $id = $_POST['loc'];
                $sinhvien = $admin->GetThongTinSVTheoKhoa($id);
            }
            
            $this->view("layoutadmin", [
                "Page" => "QuanLySV",
                "active" => "quanlysv",
                "khoa" => $khoa,
                "sinhvien" => $sinhvien,
            ]);
        }
        function CapNhatSV()
        {
            $admin = $this->model("mAdmin");
            $id = $_REQUEST['id'];
            $sinhvien = $admin->GetThongTinSVTheoID($id);
            $khoa = $admin->GetKhoa();
            $nhom = $admin->GetNhom();
            if(isset($_POST['btn_CapNhat']))
            {
                $lop = $_POST['lop'];
                $hodem = $_POST['hodem'];
                $ten = $_POST['ten'];
                $idnganh = $_POST['chuyennganh'];
                $email = $_POST['email'];
                $sdt = $_POST['sdt'];
                $idnhom = $_POST['idnhom'];
                if($admin->UpdateSV($id,$lop,$idnhom,$hodem,$ten,$idnganh,$sdt,$email))
                {
                    header("location: CapNhatSV?id=$id");
                }
            }
            $this->view("layoutadmin", [
                "Page" => "CapNhatSV",
                "id" => $id,
                "sinhvien" => $sinhvien,
                "khoa" => $khoa,
                "nhom" => $nhom,
                // "khoa" => $admin->GetKhoa(),
            ]);
        }
        function ThemSinhVien()
        {
            $admin = $this->model("mAdmin");
            $khoa = $admin->GetKhoa();
            if(isset($_POST['btn_them']))
            {
                $masv = $_POST['masv'];
                $lop = $_POST['lop'];
                $hodem = $_POST['hodem'];
                $ten = $_POST['ten'];
                $idnganh = $_POST['chuyennganh'];
                $email = $_POST['email'];
                 $sdt = $_POST['sdt'];
                if($admin->ThemSinhVien($masv,$hodem,$ten,$lop,$idnganh,$sdt,$email))
                {
                    $rs = true;
                }
                $this->view("layoutadmin", [
                    "Page" => "ThemSinhVien",
                    "active" => "themsv",
                    "khoa" => $khoa,
                    "rs" => $rs,
                ]);
            }
            $this->view("layoutadmin", [
                "Page" => "ThemSinhVien",
                "active" => "themsv",
                "khoa" => $khoa,
            ]);
        }
        public function QuanLyGV()
        {
            $admin = $this->model("mAdmin");
            $khoa = $admin->GetKhoa();
            $giangvien = $admin->GetThongTinGV();
            if(isset($_POST['btnLoc']))
            {
                $id = $_POST['loc'];
                $giangvien = $admin->GetThongTinGVTheoKhoa($id);
            }
            
            $this->view("layoutadmin", [
                "Page" => "QuanLyGV",
                "active" => "quanlygv",
                "khoa" => $khoa,
                "giangvien" => $giangvien,
            ]);
        }
        function CapNhatGV()
        {
            $admin = $this->model("mAdmin");
            $id = $_REQUEST['id'];
            $giangvien = $admin->GetThongTinGVTheoID($id);
            $khoa = $admin->GetKhoa();
            $chucvu = $admin->GetChucVu();
            if(isset($_POST['btn_CapNhat']))
            {
                $hodem = $_POST['hodem'];
                $ten = $_POST['ten'];
                $idnganh = $_POST['chuyennganh'];
                $email = $_POST['email'];
                $sdt = $_POST['sdt'];
                $cv = $_POST['chucvu'];
                if($admin->UpdateGV($id,$hodem,$ten,$idnganh,$sdt,$email,$cv))
                {
                    echo "<script>alert('Cập nhật thành công')</script>";
                    header("location: QuanLyGV");
                }
            }
            $this->view("layoutadmin", [
                "Page" => "CapNhatGV",
                "id" => $id,
                "giangvien" => $giangvien,
                "khoa" => $khoa,
                "chucvu" => $chucvu,
            ]);
        }
        function ThemGiangVien()
        {
            $admin = $this->model("mAdmin");
            $khoa = $admin->GetKhoa();
            $chucvu = $admin->GetChucVu();
            if(isset($_POST['btn_them']))
            {
                $msgv = $_POST['msgv'];
                $hodem = $_POST['hodem'];
                $ten = $_POST['ten'];
                $idnganh = $_POST['chuyennganh'];
                $email = $_POST['email'];
                 $sdt = $_POST['sdt'];
                $cv = $_POST['chucvu'];
                if($admin->ThemGiangVien($msgv,$hodem,$ten,$idnganh,$sdt,$email, $cv))
                {
                    $rs = true;
                }
                $this->view("layoutadmin", [
                    "Page" => "ThemGiangVien",
                    "active" => "themgv",
                    "khoa" => $khoa,
                    "chucvu" => $chucvu,
                    "rs" => $rs,
                ]);
            }
            $this->view("layoutadmin", [
                "Page" => "ThemGiangVien",
                "active" => "themgv",
                "khoa" => $khoa,
                "chucvu" => $chucvu,
            ]);
        }
        function DSDeTai()
        {
            $admin = $this->model("mAdmin");
            $khoa = $admin->GetKhoa();
            $detai = $admin->GetDSDetai();
            if(isset($_POST['btnLoc']))
            {
                $id = $_POST['loc'];
                $detai = $admin->GetDeTaiTheoKhoa($id);
            }
            
            $this->view("layoutadmin", [
                "Page" => "QuanLyDT",
                "active" => "dsdetai",
                "khoa" => $khoa,
                "detai" => $detai,
            ]);
        }
        function CapNhatDT()
        {
            $admin = $this->model("mAdmin");
            $id = $_REQUEST['id'];
            $detai = $admin->GetDeTaiTheoID($id);
            $khoa = $admin->GetKhoa();
            $nhom = $admin->GetNhom();
            if(isset($_POST['btn_CapNhat']))
            {
                $id = $_POST['id'];
                $trangthaidetai = $_POST['trangthaidetai'];
                $ngaydangky = $_POST['ngaydk'];
                $trangthaidk = $_POST['trangthaidk'];
                $idnhom = $_POST['nhom'];
                $yeucau = $_POST['yeucau'];
                $soluong = $_POST['soluong'];
                $tendetai = $_POST['ten'];
                $mota = $_POST['mota'];
                $idnganh = $_POST['chuyennganh'];
                if($admin->UpdateDeTai($id,$tendetai,$mota,$idnganh,$trangthaidetai,$ngaydangky,$trangthaidk,$idnhom,$yeucau,$soluong))
                {
                    header("location: CapNhatDT?id=$id");
                }
            }
            $this->view("layoutadmin", [
                "Page" => "CapNhatDT",
                "id" => $id,
                "detai" => $detai,
                "khoa" => $khoa,
                "nhom" => $nhom,
            ]);
        }
        
    }

?>