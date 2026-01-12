# Mô Hình Kiến Trúc Mã Hóa API

## Tổng Quan Hệ Thống

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                           HỆ THỐNG QUẢN LÝ KHÓA LUẬN                            │
│                      Kiến Trúc Bảo Mật API 3 Lớp (Multi-Client)                 │
└─────────────────────────────────────────────────────────────────────────────────┘

┌──────────────────────┐                              ┌──────────────────────┐
│   CLIENT (Java App)  │                              │   SERVER (PHP API)   │
│  testlaythongtinmay  │◄────────── HTTP ──────────►  │      mvc/api/        │
└──────────────────────┘                              └──────────────────────┘
         │                                                      │
         │  ┌─────────────────┐              ┌─────────────────┐│
         └──│   mycls.java    │              │    AES.php      │┘
            │  (Mã hóa AES)   │              │  (Giải mã AES)  │
            └─────────────────┘              └─────────────────┘

┌──────────────────────┐                              ┌──────────────────────┐
│   CLIENT (Web App)   │                              │   SERVER (PHP MVC)   │
│      Browser         │◄────────── HTTP ──────────►  │   mvc/controllers/   │
└──────────────────────┘                              └──────────────────────┘
         │                                                      │
         │  ┌─────────────────┐              ┌─────────────────┐│
         └──│  httpOnly Cookie│              │   $_SESSION +   │┘
            │  (JWT Token)    │              │   JWT Verify    │
            └─────────────────┘              └─────────────────┘
```

---

## Sơ Đồ Luồng Dữ Liệu Chi Tiết

### 1. Luồng Đăng Nhập (Login Flow)

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                              LUỒNG ĐĂNG NHẬP                                    │
└─────────────────────────────────────────────────────────────────────────────────┘

  JAVA CLIENT                                              PHP SERVER
  ───────────                                              ──────────
       │                                                        │
       │  1. Thu thập thông tin                                 │
       │  ┌─────────────────────────┐                           │
       │  │ • username              │                           │
       │  │ • password              │                           │
       │  │ • tenmay (tên máy)      │                           │
       │  │ • tencpu (CPU)          │                           │
       │  │ • os (hệ điều hành)     │                           │
       │  │ • ram1, ram2            │                           │
       │  │ • rom1, rom2            │                           │
       │  └─────────────────────────┘                           │
       │                                                        │
       │  2. Mã hóa AES-256-CBC                                 │
       │  ┌─────────────────────────┐                           │
       │  │ mycls.mahoa(plaintext)  │                           │
       │  │ Key: 32 bytes           │                           │
       │  │ IV:  16 bytes           │                           │
       │  │ Output: Base64 string   │                           │
       │  └─────────────────────────┘                           │
       │                                                        │
       │  3. Gửi HTTP Request                                   │
       │  ─────────────────────────────────────────────────────►│
       │  POST /api/dangnhap.php                                │
       │  Params: username=xxx&password=xxx&tenmay=xxx...       │
       │  (Tất cả đã mã hóa AES)                                │
       │                                                        │
       │                                    4. Giải mã AES      │
       │                                    ┌─────────────────┐ │
       │                                    │ $r->giaima()    │ │
       │                                    │ Giải mã từng    │ │
       │                                    │ parameter       │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │                                    5. Xác thực DB      │
       │                                    ┌─────────────────┐ │
       │                                    │ checklogin()    │ │
       │                                    │ Kiểm tra user   │ │
       │                                    │ + thông tin máy │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │                                    6. Tạo JWT Token    │
       │                                    ┌─────────────────┐ │
       │                                    │ JWT::encode()   │ │
       │                                    │ Payload:        │ │
       │                                    │ • iduser        │ │
       │                                    │ • username      │ │
       │                                    │ • PQ (quyền)    │ │
       │                                    │ • MaGV          │ │
       │                                    │ • name          │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │  7. Nhận Response                                      │
       │  ◄─────────────────────────────────────────────────────│
       │  JSON: { "token": "eyJ...", "code": 102 }              │
       │                                                        │
       │  8. Lưu Token                                          │
       │  ┌─────────────────────────┐                           │
       │  │ ghifile(token, time)    │                           │
       │  │ File: json_token.txt    │                           │
       │  └─────────────────────────┘                           │
       │                                                        │
```

---

### 2. Luồng Gọi API Có Xác Thực (Authenticated API Call)

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                         LUỒNG GỌI API CÓ XÁC THỰC                               │
└─────────────────────────────────────────────────────────────────────────────────┘

  JAVA CLIENT                                              PHP SERVER
  ───────────                                              ──────────
       │                                                        │
       │  1. Đọc Token từ file                                  │
       │  ┌─────────────────────────┐                           │
       │  │ docfile()               │                           │
       │  │ Kiểm tra thời hạn       │                           │
       │  └─────────────────────────┘                           │
       │                                                        │
       │  2. Mã hóa tham số (nếu cần)                           │
       │  ┌─────────────────────────┐                           │
       │  │ mycls.mahoa(MaGV)       │                           │
       │  │ mycls.mahoa(IDDeTai)    │                           │
       │  └─────────────────────────┘                           │
       │                                                        │
       │  3. Gửi HTTP Request + Token                           │
       │  ─────────────────────────────────────────────────────►│
       │  GET /api/getDeTaiGV.php?id=xxx&token=yyy              │
       │                                                        │
       │                                    4. Xác thực Token   │
       │                                    ┌─────────────────┐ │
       │                                    │ JWT::decode()   │ │
       │                                    │ Verify chữ ký   │ │
       │                                    │ Lấy thông tin   │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │                                    5. Giải mã params   │
       │                                    ┌─────────────────┐ │
       │                                    │ $r->giaima(id)  │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │                                    6. Xử lý nghiệp vụ  │
       │                                    ┌─────────────────┐ │
       │                                    │ Query Database  │ │
       │                                    │ Trả về kết quả  │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │  7. Nhận Response                                      │
       │  ◄─────────────────────────────────────────────────────│
       │  JSON: [{ "IDDeTai": 1, "TenDeTai": "..." }, ...]      │
       │                                                        │
```

---

## Kiến Trúc Thành Phần

### Cấu Trúc File

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                              CẤU TRÚC FILE                                      │
└─────────────────────────────────────────────────────────────────────────────────┘

PROJECT ROOT
│
├── testlaythongtinmay/                    ◄── CLIENT (Java Desktop App)
│   └── src/testlaythongtinmay/
│       └── mycls.java                     ◄── Class mã hóa AES + HTTP Client
│           ├── mahoa(String)              - Mã hóa AES-256-CBC
│           ├── giaima(String)             - Giải mã AES-256-CBC
│           ├── ghifile(token, time)       - Lưu JWT token
│           ├── docfile()                  - Đọc JWT token
│           ├── geturl(String)             - HTTP GET request
│           └── docapi(String)             - Đọc JSON từ API
│
└── mvc/                                   ◄── SERVER (PHP Backend)
    │
    ├── private/                           ◄── Thư viện bảo mật
    │   ├── AES.php                        - Class giaimaAES
    │   │   ├── mahoa(String)              - Mã hóa AES-256-CBC
    │   │   └── giaima(String)             - Giải mã AES-256-CBC
    │   │
    │   └── JWT.php                        - Class JWT
    │       ├── encode(payload, key)       - Tạo JWT token
    │       ├── decode(jwt, key)           - Giải mã JWT token
    │       └── sign(msg, key, algo)       - Ký HMAC-SHA256
    │
    ├── api/                               ◄── API Endpoints
    │   ├── dangnhap.php                   - Đăng nhập + tạo token
    │   ├── checktoken.php                 - Xác thực token
    │   ├── getDeTaiGV.php                 - Lấy đề tài theo GV
    │   ├── getSVTheoDeTai.php             - Lấy SV theo đề tài
    │   ├── nhapdiem.php                   - Nhập điểm
    │   └── ...                            - Các API khác
    │
    └── class/
        └── classketnoi.php                - Xử lý DB + Auth logic
```

---

## Chi Tiết Thuật Toán Mã Hóa

### AES-256-CBC

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                           AES-256-CBC ENCRYPTION                                │
└─────────────────────────────────────────────────────────────────────────────────┘

┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│   PLAINTEXT     │     │   AES-256-CBC   │     │   CIPHERTEXT    │
│   "admin123"    │────►│   ENCRYPT       │────►│   Base64 String │
└─────────────────┘     └─────────────────┘     └─────────────────┘
                               │
                    ┌──────────┴──────────┐
                    │                     │
              ┌─────▼─────┐         ┌─────▼─────┐
              │    KEY    │         │    IV     │
              │ 32 bytes  │         │ 16 bytes  │
              │ "123456.. │         │ "123456.. │
              │ ..789012" │         │ ..3456"   │
              └───────────┘         └───────────┘

JAVA (Client):
┌────────────────────────────────────────────────────────────────┐
│ Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");    │
│ cipher.init(Cipher.ENCRYPT_MODE, skey, iv);                    │
│ byte[] encrypted = cipher.doFinal(value.getBytes());           │
│ return Base64.getEncoder().encodeToString(encrypted);          │
└────────────────────────────────────────────────────────────────┘

PHP (Server):
┌────────────────────────────────────────────────────────────────┐
│ $giaima = base64_decode($str);                                 │
│ return openssl_decrypt($giaima, 'AES-256-CBC',                 │
│                        $this->key, OPENSSL_RAW_DATA,           │
│                        $this->iv);                             │
└────────────────────────────────────────────────────────────────┘
```

### JWT (JSON Web Token)

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                              JWT STRUCTURE                                      │
└─────────────────────────────────────────────────────────────────────────────────┘

                    JWT Token = Header.Payload.Signature
                    ─────────────────────────────────────

┌─────────────────────────────────────────────────────────────────────────────────┐
│                                                                                 │
│  ┌─────────────┐   ┌─────────────────────────────┐   ┌───────────────────────┐  │
│  │   HEADER    │   │          PAYLOAD            │   │      SIGNATURE        │  │
│  │─────────────│   │─────────────────────────────│   │───────────────────────│  │
│  │ {           │   │ {                           │   │                       │  │
│  │  "typ":"JWT"│   │  "iduser": "1",             │   │  HMAC-SHA256(         │  │
│  │  "alg":"HS25│   │  "username": "admin",       │   │    base64(header) +   │  │
│  │       6"    │   │  "PQ": "1",                 │   │    "." +              │  │
│  │ }           │   │  "tenmay": "DESKTOP-ABC",   │   │    base64(payload),   │  │
│  │             │   │  "tencpu": "Intel i5",      │   │    "NgoBao"           │  │
│  │             │   │  "os": "Windows 10",        │   │  )                    │  │
│  │             │   │  "name": "Nguyễn Văn A",    │   │                       │  │
│  │             │   │  "MaGV": "GV001"            │   │                       │  │
│  │             │   │ }                           │   │                       │  │
│  └─────────────┘   └─────────────────────────────┘   └───────────────────────┘  │
│        │                       │                              │                 │
│        └───────────────────────┼──────────────────────────────┘                 │
│                                │                                                │
│                    Base64URL Encode mỗi phần                                    │
│                                │                                                │
│                                ▼                                                │
│  eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZHVzZXIiOiIxIi...                     │
│                                                                                 │
└─────────────────────────────────────────────────────────────────────────────────┘

Secret Key: "NgoBao"
Algorithm:  HS256 (HMAC-SHA256)
```

---

## Sequence Diagram - Đăng Nhập Hoàn Chỉnh

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                        SEQUENCE DIAGRAM - ĐĂNG NHẬP                             │
└─────────────────────────────────────────────────────────────────────────────────┘

┌────────┐          ┌────────┐          ┌────────────┐          ┌──────────┐
│  User  │          │ Java   │          │ PHP API    │          │ Database │
│        │          │ Client │          │ Server     │          │          │
└───┬────┘          └───┬────┘          └─────┬──────┘          └────┬─────┘
    │                   │                     │                      │
    │ 1. Nhập username  │                     │                      │
    │    password       │                     │                      │
    │──────────────────►│                     │                      │
    │                   │                     │                      │
    │                   │ 2. Thu thập         │                      │
    │                   │    thông tin máy    │                      │
    │                   │    (CPU, RAM, OS)   │                      │
    │                   │                     │                      │
    │                   │ 3. Mã hóa AES       │                      │
    │                   │    tất cả params    │                      │
    │                   │                     │                      │
    │                   │ 4. HTTP POST        │                      │
    │                   │    /api/dangnhap    │                      │
    │                   │────────────────────►│                      │
    │                   │                     │                      │
    │                   │                     │ 5. Giải mã AES       │
    │                   │                     │    các params        │
    │                   │                     │                      │
    │                   │                     │ 6. Query user        │
    │                   │                     │────────────────────► │
    │                   │                     │                      │
    │                   │                     │ 7. Return user data  │
    │                   │                     │◄────────────────────│
    │                   │                     │                      │
    │                   │                     │ 8. Kiểm tra          │
    │                   │                     │    thông tin máy     │
    │                   │                     │                      │
    │                   │                     │ 9. Tạo JWT Token     │
    │                   │                     │    với payload       │
    │                   │                     │                      │
    │                   │ 10. Response JSON   │                      │
    │                   │     {token, code}   │                      │
    │                   │◄────────────────────│                      │
    │                   │                     │                      │
    │                   │ 11. Lưu token       │                      │
    │                   │     vào file        │                      │
    │                   │                     │                      │
    │ 12. Hiển thị      │                     │                      │
    │     kết quả       │                     │                      │
    │◄──────────────────│                     │                      │
    │                   │                     │                      │
```

---

## Bảng Tóm Tắt Cấu Hình Bảo Mật

| Thành phần | Giá trị | Vị trí |
|------------|---------|--------|
| AES Key | `12345678901234567890123456789012` (32 bytes) | `AES.php`, `mycls.java` |
| AES IV | `1234567890123456` (16 bytes) | `AES.php`, `mycls.java` |
| AES Algorithm | `AES-256-CBC` | Cả 2 phía |
| JWT Secret (API) | `NgoBao` | `JWT.php`, `classketnoi.php` |
| JWT Secret (Web) | `NgoBao_WebSecret_2024` | `Login.php` |
| JWT Algorithm | `HS256` | `JWT.php` |
| Token Expiry (API) | 3600 giây (1 giờ) | `classketnoi.php` |
| Token Expiry (Web) | 1800 giây (30 phút) | `Login.php` |
| Session Timeout | 1800 giây (30 phút) | `index.php` |

---

## Các API Endpoint Sử Dụng Mã Hóa

| API | Params mã hóa AES | Cần JWT Token |
|-----|-------------------|---------------|
| `/api/dangnhap.php` | username, password, tenmay, tencpu, os, ram1, ram2, rom1, rom2 | ❌ |
| `/api/checktoken.php` | - | ✅ (trong query) |
| `/api/getDeTaiGV.php` | id (MaGV) | ✅ |
| `/api/getSVTheoDeTai.php` | id (IDDeTai) | ✅ |
| `/api/xemdsdiem.php` | id (IDDangKy) | ✅ |
| `/api/nhapdiem.php` | iddetai, các mục điểm | ✅ |

---

---

## Bảo Mật Web Session + JWT Cookie

### Luồng Đăng Nhập Web (Browser)

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                         LUỒNG ĐĂNG NHẬP WEB + JWT COOKIE                        │
└─────────────────────────────────────────────────────────────────────────────────┘

  BROWSER                                                  PHP SERVER
  ───────                                                  ──────────
       │                                                        │
       │  1. POST /Login                                        │
       │     username + password                                │
       │  ─────────────────────────────────────────────────────►│
       │                                                        │
       │                                    2. Xác thực DB      │
       │                                    ┌─────────────────┐ │
       │                                    │ mLogin->GetDN() │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │                                    3. Tạo Session      │
       │                                    ┌─────────────────┐ │
       │                                    │ $_SESSION[...]  │ │
       │                                    │ regenerate_id() │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │                                    4. Tạo JWT Cookie   │
       │                                    ┌─────────────────┐ │
       │                                    │ JWT::encode()   │ │
       │                                    │ setcookie()     │ │
       │                                    │ httpOnly=true   │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │  5. Response + Set-Cookie: auth_token=eyJ...           │
       │  ◄─────────────────────────────────────────────────────│
       │                                                        │
       │  6. Browser tự động lưu cookie                         │
       │  ┌─────────────────────────┐                           │
       │  │ Cookie: auth_token=eyJ..│                           │
       │  │ (httpOnly - JS không    │                           │
       │  │  đọc được)              │                           │
       │  └─────────────────────────┘                           │
       │                                                        │
```

### Luồng Tự Động Khôi Phục Session từ JWT

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                    LUỒNG TỰ ĐỘNG KHÔI PHỤC SESSION TỪ JWT                       │
└─────────────────────────────────────────────────────────────────────────────────┘

  BROWSER                                                  PHP SERVER (index.php)
  ───────                                                  ───────────────────────
       │                                                        │
       │  1. Request bất kỳ (có cookie auth_token)              │
       │  ─────────────────────────────────────────────────────►│
       │                                                        │
       │                                    2. Kiểm tra Session │
       │                                    ┌─────────────────┐ │
       │                                    │ if(!$_SESSION   │ │
       │                                    │    ['iduser'])  │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │                                    3. Có JWT Cookie?   │
       │                                    ┌─────────────────┐ │
       │                                    │ $_COOKIE        │ │
       │                                    │ ['auth_token']  │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │                                    4. Verify JWT       │
       │                                    ┌─────────────────┐ │
       │                                    │ JWT::decode()   │ │
       │                                    │ Check exp time  │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │                                    5. Khôi phục Session│
       │                                    ┌─────────────────┐ │
       │                                    │ $_SESSION =     │ │
       │                                    │   JWT payload   │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │  6. Response (user đã đăng nhập)                       │
       │  ◄─────────────────────────────────────────────────────│
       │                                                        │
```

### Cấu Hình Bảo Mật Session (index.php)

```php
// Cấu hình cookie bảo mật
ini_set('session.cookie_httponly', 1);    // Chống XSS đọc cookie
ini_set('session.cookie_samesite', 'Strict'); // Chống CSRF
ini_set('session.use_strict_mode', 1);    // Chỉ chấp nhận session ID do server tạo

// Session timeout 30 phút
$session_timeout = 1800;

// Kiểm tra User-Agent chống session hijacking
if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    session_destroy();
}
```

### JWT Cookie Payload (Web)

```json
{
  "iduser": "1",
  "username": "admin",
  "MaSV": null,
  "MaGV": "GV001",
  "ten": "Nguyễn Văn A",
  "role": "giangvien",
  "phanquyen": "Giảng viên",
  "idNganh": "1",
  "PQ": "1",
  "exp": 1733789400
}
```

### File Liên Quan

| File | Chức năng |
|------|-----------|
| `index.php` | Cấu hình session, tự động khôi phục từ JWT |
| `mvc/controllers/Login.php` | Tạo session + JWT cookie khi đăng nhập |
| `mvc/controllers/Logout.php` | Xóa session + JWT cookie |
| `mvc/private/JWT.php` | Class encode/decode JWT |
| `mvc/api/checkJWT.php` | API debug kiểm tra JWT (xóa sau khi test) |

---

## Lưu Ý Bảo Mật

### ⚠️ Điểm cần cải thiện:
1. Key AES và JWT Secret đang hardcode trong source code
2. Chưa có HTTPS (dữ liệu vẫn có thể bị sniff dù đã mã hóa)
3. Chưa có rate limiting để chống brute force
4. IV cố định (nên random cho mỗi request)

### ✅ Điểm mạnh:
1. Mã hóa 2 lớp (AES cho data + JWT cho auth) - Java App
2. Session + JWT Cookie "Remember Me" - Web App
3. Hardware binding (xác thực theo thông tin máy) - Java App
4. Token có thời hạn (30 phút Web, 1 giờ API)
5. Phân quyền theo role (PQ)
6. httpOnly cookie chống XSS
7. SameSite=Strict chống CSRF
8. Session regenerate chống session fixation
9. User-Agent check chống session hijacking

---

## CÂU HỎI THƯỜNG GẶP VỀ BẢO MẬT API

### Q1: Làm sao biết dữ liệu đúng là giảng viên đó gửi lên?

**Trả lời:**

Hệ thống sử dụng **3 lớp xác thực**:

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                    LUỒNG XÁC THỰC GIẢNG VIÊN NHẬP ĐIỂM                          │
└─────────────────────────────────────────────────────────────────────────────────┘

  1. ĐĂNG NHẬP:
     ┌──────────────────────────────────────────────────────────────────────────┐
     │ Giảng viên nhập: username + password + thông tin máy (CPU, RAM, OS)     │
     │ Server kiểm tra: Đúng tài khoản + Đúng máy đã đăng ký                   │
     │ Server tạo: JWT Token chứa {MaGV, iduser, tenmay, tencpu, os}           │
     │ Server ký: Token được ký bằng Secret Key (chỉ server biết)             │
     └──────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
  2. GỬI REQUEST NHẬP ĐIỂM:
     ┌──────────────────────────────────────────────────────────────────────────┐
     │ Client gửi: {điểm các mục} + token JWT                                  │
     │ Server giải mã token → Lấy MaGV từ payload                              │
     │ Server kiểm tra: Đề tài này có IDGV = MaGV không?                       │
     │ Nếu ĐÚNG → Cho phép nhập điểm                                           │
     │ Nếu SAI → Từ chối với lỗi 403 Forbidden                                 │
     └──────────────────────────────────────────────────────────────────────────┘
```

**Tại sao không thể giả mạo?**
- Token được ký bằng HMAC-SHA256 với Secret Key
- Nếu ai đó sửa payload (đổi MaGV) → Chữ ký không khớp → Token bị reject
- Không có Secret Key → Không thể tạo chữ ký hợp lệ

### Q2: Session truyền qua đâu? Cách bắt?

**Trả lời:**

| Loại Client | Cách truyền Session/Token | Nơi lưu |
|-------------|---------------------------|---------|
| **Java App** | Token gửi trong URL parameter `?token=xxx` | File `json_token.txt` |
| **Web Browser** | Cookie `auth_token` (httpOnly) | Browser Cookie Storage |

**Cách bắt (debug):**
```
Java App:
- Xem file json_token.txt trong thư mục app
- Dùng Wireshark/Fiddler bắt HTTP request

Web:
- F12 → Network → Xem Header Cookie
- F12 → Application → Cookies
```

### Q3: Token-based Authentication là gì?

**Trả lời:**

| Session-based | Token-based (JWT) |
|---------------|-------------------|
| Server lưu session trong memory/DB | Server KHÔNG lưu gì (stateless) |
| Client gửi Session ID | Client gửi Token chứa thông tin |
| Server tra cứu DB để biết user | Server giải mã token để biết user |
| Khó scale (cần sync session) | Dễ scale (không cần sync) |
| Phù hợp web truyền thống | Phù hợp API, Mobile App |

**Hệ thống này dùng Token-based cho Java App, Hybrid (Session + JWT Cookie) cho Web.**

### Q4: Mã hóa đối xứng vs bất đối xứng?

**Trả lời:**

| Đối xứng (AES) | Bất đối xứng (RSA) |
|----------------|-------------------|
| 1 key cho cả mã hóa và giải mã | 2 key: Public + Private |
| Nhanh, phù hợp data lớn | Chậm, phù hợp data nhỏ |
| Vấn đề: Làm sao chia sẻ key an toàn? | Public key công khai, Private key bí mật |
| Hệ thống này dùng AES-256-CBC | Dùng cho chữ ký số, trao đổi key |

**Hệ thống này dùng AES-256-CBC để mã hóa dữ liệu truyền tải.**

### Q5: Chữ ký số hoạt động thế nào?

**Trả lời:**

```
JWT sử dụng HMAC-SHA256 (chữ ký đối xứng):

1. Tạo token:
   Header = {"typ":"JWT","alg":"HS256"}
   Payload = {"MaGV":"GV001","iduser":"1",...}
   Signature = HMAC-SHA256(Header.Payload, "NgoBao")
   Token = Header.Payload.Signature

2. Xác thực token:
   - Tách Header, Payload, Signature
   - Tính lại: Expected = HMAC-SHA256(Header.Payload, "NgoBao")
   - So sánh: Expected == Signature?
   - Nếu khớp → Token hợp lệ, chưa bị sửa đổi
```

### Q6: Nơi lưu Token và điều kiện hợp lệ?

**Trả lời:**

**Nơi lưu:**
| Platform | Nơi lưu | Bảo mật |
|----------|---------|---------|
| Java Desktop | File `json_token.txt` | Cần mã hóa file |
| Android | EncryptedSharedPreferences | Tốt |
| Web | httpOnly Cookie | Chống XSS |
| iOS | Keychain | Tốt nhất |

**Điều kiện Token hợp lệ:**
1. ✅ Chữ ký đúng (không bị sửa đổi)
2. ✅ Chưa hết hạn (exp > now)
3. ✅ Issuer đúng (do server tạo)
4. ✅ Thông tin máy khớp (hardware binding)
