<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
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
    <div class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Quản lý khóa luận</span>
    </div>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <h5 class="d-block">Trưởng khoa</h5>
        </div>
        </div>

    <div>
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <!-- Bảng điều khiển -->
        <li class="nav-item">
            <a href="./" class="nav-link ative">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Bảng điều khiển</p>
            </a>
        </li>
        <!-- Đề xuất đề tài  -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/DXDeTai" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Duyệt đề tài</p>
            </a>
        </li>

        <!-- Danh sách đăng ký -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/DSDeTai" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Danh sách đề tài</p>
            </a>
        </li>

        <!-- Danh sách đề tài đã đăng ký -->
        <li class="nav-item">
            <a href="./DiemKhoaLuanCacNhom" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>Điểm khóa luận</p>
            </a>
        </li>

        <!-- Hội đồng bảo vệ -->
        <li class="nav-item">
            <a href="/CongNgheMoi/TruongKhoa/HoiDongBaoVe" class="nav-link active">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Hội đồng bảo vệ</p>
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
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống quản lý khóa luận - Chọn hội đồng chấm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
        }

        body {
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            background: white;
            /* border-radius: 15px; */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            /* margin: 0px auto; */
            max-width: 1200px;
            overflow: hidden;
        }

        .header-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 2rem;
            position: relative;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,0 1000,0 1000,100"/></svg>');
        }

        .info-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .info-item i {
            width: 20px;
            margin-right: 10px;
            color: #ffd700;
            margin-top: 2px;
        }

        .info-label {
            font-weight: 600;
            margin-right: 8px;
            min-width: 140px;
            flex-shrink: 0;
        }

        .info-value {
            color: #e8f4f8;
            flex: 1;
        }

        .group-members {
            margin-top: 0.5rem;
        }

        .member-row {
            display: flex;
            align-items: center;
            margin-bottom: 0.4rem;
            padding: 0.3rem 0.8rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            border-left: 3px solid #ffd700;
        }

        .member-name {
            font-weight: 500;
            margin-right: 1rem;
            min-width: 120px;
        }

        .member-class {
            font-size: 0.9rem;
            margin-right: 1rem;
            color: #b8e6ff;
        }

        .member-id {
            font-size: 0.85rem;
            font-family: 'Courier New', monospace;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.1rem 0.4rem;
            border-radius: 4px;
        }

        .description-text {
            line-height: 1.6;
            text-align: justify;
            margin-top: 0.5rem;
        }

        .committee-section {
            padding: 2rem;
        }

        .section-title {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, var(--secondary-color), var(--success-color));
            border-radius: 2px;
        }

        .committee-column {
            background: var(--light-bg);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .committee-column::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary-color), var(--success-color));
        }

        /* .committee-column:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: var(--secondary-color);
        } */

        .column-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .column-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .suggest-btn {
            background: linear-gradient(135deg, var(--secondary-color), #5dade2);
            border: none;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(52, 152, 219, 0.3);
        }

        .suggest-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
            background: linear-gradient(135deg, #5dade2, var(--secondary-color));
        }

        .search-btn {
            background: linear-gradient(135deg, var(--success-color), #58d68d);
            border: none;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(39, 174, 96, 0.3);
        }

        .search-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.4);
            background: linear-gradient(135deg, #58d68d, var(--success-color));
        }

        .search-container {
            margin-bottom: 1rem;
            display: none;
        }

        .search-container.active {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .search-input {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .member-item {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .member-item:hover {
            border-color: var(--secondary-color);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.15);
            transform: translateX(5px);
        }

        .member-item.selected {
            background: linear-gradient(135deg, #e8f6f3, #d5f3ec);
            border-color: var(--success-color);
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.2);
        }

        .member-item.selected::before {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            color: var(--success-color);
            font-size: 0.9rem;
        }

        .member-item.hidden {
            display: none;
        }

        .member-name {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .member-department {
            font-size: 0.9rem;
            color: #6c757d;
            font-style: italic;
        }

        .no-results {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 2rem;
            display: none;
        }

        .no-results.show {
            display: block;
        }

        .confirm-section {
            background: var(--light-bg);
            padding: 2rem;
            text-align: center;
        }

        .confirm-btn {
            background: linear-gradient(135deg, var(--success-color), #58d68d);
            border: none;
            color: white;
            padding: 1rem 3rem;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(39, 174, 96, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .confirm-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(39, 174, 96, 0.4);
            background: linear-gradient(135deg, #58d68d, var(--success-color));
        }

        .confirm-btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .selected-count {
            background: var(--warning-color);
            color: white;
            border-radius: 15px;
            padding: 0.2rem 0.6rem;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 10px;
                border-radius: 10px;
            }
            
            .header-section {
                padding: 1.5rem;
            }
            
            .committee-section {
                padding: 1rem;
            }
            
            .member-item:hover {
                transform: none;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.3rem;
            }

            .suggest-btn, .search-btn {
                font-size: 0.8rem;
                padding: 0.3rem 0.8rem;
            }

            .member-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.2rem;
            }

            .member-name, .member-class, .member-id {
                min-width: auto;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-label {
                min-width: auto;
                margin-bottom: 0.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="main-container">
            <!-- Header Section -->
            <div class="header-section">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center mb-4">
                            Chọn hội đồng chấm khóa luận tốt nghiệp
                        </h1>
                        <div class="info-card">
                            <h5 class="mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Thông tin đề tài
                            </h5>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Thông tin cơ bản -->
                                    <div class="info-item">
                                        <span class="info-label">Tên đề tài:</span>
                                        <span class="info-value">Ứng dụng quản lý khóa luận tốt nghiệp</span>
                                    </div>
                                    
                                    <div class="info-item">
                                        <span class="info-label">Nhóm thực hiện:</span>
                                        <div class="info-value">
                                            <div class="group-members">
                                                <div class="member-row">
                                                    <span class="member-name">Trần Văn Tài</span>
                                                    <span class="member-class">DHTTT16A</span>
                                                    <span class="member-id">2016603001</span>
                                                </div>
                                                <div class="member-row">
                                                    <span class="member-name">Nguyễn Thị Lan</span>
                                                    <span class="member-class">DHTTT16A</span>
                                                    <span class="member-id">2016603002</span>
                                                </div>
                                                <div class="member-row">
                                                    <span class="member-name">Lê Văn Nam</span>
                                                    <span class="member-class">DHTTT16B</span>
                                                    <span class="member-id">2016603045</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <span class="info-label">Giảng viên hướng dẫn:</span>
                                        <span class="info-value">TS. Lê Văn C</span>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <!-- Mô tả đề tài -->
                                    <div class="info-item">
                                        <span class="info-label">Mô tả đề tài:</span>
                                        <div class="info-value">
                                            <div class="description-text">
                                                Xây dựng hệ thống ứng dụng web quản lý khóa luận tốt nghiệp cho khoa Công nghệ thông tin. 
                                                Hệ thống hỗ trợ quản lý toàn bộ quy trình từ đăng ký đề tài, phân công hướng dẫn, 
                                                theo dõi tiến độ thực hiện, đến việc tổ chức bảo vệ và chấm điểm. 
                                                Ứng dụng được phát triển bằng công nghệ React.js cho frontend và Node.js cho backend, 
                                                sử dụng cơ sở dữ liệu MySQL để lưu trữ thông tin.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Committee Selection Section -->
            <div class="committee-section">
                <h2 class="section-title">
                    Chọn hội đồng chấm
                </h2>

                <div class="row">
                    <!-- Chairman Column -->
                    <div class="col-lg-4 col-md-12">
                        <div class="committee-column fade-in">
                            <div class="column-header">
                                <h5 class="column-title">
                                    Chủ tịch
                                    <span class="selected-count" id="chairman-count">0/1</span>
                                </h5>
                                <div class="action-buttons">
                                    <button class="btn suggest-btn" onclick="suggestMembers('chairman')">
                                        <i class="fas fa-lightbulb me-1"></i>
                                        Gợi ý
                                    </button>
                                    <button class="btn search-btn" onclick="toggleSearch('chairman')">
                                        <i class="fas fa-search me-1"></i>
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
                            <div class="search-container" id="chairman-search">
                                <input type="text" class="search-input" placeholder="Tìm kiếm theo tên hoặc chuyên ngành..." 
                                      onkeyup="searchMembers('chairman', this.value)">
                            </div>
                            <div id="chairman-list">
                                <div class="member-item" data-role="chairman" data-id="1">
                                    <div class="member-name">Nguyễn Văn A</div>
                                    <div class="member-department">TS - Công nghệ thông tin</div>
                                </div>
                                <div class="member-item" data-role="chairman" data-id="2">
                                    <div class="member-name">Trần Thị B</div>
                                    <div class="member-department">ThS - Mạng máy tính</div>
                                </div>
                                <div class="member-item" data-role="chairman" data-id="3">
                                    <div class="member-name">Lê Văn C</div>
                                    <div class="member-department">CN - Phần mềm</div>
                                </div>
                                <div class="member-item" data-role="chairman" data-id="4">
                                    <div class="member-name">Phạm Thị D</div>
                                    <div class="member-department">ThS - Phần mềm</div>
                                </div>
                            </div>
                            <div class="no-results" id="chairman-no-results">
                                <p>Không tìm thấy thành viên phù hợp</p>
                            </div>
                        </div>
                    </div>

                    <!-- Secretary Column -->
                    <div class="col-lg-4 col-md-12">
                        <div class="committee-column fade-in" style="animation-delay: 0.2s">
                            <div class="column-header">
                                <h5 class="column-title">
                                    Thư ký
                                    <span class="selected-count" id="secretary-count">0/1</span>
                                </h5>
                                <div class="action-buttons">
                                    <button class="btn suggest-btn" onclick="suggestMembers('secretary')">
                                        <i class="fas fa-lightbulb me-1"></i>
                                        Gợi ý
                                    </button>
                                    <button class="btn search-btn" onclick="toggleSearch('secretary')">
                                        <i class="fas fa-search me-1"></i>
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
                            <div class="search-container" id="secretary-search">
                                <input type="text" class="search-input" placeholder="Tìm kiếm theo tên hoặc chuyên ngành..." 
                                    onkeyup="searchMembers('secretary', this.value)">
                            </div>
                            <div id="secretary-list">
                                <div class="member-item" data-role="secretary" data-id="5">
                                    <div class="member-name">Nguyễn Văn A</div>
                                    <div class="member-department">TS - Công nghệ thông tin</div>
                                </div>
                                <div class="member-item" data-role="secretary" data-id="6">
                                    <div class="member-name">Trần Thị B</div>
                                    <div class="member-department">ThS - Mạng máy tính</div>
                                </div>
                                <div class="member-item" data-role="secretary" data-id="7">
                                    <div class="member-name">Lê Văn C</div>
                                    <div class="member-department">CN - Phần mềm</div>
                                </div>
                                <div class="member-item" data-role="secretary" data-id="8">
                                    <div class="member-name">Phạm Thị D</div>
                                    <div class="member-department">ThS - Phần mềm</div>
                                </div>
                            </div>
                            <div class="no-results" id="secretary-no-results">
                                <p>Không tìm thấy thành viên phù hợp</p>
                            </div>
                        </div>
                    </div>

                    <!-- Reviewer Column -->
                    <div class="col-lg-4 col-md-12">
                        <div class="committee-column fade-in" style="animation-delay: 0.4s">
                            <div class="column-header">
                                <h5 class="column-title">
                                    Phản biện
                                    <span class="selected-count" id="reviewer-count">0/1</span>
                                </h5>
                                <div class="action-buttons">
                                    <button class="btn suggest-btn" onclick="suggestMembers('reviewer')">
                                        <i class="fas fa-lightbulb me-1"></i>
                                        Gợi ý
                                    </button>
                                    <button class="btn search-btn" onclick="toggleSearch('reviewer')">
                                        <i class="fas fa-search me-1"></i>
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
                            <div class="search-container" id="reviewer-search">
                                <input type="text" class="search-input" placeholder="Tìm kiếm theo tên hoặc chuyên ngành..." 
                                       onkeyup="searchMembers('reviewer', this.value)">
                            </div>
                            <div id="reviewer-list">
                                <div class="member-item" data-role="reviewer" data-id="9">
                                    <div class="member-name">Nguyễn Văn A</div>
                                    <div class="member-department">TS - Công nghệ thông tin</div>
                                </div>
                                <div class="member-item" data-role="reviewer" data-id="10">
                                    <div class="member-name">Trần Thị B</div>
                                    <div class="member-department">ThS - Mạng máy tính</div>
                                </div>
                                <div class="member-item" data-role="reviewer" data-id="11">
                                    <div class="member-name">Lê Văn C</div>
                                    <div class="member-department">CN - Phần mềm</div>
                                </div>
                                <div class="member-item" data-role="reviewer" data-id="12">
                                    <div class="member-name">Phạm Thị D</div>
                                    <div class="member-department">ThS - Phần mềm</div>
                                </div>
                            </div>
                            <div class="no-results" id="reviewer-no-results">
                                <p>Không tìm thấy thành viên phù hợp</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Section -->
            <div class="confirm-section">
                <button class="btn confirm-btn" id="confirmBtn" onclick="confirmCommittee()" disabled>
                    Xác nhận hội đồng
                </button>
                <div class="mt-3">
                    <small class="text-muted">Vui lòng chọn đủ 3 thành viên hội đồng để tiếp tục</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // State management
        let selectedMembers = {
            chairman: null,
            secretary: null,
            reviewer: null
        };

        // Initialize event listeners
        document.addEventListener('DOMContentLoaded', function() {
            initializeEventListeners();
            updateConfirmButton();
        });

        function initializeEventListeners() {
            // Add click listeners to all member items
            document.querySelectorAll('.member-item').forEach(item => {
                item.addEventListener('click', function() {
                    selectMember(this);
                });
            });
        }

        function selectMember(element) {
            const role = element.dataset.role;
            const memberId = element.dataset.id;
            const memberName = element.querySelector('.member-name').textContent;
            
            // Remove previous selection for this role
            document.querySelectorAll(`[data-role="${role}"]`).forEach(item => {
                item.classList.remove('selected');
            });
            
            // Add selection to clicked element
            element.classList.add('selected');
            
            // Update state
            selectedMembers[role] = {
                id: memberId,
                name: memberName,
                department: element.querySelector('.member-department').textContent
            };
            
            // Update UI
            updateRoleCount(role);
            updateConfirmButton();
        }

        function updateRoleCount(role) {
            const countElement = document.getElementById(`${role}-count`);
            const count = selectedMembers[role] ? 1 : 0;
            countElement.textContent = `${count}/1`;
            
            if (count === 1) {
                countElement.style.background = '#27ae60';
            } else {
                countElement.style.background = '#f39c12';
            }
        }

        function updateConfirmButton() {
            const confirmBtn = document.getElementById('confirmBtn');
            const selectedCount = Object.values(selectedMembers).filter(member => member !== null).length;
            
            if (selectedCount === 3) {
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Xác nhận hội đồng';
            } else {
                confirmBtn.disabled = true;
                confirmBtn.innerHTML = `<i class="fas fa-clock me-2"></i>Cần chọn thêm ${3 - selectedCount} thành viên`;
            }
        }

        function toggleSearch(role) {
            const searchContainer = document.getElementById(`${role}-search`);
            const searchInput = searchContainer.querySelector('.search-input');
            
            if (searchContainer.classList.contains('active')) {
                // Hide search
                searchContainer.classList.remove('active');
                searchInput.value = '';
                // Reset all items visibility
                document.querySelectorAll(`[data-role="${role}"]`).forEach(item => {
                    item.classList.remove('hidden');
                });
                document.getElementById(`${role}-no-results`).classList.remove('show');
            } else {
                // Show search
                searchContainer.classList.add('active');
                setTimeout(() => {
                    searchInput.focus();
                }, 300);
            }
        }

        function searchMembers(role, searchTerm) {
            const memberItems = document.querySelectorAll(`[data-role="${role}"]`);
            const noResultsElement = document.getElementById(`${role}-no-results`);
            let visibleCount = 0;
            
            searchTerm = searchTerm.toLowerCase().trim();
            
            memberItems.forEach(item => {
                const memberName = item.querySelector('.member-name').textContent.toLowerCase();
                const memberDept = item.querySelector('.member-department').textContent.toLowerCase();
                
                if (searchTerm === '' || memberName.includes(searchTerm) || memberDept.includes(searchTerm)) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });
            
            // Show/hide no results message
            if (visibleCount === 0 && searchTerm !== '') {
                noResultsElement.classList.add('show');
            } else {
                noResultsElement.classList.remove('show');
            }
        }

        function suggestMembers(role) {
            // Danh sách thành viên mẫu để random
            const memberPool = [
                { name: "Nguyễn Văn A", dept: "TS - Công nghệ thông tin" },
                { name: "Trần Thị B", dept: "ThS - Mạng máy tính" },
                { name: "Lê Văn C", dept: "CN - Phần mềm" },
                { name: "Phạm Thị D", dept: "ThS - Phần mềm" },
                { name: "Hoàng Văn E", dept: "TS - Trí tuệ nhân tạo" },
                { name: "Vũ Thị F", dept: "ThS - An toàn thông tin" },
                { name: "Đặng Văn G", dept: "CN - Hệ thống thông tin" },
                { name: "Bùi Thị H", dept: "TS - Khoa học máy tính" },
                { name: "Phan Văn I", dept: "ThS - Công nghệ phần mềm" },
                { name: "Mai Thị K", dept: "CN - Mạng và viễn thông" }
            ];
            
            const listElement = document.getElementById(`${role}-list`);
            
            // Hide search if active
            const searchContainer = document.getElementById(`${role}-search`);
            if (searchContainer.classList.contains('active')) {
                searchContainer.classList.remove('active');
                searchContainer.querySelector('.search-input').value = '';
            }
            
            // Thêm loading effect
            listElement.style.opacity = '0.5';
            listElement.style.pointerEvents = 'none';
            
            // Simulate loading time
            setTimeout(() => {
                // Shuffle và chọn 4 thành viên ngẫu nhiên
                const shuffled = memberPool.sort(() => 0.5 - Math.random());
                const selectedPool = shuffled.slice(0, 4);
                
                // Tạo HTML mới cho danh sách
                let newHTML = '';
                selectedPool.forEach((member, index) => {
                    const memberId = `${role}_${Date.now()}_${index}`;
                    newHTML += `
                        <div class="member-item" data-role="${role}" data-id="${memberId}">
                            <div class="member-name">${member.name}</div>
                            <div class="member-department">${member.dept}</div>
                        </div>
                    `;
                });
                
                // Cập nhật danh sách
                listElement.innerHTML = newHTML;
                
                // Thêm lại event listeners cho các item mới
                listElement.querySelectorAll('.member-item').forEach(item => {
                    item.addEventListener('click', function() {
                        selectMember(this);
                    });
                    
                    // Thêm hover effects
                    item.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateX(5px)';
                    });
                    
                    item.addEventListener('mouseleave', function() {
                        if (!this.classList.contains('selected')) {
                            this.style.transform = 'translateX(0)';
                        }
                    });
                });
                
                // Reset selection cho role này
                selectedMembers[role] = null;
                updateRoleCount(role);
                updateConfirmButton();
                
                // Restore normal state
                listElement.style.opacity = '1';
                listElement.style.pointerEvents = 'auto';
                
                // Thêm fade-in effect cho danh sách mới
                listElement.querySelectorAll('.member-item').forEach((item, index) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        item.style.transition = 'all 0.3s ease';
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, index * 100);
                });
                
            }, 800); // Loading time
        }

        function confirmCommittee() {
            // Show loading state
            const confirmBtn = document.getElementById('confirmBtn');
            const originalContent = confirmBtn.innerHTML;
            confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
            confirmBtn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                // Reset button
                confirmBtn.innerHTML = originalContent;
                confirmBtn.disabled = false;
                
                // Show success modal or toast
                showSuccessModal();
            }, 2000);
        }

        function showSuccessModal() {
            const modalHtml = `
                <div class="modal fade" id="successModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Thành công!
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <h6>Hội đồng chấm khóa luận đã được xác nhận:</h6>
                                <ul class="list-unstyled mt-3">
                                    <li class="mb-2">
                                        <i class="fas fa-crown text-warning me-2"></i>
                                        <strong>Chủ tịch:</strong> ${selectedMembers.chairman?.name || 'Chưa chọn'}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-pen text-info me-2"></i>
                                        <strong>Thư ký:</strong> ${selectedMembers.secretary?.name || 'Chưa chọn'}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-search text-success me-2"></i>
                                        <strong>Phản biện:</strong> ${selectedMembers.reviewer?.name || 'Chưa chọn'}
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                                    <i class="fas fa-check me-1"></i>
                                    Đóng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
            
            // Remove modal from DOM after hiding
            document.getElementById('successModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        }

        function showToast(message, type = 'info') {
            const toastHtml = `
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'}-circle me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            const toastContainer = document.querySelector('.toast-container');
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);
            
            const toastElement = toastContainer.lastElementChild;
            const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
            toast.show();
            
            // Remove toast from DOM after hiding
            toastElement.addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        }

        function getRoleDisplayName(role) {
            const roleNames = {
                chairman: 'Chủ tịch',
                secretary: 'Thư ký',
                reviewer: 'Phản biện'
            };
            return roleNames[role] || role;
        }

        // Add some interactive effects
        document.querySelectorAll('.member-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
            });
            
            item.addEventListener('mouseleave', function() {
                if (!this.classList.contains('selected')) {
                    this.style.transform = 'translateX(0)';
                }
            });
        });
    </script>
</body>
</html>