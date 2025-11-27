<?php
echo '
<div class="col-md-3">
    <div class="navigation-breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=".">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tiêu chí đánh giá</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <h1 class="text-center fw-bold mb-5 text-primary">TIÊU CHÍ ĐÁNH GIÁ KHÓA LUẬN TỐT NGHIỆP</h1>
    
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 5%;" class="text-center">STT</th>
                            <th style="width: 65%;">Tiêu chí đánh giá</th>
                            <th style="width: 30%;" class="text-center">Mức điểm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Tính cập nhật và mức độ phù hợp của đề tài</td>
                            <td class="text-center fw-bold">10%</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Tính khoa học và logic trong phương pháp nghiên cứu</td>
                            <td class="text-center fw-bold">15%</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>Khả năng áp dụng và tính thực tiễn của kết quả</td>
                            <td class="text-center fw-bold">15%</td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td>Kỹ năng triển khai và xử lý công nghệ</td>
                            <td class="text-center fw-bold">20%</td>
                        </tr>
                        <tr>
                            <td class="text-center">5</td>
                            <td>Thu nhận kết quả và xử lý số liệu</td>
                            <td class="text-center fw-bold">15%</td>
                        </tr>
                        <tr>
                            <td class="text-center">6</td>
                            <td>Thảo luận nghiên cứu và kết luận</td>
                            <td class="text-center fw-bold">10%</td>
                        </tr>
                        <tr>
                            <td class="text-center">7</td>
                            <td>Tài liệu tham khảo và hình thức trình bày</td>
                            <td class="text-center fw-bold">10%</td>
                        </tr>
                        <tr>
                            <td class="text-center">8</td>
                            <td>Trình bày và bảo vệ</td>
                            <td class="text-center fw-bold">5%</td>
                        </tr>
                        <tr class="table-info">
                            <td colspan="2" class="text-end fw-bold">TỔNG CỘNG:</td>
                            <td class="text-center fw-bold">100%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                <h5 class="text-primary">Ghi chú:</h5>
                <ul>
                    <li>Điểm tổng kết được tính theo thang điểm 10</li>
                    <li>Sinh viên cần đạt tối thiểu 5.0 điểm để được công nhận tốt nghiệp</li>
                    <li>Điểm cuối cùng sẽ được tổng hợp từ giảng viên hướng dẫn và hội đồng bảo vệ</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../public/css/loading.css">
<script src="../public/js/loading.js"></script>
';
?>
