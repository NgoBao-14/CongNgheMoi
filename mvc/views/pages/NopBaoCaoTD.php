<?php
$baocao = $data["baocao"];
echo'<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nộp Đề Cương Khóa Luận</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    body {
        background-color: #f0f7ff;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .header-icon {
        background-color: #ff6b6b;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    .page-title {
        color: #ff5722;
        font-weight: bold;
        font-size: 1.5rem;
    }
    .upload-area {
        border: 2px dashed #ccc;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        background-color: #f8f9fa;
        min-height: 200px;
        position: relative;
    }
    .upload-area:hover {
        border-color: #80bdff;
        background-color: #f1f8ff;
    }
    .upload-buttons {
        position: absolute;
        top: 10px;
        left: 10px;
    }
    .upload-icon {
        background-color: #7bc47f;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 5px;
    }
    .file-item {
        display: flex;
        align-items: center;
        padding: 10px;
        background-color: white;
        border-radius: 8px;
        margin-top: 20px;
    }
    .file-icon {
        color: #4285f4;
        margin-right: 10px;
    }
    .btn-save {
        background-color: #ff5722;
        color: white;
        border: none;
    }
    .btn-save:hover {
        background-color: #e64a19;
        color: white;
    }
    .btn-cancel {
        background-color: #7bc47f;
        color: white;
        border: none;
    }
    .btn-cancel:hover {
        background-color: #5aa15d;
        color: white;
    }
    .modal-header {
        background-color: #f8f9fa;
    }
    .modal-title {
        color: #ff5722;
    }
    .upload-option {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
        cursor: pointer;
    }
    .upload-option:hover {
        background-color: #f1f8ff;
        border-color: #80bdff;
    }
    .upload-option-icon {
        color: #4285f4;
        margin-right: 10px;
    }
</style>

</head>
<body>
    <div class="container">
        <div class="d-flex align-items-center mb-4">         
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="header-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div>
                        <h1 class="page-title mb-0">NỘP TIẾN ĐỘ ĐỀ TÀI</h1>
                    </div>
                </div>

                <hr>

                <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="mb-0 me-2">Thêm bài nộp</h5>
                    </div>

                    <div class="collapse show" id="collapseUpload">
                        <div class="mb-3">
                            <label class="form-label">Nộp tập tin</label>
                            <div class="text-end mb-2">
                                <small class="text-muted">Kích thước tối đa với một tập tin 10 MB, số lượng tập tin đính kèm tối đa 20</small>
                            </div>
                            <div class="upload-area">
                                <div class="upload-buttons">
                                    <button class="upload-icon" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                        <i class="bi bi-file-earmark"></i>
                                    </button>
                                    
                                </div>

                                <div class="d-flex flex-column h-100">';
                                    foreach ($baocao as $r) {
                                        $fileName = $r["DuongDan"];
                                        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                                        // Chọn icon theo loại file
                                        switch ($fileExt) {
                                            case 'pdf':
                                                $iconClass = 'bi bi-file-earmark-pdf text-danger';
                                                break;
                                            case 'doc':
                                            case 'docx':
                                                $iconClass = 'bi bi-file-earmark-word text-primary';
                                                break;
                                            default:
                                                $iconClass = 'bi bi-file-earmark-text';
                                        }

                                        echo '<div class="file-item d-flex align-items-center mb-2">
                                                <i class="' . $iconClass . ' file-icon me-2" style="font-size: 1.5rem;"></i>
                                                <a href="public/uploads/' . htmlspecialchars($fileName) . '" download>' . htmlspecialchars($fileName) . '</a>
                                            </div>';
                                    }
echo'                           </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST"  enctype="multipart/form-data" id="uploadForm">
                    <div class="mb-3">
                        <label class="form-label">Đính kèm</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="fileInput" name="fileBC" style="display: none;">
                            <button class="btn btn-outline-secondary" type="button" id="customFileBtn">Chọn tệp</button>
                            <input type="text" class="form-control" id="fileNameDisplay" placeholder="Không có tệp nào được chọn" readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start mt-4">
                        <button type="submit" class="btn btn-save me-2">
                            <i class="bi bi-save me-1"></i> Lưu những thay đổi
                        </button>
                        <button type="button" class="btn btn-cancel" onclick="location.reload()">
                            <i class="bi bi-x-circle me-1"></i> Hủy bỏ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>';
?>
<script>
    const fileInput = document.getElementById('fileInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const customFileBtn = document.getElementById('customFileBtn');
    const uploadForm = document.getElementById('uploadForm');

    customFileBtn.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if (file) {
            const allowedExts = ['doc', 'docx', 'pdf'];
            const maxSize = 10 * 1024 * 1024; // 10MB
            const fileExt = file.name.split('.').pop().toLowerCase();

            if (!allowedExts.includes(fileExt)) {
                alert('Chỉ chấp nhận file Word (.doc, .docx) hoặc PDF!');
                fileInput.value = '';
                fileNameDisplay.value = 'Không có tệp nào được chọn';
            } else if (file.size > maxSize) {
                alert('File quá lớn! Kích thước tối đa là 10MB.');
                fileInput.value = '';
                fileNameDisplay.value = 'Không có tệp nào được chọn';
            } else {
                fileNameDisplay.value = file.name;
            }
        } else {
            fileNameDisplay.value = 'Không có tệp nào được chọn';
        }
    });

    // Prevent form submission if no file is selected
    uploadForm.addEventListener('submit', (e) => {
        if (!fileInput.files || fileInput.files.length === 0) {
            e.preventDefault();
            alert('Vui lòng chọn một file để nộp!');
        }
    });
</script>