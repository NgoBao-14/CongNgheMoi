<?php
require_once "./mvc/views/components/sidebarTK.php";
$baocao = $data['baocao'];
echo '
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Danh sách tiến độ của các nhóm</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Nhóm</th>
                            <th>Tệp</th>
                            <th>Ngày nộp</th>
                        </tr>
                    </thead>
                    <tbody>';
$stt = 1;
foreach ($baocao as $row) {
    $fileName = $row["DuongDan"];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
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
    echo '<tr>
        <td>' . $stt++ . '</td>
        <td>' . $row['IDNhom'] . '</td>
        <td>
            <div class="file-item d-flex align-items-center mb-2">
                <i class="' . $iconClass . ' file-icon me-2" style="font-size: 1.5rem;"></i>
                <a href="public/uploads/' . htmlspecialchars($fileName) . '" download>' . htmlspecialchars($fileName) . '</a>
            </div>
        </td>
        <td>' . $row['NgayNop'] . '</td>
    </tr>';
}
echo '
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>';
?>
