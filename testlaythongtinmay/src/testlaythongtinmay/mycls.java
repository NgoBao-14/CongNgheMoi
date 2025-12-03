/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package testlaythongtinmay;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.nio.charset.Charset;
import java.time.Instant;
import javax.crypto.Cipher;
import javax.crypto.SecretKey;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import java.util.Base64;
import org.json.JSONArray;
import org.json.JSONObject;
import org.json.JSONTokener;
import org.apache.commons.io.IOUtils;
/**
 *
 * @author admin
 */
public class mycls {
    public void geturl(String url)
    {
        try
        {
            System.out.println("Calling URL: " + url);
            URL obj = new URL(url);
            HttpURLConnection con = (HttpURLConnection) obj.openConnection();
            con.setRequestMethod("GET");
            con.setConnectTimeout(10000);
            con.setReadTimeout(10000);
            
            int responseCode = con.getResponseCode();
            System.out.println("Response Code: " + responseCode);
            
            // Đọc response để đảm bảo server xử lý xong
            String response = IOUtils.toString(con.getInputStream(), Charset.forName("UTF-8"));
            System.out.println("Response: " + response);
            
            con.disconnect();
        }catch(Exception e)
        {
            System.out.println("Lỗi geturl: " + e.getMessage());
            e.printStackTrace();
        }
    }
    public JSONArray docapi(String url)
    {
        try
        {
            JSONArray jarr = (JSONArray) new JSONTokener(IOUtils.toString(new URL(url).openStream(),Charset.forName("UTF-8"))).nextValue();
            return jarr;
        }catch(Exception e)
        {
            System.out.println("loi");
            return null;
        }
    }
    public void ghifile(String token, long time) throws IOException
    {
        FileWriter writer = new FileWriter("json_token.txt");
        writer.write(token+"|"+time);
        writer.close();
    }
    public String docfile() throws FileNotFoundException, IOException
    {
        File file = new File("json_token.txt");
        try(BufferedReader br = new BufferedReader(new FileReader(file)))
        {
            String line = br.readLine();
            if(line != null)
            {
                String[] part = line.split("\\|");
                if(part.length == 2)
                {
                    String token =part[0];
                    long time = Long.parseLong(part[1]);
                    
                    long now = Instant.now().getEpochSecond();
                    if((now - time)<0)
                    {
                        return token;
                    }
                }
                
            }
            
        }
        return null;
    }
    private final String key = "12345678901234567890123456789012";
    private final String key_iv = "1234567890123456";
    
    public String mahoa(String value) throws Exception
    {
        IvParameterSpec iv = new IvParameterSpec(key_iv.getBytes("UTF-8"));
        SecretKeySpec skey = new SecretKeySpec(key.getBytes("UTF-8"),"AES");
        
        Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
        cipher.init(Cipher.ENCRYPT_MODE, skey,iv);
        
        byte[] encrypted = cipher.doFinal(value.getBytes());
        return Base64.getEncoder().encodeToString(encrypted);
    }
    public String giaima(String encryptedValue) throws Exception {
        IvParameterSpec iv = new IvParameterSpec(key_iv.getBytes("UTF-8"));
        SecretKeySpec skey = new SecretKeySpec(key.getBytes("UTF-8"), "AES");

        Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
        cipher.init(Cipher.DECRYPT_MODE, skey, iv);

        byte[] decodedValue = Base64.getDecoder().decode(encryptedValue);
        byte[] decrypted = cipher.doFinal(decodedValue);

        return new String(decrypted);
    }
    
    /**
     * Xóa token khi đăng xuất
     * Xóa toàn bộ nội dung file token
     */
    public void xoaToken() throws IOException {
        File file = new File("json_token.txt");
        if (file.exists()) {
            // Ghi chuỗi rỗng để xóa nội dung token
            FileWriter writer = new FileWriter(file);
            writer.write("");
            writer.close();
            System.out.println("Đã xóa token thành công");
        }
    }
    
    /**
     * Kiểm tra xem có token hợp lệ không
     */
    public boolean coTokenHopLe() {
        try {
            return docfile() != null;
        } catch (Exception e) {
            return false;
        }
    }
}
