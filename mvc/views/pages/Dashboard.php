<?php
require_once "./mvc/views/components/sidebarAdmin.php";
$dt = json_decode($data['khoa'], true);
$detaikhoa = json_decode($data['detaikhoa'], true);
$sinhvien = $data['sinhvien'];
$giangvien = $data['giangvien'];
$detai = $data['detai'];
$nhom = $data['nhom'];

echo '
<div class="content-wrapper">
    <style>
        .stats-card {
            background: white;
            border-radius: 1rem;
            padding: 1.75rem;
            border: 1px solid #E2E8F0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
            border-color: #CBD5E1;
        }
        
        .stats-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }
        
        .stats-card.blue::before { background: #3B82F6; }
        .stats-card.green::before { background: #10B981; }
        .stats-card.orange::before { background: #F59E0B; }
        .stats-card.purple::before { background: #8B5CF6; }
        
        .stats-icon {
            width: 56px;
            height: 56px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .stats-icon.blue { background: #EFF6FF; color: #3B82F6; }
        .stats-icon.green { background: #ECFDF5; color: #10B981; }
        .stats-icon.orange { background: #FFFBEB; color: #F59E0B; }
        .stats-icon.purple { background: #F5F3FF; color: #8B5CF6; }
        
        .stats-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }
        
        .stats-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: #0F172A;
            line-height: 1;
        }
        
        .page-header {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #E2E8F0;
        }
        
        .chart-container {
            background: white;
            border-radius: 1rem;
            border: 1px solid #E2E8F0;
            overflow: hidden;
        }
        
        .chart-header {
            padding: 1.5rem;
            border-bottom: 1px solid #E2E8F0;
        }
        
        .quick-action {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid #E2E8F0;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .quick-action:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
            border-color: #4F46E5;
        }
        
        .quick-action-icon {
            width: 64px;
            height: 64px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin: 0 auto 1rem;
        }
        
        .section-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }
    </style>

    <div class="container-fluid p-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="h3 fw-bold mb-2" style="color: #0F172A;">Dashboard</h1>
                    <p class="text-muted mb-0">Tổng quan hệ thống quản lý khóa luận tốt nghiệp</p>
                </div>
                <div class="text-end">
                    <div class="text-muted" style="font-size: 0.875rem;">
                        <i class="fas fa-calendar me-2"></i>' . date('d/m/Y') . '
                    </div>
                    <div class="text-muted mt-1" style="font-size: 0.875rem;">
                        <i class="fas fa-clock me-2"></i>' . date('H:i') . '
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-card blue">
                    <div class="stats-icon blue">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stats-label">Sinh viên</div>
                    <div class="stats-value">' . $sinhvien . '</div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card green">
                    <div class="stats-icon green">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stats-label">Giảng viên</div>
                    <div class="stats-value">' . $giangvien . '</div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card orange">
                    <div class="stats-icon orange">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stats-label">Đề tài</div>
                    <div class="stats-value">' . $detai . '</div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card purple">
                    <div class="stats-icon purple">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-label">Nhóm</div>
                    <div class="stats-value">' . $nhom . '</div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="chart-container">
                    <div class="chart-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold mb-1" style="color: #0F172A;">Thống kê đề tài theo khoa</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">Phân bố đề tài khóa luận theo chuyên ngành</p>
                            </div>
                            <form method="POST">
                                <select name="loc" class="form-select" style="min-width: 200px; border-radius: 0.5rem;" onchange="this.form.submit()">
                                    <option value="">Tất cả khoa</option>';
                                    foreach ($dt as $row) {
                                        echo '<option value="' . $row['IDNganh'] . '">' . $row['ChuyenNganh'] . '</option>';
                                    }
echo '                          </select>
                                <input type="hidden" name="btnLoc" value="1">
                            </form>
                        </div>
                    </div>
                    <div class="p-4">
                        <canvas id="detaiChart" style="max-height: 350px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="section-title">Thao tác nhanh</div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <a href="/CongNgheMoi/Admin/ThemSinhVien" class="text-decoration-none">
                    <div class="quick-action">
                        <div class="quick-action-icon" style="background: #EFF6FF; color: #3B82F6;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h6 class="fw-bold mb-1" style="color: #0F172A;">Thêm sinh viên</h6>
                        <p class="text-muted mb-0" style="font-size: 0.875rem;">Thêm sinh viên mới</p>
                    </div>
                </a>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <a href="/CongNgheMoi/Admin/ThemGiangVien" class="text-decoration-none">
                    <div class="quick-action">
                        <div class="quick-action-icon" style="background: #ECFDF5; color: #10B981;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h6 class="fw-bold mb-1" style="color: #0F172A;">Thêm giảng viên</h6>
                        <p class="text-muted mb-0" style="font-size: 0.875rem;">Thêm giảng viên mới</p>
                    </div>
                </a>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <a href="/CongNgheMoi/Admin/QuanLySV" class="text-decoration-none">
                    <div class="quick-action">
                        <div class="quick-action-icon" style="background: #FFFBEB; color: #F59E0B;">
                            <i class="fas fa-list"></i>
                        </div>
                        <h6 class="fw-bold mb-1" style="color: #0F172A;">Danh sách SV</h6>
                        <p class="text-muted mb-0" style="font-size: 0.875rem;">Quản lý sinh viên</p>
                    </div>
                </a>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <a href="/CongNgheMoi/Admin/DSDeTai" class="text-decoration-none">
                    <div class="quick-action">
                        <div class="quick-action-icon" style="background: #F5F3FF; color: #8B5CF6;">
                            <i class="fas fa-book"></i>
                        </div>
                        <h6 class="fw-bold mb-1" style="color: #0F172A;">Quản lý đề tài</h6>
                        <p class="text-muted mb-0" style="font-size: 0.875rem;">Xem đề tài</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById("detaiChart").getContext("2d");
    const detaiData = ' . json_encode($detaikhoa) . ';
    
    const labels = detaiData.map(item => item.ChuyenNganh);
    const data = detaiData.map(item => item.SoLuongDeTai);
    
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [{
                label: "Số lượng đề tài",
                data: data,
                backgroundColor: "#4F46E5",
                borderRadius: 8,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "#0F172A",
                    padding: 12,
                    titleFont: { size: 13, weight: "600" },
                    bodyFont: { size: 12 },
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11 } },
                    grid: { color: "#F1F5F9" }
                },
                x: {
                    ticks: { font: { size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>';
?>
