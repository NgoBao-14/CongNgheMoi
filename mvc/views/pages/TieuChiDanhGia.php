<?php
echo '
<style>
    .criteria-container {
        padding: 2rem 0;
    }
    .criteria-title {
        text-align: center;
        color: #1f2937;
        font-weight: 700;
        margin-bottom: 2rem;
        font-size: 1.5rem;
    }
    .criteria-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .criteria-table table {
        margin: 0;
        width: 100%;
    }
    .criteria-table th {
        background: #2563eb;
        color: white;
        font-weight: 600;
        padding: 1rem;
        text-align: center;
        font-size: 0.9rem;
        border: 1px solid #1e40af;
    }
    .criteria-table td {
        padding: 0.875rem;
        border: 1px solid #e5e7eb;
        font-size: 0.875rem;
        vertical-align: middle;
    }
    .criteria-table tbody tr:hover {
        background: #f9fafb;
    }
    .criteria-name {
        font-weight: 600;
        color: #374151;
    }
    .criteria-weight {
        text-align: center;
        font-weight: 600;
        color: #1f2937;
    }
    .level-header {
        background: #3b82f6 !important;
    }
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 1.5rem;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: #9ca3af;
    }
    .breadcrumb-item a {
        color: #6b7280;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #1f2937;
    }
</style>

<div class="container-fluid criteria-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/CongNgheMoi/SinhVien">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tiêu chí đánh giá</li>
        </ol>
    </nav>

    <h1 class="criteria-title">TIÊU CHÍ ĐÁNH GIÁ KHÓA LUẬN TỐT NGHIỆP</h1>
    
    <div class="criteria-table">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 20%;">Nội dung đánh giá</th>
                        <th rowspan="2" style="width: 8%;">Tỷ trọng</th>
                        <th colspan="4" class="level-header">Mức độ đạt được</th>
                    </tr>
                    <tr class="level-header">
                        <th style="width: 18%;">Mức 1 (0-30%)</th>
                        <th style="width: 18%;">Mức 2 (40-60%)</th>
                        <th style="width: 18%;">Mức 3 (70-80%)</th>
                        <th style="width: 18%;">Mức 4 (90-100%)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="criteria-name">Hình thành và phát triển ý tưởng nghiên cứu</td>
                        <td class="criteria-weight">15%</td>
                        <td>Không có hoặc ít động góp</td>
                        <td>Có thảo luận và đóng góp theo yêu cầu</td>
                        <td>Chủ động thảo luận, tự tìm hiểu</td>
                        <td>Chủ động đề xuất ý tưởng mới</td>
                    </tr>
                    <tr>
                        <td class="criteria-name">Cấu trúc báo cáo KLTN hợp lý khi thuyết trình</td>
                        <td class="criteria-weight">15%</td>
                        <td>Không hoặc ít tham gia đề cương</td>
                        <td>Có kế hoạch chưa chi tiết</td>
                        <td>Chi tiết, chưa có dự phòng hợp lý</td>
                        <td>Chi tiết, có dự phòng hợp lý</td>
                    </tr>
                    <tr>
                        <td class="criteria-name">Sự tương tác giữa SV và CBHD</td>
                        <td class="criteria-weight">10%</td>
                        <td>Không hoặc ít trao đổi với CBHD</td>
                        <td>Không chủ động liên hệ với CBHD</td>
                        <td>Chủ động gặp CBHD</td>
                        <td>Chủ động gặp CBHD và giải quyết vấn đề</td>
                    </tr>
                    <tr>
                        <td class="criteria-name">Sự tương tác giữa các thành viên nhóm</td>
                        <td class="criteria-weight">10%</td>
                        <td>Không hoặc ít trao đổi, phân công, không hoàn thành công việc</td>
                        <td>Có tham gia nhưng cần nhắc nhở</td>
                        <td>Chủ động, hoàn thành nhưng còn cần nhắc</td>
                        <td>Chủ động, hoàn thành đúng hạn</td>
                    </tr>
                    <tr>
                        <td class="criteria-name">Hoàn thành nội dung được phân công</td>
                        <td class="criteria-weight">5%</td>
                        <td>Không hoặc luôn cần nhắc nhở</td>
                        <td>Hoàn thành không đúng thời hạn, chất lượng</td>
                        <td>Hoàn thành đúng hạn nhưng còn cần sửa đổi</td>
                        <td>Chủ động hoàn thành đúng hạn</td>
                    </tr>
                    <tr>
                        <td class="criteria-name">Thu nhận kết quả và xử lý số liệu</td>
                        <td class="criteria-weight">15%</td>
                        <td>Dữ liệu giả tạo > 50%</td>
                        <td>Thiếu minh chứng hoặc dữ liệu không rõ ràng</td>
                        <td>Dữ liệu thu thập hợp lý, có minh chứng</td>
                        <td>Trung thực, minh chứng rõ ràng</td>
                    </tr>
                    <tr>
                        <td class="criteria-name">Thảo luận nghiên cứu</td>
                        <td class="criteria-weight">15%</td>
                        <td>Giải thích không phù hợp</td>
                        <td>Giải thích chưa so sánh NC liên quan</td>
                        <td>Giải thích đúng, kết luận rõ</td>
                        <td>So sánh tốt, kết luận hướng đúng mục tiêu</td>
                    </tr>
                    <tr>
                        <td class="criteria-name">Tóm tắt kết quả nghiên cứu</td>
                        <td class="criteria-weight">5%</td>
                        <td>Tóm tắt không phù hợp</td>
                        <td>Tóm tắt chưa đầy đủ</td>
                        <td>Tóm tắt được nhưng chưa có đóng</td>
                        <td>Tóm tắt chính xác, có đóng</td>
                    </tr>
                    <tr>
                        <td class="criteria-name">Kiến nghị</td>
                        <td class="criteria-weight">5%</td>
                        <td>Phần lớn không phù hợp</td>
                        <td>Một số phù hợp</td>
                        <td>Phần lớn phù hợp</td>
                        <td>Tất cả phù hợp</td>
                    </tr>
                    <tr>
                        <td class="criteria-name">Tài liệu tham khảo</td>
                        <td class="criteria-weight">5%</td>
                        <td>Sai quy định hình thức</td>
                        <td>≥3 lỗi vi trí hoặc số lượng</td>
                        <td>1-2 lỗi vi trí/số lượng</td>
                        <td>Không phát hiện lỗi</td>
                    </tr>
                    <tr>
                        <td class="criteria-name">Chu tích hình ảnh, bảng biểu</td>
                        <td class="criteria-weight">5%</td>
                        <td>Không chu tích hoặc sai hoàn toàn</td>
                        <td>Chưa đúng quy định</td>
                        <td>Đủ nhưng chưa chuẩn</td>
                        <td>Đúng quy định</td>
                    </tr>
                    <tr>
                        <td class="criteria-name">Chính tả, định dạng, thuật ngữ</td>
                        <td class="criteria-weight">5%</td>
                        <td>>20 lỗi, văn phong không phù hợp</td>
                        <td>10-20 lỗi, chưa đúng dụng thuật ngữ</td>
                        <td><10 lỗi, văn phong tạm ổn</td>
                        <td>Hầu như không lỗi, đúng văn phong chuyên ngành</td>
                    </tr>
                    <tr class="table-light">
                        <td colspan="2" class="text-end fw-bold">TỔNG CỘNG:</td>
                        <td colspan="4" class="text-center fw-bold">100%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 p-4 bg-white rounded shadow-sm">
        <h5 class="text-primary mb-3"><i class="bi bi-info-circle me-2"></i>Ghi chú:</h5>
        <ul class="mb-0">
            <li>Điểm tổng kết được tính theo thang điểm 10</li>
            <li>Sinh viên cần đạt tối thiểu 5.0 điểm để được công nhận tốt nghiệp</li>
            <li>Điểm cuối cùng sẽ được tổng hợp từ giảng viên hướng dẫn và hội đồng bảo vệ</li>
            <li>Mỗi tiêu chí được đánh giá theo 4 mức độ: Mức 1 (0-30%), Mức 2 (40-60%), Mức 3 (70-80%), Mức 4 (90-100%)</li>
        </ul>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
';
?>
