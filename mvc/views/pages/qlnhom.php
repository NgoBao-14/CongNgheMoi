<?php
require_once "./mvc/views/components/sidebarGV.php";
$nhom = $data['nhom'];
echo '

<section class="content">
        <div class="container-fluid">
        
                    <div class="card">
                <div class="card-header">
                <h3>Danh sách nhóm</h3>
                </div>
                <div class="card-body p-0">
                <table class="table">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Nhóm</th>
                        <th>Tên đề tài</th>
                        <th>Số thành viên</th>
                        <th>Chức năng</th>
                    </tr>
                    </thead>
                    <tbody>';
                    $stt = 1;
                    foreach ($nhom as $row) {
                        echo '<tr>
                            <td>' . $stt++ . '</td>
                            <td>' . $row['IDNhom'] . '</td>
                            <td>' . $row['TenDeTai'] . '</td>
                            <td>' . $row['SoLuongSinhVien'] . '</td>
                            <form method="POST">
                            <input type="hidden" name="idNhom" value="' . $row['IDNhom'] . '">
                            <td>
                                <button type="submit" name="btnXemChiTiet" class="btn btn-primary">Xem chi tiết</button>
                            </td>
                            </form>
                        </tr>';
                    }
echo'                    
                    </tbody>
                </table>
                </div>
            </div>
        </div>';

        if (isset($data['thongTinTV'])){
echo'    <!-- Group Information -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table  mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-3">STT</th>
                                <th class="px-3">MSSV</th>
                                <th class="px-3">Họ và tên</th>
                                <th class="px-3">Lớp</th>
                                <th class="px-3">Email</th>
                                <th class="px-3">Nhóm</th>
                            </tr>
                        </thead>
                        <tbody>';
                            $stt = 1;
                            foreach ($data['thongTinTV'] as $tv) {
                                echo '
                                <tr>
                                    <td class="px-3">' . $stt++ . '</td>
                                    <td class="px-3">' . htmlspecialchars($tv["MaSV"]) . '</td>
                                    <td class="px-3">' . htmlspecialchars($tv["HoTenSinhVien"]) . '</td>
                                    <td class="px-3">' . htmlspecialchars($tv["Lop"]) . '</td>
                                    <td class="px-3">' . htmlspecialchars($tv["Email"]) . '</td>
                                    <td class="px-3">' . htmlspecialchars($tv["IDNhom"]) . '</td>
                                </tr>';
                            }
echo'
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>';
        }
        else {
            echo '';
        }
echo '
    </section>';
?>