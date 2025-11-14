<?php
require_once "./mvc/views/components/sidebarTK.php";
echo '
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Quản lý Hội đồng bảo vệ</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Chức năng quản lý hội đồng bảo vệ khóa luận tốt nghiệp
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <h5>Danh sách hội đồng</h5>
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">STT</th>
                                <th width="25%">Tên hội đồng</th>
                                <th width="20%">Chủ tịch</th>
                                <th width="20%">Thư ký</th>
                                <th width="15%">Ngày bảo vệ</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Chưa có hội đồng nào được tạo
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                <button class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tạo hội đồng mới
                </button>
            </div>
        </div>
    </div>
</div>';
?>
