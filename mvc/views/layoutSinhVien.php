<?php
    if($_SESSION["PQ"] != 2){
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Bạn không có quyền truy cập'];
        header("location: " . base_url('/'));
        exit;
    }
    
    // Always use absolute path for assets
    $basePath = '/CongNgheMoi/public/';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng Đăng Ký Học Phần Sinh Viên - IUH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/sidebar.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/sinhvien.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/xemdetai.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/loading.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/toast.css">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .main-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Dashboard specific styles */
        .welcome-section {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }
        .welcome-section h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.25rem 0;
        }
        .welcome-section p {
            font-size: 0.95rem;
            margin: 0;
            opacity: 0.9;
        }
        
        .status-section {
            margin-bottom: 2rem;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 1rem 0;
        }
        .thesis-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .thesis-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        .thesis-title {
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.4;
            color: #111827;
            margin-bottom: 1.5rem;
        }
        .thesis-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }
        @media (max-width: 992px) {
            .thesis-grid {
                grid-template-columns: 1fr;
            }
        }
        .thesis-cell .thesis-meta-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        .thesis-meta-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1f2937;
        }
        .status-badge-inline {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #dbeafe;
            color: #1e40af;
        }
        .status-badge-approved { background: #d1fae5; color: #065f46; }
        .status-badge-pending { background: #fee2e2; color: #991b1b; }
        .status-badge-processing { background: #dbeafe; color: #1e40af; }
        
        .not-registered {
            text-align: center;
            padding: 2.5rem;
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 12px;
        }
        .not-registered p {
            color: #92400e;
            font-weight: 500;
            margin: 0;
            font-size: 1rem;
        }
        
        .message-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .message-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .message-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }
        .message-empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto;
            color: #9ca3af;
            font-size: 2rem;
        }
        .message-empty-state {
            text-align: center;
            padding: 2rem 1rem;
        }
        .message-empty-state h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        .message-empty-state p {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
        }
        
        @media (max-width: 768px) {
            .thesis-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <button class="mobile-menu-btn" onclick="toggleMobileSidebar()">
        <i class="bi bi-list" style="font-size: 1.5rem;"></i>
    </button>
    
    <div class="main-container">
        <!-- Sidebar Component -->
        <?php 
        // Always use absolute path from root
        if(file_exists("./mvc/views/blocks/sidebarSV.php")) {
            include "./mvc/views/blocks/sidebarSV.php";
        } else if(file_exists("blocks/sidebarSV.php")) {
            include "blocks/sidebarSV.php";
        }
        ?>

        <!-- Main Content -->
        <div class="main-content">
            <?php 
            // If Page is set, load the page content
            if(isset($data['Page']) && $data['Page'] != '') {
                require_once "./mvc/views/pages/".$data["Page"].".php";
            } else {
                // Dashboard content
                ?>
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <h2>Xin chào, <?php echo htmlspecialchars($_SESSION['ten']); ?></h2>
                    <p>Cổng Đăng Ký Đề Tài Khóa Luận Tốt Nghiệp</p>
                </div>

                <!-- Status Section - Trạng Thái Khóa Luận -->
                <div class="status-section">
                    <h3 class="section-title">Trạng Thái Khóa Luận</h3>
                    <div id="statusContent">
                        <!-- Will be filled by JS -->
                    </div>
                </div>

                <!-- Messages from GVHD Section -->
                <div class="message-section">
                    <div class="message-header">
                        <h3>Thông Báo Từ Giảng Viên Hướng Dẫn</h3>
                    </div>
                    <div id="messageContainer">
                        <!-- Will be filled by JS -->
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $basePath; ?>js/toast.js"></script>
    <script src="<?php echo $basePath; ?>js/loading.js"></script>
    
    <?php if(!isset($data['Page']) || $data['Page'] == ''): ?>
    <!-- Dashboard specific scripts -->
    <script>
        console.log('Dashboard scripts loaded');
        
        function loadStatusAndMessages() {
            console.log('loadStatusAndMessages called');
            loadThesisData();
            loadThongBaoGVHD();
        }

        function loadThesisData() {
            const statusDiv = document.getElementById('statusContent');
            
            fetch('/CongNgheMoi/SinhVien/getTTDeTaiForDashboard')
                .then(response => response.json())
                .then(data => {
                    console.log('Thesis data:', data);
                    if (data.success && data.data && data.data.TenDeTai) {
                        displayThesisInfo(data.data);
                    } else {
                        statusDiv.innerHTML = `
                            <div class="not-registered">
                                <p>Bạn chưa đăng ký đề tài</p>
                            </div>
                        `;
                    }
                })
                .catch((error) => {
                    console.error('Error loading thesis:', error);
                    statusDiv.innerHTML = `
                        <div class="not-registered">
                            <p>Bạn chưa đăng ký đề tài</p>
                        </div>
                    `;
                });
        }

        function displayThesisInfo(thesis) {
            const statusDiv = document.getElementById('statusContent');
            
            // Always show "Đã đăng ký" status for registered students
            let badgeClass = 'status-badge-approved';
            let statusText = 'Đã đăng ký';

            const html = `
                <div class="thesis-card">
                    <div class="thesis-label">Tên đề tài</div>
                    <div class="thesis-title">${escapeHtml(thesis.TenDeTai || '')}</div>
                    <div class="thesis-grid">
                        <div class="thesis-cell">
                            <div class="thesis-meta-label">Giảng viên hướng dẫn</div>
                            <div class="thesis-meta-value">${escapeHtml(thesis.GiangVienHuongDan || '')}</div>
                        </div>
                        <div class="thesis-cell">
                            <div class="thesis-meta-label">Email giảng viên</div>
                            <div class="thesis-meta-value">${escapeHtml(thesis.Email || 'Chưa có thông tin')}</div>
                        </div>
                        <div class="thesis-cell">
                            <div class="thesis-meta-label">Trạng thái</div>
                            <div class="thesis-meta-value"><span class="status-badge-inline ${badgeClass}">${escapeHtml(statusText)}</span></div>
                        </div>
                    </div>
                </div>`;
            statusDiv.innerHTML = html;
        }

        function loadThongBaoGVHD() {
            const container = document.getElementById('messageContainer');
            
            fetch('/CongNgheMoi/SinhVien/getThongBaoDeTai')
                .then(response => response.json())
                .then(data => {
                    console.log('Notification data:', data);
                    if (data.success && data.thongbao && data.thongbao.trim()) {
                        const messageLines = data.thongbao.split('\n').filter(line => line.trim());
                        let html = '';
                        messageLines.forEach((line) => {
                            html += `
                                <div style="background: #f9fafb; padding: 1rem; border-radius: 8px; border-left: 3px solid #2563eb; margin-bottom: 0.75rem;">
                                    <div style="color: #374151; font-size: 0.95rem; line-height: 1.5;">${escapeHtml(line)}</div>
                                </div>
                            `;
                        });
                        container.innerHTML = html;
                    } else {
                        container.innerHTML = `
                            <div class="message-empty-state">
                                <div class="message-empty-icon">💬</div>
                                <h4>Chưa có thông báo mới</h4>
                                <p>Hiện tại không có thông báo mới từ giảng viên hướng dẫn.</p>
                            </div>`;
                    }
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    container.innerHTML = `
                        <div class="message-empty-state">
                            <div class="message-empty-icon">💬</div>
                            <h4>Chưa có thông báo mới</h4>
                            <p>Hiện tại không có thông báo mới từ giảng viên hướng dẫn.</p>
                        </div>`;
                });
        }

        function escapeHtml(text) {
            if (!text) return '';
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }
    </script>
    <?php endif; ?>
    
    <script src="<?php echo $basePath; ?>js/sidebar.js"></script>
</body>
</html>
