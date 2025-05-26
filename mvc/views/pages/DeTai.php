<?php
$dt = $data["dt"];

    echo '
    <div class="col-md-3">
        <div class="navigation-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=".">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đăng ký đề tài</li>
                </ol>
            </nav>
        </div>
    </div>
        <!-- Project Registration Section -->
        <div id="deTaiSection" class="project-section">
            <h3 class="text-center text-primary my-4">ĐĂNG KÝ ĐỀ TÀI</h3>
            
            <div class="project-list">
                <table class="table table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">STT</th>
                            <th width="15%">Mã đề tài</th>
                            <th width="40%">Tên đề tài</th>
                            <th width="15%">Giảng viên hướng dẫn</th>
                            <th width="25%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>';
                            $i = 1;
                            foreach($dt as $row){
                                if($row['TrangThaiDK']==='Chưa được đăng ký' && $row['TrangThaiDeTai']==='Đã duyệt'){
                                echo '<tr>
                                <td>'.$i.'</td>
                                <td>'.$row['IDDeTai'].'</td>
                                <td>'.$row['TenDeTai'].'</td>
                                <td>'.$row['ten_giang_vien'].'</td>
                                <td>
                                        <button 
                                            class="btn btn-info btn-sm view-details" style="background-color: #EE7600; border-color: #EE7600; color: #fff;" 
                                            data-id="'.$row['IDDeTai'].'"
                                            data-title="'.htmlspecialchars($row['TenDeTai'], ENT_QUOTES).'"
                                            data-giangvien="'.htmlspecialchars($row['ten_giang_vien'], ENT_QUOTES).'"
                                            data-mota="'.htmlspecialchars($row['MoTa'], ENT_QUOTES).'"
                                            data-yeucau="'.htmlspecialchars($row['YeuCau'], ENT_QUOTES).'"
                                            data-sltoida="'.$row['SoLuongTV'].'"
                                        >Xem chi tiết</button>

                                        <button 
                                            class="btn btn-primary btn-sm register-btn"
                                            data-id="'.$row['IDDeTai'].'"
                                            data-title="'.htmlspecialchars($row['TenDeTai'], ENT_QUOTES).'"
                                            data-soLuong="'.$row['SoLuongTV'].'"
                                        >Đăng ký</button>
                                    </td>
                                </tr>';
                                $i++;
                            }
                            }
                            
echo '
                    </tbody>
                </table>
            </div>
            ';
echo'             <!-- Project Details Modal -->
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
            </div>';
$masv = $_SESSION['MaSV'];
$hoten = $_SESSION['ten'];
echo'            <!-- Registration Form (Initially Hidden) -->
            <div id="registrationForm" class="mt-4" style="display: none;">
                <h4 class="text-primary">Đăng ký nhóm</h4>
                <div class="card">
                    <div class="card-header text-white" style="background-color: #2196F3;">
                        <span id="selectedProjectTitle">Đề tài: </span>
                    </div>
                    <div class="card-body">
                        <form id="groupRegistrationForm" action="" method="POST">';

echo'                       <input type="hidden" id="selectedProjectId" name="selectedProjectId">
                            <div class="mb-3">
                                <h5>Trưởng nhóm</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="leaderMssv" class="form-label">MSSV</label>
                                        <input type="text" class="form-control" id="leaderMssv" name="leaderMssv"
                                            value="'.$masv.'" readonly>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="leaderName" class="form-label">Họ và tên</label>
                                        <input type="text" class="form-control" id="leaderName"
                                            value="'.$hoten.'" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="memberContainer"></div>
                                <button type="button" id="addMemberBtn" class="btn btn-secondary">Thêm thành viên</button>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" name="btnDKN">Đăng ký</button>
                                <button type="button" class="btn btn-secondary" id="cancelRegistration">Hủy</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';

    
    ?>
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
            const hanDK = this.dataset.handangky;

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
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Xử lý khi bấm nút "Đăng ký"
    document.querySelectorAll(".register-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const projectId = btn.getAttribute("data-id");
            const projectTitle = btn.getAttribute("data-title");

            // Cập nhật thông tin đề tài
            document.getElementById("selectedProjectId").value = projectId;
            document.getElementById("selectedProjectTitle").innerText = "Đề tài: " + projectTitle;

            // Hiện form đăng ký
            document.getElementById("registrationForm").style.display = "block";

            // Cuộn đến form
            document.getElementById("registrationForm").scrollIntoView({ behavior: "smooth" });
        }); 
    });

    // Hủy đăng ký
    document.getElementById("cancelRegistration").addEventListener("click", function () {
        document.getElementById("registrationForm").style.display = "none";
    });
});
</script>

<!-- them thanh vien -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const addBtn = document.getElementById("addMemberBtn");
    const memberContainer = document.getElementById("memberContainer");
    const maxMembersInput = document.getElementById("selectedProjectId"); 
    // Số lượng thành viên đã thêm
    // Giả sử nhóm trưởng đã có sẵn, nên bắt đầu từ 0
    let memberCount = 0;

    addBtn.addEventListener("click", function () {
        // Lấy nút đăng ký tương ứng để biết số lượng tối đa
        const selectedProjectId = maxMembersInput.value;
        const projectBtn = document.querySelector(`.register-btn[data-id="${selectedProjectId}"]`);
        const max = parseInt(projectBtn.getAttribute("data-soLuong"));

        // Giảm 1 vì nhóm trưởng đã có sẵn
        const maxAdditionalMembers = max - 1;

        if (memberCount >= maxAdditionalMembers) {
            alert("Đã đạt số lượng thành viên tối đa cho đề tài này.");
            return;
        }

        const index = memberCount + 1;
        const memberHtml = `
            <h5>Thành viên ${index}</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">MSSV</label>
                    <input type="text" name="members[${index}][mssv]" class="form-control"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        pattern="\\d+" title="Chỉ nhập số" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="members[${index}][hoten]" class="form-control"
                        oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ỹ\\s]/g, '')"
                        pattern="[a-zA-ZÀ-ỹ\\s]+" title="Chỉ nhập chữ cái và khoảng trắng" required>
                </div>
            </div>
        `;

        memberContainer.insertAdjacentHTML("beforeend", memberHtml);
        memberCount++;
    });
});
</script>
