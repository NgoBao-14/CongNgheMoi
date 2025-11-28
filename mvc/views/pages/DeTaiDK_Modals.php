<?php
// File chứa các modal dùng chung cho DeTaiDK và ThongTinDeTai
echo '

<!-- Thông báo từ GVHD Modal -->
<div class="modal fade" id="thongBaoModal" tabindex="-1" aria-labelledby="thongBaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="thongBaoModalLabel"><i class="bi bi-megaphone"></i> Thông báo đề tài từ giảng viên hướng dẫn</h5>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tieuChiModalLabel">
                    <i class="bi bi-clipboard-check me-2"></i>Tiêu chí đánh giá khóa luận
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 70%;">Nội dung đánh giá</th>
                                <th style="width: 30%;">Tỷ trọng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hình thành và phát triển ý tưởng nghiên cứu</td>
                                <td class="text-center fw-bold">15%</td>
                            </tr>
                            <tr>
                                <td>Cấu trúc báo cáo KLTN hợp lý khi thuyết trình</td>
                                <td class="text-center fw-bold">15%</td>
                            </tr>
                            <tr>
                                <td>Sự tương tác giữa SV và CBHD</td>
                                <td class="text-center fw-bold">10%</td>
                            </tr>
                            <tr>
                                <td>Sự tương tác giữa các thành viên nhóm</td>
                                <td class="text-center fw-bold">10%</td>
                            </tr>
                            <tr>
                                <td>Hoàn thành nội dung được phân công</td>
                                <td class="text-center fw-bold">5%</td>
                            </tr>
                            <tr>
                                <td>Thu nhận kết quả và xử lý số liệu</td>
                                <td class="text-center fw-bold">15%</td>
                            </tr>
                            <tr>
                                <td>Thảo luận nghiên cứu</td>
                                <td class="text-center fw-bold">15%</td>
                            </tr>
                            <tr>
                                <td>Tóm tắt kết quả nghiên cứu</td>
                                <td class="text-center fw-bold">5%</td>
                            </tr>
                            <tr>
                                <td>Kiến nghị</td>
                                <td class="text-center fw-bold">5%</td>
                            </tr>
                            <tr>
                                <td>Tài liệu tham khảo</td>
                                <td class="text-center fw-bold">5%</td>
                            </tr>
                            <tr>
                                <td>Chu tích hình ảnh, bảng biểu</td>
                                <td class="text-center fw-bold">5%</td>
                            </tr>
                            <tr>
                                <td>Chính tả, định dạng, thuật ngữ</td>
                                <td class="text-center fw-bold">5%</td>
                            </tr>
                            <tr class="table-warning">
                                <td class="fw-bold">TỔNG CỘNG</td>
                                <td class="text-center fw-bold">100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Lưu ý:</strong> Điểm tổng kết được tính theo thang điểm 10. Sinh viên cần đạt tối thiểu 5.0 điểm để được công nhận tốt nghiệp.
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
        
        // Load badge thông báo khi trang load
        loadThongBaoBadge();
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

    fetch("./getThongBaoDeTai")
        .then(response => response.json())
        .then(data => {
            if (data.success && data.thongbao && data.thongbao.trim() !== "") {
                const html = `
                    <div style="word-wrap: break-word; line-height: 1.6;">
                        ${data.thongbao}
                    </div>
                `;
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

function loadThongBaoBadge() {
    fetch("./getThongBaoDeTai")
        .then(response => response.json())
        .then(data => {
            if (data.success && data.thongbao && data.thongbao.trim() !== "") {
                // Nếu có thông báo, thêm badge vào nút
                const thongBaoBtn = document.querySelector("button[data-bs-target=\'#thongBaoModal\']");
                if (thongBaoBtn) {
                    thongBaoBtn.style.position = "relative";
                    const badge = document.createElement("span");
                    badge.className = "position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger";
                    badge.style.transform = "translate(-50%, -50%)";
                    badge.innerHTML = \'<i class="bi bi-exclamation-circle-fill"></i>\';
                    thongBaoBtn.appendChild(badge);
                }
            }
        })
        .catch(error => {
            console.error("Error loading badge:", error);
        });
}
</script>
';
?>
