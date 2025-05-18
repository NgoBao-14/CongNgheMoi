<?php
$dt = $data['dt'];
echo '    <section class="content">
        <div class="container-fluid">
            <div class="card-header">
            <h3 class="card-title">Danh sách đề tài</h3>
            </div>
            <div class="project-list">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">STT</th>
                            <th width="15%">Mã đề tài</th>
                            <th width="40%">Tên đề tài</th>
                            <th width="25%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>';
                            $i = 1;
                            foreach($dt as $row){
                                echo '<tr>
                                <td>'.$i.'</td>
                                <td>'.$row['IDDeTai'].'</td>
                                <td>'.$row['TenDeTai'].'</td>
                                <td>
                                        <button 
                                            class="btn view-details btn-primary" 
                                            data-id="'.$row['IDDeTai'].'"
                                            data-title="'.$row['TenDeTai'].'"
                                            data-mota="'.$row['MoTa'].'"
                                            data-yeucau="'.$row['YeuCau'].'"
                                            data-sltoida="'.$row['SoLuongTV'].'"
                                        >Xem chi tiết</button>
                                    </td>
                                </tr>';
                                $i++;
                            }
echo '
                    </tbody>
                </table>
            </div>

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
            
        </div>
    </section>';
?>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    const detailButtons = document.querySelectorAll(".view-details");

    detailButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            const idDeTai = this.dataset.id;
            const title = this.dataset.title;
            const moTa = this.dataset.mota;
            const yeuCau = this.dataset.yeucau;
            const soLuong = this.dataset.sltoida;

            const content = `
                <p><strong>Mã đề tài:</strong> ${idDeTai}</p>
                <p><strong>Tên đề tài:</strong> ${title}</p>
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