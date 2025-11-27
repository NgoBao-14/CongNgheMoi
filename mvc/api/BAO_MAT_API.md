# 🔒 Bảo Mật API - Hướng Dẫn Chi Tiết

## 📋 Mục Lục
1. [Vấn Đề Hiện Tại](#vấn-đề-hiện-tại)
2. [Các Phương Pháp Bảo Mật](#các-phương-pháp-bảo-mật)
3. [Implementation](#implementation)
4. [Best Practices](#best-practices)
5. [Testing](#testing)

---

## 🚨 Vấn Đề Hiện Tại

### 1. Gửi ID Trực Tiếp Trong URL
```php
// ❌ KHÔNG AN TOÀN
/CongNgheMoi/Admin/CapNhatDT?id=123
/api/xemdetai.php?id=456
```

**Rủi ro:**
- ❌ Ai cũng có thể đoán và thay đổi ID
- ❌ Không xác thực quyền truy cập
- ❌ Dễ bị tấn công IDOR (Insecure Direct Object Reference)
- ❌ Có thể xem/sửa dữ liệu của người khác

### 2. Thiếu Xác Thực Request
```php
// ❌ Không kiểm tra ai đang gọi API
$id = $_REQUEST['id'];
$p->xuatdanhsachdetai($id);
```

**Rủi ro:**
- ❌ Bất kỳ ai cũng có thể gọi API
- ❌ Không biết request từ đâu
- ❌ Không kiểm tra quyền hạn

---

## 🛡️ Các Phương Pháp Bảo Mật

### 1. JWT Token Authentication ⭐ (Khuyên Dùng)

**Ưu điểm:**
- ✅ Stateless (không cần lưu session)
- ✅ Chứa thông tin user
- ✅ Có thời hạn
- ✅ Khó giả mạo

**Cách hoạt động:**
```
Client                          Server
  |                               |
  |---(1) Login (user/pass)------>|
  |                               |
  |<--(2) JWT Token---------------|
  |                               |
  |---(3) Request + Token-------->|
  |                               |
  |<--(4) Verify Token + Data-----|
```

### 2. API Key + Secret

**Ưu điểm:**
- ✅ Đơn giản
- ✅ Dễ implement
- ✅ Phù hợp API nội bộ

### 3. OAuth 2.0

**Ưu điểm:**
- ✅ Chuẩn công nghiệp
- ✅ Bảo mật cao
- ✅ Phù hợp API public

### 4. HMAC Signature

**Ưu điểm:**
- ✅ Đảm bảo tính toàn vẹn
- ✅ Không thể giả mạo
- ✅ Không cần HTTPS (nhưng nên dùng)

---

## 💻 Implementation

### Phương Án 1: JWT Token (Khuyên Dùng) ⭐

#### Bước 1: Cài Đặt JWT Library

**Tải về:**
```bash
# Download từ: https://github.com/firebase/php-jwt
# Hoặc dùng Composer:
composer require firebase/php-jwt
```

#### Bước 2: Tạo File JWT Helper

**File: `mvc/private/JWT_Helper.php`**

```php
<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWT_Helper {
    // Secret key - NÊN LƯU TRONG .ENV
    private static $secret_key = "YOUR_SECRET_KEY_HERE_CHANGE_THIS_123456";
    private static $algorithm = 'HS256';
    
    /**
     * Tạo JWT Token
     * @param array $data - Dữ liệu cần mã hóa (user_id, role, etc.)
     * @param int $expire_time - Thời gian hết hạn (giây)
     * @return string - JWT Token
     */
    public static function createToken($data, $expire_time = 3600) {
        $issued_at = time();
        $expiration_time = $issued_at + $expire_time;
        
        $payload = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "data" => $data
        );
        
        return JWT::encode($payload, self::$secret_key, self::$algorithm);
    }
    
    /**
     * Verify và decode JWT Token
     * @param string $token - JWT Token
     * @return object|false - Dữ liệu hoặc false nếu invalid
     */
    public static function verifyToken($token) {
        try {
            $decoded = JWT::decode($token, new Key(self::$secret_key, self::$algorithm));
            return $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Lấy token từ header
     * @return string|null
     */
    public static function getBearerToken() {
        $headers = getallheaders();
        
        if (isset($headers['Authorization'])) {
            $matches = array();
            if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }
}
?>
```

#### Bước 3: Cập Nhật API Login

**File: `mvc/api/dangnhap_secure.php`**

```php
<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("../private/AES.php");
include("../private/JWT_Helper.php");

$r = new giaimaAES();
$p = new csdl();

// Giải mã dữ liệu
$username = $r->giaima($_REQUEST["username"]);
$pass = $r->giaima($_REQUEST["password"]);
$tenmay = $r->giaima($_REQUEST["tenmay"]);
$tencpu = $r->giaima($_REQUEST["tencpu"]);
$os = $r->giaima($_REQUEST["os"]);
$ram1 = $r->giaima($_REQUEST['ram1']);
$ram2 = $r->giaima($_REQUEST['ram2']);
$rom1 = $r->giaima($_REQUEST['rom1']);
$rom2 = $r->giaima($_REQUEST['rom2']);

// Kiểm tra login
$result = $p->checkloginSecure($username, $pass, $tenmay, $ram1, $ram2, $rom1, $rom2, $os, $tencpu);

if ($result && isset($result['iduser'])) {
    // Tạo JWT Token
    $token_data = array(
        "user_id" => $result['iduser'],
        "username" => $result['username'],
        "role" => $result['PQ'],
        "name" => $result['name']
    );
    
    // Token hết hạn sau 24 giờ
    $jwt_token = JWT_Helper::createToken($token_data, 86400);
    
    // Trả về response
    $response = array(
        "success" => true,
        "token" => $jwt_token,
        "user" => $token_data
    );
    
    echo json_encode($response);
} else {
    $response = array(
        "success" => false,
        "message" => "Đăng nhập thất bại"
    );
    
    echo json_encode($response);
}
?>
```

#### Bước 4: Tạo Middleware Xác Thực

**File: `mvc/api/middleware/auth.php`**

```php
<?php
require_once(__DIR__ . "/../../private/JWT_Helper.php");

class AuthMiddleware {
    
    /**
     * Kiểm tra xác thực
     * @return object|false - User data hoặc false
     */
    public static function authenticate() {
        // Lấy token từ header
        $token = JWT_Helper::getBearerToken();
        
        if (!$token) {
            self::sendUnauthorized("Token không được cung cấp");
            return false;
        }
        
        // Verify token
        $user_data = JWT_Helper::verifyToken($token);
        
        if (!$user_data) {
            self::sendUnauthorized("Token không hợp lệ hoặc đã hết hạn");
            return false;
        }
        
        return $user_data;
    }
    
    /**
     * Kiểm tra quyền truy cập
     * @param object $user_data - Dữ liệu user từ token
     * @param array $allowed_roles - Các role được phép
     * @return bool
     */
    public static function authorize($user_data, $allowed_roles = []) {
        if (empty($allowed_roles)) {
            return true;
        }
        
        if (!in_array($user_data->role, $allowed_roles)) {
            self::sendForbidden("Bạn không có quyền truy cập");
            return false;
        }
        
        return true;
    }
    
    /**
     * Kiểm tra quyền sở hữu resource
     * @param object $user_data - Dữ liệu user từ token
     * @param int $resource_owner_id - ID chủ sở hữu resource
     * @return bool
     */
    public static function checkOwnership($user_data, $resource_owner_id) {
        // Admin có thể truy cập mọi resource
        if ($user_data->role == 0) {
            return true;
        }
        
        // User chỉ có thể truy cập resource của mình
        if ($user_data->user_id != $resource_owner_id) {
            self::sendForbidden("Bạn không có quyền truy cập resource này");
            return false;
        }
        
        return true;
    }
    
    /**
     * Gửi response 401 Unauthorized
     */
    private static function sendUnauthorized($message) {
        http_response_code(401);
        echo json_encode(array(
            "success" => false,
            "message" => $message
        ));
        exit();
    }
    
    /**
     * Gửi response 403 Forbidden
     */
    private static function sendForbidden($message) {
        http_response_code(403);
        echo json_encode(array(
            "success" => false,
            "message" => $message
        ));
        exit();
    }
}
?>
```

#### Bước 5: Bảo Vệ API Endpoints

**File: `mvc/api/xemdetai_secure.php`**

```php
<?php
require_once("../Bridge.php");
include("../class/classketnoi.php");
include("./middleware/auth.php");

// Xác thực token
$user_data = AuthMiddleware::authenticate();
if (!$user_data) {
    exit(); // Middleware đã gửi response lỗi
}

// Kiểm tra quyền (chỉ giảng viên và admin)
if (!AuthMiddleware::authorize($user_data, [0, 1])) {
    exit(); // Middleware đã gửi response lỗi
}

// Lấy dữ liệu
$p = new csdl();

// Nếu là giảng viên, chỉ xem đề tài của mình
if ($user_data->role == 1) {
    $id = $user_data->user_id;
} else {
    // Admin có thể xem tất cả
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $user_data->user_id;
}

$p->xuatdanhsachdetai($id);
?>
```

---

### Phương Án 2: API Key + HMAC Signature

#### File: `mvc/private/API_Security.php`

```php
<?php
class API_Security {
    private static $secret_key = "YOUR_SECRET_KEY_HERE";
    
    /**
     * Tạo HMAC signature
     * @param array $data - Dữ liệu cần ký
     * @param string $timestamp - Timestamp
     * @return string - Signature
     */
    public static function createSignature($data, $timestamp) {
        ksort($data); // Sắp xếp theo key
        $string = http_build_query($data) . $timestamp;
        return hash_hmac('sha256', $string, self::$secret_key);
    }
    
    /**
     * Verify HMAC signature
     * @param array $data - Dữ liệu
     * @param string $signature - Signature cần verify
     * @param string $timestamp - Timestamp
     * @return bool
     */
    public static function verifySignature($data, $signature, $timestamp) {
        // Kiểm tra timestamp (không quá 5 phút)
        if (abs(time() - $timestamp) > 300) {
            return false;
        }
        
        $expected_signature = self::createSignature($data, $timestamp);
        return hash_equals($expected_signature, $signature);
    }
    
    /**
     * Mã hóa ID để gửi trong URL
     * @param int $id - ID cần mã hóa
     * @return string - ID đã mã hóa
     */
    public static function encryptId($id) {
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt(
            $id, 
            'AES-256-CBC', 
            self::$secret_key, 
            0, 
            $iv
        );
        return base64_encode($iv . $encrypted);
    }
    
    /**
     * Giải mã ID
     * @param string $encrypted_id - ID đã mã hóa
     * @return int|false - ID hoặc false nếu lỗi
     */
    public static function decryptId($encrypted_id) {
        $data = base64_decode($encrypted_id);
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);
        
        $decrypted = openssl_decrypt(
            $encrypted, 
            'AES-256-CBC', 
            self::$secret_key, 
            0, 
            $iv
        );
        
        return $decrypted !== false ? (int)$decrypted : false;
    }
}
?>
```

**Sử dụng:**

```php
<?php
// Mã hóa ID trước khi gửi
$encrypted_id = API_Security::encryptId(123);
$url = "/api/xemdetai.php?id=" . urlencode($encrypted_id);

// Giải mã ID khi nhận
$id = API_Security::decryptId($_REQUEST['id']);
if ($id === false) {
    die("ID không hợp lệ");
}
?>
```

---

## 📚 Best Practices

### 1. Luôn Dùng HTTPS
```apache
# .htaccess
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 2. Rate Limiting
```php
<?php
class RateLimiter {
    private static $max_requests = 100; // 100 requests
    private static $time_window = 3600; // per hour
    
    public static function check($user_id) {
        $key = "rate_limit_" . $user_id;
        $requests = apcu_fetch($key);
        
        if ($requests === false) {
            apcu_store($key, 1, self::$time_window);
            return true;
        }
        
        if ($requests >= self::$max_requests) {
            return false;
        }
        
        apcu_inc($key);
        return true;
    }
}
?>
```

### 3. Input Validation
```php
<?php
function validateInput($data, $type) {
    switch ($type) {
        case 'id':
            return filter_var($data, FILTER_VALIDATE_INT);
        case 'email':
            return filter_var($data, FILTER_VALIDATE_EMAIL);
        case 'string':
            return htmlspecialchars(strip_tags($data));
        default:
            return false;
    }
}
?>
```

### 4. CORS Headers
```php
<?php
// Chỉ cho phép domain cụ thể
header("Access-Control-Allow-Origin: https://yourdomain.com");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
?>
```

### 5. Logging
```php
<?php
function logAPIAccess($user_id, $endpoint, $ip) {
    $log = sprintf(
        "[%s] User: %s | Endpoint: %s | IP: %s\n",
        date('Y-m-d H:i:s'),
        $user_id,
        $endpoint,
        $ip
    );
    
    file_put_contents('api_access.log', $log, FILE_APPEND);
}
?>
```

---

## 🧪 Testing

### Test 1: Login và Lấy Token
```bash
curl -X POST http://localhost/CongNgheMoi/mvc/api/dangnhap_secure.php \
  -d "username=encrypted_username" \
  -d "password=encrypted_password"
```

**Response:**
```json
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "user_id": "123",
    "username": "giangvien",
    "role": "1",
    "name": "Nguyễn Văn A"
  }
}
```

### Test 2: Gọi API Với Token
```bash
curl -X GET http://localhost/CongNgheMoi/mvc/api/xemdetai_secure.php \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc..."
```

### Test 3: Gọi API Không Có Token (Phải Lỗi)
```bash
curl -X GET http://localhost/CongNgheMoi/mvc/api/xemdetai_secure.php
```

**Response:**
```json
{
  "success": false,
  "message": "Token không được cung cấp"
}
```

---

## 📊 So Sánh Các Phương Pháp

| Phương pháp | Bảo mật | Độ phức tạp | Hiệu năng | Khuyên dùng |
|-------------|---------|-------------|-----------|-------------|
| JWT Token | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐⭐⭐ | ✅ Có |
| API Key | ⭐⭐⭐ | ⭐⭐ | ⭐⭐⭐⭐⭐ | ⚠️ Nội bộ |
| OAuth 2.0 | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | ⚠️ API Public |
| HMAC | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ✅ Có |
| Encrypt ID | ⭐⭐⭐ | ⭐⭐ | ⭐⭐⭐⭐⭐ | ✅ Bổ sung |

---

## 🎯 Roadmap Implementation

### Phase 1: Cơ Bản (1-2 ngày)
- [ ] Cài đặt JWT library
- [ ] Tạo JWT_Helper class
- [ ] Cập nhật API login
- [ ] Test login và lấy token

### Phase 2: Middleware (2-3 ngày)
- [ ] Tạo AuthMiddleware
- [ ] Bảo vệ các API endpoints
- [ ] Test authentication
- [ ] Test authorization

### Phase 3: Nâng Cao (3-5 ngày)
- [ ] Implement rate limiting
- [ ] Add logging
- [ ] Encrypt sensitive IDs
- [ ] CORS configuration
- [ ] Input validation

### Phase 4: Production (1-2 ngày)
- [ ] Enable HTTPS
- [ ] Environment variables
- [ ] Error handling
- [ ] Documentation
- [ ] Security audit

---

**Tài liệu này sẽ giúp bạn bảo mật API một cách toàn diện và chuyên nghiệp! 🔒**
