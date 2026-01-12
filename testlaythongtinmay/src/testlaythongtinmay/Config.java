package testlaythongtinmay;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileReader;
import java.io.IOException;
import java.util.HashMap;
import java.util.Map;
import java.util.Properties;

/**
 * Quản lý cấu hình từ file .env hoặc biến môi trường
 * Không hardcode credentials trong code
 */
public class Config {
    private static Map<String, String> envVars = new HashMap<>();
    private static boolean loaded = false;
    
    // Default values (chỉ dùng khi dev local)
    private static final String DEFAULT_API_URL = "http://localhost:8080/CongNgheMoi/mvc/api/";
    private static final String DEFAULT_AES_KEY = "12345678901234567890123456789012";
    private static final String DEFAULT_AES_IV = "1234567890123456";
    
    static {
        loadConfig();
    }
    
    private static void loadConfig() {
        if (loaded) return;
        
        // Đọc từ file .env
        loadEnvFile(".env");
        
        loaded = true;
    }
    
    /**
     * Đọc file .env hoặc .properties
     * Format: KEY=VALUE
     */
    private static void loadEnvFile(String filename) {
        File file = new File(filename);
        if (!file.exists()) {
            System.out.println("Config file not found: " + filename);
            return;
        }
        
        try (BufferedReader reader = new BufferedReader(new FileReader(file))) {
            String line;
            while ((line = reader.readLine()) != null) {
                line = line.trim();
                
                // Bỏ qua comment và dòng trống
                if (line.isEmpty() || line.startsWith("#") || line.startsWith("//")) {
                    continue;
                }
                
                // Parse KEY=VALUE
                int idx = line.indexOf('=');
                if (idx > 0) {
                    String key = line.substring(0, idx).trim();
                    String value = line.substring(idx + 1).trim();
                    
                    // Xóa quotes nếu có
                    if ((value.startsWith("\"") && value.endsWith("\"")) ||
                        (value.startsWith("'") && value.endsWith("'"))) {
                        value = value.substring(1, value.length() - 1);
                    }
                    
                    envVars.put(key, value);
                }
            }
            System.out.println("Loaded config from: " + filename);
        } catch (IOException e) {
            System.out.println("Error reading " + filename + ": " + e.getMessage());
        }
    }
    
    /**
     * Lấy giá trị config theo thứ tự ưu tiên:
     * 1. Biến môi trường hệ thống
     * 2. File .env / config.properties
     * 3. Giá trị mặc định
     */
    private static String get(String key, String defaultValue) {
        // Ưu tiên 1: Biến môi trường hệ thống
        String envValue = System.getenv(key);
        if (envValue != null && !envValue.isEmpty()) {
            return envValue;
        }
        
        // Ưu tiên 2: File .env
        String fileValue = envVars.get(key);
        if (fileValue != null && !fileValue.isEmpty()) {
            return fileValue;
        }
        
        // Ưu tiên 3: Default
        return defaultValue;
    }
    
    // ============ API Configuration ============
    public static String getApiBaseUrl() {
        return get("API_BASE_URL", DEFAULT_API_URL);
    }
    
    // ============ AES Encryption Keys ============
    public static String getAesKey() {
        return get("AES_KEY", DEFAULT_AES_KEY);
    }
    
    public static String getAesIv() {
        return get("AES_IV", DEFAULT_AES_IV);
    }
    
    // ============ API Endpoints ============
    public static String getApiLogin() {
        return getApiBaseUrl() + "dangnhap.php?";
    }
    
    public static String getApiRegister() {
        return getApiBaseUrl() + "them.php?";
    }
    
    public static String getApiCheckToken() {
        return getApiBaseUrl() + "checktoken.php?token=";
    }
    
    public static String getApiXemDetai() {
        return getApiBaseUrl() + "xemdetaichotungsinhvien.php?";
    }
    
    public static String getApiXemDsDiem() {
        return getApiBaseUrl() + "xemdsdiem.php?";
    }
    
    public static String getApiNhapDiem() {
        return getApiBaseUrl() + "nhapdiem.php?";
    }
    
    public static String getApiGetDetaiGV() {
        return getApiBaseUrl() + "getDeTaiGV.php?";
    }
    
    public static String getApiGetSVTheoDeTai() {
        return getApiBaseUrl() + "getSVTheoDeTai.php?";
    }
    
    // ============ Debug ============
    public static void printConfig() {
        System.out.println("=== Current Config ===");
        System.out.println("API_BASE_URL: " + getApiBaseUrl());
        System.out.println("AES_KEY: " + (getAesKey().equals(DEFAULT_AES_KEY) ? "[DEFAULT]" : "[CUSTOM]"));
        System.out.println("AES_IV: " + (getAesIv().equals(DEFAULT_AES_IV) ? "[DEFAULT]" : "[CUSTOM]"));
        System.out.println("======================");
    }
}
