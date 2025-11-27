<?php
$dt = json_decode($data['dt'], true);
$daDangKy = isset($data['daDangKy']) ? $data['daDangKy'] : false;

// Kiểm tra nếu $dt không phải là mảng hoặc null
if (!is_array($dt)) {
    $dt = array();
}

    echo '
    <div class="col-md-3">
        <div class="navigation-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=".">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đăng ký đề tài</li>
                </ol>
            </nav>
        </div>
    </div>
        <!-- Project Registration Section -->
        <div id="deTaiSection" class="project-section" style="position: relative;">';
        
        // Hiển thị overlay nếu đã đăng ký
        if ($daDangKy) {
            echo '
            <div class="registration-disabled-overlay">
                <div class="registration-disabled-message">
                    <i class="bi bi-lock-fill" style="font-size: 3rem; color: #dc3545;"></i>
                    <h4 class="mt-3">Bạn đã đăng ký đề tài</h4>
                    <p>Bạn không thể đăng ký thêm đề tài mới</p>
                    <a href="./ThongTinDeTai" class="btn btn-primary mt-2">Xem thông tin đề tài</a>
                </div>
            </div>';
        }
        
        echo '
            <h3 class="text-center text-primary my-4">ĐĂNG KÝ ĐỀ TÀI</h3>
            
            <div class="project-list">
                <table class="table table-striped table-bordered">
                    <thead style="background-color: #D6E9F8;">
                        <tr>
                            <th width="3%">STT</th>
                            <th width="12%">Tên Đề Tài</th>
                            <th width="15%">Mô Tả</th>
                            <th width="15%">Yêu Cầu</th>
                            <th width="8%">Số Sinh Viên</th>
                            <th width="8%">GVHD</th>
                            <th width="8%">Trạng Thái</th>
                            <th width="8%">Chọn</th>
                        </tr>
                    </thead>
                    <tbody>';
                            $i = 1;
                            if (!empty($dt) && is_array($dt)) {
                                foreach($dt as $row){
                                    if(isset($row['TrangThaiDK']) && isset($row['TrangThaiDeTai']) && 
                                       $row['TrangThaiDK']==='Chưa được đăng ký' && $row['TrangThaiDeTai']==='Đã duyệt'){
                                echo '<tr>
                                <td class="text-center">'.$i.'</td>
                                <td>'.htmlspecialchars($row['TenDeTai']).'</td>
                                <td>'.htmlspecialchars(substr($row['MoTa'], 0, 100)).(strlen($row['MoTa']) > 100 ? '...' : '').'</td>
                                <td>'.htmlspecialchars(substr($row['YeuCau'], 0, 100)).(strlen($row['YeuCau']) > 100 ? '...' : '').'</td>
                                <td class="text-center">'.$row['SoLuongTV'].' / 4</td>
                                <td>'.htmlspecialchars($row['ten_giang_vien']).'</td>
                                <td class="text-center">
                                    <button 
                                        class="btn btn-success btn-sm" 
                                        style="background-color: #28a745; border-color: #28a745; color: #fff; border-radius: 5px; padding: 2px 8px;"
                                    >Đăng mở</button>
                                </td>
                                <td class="text-center">
                                    <input type="radio" name="chonDeTai" value="'.$row['IDDeTai'].'" 
                                        data-title="'.htmlspecialchars($row['TenDeTai'], ENT_QUOTES).'"
                                        data-giangvien="'.htmlspecialchars($row['ten_giang_vien'], ENT_QUOTES).'"
                                        data-mota="'.htmlspecialchars($row['MoTa'], ENT_QUOTES).'"
                                        data-yeucau="'.htmlspecialchars($row['YeuCau'], ENT_QUOTES).'"
                                        data-sltoida="'.$row['SoLuongTV'].'"
                                        class="form-check-input">
                                </td>
                                </tr>';
                                        $i++;
                                    }
                                }
                            } else {
                                echo '<tr><td colspan="9" class="text-center">Không có đề tài nào để đăng ký.</td></tr>';
                            }
                            
echo '
                    </tbody>
                </table>
            </div>
            
            <div class="text-end mt-3">
                <button class="btn btn-primary" id="btnDangKyDeTai">Đăng ký</button>
            </div>
        </div>
        
        <style>
        .registration-disabled-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .registration-disabled-message {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }
        
        .registration-disabled-message h4 {
            color: #dc3545;
            font-weight: 700;
        }
        
        .registration-disabled-message p {
            color: #6c757d;
            margin-bottom: 0;
        }
        </style>';

    
    ?>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    let selectedDeTaiId = null;
    let selectedDeTaiName = null;
    
    // Xử lý nút đăng ký
    document.getElementById("btnDangKyDeTai").addEventListener("click", function () {
        const selectedRadio = document.querySelector("input[name='chonDeTai']:checked");
        
        if (!selectedRadio) {
            Toast.warning("Vui lòng chọn một đề tài để đăng ký!");
            return;
        }
        
        selectedDeTaiId = selectedRadio.value;
        selectedDeTaiName = selectedRadio.dataset.title;
        
        // Hiển thị toast confirm
        Toast.confirm(
            `Bạn có chắc chắn muốn đăng ký đề tài: <strong>${selectedDeTaiName}</strong>?`,
            function() {
                // Xác nhận - hiển thị loading và chuyển trang
                LoadingSpinner.show('Đang đăng ký đề tài...');
                window.location.href = "./DangKyDeTaiMoi?iddetai=" + selectedDeTaiId;
            }
        );
    });
    

});
</script>
