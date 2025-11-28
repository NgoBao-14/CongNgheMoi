# Cấu trúc Layout Sinh Viên

## Tổng quan
Đã gộp 2 layout `layoutSV.php` và `layoutDKDT.php` thành 1 layout duy nhất: `layoutSinhVien.php`

## Cấu trúc mới

### 1. Layout chính: `layoutSinhVien.php`
- Layout duy nhất cho tất cả các trang sinh viên
- Tự động phát hiện trang dashboard hoặc trang con
- Xử lý đường dẫn CSS/JS tự động (`./ hoặc ../`)

### 2. Sidebar Component: `blocks/sidebarSV.php`
- Sidebar được tách riêng thành component
- Tự động highlight menu item active dựa trên `$data['Page']`
- Dễ dàng bảo trì và cập nhật

### 3. Controller: `SinhVien.php`
- Tất cả các function đều sử dụng `layoutSinhVien`
- Truyền `Page` parameter để xác định trang con

## Cách hoạt động

### Dashboard (Trang chủ)
```php
$this->view("layoutSinhVien", [
    "nhom" => $nhom,
    "ttsv" => $ttsv
]);
```
- Không có `Page` parameter
- Hiển thị nội dung dashboard trực tiếp trong layout
- Load JavaScript cho dashboard

### Trang con (Đăng ký đề tài, Thông tin đề tài, etc.)
```php
$this->view("layoutSinhVien", [
    "Page" => "DeTai",
    "dt" => $detai
]);
```
- Có `Page` parameter
- Load file từ `mvc/views/pages/{Page}.php`
- Sidebar tự động highlight menu tương ứng

## Lợi ích

1. **Nhất quán**: Sidebar giống hệt nhau trên mọi trang
2. **Dễ bảo trì**: Chỉ cần sửa 1 file layout và 1 file sidebar
3. **Không trùng lặp**: Loại bỏ code trùng lặp giữa 2 layout cũ
4. **Linh hoạt**: Dễ dàng thêm menu item mới trong sidebar
5. **Tự động**: Đường dẫn CSS/JS tự động điều chỉnh

## Files cũ (có thể xóa)
- `layoutSV.php` - Đã được thay thế
- `layoutDKDT.php` - Đã được thay thế
