<?php
class mLogin extends DB {
    public function GetDN($user, $pass){
        try {
            // Sử dụng prepared statement để tránh SQL injection
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
                    WHERE tk.username = ? AND tk.password = ?";
            
            $stmt = mysqli_prepare($this->connect, $sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . mysqli_error($this->connect));
            }
            
            mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            return $result;
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }
}

?>