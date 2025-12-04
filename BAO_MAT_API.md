# Tài Liệu Bảo Mật API - Hệ Thống Quản Lý Khóa Luận

## Tổng Quan

Hệ thống sử dụng 2 cơ chế bảo mật chính:
1. **AES-256-CBC** - Mã hóa dữ liệu truyền tải
2. **JWT (JSON Web Token)** - Xác thực và phân quyền người dùng

---

## 1. Mã Hóa AES-256-CBC

### Mục đích
- Mã hóa các thông tin nhạy cảm khi truyền từ client (Java App) đến server (PHP API)
- Bảo vệ username, password, thông tin máy tính khỏi bị đánh cắp

### Cấu hình
```
Key: 12345678901234567890123456789012 (32 bytes)
IV:  1234567890123456 (16 bytes)
Algorithm: AES-256-CBC
```

### File liên quan
- **PHP (Server):** `mvc/private/AES.php`
- **Java (Client):** `testlaythongtinmay/src/testlaythongtinmay/mycls.java`

### Cách sử dụng

#### PHP - Mã hóa/Giải mã
```php
include("../private/AES.php");
$r = new giaimaAES();

// Giải mã
$username = $r->giaima($_REQUEST['username']);

// Mã hóa
$encrypted = $r->mahoa("plain text");
```

#### Java - Mã hóa/Giải mã
```java
mycls cls = new mycls();

// Mã hóa
String encrypted = cls.mahoa("plain text");

// Giải mã
String decrypted = cls.giaima(encrypted);
```

---

## 2. JWT (JSON Web Token)

### Mục đích
- Xác thực người dùng sau khi đăng nhập
- Duy trì phiên đăng nhập mà không cần lưu session trên server
- Chứa thông tin user để phân quyền

### Cấu hình
```
Secret Key: NgoBao
Algorithm: HS256
Thời hạn: 3600 giây (1 giờ)
```

### File liên quan
- `mvc/private/JWT.php`
- `mvc/class/classketnoi.php` (hàm mylogin, loginToken)
- `mvc/api/checktoken.php`

### Cấu trúc Token Payload
```json
{
  "iduser": "1",
  "username": "admin",
  "PQ": "1",
  "tenmay": "DESKTOP-ABC",
  "tencpu": "Intel Core i5",
  "os": "Windows 10",
  "name": "Nguyễn Văn A",
  "MaGV": "GV001"
}
```

### Cách sử dụng

#### Tạo Token (khi đăng nhập thành công)
```php
require("../private/JWT.php");

$token = array();
$token['iduser'] = $iduser;
$token['username'] = $username;
$token['PQ'] = $PQ;
// ... các thông tin khác

$jsonwebtoken = JWT::encode($token, "NgoBao");
```

#### Giải mã Token (xác thực)
```php
require("../private/JWT.php");

$json = JWT::decode($token, "NgoBao", true);
$dulieu = json_decode(json_encode($json), true);

$iduser = $dulieu['iduser'];
$PQ = $dulieu['PQ'];
```

---

## 3. Luồng Xác Thực

### Đăng nhập lần đầu
```
1. Client mã hóa AES: username, password, thông tin máy
2. Client gửi request đến /api/dangnhap.php
3. Server giải mã AES
4. Server kiểm tra thông tin đăng nhập + thông tin máy
5. Nếu hợp lệ: Server tạo JWT token và trả về
6. Client lưu token vào file json_token.txt
```

### Đăng nhập bằng Token (tự động)
```
1. Client đọc token từ file json_token.txt
2. Client gửi token đến /api/checktoken.php
3. Server giải mã JWT và xác thực
4. Nếu hợp lệ: Trả về thông tin user
```

---

## 4. URL Test API

### Base URL
```
Local: http://localhost:8080/CongNgheMoi/mvc/api/
```

### API Endpoints

#### Đăng nhập
```
POST /api/dangnhap.php
Params (đã mã hóa AES):
- username: tên đăng nhập
- password: mật khẩu
- tenmay: tên máy tính
- tencpu: tên CPU
- os: hệ điều hành
- ram1, ram2: thông tin RAM
- rom1, rom2: thông tin ổ cứng
```

#### Kiểm tra Token
```
GET /api/checktoken.php?token={JWT_TOKEN}
Response: Thông tin user nếu token hợp lệ
```

#### Xem đề tài của giảng viên
```
GET /api/getDeTaiGV.php?id={MaGV_encoded}
Params: id - MaGV đã mã hóa AES
```

#### Xem sinh viên theo đề tài
```
GET /api/getSVTheoDeTai.php?id={IDDeTai_encoded}
Params: id - IDDeTai đã mã hóa AES
```

#### Xem điểm
```
GET /api/xemdsdiem.php?id={IDDangKy_encoded}
Params: id - IDDangKy đã mã hóa AES
```

#### Nhập điểm
```
GET /api/nhapdiem.php?Muc1=...&Muc2=...&iddetai=...
Params: Các mục điểm và IDDangKy
```

---

## 5. Response Codes

| Code | Ý nghĩa |
|------|---------|
| 101 | Đăng nhập thành công, chưa đăng ký thông tin máy |
| 102 | Đăng nhập thành công, đã có thông tin máy |

---

## 6. Lưu Ý Bảo Mật

### ⚠️ Cần cải thiện
1. **Key AES cứng trong code** - Nên lưu trong biến môi trường
2. **JWT Secret cứng** - Nên lưu trong .env
3. **Không có HTTPS** - Cần triển khai SSL/TLS
4. **Không có rate limiting** - Dễ bị brute force

### ✅ Đã có
1. Mã hóa dữ liệu nhạy cảm khi truyền
2. Xác thực bằng thông tin máy (hardware binding)
3. Token có thời hạn
4. Phân quyền theo PQ (Phân Quyền)

---

## 7. Test Nhanh với cURL

### Mã hóa AES online
Sử dụng tool online hoặc code PHP:
```php
<?php
include("mvc/private/AES.php");
$r = new giaimaAES();
echo $r->mahoa("test_value");
?>
```

### Test API checktoken
```bash
curl "http://localhost:8080/CongNgheMoi/mvc/api/checktoken.php?token=YOUR_JWT_TOKEN"
```

---

## 8. Cấu Trúc File

```
mvc/
├── private/
│   ├── AES.php          # Class mã hóa AES
│   └── JWT.php          # Class JWT
├── api/
│   ├── dangnhap.php     # API đăng nhập
│   ├── checktoken.php   # API kiểm tra token
│   ├── getDeTaiGV.php   # API lấy đề tài GV
│   ├── getSVTheoDeTai.php # API lấy SV theo đề tài
│   ├── xemdsdiem.php    # API xem điểm
│   └── nhapdiem.php     # API nhập điểm
└── class/
    └── classketnoi.php  # Class xử lý DB + Auth
```
