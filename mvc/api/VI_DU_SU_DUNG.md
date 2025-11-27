# 📖 Ví Dụ Sử Dụng API Bảo Mật

## 🎯 Mục Lục
1. [Login và Lấy Token](#1-login-và-lấy-token)
2. [Gọi API Với Token](#2-gọi-api-với-token)
3. [Ví Dụ Từng Loại API](#3-ví-dụ-từng-loại-api)
4. [Client Side (JavaScript)](#4-client-side-javascript)
5. [Java Desktop App](#5-java-desktop-app)

---

## 1. Login và Lấy Token

### API Endpoint: `dangnhap_secure.php`

**Request:**
```http
POST /CongNgheMoi/mvc/api/dangnhap_secure.php
Content-Type: application/x-www-form-urlencoded

username=encrypted_username&password=encrypted_password&tenmay=encrypted_tenmay&...
```

**Response Success:**
```json
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzQ1Njc4OTAsImV4cCI6MTYzNDY1NDI5MCwiZGF0YSI6eyJ1c2VyX2lkIjoiMTIzIiwidXNlcm5hbWUiOiJnaWFuZ3ZpZW4iLCJyb2xlIjoiMSIsIm5hbWUiOiJOZ3V54buFbiBWxINuIEEifX0.abc123xyz",
  "user": {
    "user_id": "123",
    "username": "giangvien",
    "role": "1",
    "name": "Nguyễn Văn A"
  }
}
```

**Response Error:**
```json
{
  "success": false,
  "message": "Đăng nhập thất bại"
}
```

---

## 2. Gọi API Với Token

### Cách 1: Dùng Authorization Header (Khuyên dùng)

```http
GET /CongNgheMoi/mvc/api/xemdetai_secure.php
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
```

### Cách 2: Dùng Query String (Không khuyến khích)

```http
GET /CongNgheMoi/mvc/api/xemdetai_secure.php?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
```

---

## 3. Ví Dụ Từng Loại API

### A. API Xem Đề Tài (Giảng Viên)

**File: `mvc/api/xemdetai_secure.php`**

```php
<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("./middleware/auth.php");

// Bước 1: Xác thực token
$user = AuthMiddleware::authenticate();
if (!$user) {
    exit(); // Middleware đã gửi response lỗi
}

// Bước 2: Kiểm tra quyền (chỉ giảng viên và admin)
if (!AuthMiddleware::authorize($user, [0, 1])) {
    exit();
}

// Bước 3: Lấy dữ liệu
$p = new csdl();

// Giảng viên chỉ xem đề tài của mình
if ($user->role == 1) {
    $id = $user->user_id;
} else {
    // Admin có thể xem tất cả
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $user->user_id;
}

$p->xuatdanhsachdetai($id);
?>
```

**Gọi API:**
```bash
curl -X GET http://localhost/CongNgheMoi/mvc/api/xemdetai_secure.php \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

### B. API Xem Điểm (Kiểm tra ownership)

**File: `mvc/api/xemdsdiem_secure.php`**

```php
<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("./middleware/auth.php");

// Xác thực
$user = AuthMiddleware::authenticate();
if (!$user) exit();

// Lấy ID đề tài
$iddetai = isset($_REQUEST['iddetai']) ? $_REQUEST['iddetai'] : null;

if (!$iddetai) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "ID đề tài không được cung cấp"]);
    exit();
}

// Kiểm tra quyền sở hữu
// Lấy thông tin đề tài để biết ai là chủ
$p = new csdl();
$detai_info = $p->getDetaiInfo($iddetai); // Cần tạo method này

if (!$detai_info) {
    http_response_code(404);
    echo json_encode(["success" => false, "message" => "Đề tài không tồn tại"]);
    exit();
}

// Kiểm tra ownership
if (!AuthMiddleware::checkOwnership($user, $detai_info['idgiangvien'])) {
    exit();
}

// Lấy dữ liệu
$p->xuatdanhsachdiem($iddetai);
?>
```

---

### C. API Nhập Điểm (Kiểm tra quyền và ownership)

**File: `mvc/api/nhapdiem_secure.php`**

```php
<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("./middleware/auth.php");

// Xác thực
$user = AuthMiddleware::authenticate();
if (!$user) exit();

// Chỉ giảng viên và admin mới được nhập điểm
if (!AuthMiddleware::authorize($user, [0, 1])) {
    exit();
}

// Rate limiting: Tối đa 50 request/giờ
if (!AuthMiddleware::checkRateLimit($user, 50, 3600)) {
    exit();
}

// Lấy dữ liệu
$iddetai = $_REQUEST['iddetai'];
$Muc1 = $_REQUEST['Muc1'];
$Muc2 = $_REQUEST['Muc2'];
// ... các mục khác

// Kiểm tra ownership
$p = new csdl();
$detai_info = $p->getDetaiInfo($iddetai);

if (!AuthMiddleware::checkOwnership($user, $detai_info['idgiangvien'])) {
    exit();
}

// Nhập điểm
$result = $p->nhapdiem($iddetai, $Muc1, $Muc2, ...);

echo json_encode([
    "success" => true,
    "message" => "Nhập điểm thành công"
]);
?>
```

---

### D. API Quản Lý Theo Khoa (Trưởng Khoa)

**File: `mvc/api/getDeTaiTheoKhoa_secure.php`**

```php
<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("./middleware/auth.php");

// Xác thực
$user = AuthMiddleware::authenticate();
if (!$user) exit();

// Chỉ trưởng khoa và admin
if (!AuthMiddleware::authorize($user, [0, 3])) {
    exit();
}

$idkhoa = isset($_REQUEST['idkhoa']) ? $_REQUEST['idkhoa'] : null;

// Lấy khoa của user
$p = new csdl();
$user_khoa = $p->getUserKhoa($user->user_id);

// Kiểm tra quyền truy cập khoa
if (!AuthMiddleware::checkKhoaAccess($user, $idkhoa, $user_khoa)) {
    exit();
}

// Lấy dữ liệu
$p->getDeTaiTheoKhoa($idkhoa);
?>
```

---

## 4. Client Side (JavaScript)

### A. Login và Lưu Token

```javascript
// Login function
async function login(username, password) {
    try {
        // Mã hóa dữ liệu trước khi gửi (dùng AES như Java app)
        const encryptedUsername = encryptAES(username);
        const encryptedPassword = encryptAES(password);
        
        const response = await fetch('/CongNgheMoi/mvc/api/dangnhap_secure.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                username: encryptedUsername,
                password: encryptedPassword,
                tenmay: encryptedTenmay,
                // ... các field khác
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Lưu token vào localStorage
            localStorage.setItem('token', data.token);
            localStorage.setItem('user', JSON.stringify(data.user));
            
            console.log('Đăng nhập thành công!');
            return true;
        } else {
            console.error('Đăng nhập thất bại:', data.message);
            return false;
        }
    } catch (error) {
        console.error('Lỗi:', error);
        return false;
    }
}

// Sử dụng
login('giangvien', 'password123');
```

### B. Gọi API Với Token

```javascript
// Helper function để gọi API
async function callAPI(endpoint, method = 'GET', data = null) {
    const token = localStorage.getItem('token');
    
    if (!token) {
        console.error('Chưa đăng nhập!');
        window.location.href = '/login';
        return null;
    }
    
    const options = {
        method: method,
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
        }
    };
    
    if (data && method !== 'GET') {
        options.body = JSON.stringify(data);
    }
    
    try {
        const response = await fetch(endpoint, options);
        
        // Nếu 401, token hết hạn
        if (response.status === 401) {
            console.error('Token hết hạn, vui lòng đăng nhập lại');
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/login';
            return null;
        }
        
        return await response.json();
    } catch (error) {
        console.error('Lỗi khi gọi API:', error);
        return null;
    }
}

// Ví dụ sử dụng
async function loadDeTai() {
    const data = await callAPI('/CongNgheMoi/mvc/api/xemdetai_secure.php');
    
    if (data) {
        console.log('Danh sách đề tài:', data);
        // Hiển thị dữ liệu
    }
}

loadDeTai();
```

### C. Axios (Nếu dùng)

```javascript
// Cấu hình Axios
import axios from 'axios';

// Interceptor để tự động thêm token
axios.interceptors.request.use(
    config => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers['Authorization'] = `Bearer ${token}`;
        }
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

// Interceptor để xử lý lỗi 401
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response && error.response.status === 401) {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

// Sử dụng
async function getDeTai() {
    try {
        const response = await axios.get('/CongNgheMoi/mvc/api/xemdetai_secure.php');
        console.log(response.data);
    } catch (error) {
        console.error('Lỗi:', error);
    }
}
```

---

## 5. Java Desktop App

### A. Cập Nhật mycls.java

```java
public class mycls {
    private String jwtToken = null;
    
    /**
     * Đăng nhập và lấy JWT token
     */
    public boolean loginAndGetToken(String username, String password, ...) {
        try {
            // Mã hóa dữ liệu
            username = mahoa(username).replace("+", "%2B");
            password = mahoa(password).replace("+", "%2B");
            // ... các field khác
            
            String thamso = "username=" + username + "&password=" + password + ...;
            String url = Constants.API_LOGIN_SECURE + thamso;
            
            // Gọi API
            JSONObject response = docapiObject(url);
            
            if (response.getBoolean("success")) {
                // Lưu token
                this.jwtToken = response.getString("token");
                
                // Lưu vào file
                ghifile(this.jwtToken, System.currentTimeMillis() / 1000 + 86400);
                
                return true;
            }
            
            return false;
        } catch (Exception e) {
            e.printStackTrace();
            return false;
        }
    }
    
    /**
     * Gọi API với JWT token
     */
    public JSONArray docapiWithToken(String url) {
        try {
            URL obj = new URL(url);
            HttpURLConnection con = (HttpURLConnection) obj.openConnection();
            con.setRequestMethod("GET");
            
            // Thêm Authorization header
            if (this.jwtToken != null) {
                con.setRequestProperty("Authorization", "Bearer " + this.jwtToken);
            }
            
            // Đọc response
            BufferedReader in = new BufferedReader(
                new InputStreamReader(con.getInputStream())
            );
            String inputLine;
            StringBuffer response = new StringBuffer();
            
            while ((inputLine = in.readLine()) != null) {
                response.append(inputLine);
            }
            in.close();
            
            // Parse JSON
            JSONArray jarr = new JSONArray(response.toString());
            return jarr;
        } catch (Exception e) {
            System.out.println("Lỗi: " + e.getMessage());
            return null;
        }
    }
    
    /**
     * Đọc token từ file
     */
    public String docToken() throws IOException {
        File file = new File("json_token.txt");
        if (!file.exists()) return null;
        
        try (BufferedReader br = new BufferedReader(new FileReader(file))) {
            String line = br.readLine();
            if (line != null && !line.isEmpty()) {
                String[] parts = line.split("\\|");
                if (parts.length == 2) {
                    String token = parts[0];
                    long expireTime = Long.parseLong(parts[1]);
                    
                    // Kiểm tra hết hạn
                    if (System.currentTimeMillis() / 1000 < expireTime) {
                        this.jwtToken = token;
                        return token;
                    }
                }
            }
        }
        
        return null;
    }
}
```

### B. Sử dụng Trong App

```java
// Login
mycls cls = new mycls();
boolean success = cls.loginAndGetToken(username, password, ...);

if (success) {
    // Gọi API
    JSONArray detai = cls.docapiWithToken(Constants.API_XEM_DETAI_SECURE);
    
    // Xử lý dữ liệu
    for (int i = 0; i < detai.length(); i++) {
        JSONObject dt = detai.getJSONObject(i);
        // ...
    }
}
```

---

## 📝 Checklist Implementation

### Phase 1: Setup
- [ ] Tạo file JWT_Helper.php
- [ ] Tạo file AuthMiddleware.php
- [ ] Test JWT encoding/decoding

### Phase 2: Update API
- [ ] Tạo dangnhap_secure.php
- [ ] Update các API endpoints
- [ ] Test với Postman/curl

### Phase 3: Update Client
- [ ] Update JavaScript code
- [ ] Update Java app
- [ ] Test end-to-end

### Phase 4: Production
- [ ] Change secret key
- [ ] Enable HTTPS
- [ ] Add logging
- [ ] Security audit

---

**Với hướng dẫn này, bạn có thể bảo mật API một cách toàn diện! 🔒**
