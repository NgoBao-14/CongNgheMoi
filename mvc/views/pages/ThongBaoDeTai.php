<?php
require_once "./mvc/views/components/sidebarGV.php";
?>

<style>
    .table-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
    }
    
    .modal-large .modal-body {
        max-height: 80vh;
        overflow-y: auto;
    }
    
    .notification-content {
        background-color: #f8f9fa;
        border-left: 4px solid #0d6efd;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        min-height: 100px;
        word-wrap: break-word;
        white-space: pre-wrap;
    }
    
    .btn-edit {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .table-sticky {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .description-cell {
        max-height: 200px;
        overflow-y: auto;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    /* Modal thành công */
    .success-modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 15px;
        padding: 40px 50px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        text-align: center;
        min-width: 320px;
        animation: slideIn 0.3s ease-out;
    }

    .success-modal.hidden {
        display: none;
    }

    .success-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        animation: fadeIn 0.3s ease-out;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        margin: 0;
    }

    .success-modal-overlay.hidden {
        display: none;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translate(-50%, -60%);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .success-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 3px solid #51ff68ff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
        color: #51ff68ff;
    }

    .success-modal-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .success-modal-message {
        font-size: 14px;
        color: #666;
        margin-bottom: 30px;
    }

    .success-modal-buttons {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .success-modal-btn {
        padding: 10px 30px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel {
        background-color: #e5e7eb;
        color: #374151;
    }

    .btn-cancel:hover {
        background-color: #d1d5db;
    }

    .btn-confirm {
        background-color: #7c3aed;
        color: white;
    }

    .btn-confirm:hover {
        background-color: #6d28d9;
    }
</style>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Tạo thông báo cho đề tài</h3>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($data['dsDeTai'])): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-3" style="width: 5%">STT</th>
                                    <th class="px-3" style="width: 25%">Tên đề tài</th>
                                    <th class="px-3" style="width: 25%">Mô tả</th>
                                    <th class="px-3" style="width: 25%">Yêu cầu</th>
                                    <th class="px-3 text-center" style="width: 20%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['dsDeTai'] as $key => $detai): ?>
                                    <tr>
                                        <td class="px-3"><?= $key + 1 ?></td>
                                        <td class="px-3"><?= htmlspecialchars($detai['TenDeTai']) ?></td>
                                        <td class="px-3">
                                            <div class="description-cell"><?= htmlspecialchars($detai['MoTa']) ?></div>
                                        </td>
                                        <td class="px-3">
                                            <div class="description-cell"><?= htmlspecialchars($detai['YeuCau']) ?></div>
                                        </td>
                                        <td class="px-3 text-center">
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#thongBaoModal" onclick="loadThongBao(<?= $detai['IDDeTai'] ?>, '<?= htmlspecialchars($detai['TenDeTai'], ENT_QUOTES) ?>', '<?= htmlspecialchars($detai['ThongBao'] ?? '', ENT_QUOTES) ?>')">
                                                <i class="fas fa-edit"></i> Tạo thông báo
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-info-circle text-muted" style="font-size: 2rem;"></i>
                        <p class="mt-2 text-muted">Không có đề tài nào để tạo thông báo</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Modal Thông báo -->
<div class="modal fade modal-large" id="thongBaoModal" tabindex="-1" aria-labelledby="thongBaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="thongBaoModalLabel">Tạo thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="thongBaoForm">
                    <input type="hidden" id="IDDeTai" name="IDDeTai">
                    
                    <div class="mb-3">
                        <label class="form-label"><strong>Tên đề tài:</strong></label>
                        <div id="tenDeTai" class="form-control" style="background-color: #f8f9fa; border: none;"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><strong>Thông báo trước đó:</strong></label>
                        <div id="thongBaoCu" class="notification-content"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="thongBaoMoi" class="form-label"><strong>Ghi thông báo mới:</strong></label>
                        <textarea class="form-control" id="thongBaoMoi" name="ThongBao" rows="5" placeholder="Nhập thông báo mới..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="luu()">
                    <i class="fas fa-save"></i> Lưu thông báo
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thành công -->
<div id="successModalOverlay" class="success-modal-overlay hidden"></div>
<div id="successModal" class="success-modal hidden">
    <div class="success-icon">
        <i class="fas fa-check"></i>
    </div>
    <div class="success-modal-title">Tạo thông báo thành công!</div>
    <!-- <div class="success-modal-message">Tạo thông báo thành công!</div> -->
</div>

<script>
    function loadThongBao(idDeTai, tenDeTai, thongBaoCu) {
        document.getElementById('IDDeTai').value = idDeTai;
        document.getElementById('tenDeTai').textContent = tenDeTai;
        document.getElementById('thongBaoMoi').value = '';
        
        // Hiển thị thông báo cũ
        if (thongBaoCu && thongBaoCu.trim() !== '') {
            document.getElementById('thongBaoCu').textContent = thongBaoCu;
        } else {
            document.getElementById('thongBaoCu').innerHTML = '<em style="color: #999;">Không có thông báo cũ</em>';
        }
    }
    
    function luu() {
        const IDDeTai = document.getElementById('IDDeTai').value;
        const ThongBao = document.getElementById('thongBaoMoi').value;
        
        if (!IDDeTai) {
            alert('Lỗi: Không tìm thấy đề tài');
            return;
        }
        
        const formData = new FormData();
        formData.append('btnCapNhat', 1);
        formData.append('IDDeTai', IDDeTai);
        formData.append('ThongBao', ThongBao);
        
        fetch('/CongNgheMoi/GiangVien/ThongBaoDeTai', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Đóng modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('thongBaoModal'));
                modal.hide();
                
                // Hiển thị modal thành công
                showSuccessModal();
                
                // Tự động đóng modal thành công sau 0.5 giây và refresh trang
                setTimeout(() => {
                    closeSuccessModal();
                    location.reload();
                }, 500);
            } else {
                alert('Lưu thông báo thất bại: ' + (data.message || 'Vui lòng thử lại'));
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại.');
        });
    }

    function showSuccessModal() {
        document.getElementById('successModal').classList.remove('hidden');
        document.getElementById('successModalOverlay').classList.remove('hidden');
    }

    function closeSuccessModal() {
        document.getElementById('successModal').classList.add('hidden');
        document.getElementById('successModalOverlay').classList.add('hidden');
    }
</script>
