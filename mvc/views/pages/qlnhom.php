<?php
require_once "./mvc/views/components/sidebarGV.php";

echo '
<section class="content">
    <div class="container-fluid">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Danh sách sinh viên đã đăng ký</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-3">STT</th>
                                        <th class="px-3">Mã SV</th>
                                        <th class="px-3">Họ và tên</th>
                                        <th class="px-3">Lớp</th>
                                        <th class="px-3">Nhóm</th>
                                        <th class="px-3">Đề tài đăng ký</th>
                                        <th class="px-3 text-center">Kết quả đánh giá</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                
                                if (isset($data['danhSachSV']) && !empty($data['danhSachSV'])) {
                                    $stt = 1;
                                    foreach ($data['danhSachSV'] as $sv) {
                                        $nhomDisplay = '';
                                        if (isset($sv["IDNhom"]) && !empty($sv["IDNhom"])) {
                                            $nhomDisplay = htmlspecialchars($sv["IDNhom"]);
                                        } else {
                                            $nhomDisplay = '<span style="color: #dc3545; font-weight: bold;">Làm một mình</span>';
                                        }
                                        
                                        echo '
                                        <tr>
                                            <td class="px-3">' . $stt++ . '</td>
                                            <td class="px-3">' . htmlspecialchars($sv["MaSV"]) . '</td>
                                            <td class="px-3">' . htmlspecialchars($sv["HoTenSinhVien"]) . '</td>
                                            <td class="px-3">' . htmlspecialchars($sv["Lop"]) . '</td>
                                            <td class="px-3">' . $nhomDisplay . '</td>
                                            <td class="px-3">' . htmlspecialchars($sv["TenDeTai"]) . '</td>
                                            <td class="px-3 text-center">
                                                <button class="btn btn-sm btn-info btn-xem-ketqua" 
                                                        data-masv="' . htmlspecialchars($sv["MaSV"]) . '"
                                                        data-hoten="' . htmlspecialchars($sv["HoTenSinhVien"]) . '">
                                                    <i class="fas fa-eye"></i> Xem
                                                </button>
                                            </td>
                                        </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="7" class="text-center py-4">Chưa có sinh viên nào đăng ký đề tài</td></tr>';
                                }
                                
echo'                           </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Modal Kết quả đánh giá -->
        <div class="modal fade" id="ketQuaModal" tabindex="-1" aria-labelledby="ketQuaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="ketQuaModalLabel">Kết quả đánh giá</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="ketQuaContent">
                        <div class="text-center py-4">
                            <div class="spinner-border text-info" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-2">Đang tải kết quả đánh giá...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>';
?>
    
    <script>
    $(document).ready(function() {
        // Xử lý click nút xem kết quả
        $(".btn-xem-ketqua").click(function() {
            const masv = $(this).data("masv");
            const hoten = $(this).data("hoten");
            
            $("#ketQuaModalLabel").text("Kết quả đánh giá - " + hoten);
            $("#ketQuaModal").modal("show");
            
            // Load kết quả đánh giá
            loadKetQuaDanhGia(masv);
        });
    });
    
    function loadKetQuaDanhGia(masv) {
        const contentDiv = $("#ketQuaContent");
        contentDiv.html(`
            <div class="text-center py-4">
                <div class="spinner-border text-info" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Đang tải kết quả đánh giá...</p>
            </div>
        `);
        
        $.ajax({
            url: "./getKetQuaDanhGia",
            method: "GET",
            data: { masv: masv },
            dataType: "json",
            success: function(data) {
                if (data.success && data.ketqua) {
                    const kq = data.ketqua;
                    
                    // Danh sách các tiêu chí đánh giá
                    const tieuChi = [
                        { key: "Muc1", label: "Hình thành và phát triển ý tưởng nghiên cứu" },
                        { key: "Muc2", label: "Cấu trúc báo cáo KLTN hợp lý khi thuyết trình" },
                        { key: "Muc3_1", label: "Sự tương tác giữa SV và CBHD" },
                        { key: "Muc3_2", label: "Sự tương tác giữa các thành viên nhóm" },
                        { key: "Muc3_3", label: "Hoàn thành nhiệm vụ được phân công" },
                        { key: "Muc4_1", label: "Thu nhận kết quả và xử lý số liệu" },
                        { key: "Muc4_2", label: "Thảo luận nghiên cứu" },
                        { key: "Muc5_1", label: "Tóm tắt kết quả nghiên cứu" },
                        { key: "Muc5_2", label: "Kiến nghị" },
                        { key: "Muc6_1", label: "Tài liệu tham khảo" },
                        { key: "Muc6_2", label: "Chú thích hình ảnh, bảng biểu" },
                        { key: "Muc6_3", label: "Chính tả, định dạng, thuật ngữ" }
                    ];
                    
                    let html = `
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead style="background-color: #5DADE2; color: white;">
                                    <tr>
                                        <th>Nội dung đánh giá</th>
                                        <th class="text-center" width="150">Điểm</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    tieuChi.forEach(function(tc) {
                        const diem = kq[tc.key] || '';
                        html += `
                            <tr>
                                <td>${tc.label}</td>
                                <td class="text-center">${diem}</td>
                            </tr>
                        `;
                    });
                    
                    html += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    
                    contentDiv.html(html);
                } else {
                    // Vẫn hiển thị form rỗng nếu chưa có điểm
                    const tieuChi = [
                        "Hình thành và phát triển ý tưởng nghiên cứu",
                        "Cấu trúc báo cáo KLTN hợp lý khi thuyết trình",
                        "Sự tương tác giữa SV và CBHD",
                        "Sự tương tác giữa các thành viên nhóm",
                        "Hoàn thành nhiệm vụ được phân công",
                        "Thu nhận kết quả và xử lý số liệu",
                        "Thảo luận nghiên cứu",
                        "Tóm tắt kết quả nghiên cứu",
                        "Kiến nghị",
                        "Tài liệu tham khảo",
                        "Chú thích hình ảnh, bảng biểu",
                        "Chính tả, định dạng, thuật ngữ"
                    ];
                    
                    let html = `
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead style="background-color: #5DADE2; color: white;">
                                    <tr>
                                        <th>Nội dung đánh giá</th>
                                        <th class="text-center" width="150">Điểm</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    tieuChi.forEach(function(tc) {
                        html += `
                            <tr>
                                <td>${tc}</td>
                                <td class="text-center"></td>
                            </tr>
                        `;
                    });
                    
                    html += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    
                    contentDiv.html(html);
                }
            },
            error: function() {
                contentDiv.html(`
                    <div class="alert alert-danger text-center">
                        <i class="fas fa-exclamation-triangle"></i> Có lỗi xảy ra khi tải kết quả đánh giá
                    </div>
                `);
            }
        });
    }
    </script>