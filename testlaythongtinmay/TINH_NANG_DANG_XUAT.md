# 🚪 Tính Năng Đăng Xuất

## 📋 Mô Tả

Tính năng đăng xuất cho phép giảng viên thoát khỏi hệ thống một cách an toàn, xóa token xác thực và quay về màn hình đăng nhập.

---

## ✨ Các Cải Tiến

### 1. Xóa Token An Toàn
Khi đăng xuất, hệ thống sẽ:
- ✅ Xóa toàn bộ nội dung file `json_token.txt`
- ✅ Đảm bảo không thể tự động đăng nhập lại
- ✅ Bảo mật thông tin người dùng

### 2. Xác Nhận Trước Khi Đăng Xuất
- ✅ Hiển thị dialog xác nhận
- ✅ Tránh đăng xuất nhầm
- ✅ Thông báo rõ ràng

### 3. Thông Báo Thành Công
- ✅ Hiển thị thông báo "Đăng xuất thành công!"
- ✅ Lời chào tạm biệt thân thiện
- ✅ Chuyển về màn hình đăng nhập

---

## 🔧 Cách Sử Dụng

### Bước 1: Click Button Đăng Xuất
Ở góc trên bên phải màn hình chính, click vào button:
```
🚪 Đăng xuất
```

### Bước 2: Xác Nhận
Hệ thống hiển thị dialog:
```
┌─────────────────────────────────────┐
│  Xác nhận đăng xuất                 │
├─────────────────────────────────────┤
│  Bạn có chắc muốn đăng xuất         │
│  khỏi hệ thống?                     │
│                                     │
│         [ Có ]      [ Không ]       │
└─────────────────────────────────────┘
```

### Bước 3: Hoàn Tất
Nếu chọn "Có":
1. Token được xóa khỏi file `json_token.txt`
2. Hiển thị thông báo thành công
3. Chuyển về màn hình đăng nhập

---

## 💻 Code Implementation

### Method xóa token trong `mycls.java`:

```java
/**
 * Xóa token khi đăng xuất
 * Xóa toàn bộ nội dung file token
 */
public void xoaToken() throws IOException {
    File file = new File("json_token.txt");
    if (file.exists()) {
        // Ghi chuỗi rỗng để xóa nội dung token
        FileWriter writer = new FileWriter(file);
        writer.write("");
        writer.close();
        System.out.println("Đã xóa token thành công");
    }
}

/**
 * Kiểm tra xem có token hợp lệ không
 */
public boolean coTokenHopLe() {
    try {
        return docfile() != null;
    } catch (Exception e) {
        return false;
    }
}
```

### Method xử lý đăng xuất trong `ModernMainForm.java`:

```java
private void handleLogout() {
    int choice = JOptionPane.showConfirmDialog(this, 
        "Bạn có chắc muốn đăng xuất khỏi hệ thống?", 
        "Xác nhận đăng xuất", 
        JOptionPane.YES_NO_OPTION,
        JOptionPane.QUESTION_MESSAGE);
    
    if (choice == JOptionPane.YES_OPTION) {
        try {
            // Xóa token khi đăng xuất
            mycls cls = new mycls();
            cls.xoaToken();
            
            // Hiển thị thông báo đăng xuất thành công
            JOptionPane.showMessageDialog(this, 
                "Đăng xuất thành công!\nHẹn gặp lại bạn!", 
                "Thông báo", 
                JOptionPane.INFORMATION_MESSAGE);
            
            // Chuyển về form đăng nhập
            ModernLoginForm loginForm = new ModernLoginForm();
            loginForm.setVisible(true);
            dispose();
        } catch (Exception e) {
            JOptionPane.showMessageDialog(this, 
                "Lỗi khi đăng xuất: " + e.getMessage(), 
                "Lỗi", 
                JOptionPane.ERROR_MESSAGE);
        }
    }
}
```

---

## 🔒 Bảo Mật

### Trước khi có tính năng xóa token:
❌ Token vẫn còn trong file sau khi đăng xuất
❌ Có thể tự động đăng nhập lại
❌ Rủi ro bảo mật nếu máy dùng chung

### Sau khi có tính năng xóa token:
✅ Token bị xóa hoàn toàn
✅ Phải đăng nhập lại mỗi lần
✅ An toàn hơn trên máy dùng chung

---

## 🎯 Luồng Hoạt Động

```
┌─────────────────┐
│  Đang sử dụng   │
│   hệ thống      │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Click "Đăng xuất"│
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Xác nhận?      │
└────┬───────┬────┘
     │       │
   Có│       │Không
     │       │
     ▼       ▼
┌─────────┐ ┌──────────┐
│Xóa token│ │Tiếp tục  │
└────┬────┘ │sử dụng   │
     │      └──────────┘
     ▼
┌─────────────────┐
│Thông báo thành  │
│     công        │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Màn hình đăng   │
│     nhập        │
└─────────────────┘
```

---

## 🧪 Test Cases

### Test 1: Đăng xuất thành công
1. Đăng nhập vào hệ thống
2. Click button "Đăng xuất"
3. Click "Có" trong dialog xác nhận
4. **Kết quả mong đợi:**
   - File `json_token.txt` bị xóa nội dung
   - Hiển thị thông báo thành công
   - Chuyển về màn hình đăng nhập

### Test 2: Hủy đăng xuất
1. Đăng nhập vào hệ thống
2. Click button "Đăng xuất"
3. Click "Không" trong dialog xác nhận
4. **Kết quả mong đợi:**
   - Vẫn ở màn hình chính
   - Token không bị xóa
   - Tiếp tục sử dụng bình thường

### Test 3: Không thể tự động đăng nhập sau khi đăng xuất
1. Đăng xuất khỏi hệ thống
2. Đóng app
3. Mở lại app
4. **Kết quả mong đợi:**
   - Hiển thị màn hình đăng nhập
   - Không tự động đăng nhập
   - Phải nhập lại thông tin

---

## 📊 So Sánh

| Tính năng | Trước | Sau |
|-----------|-------|-----|
| Xóa token | ❌ Không | ✅ Có |
| Xác nhận | ❌ Không | ✅ Có |
| Thông báo | ❌ Không | ✅ Có |
| Bảo mật | ⚠️ Thấp | ✅ Cao |
| UX | ⚠️ Tạm | ✅ Tốt |

---

## 🔮 Cải Tiến Tương Lai

Có thể thêm:
- [ ] Đăng xuất tự động sau thời gian không hoạt động
- [ ] Lưu lịch sử đăng nhập/đăng xuất
- [ ] Đăng xuất từ xa (logout all devices)
- [ ] Thông báo khi token sắp hết hạn
- [ ] Session management nâng cao

---

## 🐛 Xử Lý Lỗi

### Lỗi: Không xóa được token
```java
catch (Exception e) {
    JOptionPane.showMessageDialog(this, 
        "Lỗi khi đăng xuất: " + e.getMessage(), 
        "Lỗi", 
        JOptionPane.ERROR_MESSAGE);
}
```

### Lỗi: File token không tồn tại
- Hệ thống kiểm tra `file.exists()` trước khi xóa
- Không báo lỗi nếu file không tồn tại

---

## ✅ Checklist

Khi implement tính năng đăng xuất, đảm bảo:
- [x] Xóa token khỏi file
- [x] Xác nhận trước khi đăng xuất
- [x] Thông báo thành công
- [x] Chuyển về màn hình đăng nhập
- [x] Xử lý lỗi đầy đủ
- [x] Test trên nhiều trường hợp
- [x] Đảm bảo bảo mật

---

## 📝 Ghi Chú

- Token được lưu trong file `json_token.txt` ở thư mục gốc của app
- Token có thời hạn, được kiểm tra mỗi lần khởi động app
- Đăng xuất sẽ xóa token ngay lập tức, không cần chờ hết hạn

**Tính năng này giúp bảo mật hệ thống tốt hơn, đặc biệt khi sử dụng trên máy tính dùng chung! 🔒**
