<?php
class mLogin extends DB {
    public function GetDN($user, $pass){
    $sql = "SELECT 
                tk.iduser, tk.username, tk.password, tk.PQ,
                pq.PhanQuyen,
                u.HoDem, u.Ten, u.SDT, u.Email, u.IDNganh,
                sv.MaSV, sv.Lop,
                gv.MaGV,
                CASE 
                    WHEN sv.iduser IS NOT NULL THEN 'sinhvien'
                    WHEN gv.iduser IS NOT NULL THEN 'giangvien'
                    ELSE 'khac'
                END AS role
            FROM taikhoan tk
            JOIN phanquyen pq ON tk.PQ = pq.idpq
            LEFT JOIN user u ON tk.iduser = u.iduser
            LEFT JOIN sinhvien sv ON tk.iduser = sv.iduser
            LEFT JOIN giangvien gv ON tk.iduser = gv.iduser
            WHERE tk.username = '$user' AND tk.password = '$pass'";
    $result = mysqli_query($this->connect, $sql);
    return $result;
    }
}

?>