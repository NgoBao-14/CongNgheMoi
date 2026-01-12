# Hướng Dẫn Build và Chạy App

## Yêu cầu hệ thống

- JDK 8 trở lên
- NetBeans IDE (hoặc IDE Java khác)
- Các thư viện đã được thêm vào project:
  - FlatLaf (UI theme)
  - OSHI (lấy thông tin phần cứng)
  - Apache Commons IO
  - org.json
  - JNA

## Cách chạy

### 1. Từ NetBeans IDE:
```
1. Mở project trong NetBeans
2. Click chuột phải vào project → Clean and Build
3. Click Run Project (F6) hoặc click chuột phải → Run
```

### 2. Từ Command Line:
```bash
# Build project
cd testlaythongtinmay
ant clean
ant jar

# Chạy app
java -jar dist/testlaythongtinmay.jar
```

### 3. Từ file .jar đã build:
```bash
# Chạy trực tiếp file jar
java -jar testlaythongtinmay.jar
```

## Cấu trúc giao diện mới

### 1. Form Đăng Nhập (ModernLoginForm)
- **Bên trái**: Panel gradient xanh với thông tin hệ thống
- **Bên phải**: Form đăng nhập với:
  - Trường "Mã giảng viên"
  - Trường "Mật khẩu"
  - Button "ĐĂNG NHẬP" với gradient

### 2. Form Đăng Ký Máy (ModernRegisterForm)
- **Header**: Gradient xanh với tiêu đề
- **Content**: Form cuộn với các trường:
  - Tên máy tính
  - Serial RAM 1, 2
  - Serial Ổ cứng 1, 2
  - CPU
  - Hệ điều hành
- **Buttons**: 
  - "LẤY THÔNG TIN" - Tự động lấy thông tin máy
  - "ĐĂNG KÝ" - Đăng ký máy vào hệ thống

### 3. Form Chính (myform)
- Giữ nguyên giao diện cũ (có thể cải thiện sau)
- Hiển thị danh sách đề tài
- Bảng chấm điểm chi tiết

## Tính năng mới

### 1. Xử lý bất đồng bộ
- Đăng nhập không làm đơ giao diện
- Hiển thị trạng thái "Đang đăng nhập..."

### 2. Thông báo rõ ràng
- Thông báo lỗi cụ thể
- Thông báo thành công

### 3. Validation
- Kiểm tra trường rỗng
- Thông báo khi thiếu thông tin

## Khắc phục sự cố

### Lỗi: "Cannot find FlatLaf"
```bash
# Đảm bảo thư viện FlatLaf đã được thêm vào project
# Trong NetBeans: Libraries → Add JAR/Folder → Chọn flatlaf.jar
```

### Lỗi: "Cannot find OSHI"
```bash
# Thêm các thư viện OSHI:
# - oshi-core.jar
# - jna.jar
# - jna-platform.jar
```

### Lỗi kết nối API
```bash
# Kiểm tra:
# 1. Server PHP đang chạy tại http://localhost:8080
# 2. File Constants.java có đúng URL API
# 3. Firewall không chặn kết nối
```

## Tùy chỉnh

### Thay đổi màu sắc:
Chỉnh sửa file `ModernUI.java`:
```java
public static final Color PRIMARY_COLOR = new Color(41, 128, 185); // Đổi màu chủ đạo
public static final Color PRIMARY_DARK = new Color(31, 97, 141);   // Đổi màu đậm
```

### Thay đổi font chữ:
```java
// Trong ModernUI.java
textField.setFont(new Font("Segoe UI", Font.PLAIN, 14)); // Đổi font và size
```

### Quay lại giao diện cũ:
Trong `Testlaythongtinmay.java`, đổi:
```java
ModernLoginForm fm = new ModernLoginForm();
```
Thành:
```java
formDangNhap fm = new formDangNhap();
```

## Screenshot

### Giao diện đăng nhập mới:
- Layout 2 cột hiện đại
- Gradient xanh dương chuyên nghiệp
- Button với hiệu ứng hover

### Giao diện đăng ký máy:
- Header gradient nổi bật
- Form cuộn mượt mà
- Tự động lấy thông tin phần cứng

## Liên hệ hỗ trợ

Nếu gặp vấn đề, vui lòng:
1. Kiểm tra log trong console
2. Đảm bảo tất cả thư viện đã được thêm
3. Kiểm tra kết nối API backend
