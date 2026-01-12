package testlaythongtinmay;

import java.io.*;
import java.net.HttpURLConnection;
import java.net.URL;
import java.nio.charset.Charset;
import java.nio.charset.StandardCharsets;
import java.time.Instant;
import java.util.Base64;
import javax.crypto.Cipher;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import org.json.JSONArray;
import org.json.JSONObject;
import org.json.JSONTokener;
import org.apache.commons.io.IOUtils;

/**
 * Utility class cho mã hóa AES và gọi API
 */
public class mycls {
    
    private final String key = Config.getAesKey();
    private final String iv = Config.getAesIv();
    
    /**
     * Gọi API và trả về JSONArray
     */
    public JSONArray docapi(String url) {
        try {
            String response = IOUtils.toString(new URL(url).openStream(), StandardCharsets.UTF_8);
            Object json = new JSONTokener(response).nextValue();
            
            if (json instanceof JSONArray) {
                return (JSONArray) json;
            } else if (json instanceof JSONObject) {
                JSONObject obj = (JSONObject) json;
                if (obj.has("error")) {
                    System.err.println("API Error: " + obj.getString("error"));
                }
            }
            return null;
        } catch (Exception e) {
            System.err.println("Lỗi docapi: " + e.getMessage());
            return null;
        }
    }
    
    /**
     * Gọi API GET đơn giản
     */
    public void geturl(String url) {
        try {
            HttpURLConnection con = (HttpURLConnection) new URL(url).openConnection();
            con.setRequestMethod("GET");
            con.setConnectTimeout(10000);
            con.setReadTimeout(10000);
            
            int responseCode = con.getResponseCode();
            String response = IOUtils.toString(con.getInputStream(), StandardCharsets.UTF_8);
            
            System.out.println("Response [" + responseCode + "]: " + response);
            con.disconnect();
        } catch (Exception e) {
            System.err.println("Lỗi geturl: " + e.getMessage());
        }
    }
    
    /**
     * Mã hóa AES-256-CBC
     */
    public String mahoa(String value) throws Exception {
        IvParameterSpec ivSpec = new IvParameterSpec(iv.getBytes(StandardCharsets.UTF_8));
        SecretKeySpec keySpec = new SecretKeySpec(key.getBytes(StandardCharsets.UTF_8), "AES");
        
        Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
        cipher.init(Cipher.ENCRYPT_MODE, keySpec, ivSpec);
        
        byte[] encrypted = cipher.doFinal(value.getBytes(StandardCharsets.UTF_8));
        return Base64.getEncoder().encodeToString(encrypted);
    }
    
    /**
     * Giải mã AES-256-CBC
     */
    public String giaima(String encryptedValue) throws Exception {
        IvParameterSpec ivSpec = new IvParameterSpec(iv.getBytes(StandardCharsets.UTF_8));
        SecretKeySpec keySpec = new SecretKeySpec(key.getBytes(StandardCharsets.UTF_8), "AES");
        
        Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
        cipher.init(Cipher.DECRYPT_MODE, keySpec, ivSpec);
        
        byte[] decoded = Base64.getDecoder().decode(encryptedValue);
        byte[] decrypted = cipher.doFinal(decoded);
        
        return new String(decrypted, StandardCharsets.UTF_8);
    }
    
    /**
     * Lưu token vào file
     */
    public void ghifile(String token, long expireTime) throws IOException {
        try (FileWriter writer = new FileWriter("json_token.txt")) {
            writer.write(token + "|" + expireTime);
        }
    }
    
    /**
     * Đọc token từ file, trả về null nếu hết hạn
     */
    public String docfile() throws IOException {
        File file = new File("json_token.txt");
        if (!file.exists()) {
            return null;
        }
        
        try (BufferedReader br = new BufferedReader(new FileReader(file))) {
            String line = br.readLine();
            if (line != null && !line.trim().isEmpty()) {
                String[] parts = line.split("\\|");
                if (parts.length == 2) {
                    String token = parts[0];
                    long expireTime = Long.parseLong(parts[1]);
                    
                    if (expireTime > Instant.now().getEpochSecond()) {
                        return token;
                    }
                }
            }
        }
        return null;
    }
    
    /**
     * Xóa token (đăng xuất)
     */
    public void xoaToken() throws IOException {
        File file = new File("json_token.txt");
        if (file.exists()) {
            try (FileWriter writer = new FileWriter(file)) {
                writer.write("");
            }
        }
    }
    
    /**
     * Kiểm tra token còn hợp lệ không
     */
    public boolean coTokenHopLe() {
        try {
            return docfile() != null;
        } catch (Exception e) {
            return false;
        }
    }
}
