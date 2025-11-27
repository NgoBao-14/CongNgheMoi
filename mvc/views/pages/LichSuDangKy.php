<?php
$lichsu = isset($data['lichsu']) ? $data['lichsu'] : array();

echo '
<div class="col-md-3">
    <div class="navigation-breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=".">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lịch sử đăng ký</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <h1 class="text-center fw-bold mb-5 text-primary">LỊCH SỬ ĐĂNG KÝ ĐỀ TÀI</h1>
    
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 10%;" class="text-center">STT</th>
                            <th style="width: 45%;">Tên đề tài</th>
                            <th style="width: 25%;">Giảng viên hướng dẫn</th>
                            <th style="width: 20%;" class="text-center">Đợt</th>
                        </tr>
                    </thead>
                    <tbody>';
                    
if (!empty($lichsu) && is_array($lichsu)) {
    $stt = 1;
    $hasData = false;
    foreach ($lichsu as $row) {
        if (isset($row['TenDeTai']) && !empty($row['TenDeTai'])) {
            $hasData = true;
            echo '
            <tr>
                <td class="text-center">'.$stt.'</td>
                <td>'.htmlspecialchars($row['TenDeTai']).'</td>
                <td>'.htmlspecialchars($row['GiangVienHuongDan']).'</td>
                <td class="text-center">Học kỳ 1 năm 2025-2026</td>
            </tr>';
            $stt++;
        }
    }
    
    if (!$hasData) {
        echo '<tr><td colspan="4" class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
                <p class="mt-3 text-muted">Không có lịch sử làm đồ án nào</p>
              </td></tr>';
    }
} else {
    echo '<tr><td colspan="4" class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
            <p class="mt-3 text-muted">Không có lịch sử làm đồ án nào</p>
          </td></tr>';
}

echo '
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../public/css/loading.css">
<script src="../public/js/loading.js"></script>
';
?>
