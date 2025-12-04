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
        
        // Hiển thị thông báo nếu đã đăng ký
        if ($daDangKy) {
            echo '
            <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i>
                <div>
                    Bạn đã đăng ký đề tài. 
                    <a href="./ThongTinDeTai" class="alert-link">Xem thông tin đề tài của bạn</a>
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
                                    // Kiểm tra số lượng đã đăng ký
                                    $soLuongDaDangKy = isset($row['SoLuongDaDangKy']) ? $row['SoLuongDaDangKy'] : 0;
                                    $soLuongToiDa = $row['SoLuongTV'];
                                    $isDayDu = $soLuongDaDangKy >= $soLuongToiDa;
                                    
                                    // Class cho row nếu đã đủ số lượng
                                    $rowClass = $isDayDu ? 'style="opacity: 0.5; background-color: #f5f5f5;"' : '';
                                    $disabledAttr = $isDayDu ? 'disabled' : '';
                                    
                                    echo '<tr '.$rowClass.'>
                                    <td class="text-center">'.$i.'</td>
                                    <td>'.htmlspecialchars($row['TenDeTai']).'</td>
                                    <td>'.htmlspecialchars(substr($row['MoTa'], 0, 100)).(strlen($row['MoTa']) > 100 ? '...' : '').'</td>
                                    <td>'.htmlspecialchars(substr($row['YeuCau'], 0, 100)).(strlen($row['YeuCau']) > 100 ? '...' : '').'</td>
                                    <td class="text-center">
                                        <span '.($isDayDu ? 'style="color: #dc3545; font-weight: bold;"' : '').'>'
                                            .$soLuongDaDangKy.' / '.$soLuongToiDa.
                                        '</span>
                                    </td>
                                    <td>'.htmlspecialchars($row['ten_giang_vien']).'</td>
                                    <td class="text-center">
                                        <button 
                                            class="btn btn-'.($isDayDu ? 'secondary' : 'success').' btn-sm" 
                                            style="border-radius: 5px; padding: 2px 8px;"
                                            disabled
                                        >'.($isDayDu ? 'Đã đủ' : 'Đăng mở').'</button>
                                    </td>
                                    <td class="text-center">
                                        <input type="radio" name="chonDeTai" value="'.$row['IDDeTai'].'" 
                                            data-title="'.htmlspecialchars($row['TenDeTai'], ENT_QUOTES).'"
                                            data-giangvien="'.htmlspecialchars($row['ten_giang_vien'], ENT_QUOTES).'"
                                            data-mota="'.htmlspecialchars($row['MoTa'], ENT_QUOTES).'"
                                            data-yeucau="'.htmlspecialchars($row['YeuCau'], ENT_QUOTES).'"
                                            data-sltoida="'.$row['SoLuongTV'].'"
                                            class="form-check-input"
                                            '.($daDangKy ? 'disabled' : $disabledAttr).'>
                                    </td>
                                    </tr>';
                                    $i++;
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center">Không có đề tài nào để đăng ký.</td></tr>';
                            }
                            
echo '
                    </tbody>
                </table>
            </div>
            
            <div class="text-end mt-3">';
            
            if ($daDangKy) {
                echo '<button class="btn btn-secondary" id="btnDangKyDeTai" disabled style="opacity: 0.5; cursor: not-allowed;">
                    <i class="bi bi-lock-fill me-1"></i>Đã đăng ký
                </button>';
            } else {
                echo '<button class="btn btn-primary" id="btnDangKyDeTai">Đăng ký</button>';
            }
            
            echo '
            </div>
        </div>';

    
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
        
        // Kiểm tra nếu radio bị disabled (đề tài đã đủ)
        if (selectedRadio.disabled) {
            Toast.error("Đề tài này đã đủ số lượng sinh viên đăng ký!");
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
