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
    }

?>