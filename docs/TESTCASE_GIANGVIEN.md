# Test Cases - Actor: Giảng Viên

## Thông Tin Chung

| Thông tin | Giá trị |
|-----------|---------|
| Actor | Giảng viên (PQ = 1) hoặc Trưởng khoa (PQ = 4) |
| URL Base | http://localhost:8080/CongNgheMoi |
| Ngày tạo | 05/12/2024 |

---

## Danh Sách Test Cases

| TC | Các bước | Dữ liệu Test | Kết quả mong đợi | Kết quả thực tế | P/F |
|----|----------|--------------|------------------|-----------------|-----|
| TC01 (Đăng nhập Web thành công) | 1. Truy cập trang đăng nhập<br>2. Nhập mã giảng viên<br>3. Nhập mật khẩu<br>4. Click "Đăng nhập" | Username: GV001<br>Password: 123456 | Hệ thống chuyển đến trang Dashboard giảng viên, hiển thị thông tin giảng viên | Như mong đợi | P |
| TC02 (Đăng nhập Web thất bại - Sai mật khẩu) | 1. Truy cập trang đăng nhập<br>2. Nhập mã giảng viên đúng<br>3. Nhập mật khẩu sai<br>4. Click "Đăng nhập" | Username: GV001<br>Password: saimatkhau | Hệ thống hiển thị thông báo lỗi "Sai tên đăng nhập hoặc mật khẩu" | | |
| TC03 (Xem danh sách đề tài của tôi) | 1. Đăng nhập thành công<br>2. Click menu "Đề tài của tôi" | | Hệ thống hiển thị bảng danh sách đề tài với các cột: STT, Tên đề tài, Mô tả, Trạng thái duyệt, Trạng thái đăng ký | | |
| TC04 (Đề xuất đề tài mới thành công) | 1. Click menu "Đề xuất đề tài"<br>2. Nhập tên đề tài<br>3. Nhập mô tả<br>4. Nhập yêu cầu<br>5. Chọn số lượng thành viên<br>6. Click "Đề xuất" | Tên: "Xây dựng hệ thống quản lý thư viện"<br>Mô tả: "Hệ thống quản lý mượn trả sách"<br>Yêu cầu: "Biết PHP, MySQL"<br>Số lượng: 2 | Hệ thống hiển thị thông báo "Thêm đề tài thành công", đề tài xuất hiện trong danh sách với trạng thái "Chờ duyệt" | | |
| TC05 (Đề xuất đề tài - Thiếu thông tin) | 1. Click menu "Đề xuất đề tài"<br>2. Để trống tên đề tài<br>3. Click "Đề xuất" | Tên: (trống)<br>Mô tả: "Test"<br>Yêu cầu: "Test" | Hệ thống hiển thị thông báo lỗi yêu cầu nhập đầy đủ thông tin bắt buộc | | |
| TC06 (Tạo thông báo cho đề tài) | 1. Click menu "Tạo thông báo"<br>2. Click nút "Tạo thông báo" của đề tài<br>3. Nhập nội dung thông báo<br>4. Click "Lưu thông báo" | Thông báo: "Các bạn sinh viên nộp báo cáo tiến độ trước ngày 15/12" | Hệ thống hiển thị modal thành công, trang tự động refresh, thông báo được lưu | | |
| TC07 (Cập nhật thông báo đề tài) | 1. Click "Tạo thông báo" của đề tài đã có thông báo<br>2. Xem thông báo cũ hiển thị<br>3. Nhập thông báo mới<br>4. Click "Lưu thông báo" | Thông báo mới: "Deadline nộp báo cáo: 20/12/2024" | Hệ thống lưu thông báo mới, thông báo cũ được thay thế | | |
| TC08 (Tạo thông báo - Vượt quá giới hạn) | 1. Click "Tạo thông báo"<br>2. Nhập thông báo > 5000 ký tự<br>3. Click "Lưu thông báo" | Thông báo: (chuỗi > 5000 ký tự) | Hệ thống hiển thị thông báo lỗi "Thông báo quá dài (tối đa 5000 ký tự)" | | |
| TC09 (Xem danh sách sinh viên đăng ký) | 1. Click menu "Quản lý nhóm" | | Hệ thống hiển thị danh sách sinh viên đã đăng ký đề tài với các cột: MSSV, Họ tên, Đề tài, Nhóm | | |
| TC10 (Xem kết quả đánh giá sinh viên) | 1. Vào trang Quản lý nhóm<br>2. Click vào sinh viên để xem chi tiết | | Hệ thống hiển thị phiếu điểm với các mục đánh giá và điểm đã chấm | | |
| TC11 (Đổi mật khẩu thành công) | 1. Click menu "Đổi mật khẩu"<br>2. Nhập mật khẩu cũ<br>3. Nhập mật khẩu mới<br>4. Xác nhận mật khẩu mới<br>5. Click "Đổi mật khẩu" | Mật khẩu cũ: 123456<br>Mật khẩu mới: 654321<br>Xác nhận: 654321 | Hệ thống hiển thị thông báo "Đổi mật khẩu thành công" | | |
| TC12 (Đổi mật khẩu - Mật khẩu cũ sai) | 1. Click menu "Đổi mật khẩu"<br>2. Nhập mật khẩu cũ sai<br>3. Nhập mật khẩu mới<br>4. Click "Đổi mật khẩu" | Mật khẩu cũ: saimatkhau<br>Mật khẩu mới: 654321 | Hệ thống hiển thị thông báo lỗi "Mật khẩu cũ không đúng" | | |
| TC13 (Đăng xuất khỏi hệ thống Web) | 1. Click menu "Đăng xuất" | | Hệ thống xóa session, chuyển về trang đăng nhập | | |

| TC14 (App Java - Đăng nhập lần đầu, chưa đăng ký máy) | 1. Mở app Java<br>2. Nhập mã giảng viên<br>3. Nhập mật khẩu<br>4. Click "Đăng nhập" | Username: GV001<br>Password: 123456<br>(Chưa đăng ký máy) | Hệ thống chuyển đến form đăng ký máy tính với các trường: Tên máy, RAM, ROM, CPU, OS | | |
| TC15 (App Java - Đăng ký thông tin máy tính) | 1. Click "Lấy thông tin"<br>2. Kiểm tra thông tin máy hiển thị đúng<br>3. Click "Đăng ký" | | Hệ thống hiển thị thông báo "Đăng ký máy tính thành công", chuyển đến màn hình chính với danh sách đề tài | | |
| TC16 (App Java - Đăng nhập đã đăng ký máy) | 1. Mở app Java<br>2. Nhập mã giảng viên<br>3. Nhập mật khẩu<br>4. Click "Đăng nhập" | Username: GV001<br>Password: 123456<br>(Đã đăng ký máy) | Hệ thống chuyển đến màn hình chính, hiển thị danh sách đề tài có sinh viên đăng ký | | |
| TC17 (App Java - Xem danh sách đề tài) | 1. Đăng nhập thành công<br>2. Xem bảng "Danh sách đề tài" bên trái | | Hệ thống hiển thị các đề tài có sinh viên đăng ký với cột: ID, Tên đề tài, SL SV | | |
| TC18 (App Java - Xem sinh viên theo đề tài) | 1. Click vào một đề tài trong bảng | | Hệ thống hiển thị danh sách sinh viên đăng ký đề tài đó với cột: ID ĐK, MSSV, Họ và Tên, Lớp, Nhóm (hoặc "Làm một mình") | | |
| TC19 (App Java - Xem phiếu chấm điểm) | 1. Click vào một sinh viên trong danh sách | | Hệ thống hiển thị phiếu chấm điểm với 12 tiêu chí, header hiển thị "Sinh viên: [MSSV] - [Họ tên]" | | |
| TC20 (App Java - Chấm điểm sinh viên thành công) | 1. Chọn sinh viên<br>2. Nhập điểm cho từng tiêu chí<br>3. Click "Lưu điểm" | Muc1: 8<br>Muc2: 7<br>Muc3.1: 9<br>Muc3.2: 8<br>Muc3.3: 7<br>Muc4.1: 8<br>Muc4.2: 9<br>Muc5.1: 7<br>Muc5.2: 8<br>Muc6.1: 9<br>Muc6.2: 8<br>Muc6.3: 7 | Hệ thống hiển thị thông báo "Lưu điểm thành công", điểm được lưu vào database | | |
| TC21 (App Java - Chấm điểm không hợp lệ) | 1. Chọn sinh viên<br>2. Nhập điểm = 15 (ngoài khoảng 0-10)<br>3. Tab sang ô khác | Điểm: 15 | Hệ thống hiển thị thông báo lỗi "Điểm phải từ 0 đến 10", không cho phép lưu | | |
| TC22 (App Java - Chấm điểm nhập chữ) | 1. Chọn sinh viên<br>2. Nhập chữ vào ô điểm<br>3. Tab sang ô khác | Điểm: "abc" | Hệ thống hiển thị thông báo lỗi "Vui lòng nhập số" | | |
| TC23 (App Java - Làm mới dữ liệu) | 1. Click nút "Làm mới" | | Hệ thống tải lại danh sách đề tài, hiển thị thông báo "Đã làm mới dữ liệu" | | |
| TC24 (App Java - Đăng xuất) | 1. Click nút "Đăng xuất"<br>2. Click "Yes" xác nhận | | Hệ thống xóa token, hiển thị thông báo "Đăng xuất thành công", chuyển về form đăng nhập | | |
| TC25 (Phân quyền - Truy cập trang Admin) | 1. Đăng nhập với quyền giảng viên<br>2. Truy cập URL /Admin | | Hệ thống hiển thị thông báo "Bạn không có quyền truy cập", chuyển về trang chủ | | |
| TC26 (Phân quyền - Truy cập trang Sinh viên) | 1. Đăng nhập với quyền giảng viên<br>2. Truy cập URL /SinhVien | | Hệ thống hiển thị thông báo "Bạn không có quyền truy cập", chuyển về trang chủ | | |

---

## Tổng Kết

| Loại Test | Số lượng | Pass | Fail |
|-----------|----------|------|------|
| Đăng nhập Web | 2 | | |
| Quản lý đề tài | 3 | | |
| Thông báo | 3 | | |
| Quản lý nhóm | 2 | | |
| Đổi mật khẩu | 2 | | |
| Đăng xuất Web | 1 | | |
| App Java | 11 | | |
| Phân quyền | 2 | | |
| **Tổng** | **26** | | |

---

**Người thực hiện:** _______________  
**Ngày thực hiện:** _______________  
**Ghi chú:** _______________
