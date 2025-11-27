<?php
// $nhom = $data['nhom'];
echo '    
    <div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link">Contact</a>
        </li>
    </ul>


    <ul class="navbar-nav ml-auto">
        <!-- thu phóng -->
        <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
        </li>
    </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Quản lý khóa luận</span>
    </a>


    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="" class="d-block">Giảng Viên</a>
        </div>
        </div>

    <div>
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <!-- Bảng điều khiển -->
        <li class="nav-item" >
            <a href="./" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Bảng điều khiển</p>
            </a>
        </li>
        <!-- Đề xuất đề tài  -->
        <li class="nav-item">
            <a href="./DeXuatDeTai" class="nav-link" >
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Đề xuất đề tài</p>
            </a>
        </li>

        <!-- Danh sách đăng ký -->
        <li class="nav-item">
            <a href="./QuanLyDeTai" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Danh sách đề tài</p>
            </a>
        </li>

        <!-- Sinh viên -->
        <li class="nav-item">
            <a href="./QuanLyNhom" class="nav-link" style="background-color:rgb(35, 120, 206);">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Quản lý nhóm</p>
            </a>
        </li>

        <!-- Giáo viên -->
        <li class="nav-item">
            <a href="./TienDoDeTai" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Tiến độ đề tài</p>
            </a>
        </li>

        
        <li class="nav-item">
            <a href="./QuanLyKhoaLuan" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Báo cáo khóa luận</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="/CongNgheMoi/Logout" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Đăng xuất</p>
            </a>
        </li>
        </ul>
        </nav>
    </div>

    </aside>

    <div class="content-wrapper">
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