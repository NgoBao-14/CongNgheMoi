/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Main.java to edit this template
 */
package testlaythongtinmay;

import com.formdev.flatlaf.FlatIntelliJLaf;
import java.io.IOException;
import org.json.JSONArray;
import org.json.JSONObject;
import com.formdev.flatlaf.FlatLightLaf;
/**
 *
 * @author admin
 */
public class Testlaythongtinmay {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws IOException {
        // TODO code application logic here
        try {
            javax.swing.UIManager.setLookAndFeel(new FlatIntelliJLaf()); // thêm dòng này
        } catch (Exception e) {
            System.err.println("Không thể cài FlatLaf");
        }
        
        mycls cls = new mycls();
        if(cls.docfile()==null)
        {
        // Sử dụng form đăng nhập mới với giao diện đẹp
        ModernLoginForm fm = new ModernLoginForm();
        fm.setVisible(true);
        }
        else
        {
            String token = cls.docfile();
            String url = Constants.API_CHECK_TOKEN + token;
            JSONArray jarr = cls.docapi(url);
            
            // Token cũ không hợp lệ hoặc thiếu MaGV -> xóa token và đăng nhập lại
            if (jarr == null || jarr.length() == 0) {
                cls.xoaToken();
                ModernLoginForm fm = new ModernLoginForm();
                fm.setVisible(true);
                return;
            }
            
            try {
                JSONObject jon = jarr.getJSONObject(0);
                String iduser = String.valueOf(jon.getInt("iduser")); 
                String pq = jon.getString("PQ");
                String name = jon.getString("name");
                String maGV = jon.optString("MaGV", "");
                
                // Nếu không có MaGV trong token cũ -> xóa token và đăng nhập lại
                if (maGV.isEmpty()) {
                    cls.xoaToken();
                    ModernLoginForm fm = new ModernLoginForm();
                    fm.setVisible(true);
                    return;
                }
                
                ModernMainForm mf = new ModernMainForm(iduser, name, maGV);
                mf.setVisible(true);
            } catch(Exception e) {
                cls.xoaToken();
                ModernLoginForm fm = new ModernLoginForm();
                fm.setVisible(true);
            }
    }
    
}}
