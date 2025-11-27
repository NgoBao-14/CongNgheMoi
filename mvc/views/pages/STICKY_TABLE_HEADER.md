# 📌 Sticky Table Header - Cải Tiến Bảng Quản Lý

## 📋 Mô Tả

Cải tiến bảng quản lý với header cố định (sticky) và chỉ scroll nội dung bảng, không scroll cả trang.

---

## ✨ Các Cải Tiến

### 1. Header Sticky (Cố Định)
- ✅ Header bảng luôn hiển thị khi scroll
- ✅ Dễ theo dõi cột dữ liệu
- ✅ Không bị mất tiêu đề khi xem dữ liệu dài

### 2. Scroll Chỉ Trong Bảng
- ✅ Không scroll cả trang
- ✅ Header và filter luôn hiển thị
- ✅ Chỉ nội dung bảng được scroll

### 3. Custom Scrollbar Đẹp
- ✅ Scrollbar tùy chỉnh màu sắc
- ✅ Bo góc mượt mà
- ✅ Hover effect

### 4. Màu Sắc Phân Biệt
- 🟣 **Quản lý Đề Tài**: Gradient tím (Indigo)
- 🟢 **Quản lý Giảng Viên**: Gradient xanh lá (Green)
- 🔵 **Quản lý Sinh Viên**: Gradient xanh dương (Blue)

---

## 🎨 CSS Implementation

### Cấu Trúc HTML:
```html
<div class="table-container">
    <div class="table-wrapper">
        <table class="table data-table">
            <thead>
                <!-- Header sticky -->
            </thead>
            <tbody>
                <!-- Nội dung scroll -->
            </tbody>
        </table>
    </div>
</div>
```

### CSS Chính:

```css
/* Container với chiều cao cố định */
.table-container {
    background: white;
    border-radius: 1rem;
    border: 1px solid #E2E8F0;
    overflow: hidden;
    max-height: calc(100vh - 350px);  /* Chiều cao động */
    display: flex;
    flex-direction: column;
}

/* Wrapper cho scroll */
.table-wrapper {
    overflow-y: auto;  /* Scroll dọc */
    overflow-x: auto;  /* Scroll ngang nếu cần */
    flex: 1;
}

/* Custom scrollbar */
.table-wrapper::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.table-wrapper::-webkit-scrollbar-track {
    background: #F1F5F9;
    border-radius: 4px;
}

.table-wrapper::-webkit-scrollbar-thumb {
    background: #CBD5E1;
    border-radius: 4px;
}

.table-wrapper::-webkit-scrollbar-thumb:hover {
    background: #94A3B8;
}

/* Header sticky với gradient */
.data-table thead {
    background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
    position: sticky;  /* Cố định header */
    top: 0;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15);
}

.data-table thead th {
    padding: 1rem;
    font-size: 0.75rem;
    font-weight: 700;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border: none;
    white-space: nowrap;  /* Không xuống dòng */
}
```

---

## 🎯 Áp Dụng Cho Các Trang

### 1. Quản Lý Đề Tài (QuanLyDT.php)
```css
.data-table thead {
    background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
    /* Gradient tím Indigo */
}
```

### 2. Quản Lý Giảng Viên (QuanLyGV.php)
```css
.data-table thead {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    /* Gradient xanh lá Green */
}
```

### 3. Quản Lý Sinh Viên (QuanLySV.php)
```css
.data-table thead {
    background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
    /* Gradient xanh dương Blue */
}
```

---

## 📊 So Sánh Trước và Sau

### ❌ TRƯỚC:

```
┌─────────────────────────────────┐
│  Header                         │ ← Scroll mất
├─────────────────────────────────┤
│  Filter                         │ ← Scroll mất
├─────────────────────────────────┤
│  Table Header                   │ ← Scroll mất
├─────────────────────────────────┤
│  Row 1                          │
│  Row 2                          │
│  Row 3                          │
│  ...                            │
│  Row 100                        │ ← Phải scroll cả trang
└─────────────────────────────────┘
```

**Vấn đề:**
- ❌ Mất header khi scroll xuống
- ❌ Phải scroll lên lại để xem tên cột
- ❌ Khó theo dõi dữ liệu

---

### ✅ SAU:

```
┌─────────────────────────────────┐
│  Header                         │ ← Luôn hiển thị
├─────────────────────────────────┤
│  Filter                         │ ← Luôn hiển thị
├─────────────────────────────────┤
│ ┌─────────────────────────────┐ │
│ │ Table Header (STICKY)       │ │ ← Cố định
│ ├─────────────────────────────┤ │
│ │ Row 1                       │ │
│ │ Row 2                       │ │
│ │ Row 3                       │ │
│ │ ...                         │ │ ← Chỉ scroll trong này
│ │ Row 100                     │ │
│ └─────────────────────────────┘ │
└─────────────────────────────────┘
```

**Cải thiện:**
- ✅ Header luôn hiển thị
- ✅ Dễ theo dõi cột dữ liệu
- ✅ Không cần scroll lên lại

---

## 🔧 Tính Năng Chi Tiết

### 1. Chiều Cao Động
```css
max-height: calc(100vh - 350px);
```
- Tự động tính chiều cao dựa trên viewport
- Trừ đi phần header, filter, padding
- Responsive với mọi kích thước màn hình

### 2. Sticky Position
```css
position: sticky;
top: 0;
z-index: 10;
```
- Header cố định khi scroll
- Luôn ở trên cùng của bảng
- z-index cao để không bị che

### 3. Shadow Effect
```css
box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15);
```
- Tạo độ sâu cho header
- Phân biệt rõ header và nội dung
- Màu shadow theo gradient

### 4. White Space
```css
white-space: nowrap;
```
- Tiêu đề không xuống dòng
- Giữ header gọn gàng
- Dễ đọc

---

## 🎨 Màu Sắc Gradient

### Quản Lý Đề Tài (Tím Indigo):
```css
background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15);
```

### Quản Lý Giảng Viên (Xanh Lá):
```css
background: linear-gradient(135deg, #10B981 0%, #059669 100%);
box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);
```

### Quản Lý Sinh Viên (Xanh Dương):
```css
background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
```

---

## 📱 Responsive

### Desktop (> 1200px):
- Chiều cao: `calc(100vh - 350px)`
- Hiển thị đầy đủ các cột
- Scrollbar 8px

### Tablet (768px - 1200px):
- Chiều cao: `calc(100vh - 300px)`
- Scroll ngang nếu cần
- Scrollbar 6px

### Mobile (< 768px):
- Chiều cao: `calc(100vh - 250px)`
- Scroll ngang chắc chắn
- Scrollbar 4px

---

## 🧪 Test Cases

### Test 1: Scroll Dọc
1. Mở trang quản lý có nhiều dữ liệu
2. Scroll xuống trong bảng
3. **Kết quả:** Header vẫn hiển thị, filter không scroll

### Test 2: Scroll Ngang
1. Thu nhỏ cửa sổ browser
2. Scroll ngang trong bảng
3. **Kết quả:** Header scroll theo, không bị lệch

### Test 3: Resize Window
1. Thay đổi kích thước cửa sổ
2. Kiểm tra chiều cao bảng
3. **Kết quả:** Tự động điều chỉnh theo viewport

### Test 4: Hover Scrollbar
1. Di chuột vào scrollbar
2. **Kết quả:** Màu scrollbar đổi sang đậm hơn

---

## 💡 Tips & Tricks

### 1. Điều Chỉnh Chiều Cao:
```css
/* Tăng chiều cao bảng */
max-height: calc(100vh - 300px);  /* Giảm từ 350px xuống 300px */

/* Giảm chiều cao bảng */
max-height: calc(100vh - 400px);  /* Tăng từ 350px lên 400px */
```

### 2. Thay Đổi Màu Scrollbar:
```css
.table-wrapper::-webkit-scrollbar-thumb {
    background: #4F46E5;  /* Màu tím */
}
```

### 3. Ẩn Scrollbar (Nếu Muốn):
```css
.table-wrapper {
    scrollbar-width: none;  /* Firefox */
    -ms-overflow-style: none;  /* IE/Edge */
}

.table-wrapper::-webkit-scrollbar {
    display: none;  /* Chrome/Safari */
}
```

### 4. Smooth Scroll:
```css
.table-wrapper {
    scroll-behavior: smooth;
}
```

---

## 🐛 Troubleshooting

### Vấn đề: Header không sticky
**Giải pháp:**
```css
/* Đảm bảo có position: sticky */
.data-table thead {
    position: sticky;
    top: 0;
    z-index: 10;
}
```

### Vấn đề: Scroll không hoạt động
**Giải pháp:**
```css
/* Đảm bảo có overflow */
.table-wrapper {
    overflow-y: auto;
    overflow-x: auto;
}
```

### Vấn đề: Header bị che
**Giải pháp:**
```css
/* Tăng z-index */
.data-table thead {
    z-index: 100;  /* Tăng từ 10 lên 100 */
}
```

---

## 📈 Lợi Ích

### Cho Người Dùng:
- ✅ Dễ theo dõi dữ liệu
- ✅ Không mất tiêu đề khi scroll
- ✅ Trải nghiệm mượt mà hơn
- ✅ Tiết kiệm thời gian

### Cho Hệ Thống:
- ✅ Giao diện chuyên nghiệp
- ✅ Tăng tính khả dụng
- ✅ Giảm lỗi nhập liệu
- ✅ Tăng hiệu quả làm việc

---

## 🔮 Cải Tiến Tương Lai

- [ ] Thêm filter sticky
- [ ] Thêm pagination sticky
- [ ] Thêm action buttons sticky
- [ ] Virtual scrolling cho dữ liệu lớn
- [ ] Lazy loading
- [ ] Export visible data

---

**Tính năng này giúp quản lý dữ liệu dễ dàng và chuyên nghiệp hơn! 📊**
