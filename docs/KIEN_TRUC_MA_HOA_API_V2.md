# Kiến Trúc Mã Hóa API v2 - RSA Key Exchange

## So Sánh v1 vs v2

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                           SO SÁNH V1 vs V2                                      │
└─────────────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────┬─────────────────────────────────────────────┐
│            V1 (Hiện tại)        │              V2 (Cải tiến)                  │
├─────────────────────────────────┼─────────────────────────────────────────────┤
│ AES Key: HARDCODE trong code    │ AES Key: NGẪU NHIÊN mỗi session             │
│ Key: "123456789012345678901234" │ Key: random_bytes(32)                       │
├─────────────────────────────────┼─────────────────────────────────────────────┤
│ IV: CỐ ĐỊNH                     │ IV: NGẪU NHIÊN mỗi request                  │
│ IV: "1234567890123456"          │ IV: random_bytes(16)                        │
├─────────────────────────────────┼─────────────────────────────────────────────┤
│ Trao đổi key: KHÔNG CÓ          │ Trao đổi key: RSA-2048 + OAEP               │
│ (Pre-shared key)                │ (Hybrid encryption)                         │
├─────────────────────────────────┼─────────────────────────────────────────────┤
│ Nếu lộ key: TẤT CẢ bị lộ        │ Nếu lộ key: CHỈ 1 session bị ảnh hưởng     │
├─────────────────────────────────┼─────────────────────────────────────────────┤
│ Decompile app: Lộ key           │ Decompile app: Chỉ thấy thuật toán          │
├─────────────────────────────────┼─────────────────────────────────────────────┤
│ Đổi key: Phải update app + API  │ Đổi key: Tự động mỗi session                │
└─────────────────────────────────┴─────────────────────────────────────────────┘
```

---

## Luồng Key Exchange v2

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                    LUỒNG KEY EXCHANGE (RSA + AES)                               │
└─────────────────────────────────────────────────────────────────────────────────┘

  JAVA CLIENT                                              PHP SERVER
  ───────────                                              ──────────
       │                                                        │
       │  ╔═══════════════════════════════════════════════════╗ │
       │  ║ BƯỚC 1: LẤY RSA PUBLIC KEY                        ║ │
       │  ╚═══════════════════════════════════════════════════╝ │
       │                                                        │
       │  GET /api/getPublicKey.php                             │
       │  ─────────────────────────────────────────────────────►│
       │                                                        │
       │                                    Server có sẵn:      │
       │                                    - RSA Private Key   │
       │                                    - RSA Public Key    │
       │                                                        │
       │  Response: { public_key: "-----BEGIN PUBLIC KEY..." }  │
       │  ◄─────────────────────────────────────────────────────│
       │                                                        │
       │  ╔═══════════════════════════════════════════════════╗ │
       │  ║ BƯỚC 2: TẠO AES KEY NGẪU NHIÊN                    ║ │
       │  ╚═══════════════════════════════════════════════════╝ │
       │                                                        │
       │  Client tạo:                                           │
       │  ┌─────────────────────────────────┐                   │
       │  │ AES_KEY = random(32 bytes)      │                   │
       │  │ AES_IV  = random(16 bytes)      │                   │
       │  └─────────────────────────────────┘                   │
       │                                                        │
       │  ╔═══════════════════════════════════════════════════╗ │
       │  ║ BƯỚC 3: MÃ HÓA AES KEY BẰNG RSA                   ║ │
       │  ╚═══════════════════════════════════════════════════╝ │
       │                                                        │
       │  Client mã hóa:                                        │
       │  ┌─────────────────────────────────────────────────┐   │
       │  │ encrypted_key = RSA_Encrypt(AES_KEY, PublicKey) │   │
       │  │ Padding: OAEP with SHA-256                      │   │
       │  └─────────────────────────────────────────────────┘   │
       │                                                        │
       │  ╔═══════════════════════════════════════════════════╗ │
       │  ║ BƯỚC 4: GỬI ENCRYPTED KEY LÊN SERVER              ║ │
       │  ╚═══════════════════════════════════════════════════╝ │
       │                                                        │
       │  POST /api/exchangeKey.php                             │
       │  Body: { encrypted_aes_key, aes_iv }                   │
       │  ─────────────────────────────────────────────────────►│
       │                                                        │
       │                                    Server giải mã:     │
       │                                    ┌─────────────────┐ │
       │                                    │ AES_KEY =       │ │
       │                                    │ RSA_Decrypt(    │ │
       │                                    │   encrypted,    │ │
       │                                    │   PrivateKey)   │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │                                    Server lưu:         │
       │                                    ┌─────────────────┐ │
       │                                    │ session_id →    │ │
       │                                    │ {AES_KEY,       │ │
       │                                    │  AES_IV,        │ │
       │                                    │  expires}       │ │
       │                                    └─────────────────┘ │
       │                                                        │
       │  Response: { session_id: "abc123..." }                 │
       │  ◄─────────────────────────────────────────────────────│
       │                                                        │
       │  Client lưu: session_id + AES_KEY + AES_IV             │
       │                                                        │
       │  ╔═══════════════════════════════════════════════════╗ │
       │  ║ BƯỚC 5: SỬ DỤNG AES KEY CHO CÁC REQUEST           ║ │
       │  ╚═══════════════════════════════════════════════════╝ │
       │                                                        │
       │  Request: { session_id, data: AES_Encrypt(payload) }   │
       │  ─────────────────────────────────────────────────────►│
       │                                                        │
       │                                    Server:             │
       │                                    1. Lấy AES_KEY từ   │
       │                                       session_id       │
       │                                    2. Giải mã data     │
       │                                    3. Xử lý nghiệp vụ  │
       │                                                        │
```

---

## Cấu Trúc File v2

```
PROJECT ROOT
│
├── testlaythongtinmay/                    ◄── CLIENT (Java Desktop App)
│   └── src/testlaythongtinmay/
│       ├── mycls.java                     ◄── v1: AES với key cố định
│       └── RSAKeyExchange.java            ◄── v2: RSA + AES dynamic key
│           ├── performKeyExchange()       - Thực hiện trao đổi key
│           ├── fetchPublicKey()           - Lấy RSA public key
│           ├── generateAESKey()           - Tạo AES key ngẫu nhiên
│           ├── encryptAESKeyWithRSA()     - Mã hóa AES key bằng RSA
│           ├── encrypt()                  - Mã hóa data bằng AES
│           └── encryptWithRandomIV()      - Mã hóa với IV ngẫu nhiên
│
└── mvc/                                   ◄── SERVER (PHP Backend)
    │
    └── private/
        ├── AES.php                        ◄── v1: Key cố định
        ├── AES_v2.php                     ◄── v2: Key từ session
        ├── RSA.php                        ◄── RSA Key Exchange
        │   ├── generateKeyPair()          - Tạo cặp RSA key
        │   ├── getPublicKey()             - Lấy public key
        │   └── decryptAESKey()            - Giải mã AES key
        │
        ├── keys/                          ◄── Thư mục chứa RSA keys
        │   ├── private_key.pem            - RSA Private Key (BÍ MẬT)
        │   └── public_key.pem             - RSA Public Key (công khai)
        │
        └── sessions/                      ◄── Thư mục chứa session keys
            └── {session_id}.json          - AES key cho mỗi session
```

---

## Code Ví Dụ

### Java Client - Sử dụng v2

```java
// Khởi tạo và thực hiện key exchange
RSAKeyExchange keyExchange = new RSAKeyExchange();

// Bước 1-4: Trao đổi key với server
if (keyExchange.performKeyExchange()) {
    System.out.println("Session ID: " + keyExchange.getSessionId());
    
    // Bước 5: Mã hóa dữ liệu bằng AES key đã trao đổi
    String encrypted = keyExchange.encrypt("username=admin&password=123456");
    
    // Gửi request với session_id
    String url = API_URL + "?session_id=" + keyExchange.getSessionId() 
               + "&data=" + URLEncoder.encode(encrypted, "UTF-8");
}
```

### PHP Server - Sử dụng v2

```php
<?php
require_once("../private/AES_v2.php");

// Lấy session_id từ request
$sessionId = $_REQUEST['session_id'];
$encryptedData = $_REQUEST['data'];

// Tạo AES instance với session key
$aes = new AESv2($sessionId);

// Giải mã dữ liệu
$decrypted = $aes->decrypt($encryptedData);
// $decrypted = "username=admin&password=123456"

// Xử lý nghiệp vụ...
?>
```

---

## Bảng So Sánh Bảo Mật

| Tiêu chí | v1 (Pre-shared) | v2 (RSA Exchange) |
|----------|-----------------|-------------------|
| **Key cố định** | ✅ Có | ❌ Không |
| **Key ngẫu nhiên mỗi session** | ❌ Không | ✅ Có |
| **IV ngẫu nhiên** | ❌ Không | ✅ Có |
| **Forward Secrecy** | ❌ Không | ✅ Có |
| **Chống Replay Attack** | ❌ Yếu | ✅ Tốt |
| **Decompile lộ key** | ✅ Có | ❌ Không |
| **Độ phức tạp** | Thấp | Trung bình |
| **Performance** | Nhanh | Chậm hơn (lần đầu) |

---

## Forward Secrecy là gì?

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                         FORWARD SECRECY                                         │
└─────────────────────────────────────────────────────────────────────────────────┘

Giả sử hacker bắt được TẤT CẢ traffic mã hóa và lưu lại.
Sau đó hacker lấy được Private Key của server.

┌─────────────────────────────────┬─────────────────────────────────────────────┐
│            V1 (Không có FS)     │              V2 (Có Forward Secrecy)        │
├─────────────────────────────────┼─────────────────────────────────────────────┤
│ Hacker có Private Key           │ Hacker có Private Key                       │
│ → Giải mã được TẤT CẢ traffic   │ → Chỉ giải được AES key của session đó     │
│    đã bắt trước đó              │ → Mỗi session có AES key KHÁC NHAU         │
│                                 │ → Traffic cũ vẫn AN TOÀN                   │
└─────────────────────────────────┴─────────────────────────────────────────────┘
```

---

## Khi nào dùng v1 vs v2?

| Trường hợp | Khuyến nghị |
|------------|-------------|
| Ứng dụng nội bộ, ít user | v1 (đơn giản) |
| Ứng dụng public, nhiều user | v2 (an toàn) |
| Dữ liệu nhạy cảm (điểm, tài chính) | v2 + HTTPS |
| Prototype, demo | v1 |
| Production | v2 + HTTPS |

---

## Cách Triển Khai v2

### Bước 1: Tạo RSA Key Pair (chạy 1 lần)

```php
<?php
require_once("mvc/private/RSA.php");
$rsa = new RSAKeyExchange();
$result = $rsa->generateKeyPair();
echo $result['message'];
// Output: "RSA key pair đã được tạo thành công"
?>
```

### Bước 2: Cập nhật Java App

```java
// Thay thế mycls bằng RSAKeyExchange
// Trước:
mycls cls = new mycls();
String encrypted = cls.mahoa("data");

// Sau:
RSAKeyExchange keyExchange = new RSAKeyExchange();
keyExchange.performKeyExchange();
String encrypted = keyExchange.encrypt("data");
```

### Bước 3: Cập nhật PHP API

```php
// Thay thế AES.php bằng AES_v2.php
// Trước:
$r = new giaimaAES();
$data = $r->giaima($_REQUEST['data']);

// Sau:
$aes = new AESv2($_REQUEST['session_id']);
$data = $aes->decrypt($_REQUEST['data']);
```

---

## Lưu Ý Bảo Mật v2

### ✅ Đã cải thiện:
1. Key ngẫu nhiên mỗi session
2. IV ngẫu nhiên mỗi request (tùy chọn)
3. Forward Secrecy
4. Không lộ key khi decompile

### ⚠️ Vẫn cần:
1. **HTTPS** - Chống Man-in-the-Middle
2. **Certificate Pinning** - Chống fake certificate
3. **Rate Limiting** - Chống brute force
4. **Key Rotation** - Đổi RSA key định kỳ

---

## API Endpoints v2

| API | Method | Mô tả |
|-----|--------|-------|
| `/api/getPublicKey.php` | GET | Lấy RSA Public Key |
| `/api/exchangeKey.php` | POST | Gửi encrypted AES key, nhận session_id |
| `/api/dangnhap.php` | POST | Đăng nhập (thêm session_id) |
| `/api/nhapdiem.php` | POST | Nhập điểm (thêm session_id) |

---

## Tổng Kết

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                              TÓM TẮT                                            │
└─────────────────────────────────────────────────────────────────────────────────┘

V1 (Pre-shared Key):
├── Ưu điểm: Đơn giản, nhanh
├── Nhược điểm: Key cố định, lộ khi decompile
└── Phù hợp: Demo, prototype, ứng dụng nội bộ

V2 (RSA Key Exchange):
├── Ưu điểm: An toàn, Forward Secrecy, key ngẫu nhiên
├── Nhược điểm: Phức tạp hơn, chậm hơn lần đầu
└── Phù hợp: Production, dữ liệu nhạy cảm

Khuyến nghị cho hệ thống quản lý khóa luận:
→ Dùng V2 + HTTPS để bảo vệ điểm số sinh viên
```
