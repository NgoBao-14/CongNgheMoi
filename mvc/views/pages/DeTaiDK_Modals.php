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
                
                // Xác định màu và trạng thái dựa trên điểm
                let diemClass = "text-primary";
                let diemStatus = "";
                if (kq.TongDiem !== null) {
                    if (kq.TongDiem >= 8) {
                        diemClass = "text-success";
                        diemStatus = "Giỏi";
                    } else if (kq.TongDiem >= 6.5) {
                        diemClass = "text-info";
                        diemStatus = "Khá";
                    } else if (kq.TongDiem >= 5) {
                        diemClass = "text-warning";
                        diemStatus = "Trung bình";
                    } else {
                        diemClass = "text-danger";
                        diemStatus = "Không đạt";
                    }
                }
                
                let html = `
                    <div class="card border-0">
                        <div class="card-body">
                            <!-- Điểm tổng kết nổi bật -->
                            <div class="text-center mb-4 p-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px;">
                                <h6 class="text-muted mb-2">ĐIỂM TỔNG KẾT</h6>
                                <div class="display-3 fw-bold ${diemClass}">${kq.TongDiem !== null ? kq.TongDiem : "-"}<span class="fs-4">/10</span></div>
                                ${diemStatus ? `<span class="badge bg-${kq.TongDiem >= 5 ? (kq.TongDiem >= 8 ? "success" : (kq.TongDiem >= 6.5 ? "info" : "warning")) : "danger"} mt-2">${diemStatus}</span>` : ""}
                            </div>
                            
                            <!-- Thông tin giảng viên -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-person-badge text-primary me-2"></i>
                                    <strong>Giảng viên chấm:</strong>
                                    <span class="ms-2">${kq.TenGiangVien || "Chưa có thông tin"}</span>
                                </div>
                            </div>
                `;
                
                if (kq.ChiTietDiem && kq.ChiTietDiem.length > 0) {
                    html += `
                        <h6 class="mb-3 fw-bold"><i class="bi bi-list-check text-primary me-2"></i>Chi tiết điểm theo tiêu chí</h6>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="border-radius: 8px; overflow: hidden;">
                                <thead style="background: linear-gradient(135deg, #007dc9 0%, #0066a1 100%);">
                                    <tr>
                                        <th class="text-white" style="width: 50%;">Tiêu chí đánh giá</th>
                                        <th class="text-white text-center" style="width: 20%;">Tỷ trọng</th>
                                        <th class="text-white text-center" style="width: 15%;">Điểm</th>
                                        <th class="text-white text-center" style="width: 15%;">Điểm quy đổi</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    let tongDiemQuyDoi = 0;
                    kq.ChiTietDiem.forEach(function(ct, index) {
                        const diem = ct.Diem !== null && ct.Diem !== "" ? parseFloat(ct.Diem) : null;
                        const tyTrong = ct.TyTrong || 0;
                        const diemQuyDoi = diem !== null ? (diem * tyTrong / 100).toFixed(2) : "-";
                        if (diem !== null) tongDiemQuyDoi += parseFloat(diemQuyDoi);
                        
                        const rowClass = index % 2 === 0 ? "bg-light" : "";
                        const diemDisplay = diem !== null ? diem : "-";
                        const diemColor = diem !== null ? (diem >= 8 ? "text-success" : (diem >= 5 ? "text-primary" : "text-danger")) : "text-muted";
                        
                        html += `
                            <tr class="${rowClass}">
                                <td class="py-2">${ct.TenTieuChi}</td>
                                <td class="text-center py-2"><span class="badge bg-secondary">${tyTrong}%</span></td>
                                <td class="text-center py-2 fw-bold ${diemColor}">${diemDisplay}</td>
                                <td class="text-center py-2">${diemQuyDoi}</td>
                            </tr>
                        `;
                    });
                    
                    html += `
                                </tbody>
                                <tfoot style="background-color: #fff3cd;">
                                    <tr>
                                        <td class="fw-bold py-2">TỔNG CỘNG</td>
                                        <td class="text-center fw-bold py-2">100%</td>
                                        <td class="text-center py-2">-</td>
                                        <td class="text-center fw-bold py-2 ${diemClass}">${kq.TongDiem !== null ? kq.TongDiem : "-"}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    `;
                }
                
                html += `
                            <div class="alert alert-info mt-4 mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Lưu ý:</strong> Điểm tổng kết được tính theo thang điểm 10. Sinh viên cần đạt tối thiểu 5.0 điểm để được công nhận tốt nghiệp.
                            </div>
                        </div>
                    </div>
                `;
                contentDiv.innerHTML = html;
            } else {
                contentDiv.innerHTML = `
                    <div class="text-center py-5">
                        <i class="bi bi-clipboard-x text-muted" style="font-size: 4rem;"></i>
                        <h5 class="mt-3 text-muted">Chưa có kết quả chấm</h5>
                        <p class="text-muted">Giảng viên hướng dẫn chưa nhập điểm cho bạn.<br>Vui lòng quay lại sau.</p>
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
