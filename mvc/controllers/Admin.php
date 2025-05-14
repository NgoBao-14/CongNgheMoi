<?php
    class admin extends Controller{
        public function SayHi(){
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
                    "khoa" => $khoa,
                    "rs" => $rs,
                ]);
            }
            $this->view("layoutadmin", [
                "Page" => "ThemSinhVien",
                "khoa" => $khoa,
            ]);
        }
        
    }

?>