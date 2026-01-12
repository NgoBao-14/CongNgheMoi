package testlaythongtinmay;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.nio.charset.StandardCharsets;
import java.security.KeyFactory;
import java.security.PublicKey;
import java.security.SecureRandom;
import java.security.spec.X509EncodedKeySpec;
import java.util.Base64;
import javax.crypto.Cipher;
import javax.crypto.KeyGenerator;
import javax.crypto.SecretKey;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import org.json.JSONObject;

/**
 * RSA Key Exchange - Trao đổi AES key an toàn với Server
 * 
 * Luồng:
 * 1. Lấy RSA Public Key từ server
 * 2. Tạo AES key + IV ngẫu nhiên
 * 3. Mã hóa AES key bằng RSA Public Key
 * 4. Gửi lên server, nhận session_id
 * 5. Dùng session_id + AES key cho các request sau
 */
public class RSAKeyExchange {
    
    private String serverPublicKey;
    private byte[] aesKey;
    private byte[] aesIV;
    private String sessionId;
    
    private static final String API_GET_PUBLIC_KEY = Config.getApiBaseUrl() + "getPublicKey.php";
    private static final String API_EXCHANGE_KEY = Config.getApiBaseUrl() + "exchangeKey.php";
    
    /**
     * Thực hiện key exchange với server
     * @return true nếu thành công
     */
    public boolean performKeyExchange() throws Exception {
        // Bước 1: Lấy Public Key từ server
        System.out.println("=== BẮT ĐẦU KEY EXCHANGE ===");
        System.out.println("Bước 1: Lấy RSA Public Key từ server...");
        
        if (!fetchPublicKey()) {
            System.out.println("Lỗi: Không thể lấy public key");
            return false;
        }
        System.out.println("✓ Đã nhận Public Key");
        
        // Bước 2: Tạo AES key và IV ngẫu nhiên
        System.out.println("Bước 2: Tạo AES Key ngẫu nhiên...");
        generateAESKey();
        System.out.println("✓ Đã tạo AES Key (256 bits) và IV (128 bits)");
        
        // Bước 3: Mã hóa AES key bằng RSA Public Key
        System.out.println("Bước 3: Mã hóa AES Key bằng RSA...");
        String encryptedAESKey = encryptAESKeyWithRSA();
        System.out.println("✓ Đã mã hóa AES Key");
        
        // Bước 4: Gửi lên server
        System.out.println("Bước 4: Gửi encrypted key lên server...");
        if (!sendEncryptedKey(encryptedAESKey)) {
            System.out.println("Lỗi: Không thể gửi key lên server");
            return false;
        }
        System.out.println("✓ Key exchange thành công!");
        System.out.println("Session ID: " + sessionId);
        System.out.println("=== KẾT THÚC KEY EXCHANGE ===\n");
        
        return true;
    }
    
    /**
     * Lấy RSA Public Key từ server
     */
    private boolean fetchPublicKey() throws Exception {
        URL url = new URL(API_GET_PUBLIC_KEY);
        HttpURLConnection conn = (HttpURLConnection) url.openConnection();
        conn.setRequestMethod("GET");
        conn.setConnectTimeout(10000);
        conn.setReadTimeout(10000);
        
        int responseCode = conn.getResponseCode();
        if (responseCode != 200) {
            return false;
        }
        
        BufferedReader reader = new BufferedReader(
            new InputStreamReader(conn.getInputStream(), StandardCharsets.UTF_8)
        );
        StringBuilder response = new StringBuilder();
        String line;
        while ((line = reader.readLine()) != null) {
            response.append(line);
        }
        reader.close();
        
        JSONObject json = new JSONObject(response.toString());
        if (json.getInt("success") == 1) {
            serverPublicKey = json.getString("public_key");
            return true;
        }
        
        return false;
    }
    
    /**
     * Tạo AES key và IV ngẫu nhiên
     */
    private void generateAESKey() throws Exception {
        // Tạo AES-256 key
        KeyGenerator keyGen = KeyGenerator.getInstance("AES");
        keyGen.init(256, new SecureRandom());
        SecretKey secretKey = keyGen.generateKey();
        aesKey = secretKey.getEncoded();
        
        // Tạo IV ngẫu nhiên (16 bytes)
        aesIV = new byte[16];
        new SecureRandom().nextBytes(aesIV);
    }
    
    /**
     * Mã hóa AES key bằng RSA Public Key
     */
    private String encryptAESKeyWithRSA() throws Exception {
        // Parse PEM public key
        String publicKeyPEM = serverPublicKey
            .replace("-----BEGIN PUBLIC KEY-----", "")
            .replace("-----END PUBLIC KEY-----", "")
            .replaceAll("\\s", "");
        
        byte[] publicKeyBytes = Base64.getDecoder().decode(publicKeyPEM);
        X509EncodedKeySpec keySpec = new X509EncodedKeySpec(publicKeyBytes);
        KeyFactory keyFactory = KeyFactory.getInstance("RSA");
        PublicKey publicKey = keyFactory.generatePublic(keySpec);
        
        // Mã hóa AES key bằng RSA với OAEP padding
        Cipher cipher = Cipher.getInstance("RSA/ECB/OAEPWithSHA-256AndMGF1Padding");
        cipher.init(Cipher.ENCRYPT_MODE, publicKey);
        byte[] encryptedKey = cipher.doFinal(aesKey);
        
        return Base64.getEncoder().encodeToString(encryptedKey);
    }
    
    /**
     * Gửi encrypted AES key lên server
     */
    private boolean sendEncryptedKey(String encryptedAESKey) throws Exception {
        URL url = new URL(API_EXCHANGE_KEY);
        HttpURLConnection conn = (HttpURLConnection) url.openConnection();
        conn.setRequestMethod("POST");
        conn.setDoOutput(true);
        conn.setConnectTimeout(10000);
        conn.setReadTimeout(10000);
        conn.setRequestProperty("Content-Type", "application/x-www-form-urlencoded");
        
        // Chuẩn bị data
        String aesIvBase64 = Base64.getEncoder().encodeToString(aesIV);
        String postData = "encrypted_aes_key=" + URLEncoder.encode(encryptedAESKey, "UTF-8")
                        + "&aes_iv=" + URLEncoder.encode(aesIvBase64, "UTF-8");
        
        // Gửi request
        try (OutputStream os = conn.getOutputStream()) {
            os.write(postData.getBytes(StandardCharsets.UTF_8));
        }
        
        int responseCode = conn.getResponseCode();
        if (responseCode != 200) {
            return false;
        }
        
        // Đọc response
        BufferedReader reader = new BufferedReader(
            new InputStreamReader(conn.getInputStream(), StandardCharsets.UTF_8)
        );
        StringBuilder response = new StringBuilder();
        String line;
        while ((line = reader.readLine()) != null) {
            response.append(line);
        }
        reader.close();
        
        JSONObject json = new JSONObject(response.toString());
        if (json.getInt("success") == 1) {
            sessionId = json.getString("session_id");
            return true;
        }
        
        return false;
    }
    
    /**
     * Mã hóa dữ liệu bằng AES key đã trao đổi
     */
    public String encrypt(String plaintext) throws Exception {
        if (aesKey == null || aesIV == null) {
            throw new Exception("Chưa thực hiện key exchange. Gọi performKeyExchange() trước.");
        }
        
        SecretKeySpec keySpec = new SecretKeySpec(aesKey, "AES");
        IvParameterSpec ivSpec = new IvParameterSpec(aesIV);
        
        Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
        cipher.init(Cipher.ENCRYPT_MODE, keySpec, ivSpec);
        
        byte[] encrypted = cipher.doFinal(plaintext.getBytes(StandardCharsets.UTF_8));
        return Base64.getEncoder().encodeToString(encrypted);
    }
    
    /**
     * Giải mã dữ liệu bằng AES key đã trao đổi
     */
    public String decrypt(String ciphertext) throws Exception {
        if (aesKey == null || aesIV == null) {
            throw new Exception("Chưa thực hiện key exchange. Gọi performKeyExchange() trước.");
        }
        
        SecretKeySpec keySpec = new SecretKeySpec(aesKey, "AES");
        IvParameterSpec ivSpec = new IvParameterSpec(aesIV);
        
        Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
        cipher.init(Cipher.DECRYPT_MODE, keySpec, ivSpec);
        
        byte[] decoded = Base64.getDecoder().decode(ciphertext);
        byte[] decrypted = cipher.doFinal(decoded);
        
        return new String(decrypted, StandardCharsets.UTF_8);
    }
    
    /**
     * Mã hóa với IV ngẫu nhiên (an toàn hơn)
     * IV được prepend vào ciphertext
     */
    public String encryptWithRandomIV(String plaintext) throws Exception {
        if (aesKey == null) {
            throw new Exception("Chưa thực hiện key exchange.");
        }
        
        // Tạo IV ngẫu nhiên cho mỗi lần mã hóa
        byte[] randomIV = new byte[16];
        new SecureRandom().nextBytes(randomIV);
        
        SecretKeySpec keySpec = new SecretKeySpec(aesKey, "AES");
        IvParameterSpec ivSpec = new IvParameterSpec(randomIV);
        
        Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
        cipher.init(Cipher.ENCRYPT_MODE, keySpec, ivSpec);
        
        byte[] encrypted = cipher.doFinal(plaintext.getBytes(StandardCharsets.UTF_8));
        
        // Prepend IV vào ciphertext
        byte[] combined = new byte[randomIV.length + encrypted.length];
        System.arraycopy(randomIV, 0, combined, 0, randomIV.length);
        System.arraycopy(encrypted, 0, combined, randomIV.length, encrypted.length);
        
        return Base64.getEncoder().encodeToString(combined);
    }
    
    // Getters
    public String getSessionId() {
        return sessionId;
    }
    
    public byte[] getAesKey() {
        return aesKey;
    }
    
    public byte[] getAesIV() {
        return aesIV;
    }
}
