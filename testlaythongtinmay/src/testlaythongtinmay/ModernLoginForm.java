package testlaythongtinmay;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import java.awt.*;
import java.net.InetAddress;
import java.util.List;
import org.json.JSONArray;
import org.json.JSONObject;
import oshi.SystemInfo;
import oshi.hardware.*;
import oshi.software.os.OperatingSystem;

public class ModernLoginForm extends JFrame {
    
    private JTextField txt_username;
    private JPasswordField txt_password;
    private JButton btn_login;
    
    public ModernLoginForm() {
        initComponents();
    }
    
    private void initComponents() {
        setTitle("Đăng Nhập Hệ Thống");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(900, 600);
        setLocationRelativeTo(null);
        setResizable(false);
        
        // Main panel với gradient background
        JPanel mainPanel = new JPanel(new GridBagLayout());
        mainPanel.setBackground(ModernUI.LIGHT_BG);
        
        // Left panel - Gradient với thông tin
        JPanel leftPanel = ModernUI.createGradientPanel();
        leftPanel.setPreferredSize(new Dimension(400, 600));
        leftPanel.setLayout(new BoxLayout(leftPanel, BoxLayout.Y_AXIS));
        leftPanel.setBorder(new EmptyBorder(50, 40, 50, 40));
        
        JLabel welcomeLabel = new JLabel("HỆ THỐNG");
        welcomeLabel.setFont(new Font("Segoe UI", Font.BOLD, 32));
        welcomeLabel.setForeground(Color.WHITE);
        welcomeLabel.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        JLabel systemLabel = new JLabel("QUẢN LÝ KHÓA LUẬN");
        systemLabel.setFont(new Font("Segoe UI", Font.BOLD, 28));
        systemLabel.setForeground(Color.WHITE);
        systemLabel.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        JLabel descLabel = new JLabel("<html>Đăng nhập để truy cập vào hệ thống<br>quản lý đề tài và chấm điểm khóa luận</html>");
        descLabel.setFont(new Font("Segoe UI", Font.PLAIN, 14));
        descLabel.setForeground(new Color(255, 255, 255, 200));
        descLabel.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        leftPanel.add(Box.createVerticalGlue());
        leftPanel.add(welcomeLabel);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 10)));
        leftPanel.add(systemLabel);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 30)));
        leftPanel.add(descLabel);
        leftPanel.add(Box.createVerticalGlue());
        
        // Right panel - Form đăng nhập
        JPanel rightPanel = new JPanel();
        rightPanel.setBackground(Color.WHITE);
        rightPanel.setPreferredSize(new Dimension(500, 600));
        rightPanel.setLayout(new GridBagLayout());
        rightPanel.setBorder(new EmptyBorder(50, 60, 50, 60));
        
        GridBagConstraints gbc = new GridBagConstraints();
        gbc.fill = GridBagConstraints.HORIZONTAL;
        gbc.insets = new Insets(10, 0, 10, 0);
        
        // Title
        JLabel titleLabel = ModernUI.createTitleLabel("Đăng Nhập");
        gbc.gridx = 0;
        gbc.gridy = 0;
        gbc.gridwidth = 2;
        gbc.anchor = GridBagConstraints.CENTER;
        rightPanel.add(titleLabel, gbc);
        
        gbc.gridwidth = 1;
        gbc.anchor = GridBagConstraints.WEST;
        
        // Username label
        JLabel userLabel = ModernUI.createLabel("Mã giảng viên");
        gbc.gridy = 1;
        gbc.insets = new Insets(30, 0, 5, 0);
        rightPanel.add(userLabel, gbc);
        
        // Username field
        txt_username = ModernUI.createModernTextField("Nhập mã giảng viên");
        txt_username.setPreferredSize(new Dimension(350, 45));
        gbc.gridy = 2;
        gbc.insets = new Insets(0, 0, 15, 0);
        rightPanel.add(txt_username, gbc);
        
        // Password label
        JLabel passLabel = ModernUI.createLabel("Mật khẩu");
        gbc.gridy = 3;
        gbc.insets = new Insets(10, 0, 5, 0);
        rightPanel.add(passLabel, gbc);
        
        // Password field
        txt_password = ModernUI.createModernPasswordField();
        txt_password.setPreferredSize(new Dimension(350, 45));
        gbc.gridy = 4;
        gbc.insets = new Insets(0, 0, 25, 0);
        rightPanel.add(txt_password, gbc);
        
        // Login button
        btn_login = ModernUI.createModernButton("ĐĂNG NHẬP");
        btn_login.setPreferredSize(new Dimension(350, 50));
        btn_login.addActionListener(e -> handleLogin());
        gbc.gridy = 5;
        gbc.insets = new Insets(10, 0, 10, 0);
        rightPanel.add(btn_login, gbc);
        
        // Add panels to main panel
        GridBagConstraints mainGbc = new GridBagConstraints();
        mainGbc.gridx = 0;
        mainGbc.gridy = 0;
        mainGbc.weightx = 0.4;
        mainGbc.weighty = 1.0;
        mainGbc.fill = GridBagConstraints.BOTH;
        mainPanel.add(leftPanel, mainGbc);
        
        mainGbc.gridx = 1;
        mainGbc.weightx = 0.6;
        mainPanel.add(rightPanel, mainGbc);
        
        add(mainPanel);
    }
    
    private void handleLogin() {
        String username = txt_username.getText().trim();
        String password = new String(txt_password.getPassword());
        
        if (username.isEmpty() || password.isEmpty()) {
            JOptionPane.showMessageDialog(this, 
                "Vui lòng nhập đầy đủ thông tin!", 
                "Thông báo", 
                JOptionPane.WARNING_MESSAGE);
            return;
        }
        
        // Hiển thị loading
        btn_login.setEnabled(false);
        btn_login.setText("Đang đăng nhập...");
        
        // Xử lý đăng nhập trong thread riêng
        new SwingWorker<Void, Void>() {
            @Override
            protected Void doInBackground() throws Exception {
                performLogin(username, password);
                return null;
            }
            
            @Override
            protected void done() {
                btn_login.setEnabled(true);
                btn_login.setText("ĐĂNG NHẬP");
            }
        }.execute();
    }
    
    private void performLogin(String username, String password) {
        try {
            InetAddress localHost = InetAddress.getLocalHost();
            String tenmay = localHost.getHostName();
            
            SystemInfo systemInfo = new SystemInfo();
            CentralProcessor cpu = systemInfo.getHardware().getProcessor();
            String tencpu = cpu.getProcessorIdentifier().getName();
            
            OperatingSystem hedieuhanh = systemInfo.getOperatingSystem();
            String os = hedieuhanh.getFamily();
            
            // Lấy RAM
            SystemInfo si = new SystemInfo();
            HardwareAbstractionLayer hal = si.getHardware();
            GlobalMemory memory = hal.getMemory();
            String serial1 = null, serial2 = null;
            int i = 0;
            for (PhysicalMemory pm : memory.getPhysicalMemory()) {
                if (i == 0) serial1 = pm.getSerialNumber();
                else if (i == 1) serial2 = pm.getSerialNumber();
                i++;
            }
            if (i == 1) serial2 = null;
            String ram1 = (serial1 != null ? serial1 : "NULL");
            String ram2 = (serial2 != null ? serial2 : "NULL");
            
            // Lấy ROM
            List<HWDiskStore> disks = hal.getDiskStores();
            String serialRom1 = null, serialRom2 = null;
            int j = 0;
            for (HWDiskStore disk : disks) {
                if (j == 0) serialRom1 = disk.getSerial();
                else if (j == 1) serialRom2 = disk.getSerial();
                j++;
            }
            if (j == 1) serialRom2 = null;
            String rom1 = (serialRom1 != null ? serialRom1 : "NULL");
            String rom2 = (serialRom2 != null ? serialRom2 : "NULL");
            
            mycls cls = new mycls();
            username = cls.mahoa(username).replace("+", "%2B");
            password = cls.mahoa(password).replace("+", "%2B");
            tenmay = cls.mahoa(tenmay).replace("+", "%2B");
            tencpu = cls.mahoa(tencpu).replace("+", "%2B");
            os = cls.mahoa(os).replace("+", "%2B");
            ram1 = cls.mahoa(ram1).replace("+", "%2B");
            ram2 = cls.mahoa(ram2).replace("+", "%2B");
            rom1 = cls.mahoa(rom1).replace("+", "%2B");
            rom2 = cls.mahoa(rom2).replace("+", "%2B");
            
            String thamso = "username=" + username + "&password=" + password + 
                          "&ram1=" + ram1 + "&ram2=" + ram2 + "&rom1=" + rom1 + 
                          "&rom2=" + rom2 + "&tenmay=" + tenmay + "&tencpu=" + tencpu + 
                          "&os=" + os;
            String url = Constants.API_LOGIN + thamso;
            
            JSONArray jarr = cls.docapi(url);
            if (jarr != null && jarr.length() > 0) {
                JSONObject jon = jarr.getJSONObject(0);
                String iduser = String.valueOf(jon.getInt("iduser"));
                int response = jon.getInt("Response");
                int pq = jon.getInt("PQ");
                String name = jon.getString("name");
                
                if (response == 101 && (pq == 1 || pq == 4)) {
                    String maGV = jon.optString("MaGV", "");
                    SwingUtilities.invokeLater(() -> {
                        ModernRegisterForm fm = new ModernRegisterForm(iduser, name, maGV);
                        fm.setVisible(true);
                        dispose();
                    });
                } else if (response == 102 && (pq == 1 || pq == 4)) {
                    String token = jon.getString("token");
                    long time = jon.getLong("time");
                    String maGV = jon.getString("MaGV");
                    cls.ghifile(token, time);
                    
                    SwingUtilities.invokeLater(() -> {
                        ModernMainForm mf = new ModernMainForm(iduser, name, maGV);
                        mf.setVisible(true);
                        dispose();
                    });
                } else {
                    SwingUtilities.invokeLater(() -> {
                        JOptionPane.showMessageDialog(this, 
                            "Bạn không có quyền truy cập!", 
                            "Lỗi", 
                            JOptionPane.ERROR_MESSAGE);
                    });
                }
            } else {
                SwingUtilities.invokeLater(() -> {
                    JOptionPane.showMessageDialog(this, 
                        "Sai tên đăng nhập hoặc mật khẩu!", 
                        "Lỗi", 
                        JOptionPane.ERROR_MESSAGE);
                });
            }
        } catch (Exception e) {
            e.printStackTrace();
            SwingUtilities.invokeLater(() -> {
                JOptionPane.showMessageDialog(this, 
                    "Có lỗi xảy ra: " + e.getMessage(), 
                    "Lỗi", 
                    JOptionPane.ERROR_MESSAGE);
            });
        }
    }
    
    public static void main(String[] args) {
        try {
            UIManager.setLookAndFeel(new com.formdev.flatlaf.FlatIntelliJLaf());
        } catch (Exception e) {
            e.printStackTrace();
        }
        
        SwingUtilities.invokeLater(() -> {
            new ModernLoginForm().setVisible(true);
        });
    }
}
