# Test Cases - Actor: Admin

## Thông Tin Chung

| Thông tin | Giá trị |
|-----------|---------|
| Actor | Admin (PQ = 3) |
| URL Base | http://localhost:8080/CongNgheMoi |
| Ngày tạo | 05/12/2024 |

---

## Danh Sách Test Cases

| TC | Các bước | Dữ liệu Test | Kết quả mong đợi | Kết quả thực tế | P/F |
|----|----------|--------------|------------------|-----------------|-----|
| TC01 (Đăng nhập Admin thành công) | 1. Truy cập trang đăng nhập<br>2. Nhập tài khoản admin<br>3. Nhập mật khẩu<br>4. Click "Đăng nhập" | Username: admin<br>Password: 123456 | Hệ thống chuyển đến trang Dashboard Admin, hiển thị các chỉ số: Sinh viên, Giảng viên, Đề tài, SV đã đăng ký | | |
| TC02 (Đăng nhập Admin thất bại) | 1. Truy cập trang đăng nhập<br>2. Nhập tài khoản admin<br>3. Nhập mật khẩu sai<br>4. Click "Đăng nhập" | Username: admin<br>Password: saimatkhau | Hệ thống hiển thị thông báo lỗi "Sai tên đăng nhập hoặc mật khẩu" | | |
| TC03 (Xem Dashboard) | 1. Đăng nhập thành công<br>2. Xem trang Dashboard | | Hệ thống hiển thị 4 card thống kê: Sinh viên, Giảng viên, Đề tài, SV đã đăng ký và biểu đồ đề tài theo khoa | | |
| TC04 (Lọc biểu đồ theo khoa) | 1. Vào Dashboard<br>2. Chọn khoa từ dropdown<br>3. Xem biểu đồ cập nhật | Khoa: Công nghệ thông tin | Hệ thống cập nhật biểu đồ chỉ hiển thị đề tài của khoa được chọn | | |
| TC05 (Xem danh sách sinh viên) | 1. Click menu "Quản lý sinh viên" | | Hệ thống hiển thị bảng danh sách sinh viên với các cột: STT, MSSV, Họ và tên, Lớp, Chuyên ngành, Email | | |
| TC06 (Lọc sinh viên theo khoa) | 1. Vào trang Quản lý sinh viên<br>2. Chọn khoa từ dropdown | Khoa: Công nghệ thông tin | Hệ thống chỉ hiển thị sinh viên thuộc khoa được chọn, số lượng cập nhật | | |
| TC07 (Thêm sinh viên mới thành công) | 1. Click menu "Thêm sinh viên"<br>2. Nhập MSSV<br>3. Nhập họ đệm<br>4. Nhập tên<br>5. Nhập lớp<br>6. Chọn chuyên ngành<br>7. Nhập email<br>8. Nhập SĐT<br>9. Click "Thêm" | MSSV: 2021001<br>Họ đệm: Nguyễn Văn<br>Tên: A<br>Lớp: CNTT01<br>Chuyên ngành: CNTT<br>Email: a@gmail.com<br>SĐT: 0901234567 | Hệ thống hiển thị thông báo thành công, sinh viên xuất hiện trong danh sách | | |
| TC08 (Thêm sinh viên - MSSV trùng) | 1. Click menu "Thêm sinh viên"<br>2. Nhập MSSV đã tồn tại<br>3. Nhập các thông tin khác<br>4. Click "Thêm" | MSSV: (đã tồn tại) | Hệ thống hiển thị thông báo lỗi "MSSV đã tồn tại" | | |
| TC09 (Cập nhật thông tin sinh viên) | 1. Vào Quản lý sinh viên<br>2. Click nút sửa của sinh viên<br>3. Sửa thông tin<br>4. Click "Cập nhật" | Lớp mới: CNTT02<br>Email mới: newemail@gmail.com | Hệ thống lưu thông tin mới, chuyển về trang chi tiết với thông tin đã cập nhật | | |
| TC10 (Xem danh sách giảng viên) | 1. Click menu "Quản lý giảng viên" | | Hệ thống hiển thị bảng danh sách giảng viên với các cột: Mã GV, Họ và tên, Chuyên ngành, Vai trò | | |
| TC11 (Lọc giảng viên theo khoa) | 1. Vào trang Quản lý giảng viên<br>2. Chọn khoa từ dropdown | Khoa: Công nghệ thông tin | Hệ thống chỉ hiển thị giảng viên thuộc khoa được chọn | | |
| TC12 (Thêm giảng viên mới thành công) | 1. Click menu "Thêm giảng viên"<br>2. Nhập mã GV<br>3. Nhập họ đệm<br>4. Nhập tên<br>5. Chọn chuyên ngành<br>6. Nhập email<br>7. Nhập SĐT<br>8. Chọn chức vụ<br>9. Click "Thêm" | Mã GV: GV010<br>Họ đệm: Trần Văn<br>Tên: B<br>Chuyên ngành: CNTT<br>Email: b@gmail.com<br>SĐT: 0912345678<br>Chức vụ: Giảng viên | Hệ thống hiển thị thông báo thành công, giảng viên xuất hiện trong danh sách | | |
| TC13 (Cập nhật thông tin giảng viên) | 1. Vào Quản lý giảng viên<br>2. Click nút sửa của giảng viên<br>3. Sửa thông tin<br>4. Click "Cập nhật" | Email mới: gvnew@gmail.com<br>Chức vụ: Trưởng khoa | Hệ thống hiển thị thông báo "Cập nhật thành công", chuyển về danh sách giảng viên | | |
| TC14 (Xem danh sách đề tài) | 1. Click menu "Quản lý đề tài" | | Hệ thống hiển thị bảng danh sách đề tài với các cột: Tên đề tài, Mô tả, Giảng viên, Chuyên ngành, Trạng thái | | |
| TC15 (Lọc đề tài theo khoa) | 1. Vào trang Quản lý đề tài<br>2. Chọn khoa từ dropdown | Khoa: Công nghệ thông tin | Hệ thống chỉ hiển thị đề tài thuộc khoa được chọn | | |
| TC16 (Cập nhật đề tài - Duyệt đề tài) | 1. Vào Quản lý đề tài<br>2. Click nút sửa của đề tài "Chờ duyệt"<br>3. Đổi trạng thái thành "Đã duyệt"<br>4. Click "Cập nhật" | Trạng thái: Đã duyệt | Hệ thống lưu trạng thái mới, đề tài hiển thị "Đã duyệt" trong danh sách | | |
| TC17 (Cập nhật đề tài - Sửa thông tin) | 1. Vào chi tiết đề tài<br>2. Sửa tên đề tài<br>3. Sửa mô tả<br>4. Sửa yêu cầu<br>5. Click "Cập nhật" | Tên mới: "Đề tài cập nhật"<br>Mô tả mới: "Mô tả mới"<br>Yêu cầu mới: "Yêu cầu mới" | Hệ thống lưu thông tin mới, hiển thị thông tin đã cập nhật | | |

| TC18 (Thao tác nhanh - Thêm sinh viên) | 1. Vào Dashboard<br>2. Click "Thêm sinh viên" trong phần Thao tác nhanh | | Hệ thống chuyển đến trang Thêm sinh viên | | |
| TC19 (Thao tác nhanh - Thêm giảng viên) | 1. Vào Dashboard<br>2. Click "Thêm giảng viên" trong phần Thao tác nhanh | | Hệ thống chuyển đến trang Thêm giảng viên | | |
| TC20 (Thao tác nhanh - Danh sách SV) | 1. Vào Dashboard<br>2. Click "Danh sách SV" trong phần Thao tác nhanh | | Hệ thống chuyển đến trang Quản lý sinh viên | | |
| TC21 (Thao tác nhanh - Quản lý đề tài) | 1. Vào Dashboard<br>2. Click "Quản lý đề tài" trong phần Thao tác nhanh | | Hệ thống chuyển đến trang Quản lý đề tài | | |
| TC22 (Đổi mật khẩu Admin thành công) | 1. Click menu "Đổi mật khẩu"<br>2. Nhập mật khẩu cũ<br>3. Nhập mật khẩu mới<br>4. Xác nhận mật khẩu mới<br>5. Click "Đổi mật khẩu" | Mật khẩu cũ: 123456<br>Mật khẩu mới: admin123<br>Xác nhận: admin123 | Hệ thống hiển thị thông báo "Đổi mật khẩu thành công" | | |
| TC23 (Đổi mật khẩu - Mật khẩu cũ sai) | 1. Click menu "Đổi mật khẩu"<br>2. Nhập mật khẩu cũ sai<br>3. Nhập mật khẩu mới<br>4. Click "Đổi mật khẩu" | Mật khẩu cũ: saimatkhau<br>Mật khẩu mới: admin123 | Hệ thống hiển thị thông báo lỗi "Mật khẩu cũ không đúng" | | |
| TC24 (Đổi mật khẩu - Xác nhận không khớp) | 1. Click menu "Đổi mật khẩu"<br>2. Nhập mật khẩu cũ đúng<br>3. Nhập mật khẩu mới<br>4. Nhập xác nhận khác mật khẩu mới<br>5. Click "Đổi mật khẩu" | Mật khẩu mới: admin123<br>Xác nhận: admin456 | Hệ thống hiển thị thông báo lỗi "Mật khẩu xác nhận không khớp" | | |
| TC25 (Đăng xuất Admin) | 1. Click menu "Đăng xuất" | | Hệ thống xóa session, chuyển về trang đăng nhập | | |
| TC26 (Phân quyền - Truy cập trang Giảng viên) | 1. Đăng nhập với quyền Admin<br>2. Truy cập URL /GiangVien | | Hệ thống hiển thị thông báo "Bạn không có quyền truy cập", chuyển về trang chủ | | |
| TC27 (Phân quyền - Truy cập trang Sinh viên) | 1. Đăng nhập với quyền Admin<br>2. Truy cập URL /SinhVien | | Hệ thống hiển thị thông báo "Bạn không có quyền truy cập", chuyển về trang chủ | | |
| TC28 (Kiểm tra số liệu Dashboard khớp) | 1. Đăng nhập Admin<br>2. Xem số sinh viên trên Dashboard<br>3. Vào Quản lý sinh viên<br>4. So sánh số lượng | | Số sinh viên trên Dashboard phải bằng số sinh viên trong danh sách Quản lý sinh viên | | |

---

## Tổng Kết

| Loại Test | Số lượng | Pass | Fail |
|-----------|----------|------|------|
| Đăng nhập | 2 | | |
| Dashboard | 2 | | |
| Quản lý sinh viên | 5 | | |
| Quản lý giảng viên | 4 | | |
| Quản lý đề tài | 4 | | |
| Thao tác nhanh | 4 | | |
| Đổi mật khẩu | 3 | | |
| Đăng xuất | 1 | | |
| Phân quyền | 2 | | |
| Kiểm tra dữ liệu | 1 | | |
| **Tổng** | **28** | | |

---

**Người thực hiện:** _______________  
**Ngày thực hiện:** _______________  
**Ghi chú:** _______________
