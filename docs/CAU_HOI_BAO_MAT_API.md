# Câu Hỏi Thường Gặp - Bảo Mật API

## Mục Lục
1. [Tại sao lưu thông tin máy (RAM, ROM) có thể thay đổi?](#1-tại-sao-lưu-thông-tin-máy-ram-rom-có-thể-thay-đổi)
2. [Làm sao biết dữ liệu đúng là giảng viên đó gửi lên?](#2-làm-sao-biết-dữ-liệu-đúng-là-giảng-viên-đó-gửi-lên)
3. [Session truyền qua đâu? Cách bắt?](#3-session-truyền-qua-đâu-cách-bắt)
4. [Token-based Authentication là gì?](#4-token-based-authentication-là-gì)
5. [Mã hóa đối xứng vs bất đối xứng?](#5-mã-hóa-đối-xứng-vs-bất-đối-xứng)
6. [Làm sao chia sẻ key đối xứng an toàn?](#6-làm-sao-chia-sẻ-key-đối-xứng-an-toàn)
7. [Chữ ký số hoạt động thế nào?](#7-chữ-ký-số-hoạt-động-thế-nào)
8. [Token lưu ở đâu? Điều kiện hợp lệ?](#8-token-lưu-ở-đâu-điều-kiện-hợp-lệ)
9. [AES là gì? Cách tạo?](#9-aes-là-gì-cách-tạo)

---

## 1. Tại sao lưu thông tin máy (RAM, ROM) có thể thay đổi?

### Câu hỏi
> "Tại sao lưu thông tin máy mà dùng RAM, ROM - mấy cái có thể bị thay đổi?"

### Trả lời

**Đúng là có hạn chế**, nhưng đây là giải pháp **cân bằng giữa bảo mật và trải nghiệm người dùng**:

#### Lý do chọn RAM, ROM, CPU:

| Thông tin | Tính ổn định | Lý do sử dụng |
|-----------|--------------|---------------|
| **Tên máy (hostname)** | Cao | Ít khi đổi, dễ lấy |
| **Tên CPU** | Rất cao | Không đổi trừ khi thay CPU |
| **Hệ điều hành** | Cao | Ít khi nâng cấp |
| **RAM** | Trung bình | Có thể nâng cấp nhưng hiếm |
| **ROM (ổ cứng)** | Trung bình | Có thể thay nhưng hiếm |

#### Mục đích thực sự:
```
Không phải để "khóa cứng" vào 1 máy duy nhất
Mà để PHÁT HIỆN khi có ai đó đánh cắp token và dùng trên máy khác
```

#### Kịch bản bảo vệ:
```
1. Giảng viên A đăng nhập trên máy văn phòng
   → Token được tạo với thông tin: CPU Intel i5, RAM 16GB, Windows 10

2. Hacker đánh cắp token của A

3. Hacker dùng token trên máy của mình
   → Server kiểm tra: CPU AMD Ryzen, RAM 32GB, Windows 11
   → KHÔNG KHỚP → Từ chối truy cập!
```

#### Giải pháp tốt hơn (nếu có thời gian cải tiến):

| Phương pháp | Độ ổn định | Độ khó giả mạo |
|-------------|------------|----------------|
| **MAC Address** | Cao | Có thể spoof |
| **Serial Number ổ cứng** | Rất cao | Khó giả mạo |
| **TPM (Trusted Platform Module)** | Rất cao | Rất khó |
| **Hardware ID (HWID)** | Rất cao | Khó |
| **Fingerprint trình duyệt** | Trung bình | Dễ thay đổi |

#### Code cải tiến (nếu có thời gian):
```java
// Lấy Serial Number ổ cứng (khó thay đổi hơn)
String getHardDriveSerial() {
    String serial = "";
    try {
        Process p = Runtime.getRuntime().exec("wmic diskdrive get serialnumber");
        BufferedReader reader = new BufferedReader(new InputStreamReader(p.getInputStream()));
        String line;
        while ((line = reader.readLine()) != null) {
            if (!line.trim().isEmpty() && !line.contains("SerialNumber")) {
                serial = line.trim();
                break;
            }
        }
    } catch (Exception e) {}
    return serial;
}
```

#### Kết luận:
> "Hệ thống hiện tại sử dụng thông tin phần cứng như một **lớp bảo vệ bổ sung** (defense in depth), không phải lớp bảo vệ duy nhất. Kết hợp với JWT token có thời hạn và xác thực username/password, hệ thống vẫn đảm bảo an toàn ở mức chấp nhận được cho ứng dụng quản lý khóa luận."

---

## 2. Làm sao biết dữ liệu đúng là giảng viên đó gửi lên?

### Câu hỏi
> "Khi giảng viên nhập điểm và gửi lên server, làm sao biết đúng là giảng viên đó gửi?"

### Trả lời

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

### Tại sao không thể giả mạo?

1. **Token được ký bằng HMAC-SHA256** với Secret Key chỉ server biết
2. Nếu ai đó **sửa payload** (đổi MaGV) → **Chữ ký không khớp** → Token bị reject
3. **Không có Secret Key** → Không thể tạo chữ ký hợp lệ

### Code minh họa (PHP):
```php
// Server kiểm tra quyền sở hữu đề tài
$checkOwnership = "
    SELECT dk.IDDangKy 
    FROM dangkydetai dk
    JOIN detai dt ON dk.IDDeTai = dt.IDDeTai
    WHERE dk.IDDangKy = '$iddetai' 
    AND dt.IDGV = '$MaGV_from_token'  // MaGV lấy từ token, không phải từ request
";

if (mysqli_num_rows($result) == 0) {
    // Giảng viên này KHÔNG sở hữu đề tài → Từ chối
    die("Bạn không có quyền nhập điểm cho sinh viên này");
}
```

---

## 3. Session truyền qua đâu? Cách bắt?

### Câu hỏi
> "Session truyền qua đâu? Làm sao bắt được?"

### Trả lời

| Loại Client | Cách truyền | Nơi lưu | Cách bắt (debug) |
|-------------|-------------|---------|------------------|
| **Java App** | URL parameter `?token=xxx` | File `json_token.txt` | Xem file hoặc dùng Wireshark |
| **Web Browser** | Cookie `auth_token` (httpOnly) | Browser Cookie Storage | F12 → Network → Headers |

### Luồng chi tiết:

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                         JAVA APP                                                │
└─────────────────────────────────────────────────────────────────────────────────┘

1. Đăng nhập thành công → Server trả về token
2. App lưu token vào file: json_token.txt
   Nội dung: "eyJhbGciOiJIUzI1NiJ9...|1702900800"
             (token | thời gian hết hạn)

3. Mỗi request tiếp theo:
   URL: /api/nhapdiem.php?Muc1=8&Muc2=7&...&token=eyJhbGciOiJIUzI1NiJ9...

┌─────────────────────────────────────────────────────────────────────────────────┐
│                         WEB BROWSER                                             │
└─────────────────────────────────────────────────────────────────────────────────┘

1. Đăng nhập thành công → Server set cookie:
   Set-Cookie: auth_token=eyJ...; HttpOnly; SameSite=Strict

2. Browser tự động lưu cookie (JavaScript không đọc được vì httpOnly)

3. Mỗi request tiếp theo, browser tự động gửi cookie trong Header:
   Cookie: auth_token=eyJ...; PHPSESSID=abc123
```

### Cách bắt để debug:

**Java App:**
```bash
# Xem file token
type json_token.txt

# Dùng Wireshark/Fiddler bắt HTTP traffic
```

**Web Browser:**
```
F12 → Network → Chọn request → Headers → Cookie
F12 → Application → Cookies → Chọn domain
```

---

## 4. Token-based Authentication là gì?

### Câu hỏi
> "Token-based là sao?"

### Trả lời

| Session-based (Truyền thống) | Token-based (JWT) |
|------------------------------|-------------------|
| Server **lưu session** trong memory/DB | Server **KHÔNG lưu gì** (stateless) |
| Client gửi **Session ID** | Client gửi **Token chứa thông tin** |
| Server **tra cứu DB** để biết user | Server **giải mã token** để biết user |
| Khó scale (cần sync session giữa servers) | Dễ scale (không cần sync) |
| Phù hợp **web truyền thống** | Phù hợp **API, Mobile App** |

### Ví dụ so sánh:

```
SESSION-BASED:
┌─────────┐                    ┌─────────┐
│ Client  │ ── SessionID ───► │ Server  │ ── Tra cứu ──► Database
└─────────┘    "abc123"        └─────────┘               "abc123 → user_id=1"

TOKEN-BASED:
┌─────────┐                    ┌─────────┐
│ Client  │ ── JWT Token ────► │ Server  │ ── Giải mã ──► {user_id: 1, MaGV: "GV001"}
└─────────┘    "eyJ..."        └─────────┘               (Không cần DB!)
```

### Hệ thống này dùng gì?
- **Java App**: Token-based (JWT)
- **Web**: Hybrid (Session + JWT Cookie để "Remember Me")

---

## 5. Mã hóa đối xứng vs bất đối xứng?

### Câu hỏi
> "Giải thích mã hóa đối xứng và bất đối xứng?"

### Trả lời

| Đối xứng (AES) | Bất đối xứng (RSA) |
|----------------|-------------------|
| **1 key** cho cả mã hóa và giải mã | **2 key**: Public + Private |
| **Nhanh**, phù hợp data lớn | **Chậm**, phù hợp data nhỏ |
| Vấn đề: Làm sao chia sẻ key an toàn? | Public key công khai, Private key bí mật |

### Minh họa:

```
ĐỐI XỨNG (AES):
┌─────────┐     KEY="secret"      ┌─────────┐
│ Client  │ ◄──────────────────► │ Server  │
└─────────┘                       └─────────┘
    │                                  │
    │ Mã hóa: AES("data", "secret")    │
    │ ─────────────────────────────►   │
    │                                  │ Giải mã: AES(encrypted, "secret")
    
BẤT ĐỐI XỨNG (RSA):
┌─────────┐                       ┌─────────┐
│ Client  │                       │ Server  │
└─────────┘                       └─────────┘
    │                                  │
    │ ◄── Gửi Public Key ──────────   │ (Server giữ Private Key)
    │                                  │
    │ Mã hóa: RSA("data", PublicKey)  │
    │ ─────────────────────────────►   │
    │                                  │ Giải mã: RSA(encrypted, PrivateKey)
```

### Hệ thống này dùng gì?
- **AES-256-CBC**: Mã hóa dữ liệu truyền tải (username, password, điểm)
- **HMAC-SHA256**: Ký JWT token (thuộc họ đối xứng)

---

## 6. Làm sao chia sẻ key đối xứng an toàn?

### Câu hỏi
> "Mã hóa đối xứng có vấn đề là làm sao chia sẻ key an toàn?"

### Trả lời

Có 3 cách chính:

### Cách 1: Pre-shared Key (Hệ thống hiện tại)
```
Developer hardcode key vào cả Client và Server
Ưu: Đơn giản
Nhược: Decompile app → lộ key
```

### Cách 2: RSA Key Exchange (Khuyến nghị)
```
1. Server tạo cặp RSA (Public/Private)
2. Client lấy Public Key từ server
3. Client tạo AES Key ngẫu nhiên
4. Client mã hóa AES Key bằng RSA Public → gửi server
5. Server giải mã bằng RSA Private → có AES Key
6. Từ đây, cả hai dùng AES Key để mã hóa dữ liệu
```

### Cách 3: Diffie-Hellman
```
Trao đổi key mà không cần gửi key qua mạng
(Phức tạp, ít dùng trong ứng dụng web)
```

### Cách 4: HTTPS/TLS (Thực tế nhất)
```
HTTPS tự động xử lý việc trao đổi key
Chỉ cần cài SSL certificate
```

---

## 7. Chữ ký số hoạt động thế nào?

### Câu hỏi
> "Chữ ký số hoạt động như thế nào?"

### Trả lời

### JWT sử dụng HMAC-SHA256:

```
1. TẠO TOKEN:
   Header = {"typ":"JWT","alg":"HS256"}
   Payload = {"MaGV":"GV001","iduser":"1",...}
   
   Signature = HMAC-SHA256(
       base64(Header) + "." + base64(Payload),
       "NgoBao"  // Secret Key
   )
   
   Token = base64(Header) + "." + base64(Payload) + "." + base64(Signature)
         = "eyJhbGciOiJIUzI1NiJ9.eyJNYUdWIjoiR1YwMDEifQ.abc123..."

2. XÁC THỰC TOKEN:
   - Tách: Header, Payload, Signature
   - Tính lại: Expected = HMAC-SHA256(Header.Payload, "NgoBao")
   - So sánh: Expected == Signature?
   - Nếu KHỚP → Token hợp lệ, chưa bị sửa đổi
   - Nếu KHÔNG KHỚP → Token đã bị giả mạo → Reject!
```

### Tại sao an toàn?
- Không có Secret Key → Không thể tạo Signature đúng
- Sửa Payload → Signature không khớp → Bị phát hiện

---

## 8. Token lưu ở đâu? Điều kiện hợp lệ?

### Câu hỏi
> "Token lưu ở đâu? Điều kiện để token hợp lệ?"

### Trả lời

### Nơi lưu:

| Platform | Nơi lưu | Độ an toàn |
|----------|---------|------------|
| **Java Desktop** | File `json_token.txt` | Trung bình (cần mã hóa file) |
| **Android** | EncryptedSharedPreferences | Tốt |
| **iOS** | Keychain | Rất tốt |
| **Web** | httpOnly Cookie | Tốt (chống XSS) |
| **Web (không nên)** | localStorage | Kém (dễ bị XSS) |

### Điều kiện Token hợp lệ:

```
1. ✅ Chữ ký đúng (không bị sửa đổi)
   → Server tính lại signature và so sánh

2. ✅ Chưa hết hạn (exp > now)
   → Kiểm tra trường "exp" trong payload

3. ✅ Issuer đúng (do server của mình tạo)
   → Kiểm tra trường "iss" nếu có

4. ✅ Thông tin máy khớp (hardware binding)
   → So sánh tenmay, tencpu, os trong token với DB
```

---

## 9. AES là gì? Cách tạo?

### Câu hỏi
> "AES là gì? Cách tạo chữ ký số bằng AES?"

### Trả lời

### AES (Advanced Encryption Standard):
- Thuật toán mã hóa **đối xứng**
- Block size: 128 bits
- Key size: 128/192/256 bits
- Mode phổ biến: CBC, GCM

### Lưu ý quan trọng:
> **AES KHÔNG dùng để tạo chữ ký số!**
> AES dùng để **mã hóa dữ liệu** (encryption)
> Chữ ký số dùng **HMAC** hoặc **RSA**

### Code mã hóa AES (Java):
```java
// Mã hóa
Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
SecretKeySpec keySpec = new SecretKeySpec(key.getBytes(), "AES");
IvParameterSpec ivSpec = new IvParameterSpec(iv.getBytes());
cipher.init(Cipher.ENCRYPT_MODE, keySpec, ivSpec);
byte[] encrypted = cipher.doFinal(data.getBytes());
return Base64.getEncoder().encodeToString(encrypted);
```

### Code mã hóa AES (PHP):
```php
// Mã hóa
$encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
return base64_encode($encrypted);

// Giải mã
$decrypted = openssl_decrypt(base64_decode($encrypted), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
```

---

## Tổng Kết

| Câu hỏi | Trả lời ngắn gọn |
|---------|------------------|
| Tại sao dùng RAM/ROM? | Defense in depth, phát hiện token bị đánh cắp |
| Làm sao biết đúng GV gửi? | JWT token chứa MaGV + kiểm tra quyền sở hữu đề tài |
| Session truyền qua đâu? | Java: URL param, Web: Cookie httpOnly |
| Token-based là gì? | Server không lưu session, client gửi token chứa thông tin |
| Đối xứng vs bất đối xứng? | 1 key vs 2 key (public/private) |
| Chia sẻ key an toàn? | RSA exchange hoặc HTTPS |
| Chữ ký số? | HMAC-SHA256 ký token, không thể giả mạo |
| Token lưu đâu? | File/Cookie, cần httpOnly và mã hóa |
| AES là gì? | Mã hóa đối xứng, KHÔNG phải chữ ký số |
