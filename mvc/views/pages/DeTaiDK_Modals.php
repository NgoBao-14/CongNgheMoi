<?php
// File chứa các modal dùng chung cho DeTaiDK và ThongTinDeTai
echo '
<!-- Project Details Modal -->
<div class="modal fade" id="projectDetailModal" tabindex="-1" aria-labelledby="projectDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="projectDetailModalLabel">Chi tiết đề tài</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="projectDetailContent">
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Thông báo từ GVHD Modal -->
<div class="modal fade" id="thongBaoModal" tabindex="-1" aria-labelledby="thongBaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="thongBaoModalLabel">Thông báo đề tài từ giảng viên hướng dẫn</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="thongBaoContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Đang tải thông báo...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Tiêu chí đánh giá Modal -->
<div class="modal fade" id="tieuChiModal" tabindex="-1" aria-labelledby="tieuChiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="tieuChiModalLabel">Tiêu chí đánh giá khóa luận</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;" class="text-center">STT</th>
                                <th style="width: 65%;">Tiêu chí đánh giá</th>
                                <th style="width: 30%;" class="text-center">Mức điểm</th>
                            </tr>
                        </thead>
                        <tbody id="tieuChiTableBody">
                            <tr>
                                <td class="text-center">1</td>
                                <td>Tính cập nhật và mức độ phù hợp của đề tài</td>
                                <td class="text-center">10%</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Tính khoa học và logic trong phương pháp nghiên cứu</td>
                                <td class="text-center">15%</td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>Khả năng áp dụng và tính thực tiễn của kết quả</td>
                                <td class="text-center">15%</td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td>Kỹ năng triển khai và xử lý công nghệ</td>
                                <td class="text-center">20%</td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td>Thu nhận kết quả và xử lý số liệu</td>
                                <td class="text-center">15%</td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td>Thảo luận nghiên cứu và kết luận</td>
                                <td class="text-center">10%</td>
                            </tr>
                            <tr>
                                <td class="text-center">7</td>
                                <td>Tài liệu tham khảo và hình thức trình bày</td>
                                <td class="text-center">10%</td>
                            </tr>
                            <tr>
                                <td class="text-center">8</td>
                                <td>Trình bày và bảo vệ</td>
                                <td class="text-center">5%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Kết quả chấm từ GVHD Modal -->
<div class="modal fade" id="ketQuaChamModal" tabindex="-1" aria-labelledby="ketQuaChamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="ketQuaChamModalLabel">Kết quả chấm từ giảng viên hướng dẫn</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="ketQuaChamContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Đang tải kết quả chấm...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes rotate4 {
    100% {
        transform: rotate(360deg);
    }
}

@keyframes dash4 {
    0% {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
    }
    50% {
        stroke-dasharray: 90, 200;
        stroke-dashoffset: -35px;
    }
    100% {
        stroke-dashoffset: -125px;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const detailButtons = document.querySelectorAll(".view-details");

    detailButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            const title = this.dataset.title;
            const giangVien = this.dataset.giangvien;
            const moTa = this.dataset.mota;
            const yeuCau = this.dataset.yeucau;
            const soLuong = this.dataset.sltoida;

            const content = `
                <p><strong>Tên đề tài:</strong> ${title}</p>
                <p><strong>Giảng viên hướng dẫn:</strong> ${giangVien}</p>
                <p><strong>Mô tả:</strong> ${moTa}</p>
                <p><strong>Yêu cầu:</strong> ${yeuCau}</p>
                <p><strong>Số lượng tối đa:</strong> ${soLuong}</p>
            `;
            document.getElementById("projectDetailContent").innerHTML = content;
            const modal = new bootstrap.Modal(document.getElementById("projectDetailModal"));
            modal.show();
        });
    });

    // Load thông báo từ GVHD khi modal mở
    const thongBaoModal = document.getElementById("thongBaoModal");
    if (thongBaoModal) {
        thongBaoModal.addEventListener("show.bs.modal", function() {
            loadThongBao();
        });
    }

    // Load kết quả chấm khi modal mở
    const ketQuaChamModal = document.getElementById("ketQuaChamModal");
    if (ketQuaChamModal) {
        ketQuaChamModal.addEventListener("show.bs.modal", function() {
            loadKetQuaCham();
        });
    }
    
    // Xử lý nút hủy đăng ký
    const btnHuyDangKy = document.getElementById("btnHuyDangKy");
    if(btnHuyDangKy){
        btnHuyDangKy.addEventListener("click", function() {
            Toast.confirm(
                "Bạn có chắc chắn muốn hủy đăng ký đề tài này không?",
                function() {
                    LoadingSpinner.show("Đang hủy đăng ký...");
                    window.location.href = "./HuyDangKyDeTai";
                }
            );
        });
    }
    
    // Xử lý nút đăng ký nhóm
    const btnDangKyNhom = document.getElementById("btnDangKyNhom");
    if(btnDangKyNhom){
        btnDangKyNhom.addEventListener("click", function() {
            const selectedRadio = document.querySelector("input[name=\'chonNhom\']:checked");
            if(!selectedRadio){
                Toast.warning("Vui lòng chọn sinh viên để làm chung nhóm!");
                return;
            }
            
            Toast.confirm(
                "Bạn có chắc chắn muốn đăng ký làm chung nhóm với sinh viên này không?",
                function() {
                    LoadingSpinner.show("Đang đăng ký nhóm...");
                    const maSVChon = selectedRadio.value;
                    window.location.href = "./DangKyNhom?masv=" + maSVChon;
                }
            );
        });
    }
    
    // Xử lý nút hủy nhóm
    const btnHuyNhom = document.getElementById("btnHuyNhom");
    if(btnHuyNhom){
        btnHuyNhom.addEventListener("click", function() {
            Toast.confirm(
                "Bạn có chắc chắn muốn hủy nhóm không? Sau khi hủy, các thành viên sẽ trở về làm một mình.",
                function() {
                    LoadingSpinner.show("Đang hủy nhóm...");
                    window.location.href = "./HuyNhom";
                }
            );
        });
    }
});

function loadThongBao() {
    const contentDiv = document.getElementById("thongBaoContent");
    contentDiv.innerHTML = `
        <div class="text-center py-4">
            <svg viewBox="25 25 50 50" style="width: 3.25em; transform-origin: center; animation: rotate4 2s linear infinite;">
                <circle r="20" cy="50" cx="50" style="fill: none; stroke: hsl(214, 97%, 59%); stroke-width: 2; stroke-dasharray: 1, 200; stroke-dashoffset: 0; stroke-linecap: round; animation: dash4 1.5s ease-in-out infinite;"></circle>
            </svg>
            <p class="mt-2">Đang tải thông báo...</p>
        </div>
    `;

    fetch("./getThongBaoGVHD")
        .then(response => response.json())
        .then(data => {
            if (data.success && data.thongbao && data.thongbao.length > 0) {
                let html = \'<div class="list-group">\';
                data.thongbao.forEach(function(tb) {
                    const ngayTao = tb.NgayTao ? new Date(tb.NgayTao).toLocaleDateString("vi-VN") : "N/A";
                    html += `
                        <div class="list-group-item mb-3">
                            <div class="d-flex w-100 justify-content-between mb-2">
                                <h6 class="mb-1 fw-bold">${tb.TieuDe || "Thông báo"}</h6>
                                <small class="text-muted">${ngayTao}</small>
                            </div>
                            <p class="mb-1">${tb.NoiDung || "Không có nội dung"}</p>
                            ${tb.GhiChu ? `<p class="mb-0"><small class="text-muted"><strong>Ghi chú:</strong> ${tb.GhiChu}</small></p>` : ""}
                        </div>
                    `;
                });
                html += \'</div>\';
                contentDiv.innerHTML = html;
            } else {
                contentDiv.innerHTML = `
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Chưa có thông báo nào từ giảng viên hướng dẫn.
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error("Error:", error);
            contentDiv.innerHTML = `
                <div class="alert alert-danger text-center">
                    <i class="bi bi-exclamation-triangle"></i> Có lỗi xảy ra khi tải thông báo. Vui lòng thử lại sau.
                </div>
            `;
        });
}

function loadKetQuaCham() {
    const contentDiv = document.getElementById("ketQuaChamContent");
    contentDiv.innerHTML = `
        <div class="text-center py-4">
            <svg viewBox="25 25 50 50" style="width: 3.25em; transform-origin: center; animation: rotate4 2s linear infinite;">
                <circle r="20" cy="50" cx="50" style="fill: none; stroke: hsl(40, 97%, 59%); stroke-width: 2; stroke-dasharray: 1, 200; stroke-dashoffset: 0; stroke-linecap: round; animation: dash4 1.5s ease-in-out infinite;"></circle>
            </svg>
            <p class="mt-2">Đang tải kết quả chấm...</p>
        </div>
    `;

    fetch("./getKetQuaCham")
        .then(response => response.json())
        .then(data => {
            if (data.success && data.ketqua) {
                const kq = data.ketqua;
                let html = `
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Thông tin chấm điểm</h6>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 40%;">Điểm tổng kết:</th>
                                        <td><strong class="text-primary fs-5">${kq.TongDiem || "Chưa có"} ${kq.TongDiem ? "/10" : ""}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Ngày chấm:</th>
                                        <td>${kq.NgayCham ? new Date(kq.NgayCham).toLocaleDateString("vi-VN") : "Chưa có"}</td>
                                    </tr>
                                    <tr>
                                        <th>Nhận xét:</th>
                                        <td>${kq.NhanXet || "Chưa có nhận xét"}</td>
                                    </tr>
                                </tbody>
                            </table>
                `;
                
                if (kq.ChiTietDiem && kq.ChiTietDiem.length > 0) {
                    html += `
                        <h6 class="mt-4 mb-3">Chi tiết điểm</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tiêu chí</th>
                                        <th class="text-center">Điểm</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    kq.ChiTietDiem.forEach(function(ct) {
                        html += `
                            <tr>
                                <td>${ct.TenTieuChi}</td>
                                <td class="text-center">${ct.Diem || "-"}</td>
                            </tr>
                        `;
                    });
                    html += `
                                </tbody>
                            </table>
                        </div>
                    `;
                }
                
                html += `
                        </div>
                    </div>
                `;
                contentDiv.innerHTML = html;
            } else {
                contentDiv.innerHTML = `
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Chưa có kết quả chấm từ giảng viên hướng dẫn.
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error("Error:", error);
            contentDiv.innerHTML = `
                <div class="alert alert-danger text-center">
                    <i class="bi bi-exclamation-triangle"></i> Có lỗi xảy ra khi tải kết quả chấm. Vui lòng thử lại sau.
                </div>
            `;
        });
}
</script>
';
?>
