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
        formDangNhap fm = new formDangNhap();
        fm.setVisible(true);
        }
        else
        {
            String token = cls.docfile();
            String url = Constants.API_CHECK_TOKEN + token;
            JSONArray jarr = new JSONArray();
            jarr = cls.docapi(url);
            for(int i=0;i<cls.docapi(url).length();i++)
            {
            try {
                JSONObject jon = jarr.getJSONObject(i);
                String iduser = String.valueOf(jon.getInt("iduser")); 
                String pq = jon.getString("PQ");
                String name = jon.getString("name");
                myform mf = new myform(iduser,name);
                mf.setVisible(true);
                
                }catch(Exception e)
                {
                
                }
            }
    }
    
}}
