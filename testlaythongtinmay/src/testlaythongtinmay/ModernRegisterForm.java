package testlaythongtinmay;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import java.awt.*;
import java.net.InetAddress;
import java.util.List;
import oshi.SystemInfo;
import oshi.hardware.*;
import oshi.software.os.OperatingSystem;

public class ModernRegisterForm extends JFrame {
    
    private JTextField txt_tenmay, txt_ram1, txt_ram2, txt_rom1, txt_rom2, txt_cpu, txt_os;
    private JButton btn_getInfo, btn_register;
    private String iduser, name, maGV;
    
    public ModernRegisterForm(String iduser, String name, String maGV) {
        this.iduser = iduser;
        this.name = name;
        this.maGV = maGV;
        initComponents();
    }
    
    private void initComponents() {
        setTitle("Đăng Ký Máy Tính");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(700, 750);
        setLocationRelativeTo(null);
        setResizable(false);
        
        // Main panel
        JPanel mainPanel = new JPanel();
        mainPanel.setLayout(new BorderLayout());
        mainPanel.setBackground(ModernUI.LIGHT_BG);
        
        // Header panel
        JPanel headerPanel = ModernUI.createGradientPanel();
        headerPanel.setPreferredSize(new Dimension(700, 120));
        headerPanel.setLayout(new BoxLayout(headerPanel, BoxLayout.Y_AXIS));
        headerPanel.setBorder(new EmptyBorder(25, 40, 25, 40));
        
        JLabel titleLabel = new JLabel("ĐĂNG KÝ MÁY TÍNH");
        titleLabel.setFont(new Font("Segoe UI", Font.BOLD, 28));
        titleLabel.setForeground(Color.WHITE);
        titleLabel.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        JLabel subtitleLabel = new JLabel("Bạn cần đăng ký thông tin máy tính để tiếp tục sử dụng hệ thống");
        subtitleLabel.setFont(new Font("Segoe UI", Font.PLAIN, 14));
        subtitleLabel.setForeground(new Color(255, 255, 255, 200));
        subtitleLabel.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        headerPanel.add(titleLabel);
        headerPanel.add(Box.createRigidArea(new Dimension(0, 10)));
        headerPanel.add(subtitleLabel);
        
        // Content panel
        JPanel contentPanel = new JPanel();
        contentPanel.setBackground(Color.WHITE);
        contentPanel.setBorder(new EmptyBorder(40, 50, 40, 50));
        contentPanel.setLayout(new GridBagLayout());
        
        GridBagConstraints gbc = new GridBagConstraints();
        gbc.fill = GridBagConstraints.HORIZONTAL;
        gbc.insets = new Insets(8, 0, 8, 0);
        gbc.gridx = 0;
        
        // Tên máy
        gbc.gridy = 0;
        contentPanel.add(ModernUI.createLabel("Tên máy tính"), gbc);
        
        txt_tenmay = ModernUI.createModernTextField("");
        txt_tenmay.setPreferredSize(new Dimension(550, 40));
        txt_tenmay.setEditable(false);
        gbc.gridy = 1;
        contentPanel.add(txt_tenmay, gbc);
        
        // RAM 1
        gbc.gridy = 2;
        gbc.insets = new Insets(15, 0, 8, 0);
        contentPanel.add(ModernUI.createLabel("Serial RAM 1"), gbc);
        
        txt_ram1 = ModernUI.createModernTextField("");
        txt_ram1.setPreferredSize(new Dimension(550, 40));
        txt_ram1.setEditable(false);
        gbc.gridy = 3;
        gbc.insets = new Insets(8, 0, 8, 0);
        contentPanel.add(txt_ram1, gbc);
        
        // RAM 2
        gbc.gridy = 4;
        contentPanel.add(ModernUI.createLabel("Serial RAM 2"), gbc);
        
        txt_ram2 = ModernUI.createModernTextField("");
        txt_ram2.setPreferredSize(new Dimension(550, 40));
        txt_ram2.setEditable(false);
        gbc.gridy = 5;
        contentPanel.add(txt_ram2, gbc);
        
        // ROM 1
        gbc.gridy = 6;
        gbc.insets = new Insets(15, 0, 8, 0);
        contentPanel.add(ModernUI.createLabel("Serial Ổ cứng 1"), gbc);
        
        txt_rom1 = ModernUI.createModernTextField("");
        txt_rom1.setPreferredSize(new Dimension(550, 40));
        txt_rom1.setEditable(false);
        gbc.gridy = 7;
        gbc.insets = new Insets(8, 0, 8, 0);
        contentPanel.add(txt_rom1, gbc);
        
        // ROM 2
        gbc.gridy = 8;
        contentPanel.add(ModernUI.createLabel("Serial Ổ cứng 2"), gbc);
        
        txt_rom2 = ModernUI.createModernTextField("");
        txt_rom2.setPreferredSize(new Dimension(550, 40));
        txt_rom2.setEditable(false);
        gbc.gridy = 9;
        contentPanel.add(txt_rom2, gbc);
        
        // CPU
        gbc.gridy = 10;
        gbc.insets = new Insets(15, 0, 8, 0);
        contentPanel.add(ModernUI.createLabel("CPU"), gbc);
        
        txt_cpu = ModernUI.createModernTextField("");
        txt_cpu.setPreferredSize(new Dimension(550, 40));
        txt_cpu.setEditable(false);
        gbc.gridy = 11;
        gbc.insets = new Insets(8, 0, 8, 0);
        contentPanel.add(txt_cpu, gbc);
        
        // OS
        gbc.gridy = 12;
        contentPanel.add(ModernUI.createLabel("Hệ điều hành"), gbc);
        
        txt_os = ModernUI.createModernTextField("");
        txt_os.setPreferredSize(new Dimension(550, 40));
        txt_os.setEditable(false);
        gbc.gridy = 13;
        contentPanel.add(txt_os, gbc);
        
        // Button panel
        JPanel buttonPanel = new JPanel(new FlowLayout(FlowLayout.CENTER, 15, 0));
        buttonPanel.setBackground(Color.WHITE);
        buttonPanel.setBorder(new EmptyBorder(20, 0, 0, 0));
        
        btn_getInfo = ModernUI.createModernButton("LẤY THÔNG TIN");
        btn_getInfo.setPreferredSize(new Dimension(250, 45));
        btn_getInfo.addActionListener(e -> getSystemInfo());
        
        btn_register = ModernUI.createModernButton("ĐĂNG KÝ");
        btn_register.setPreferredSize(new Dimension(250, 45));
        btn_register.addActionListener(e -> handleRegister());
        btn_register.setEnabled(false);
        
        buttonPanel.add(btn_getInfo);
        buttonPanel.add(btn_register);
        
        gbc.gridy = 14;
        gbc.insets = new Insets(20, 0, 0, 0);
        contentPanel.add(buttonPanel, gbc);
        
        // Add to main panel
        mainPanel.add(headerPanel, BorderLayout.NORTH);
        
        JScrollPane scrollPane = new JScrollPane(contentPanel);
        scrollPane.setBorder(null);
        scrollPane.getVerticalScrollBar().setUnitIncrement(16);
        mainPanel.add(scrollPane, BorderLayout.CENTER);
        
        add(mainPanel);
    }
    
    private void getSystemInfo() {
        try {
            InetAddress localHost = InetAddress.getLocalHost();
            txt_tenmay.setText(localHost.getHostName());
            
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
            txt_ram1.setText(serial1 != null ? serial1 : "NULL");
            txt_ram2.setText(serial2 != null ? serial2 : "NULL");
            
            List<HWDiskStore> disks = hal.getDiskStores();
            String serialRom1 = null, serialRom2 = null;
            int j = 0;
            for (HWDiskStore disk : disks) {
                if (j == 0) serialRom1 = disk.getSerial();
                else if (j == 1) serialRom2 = disk.getSerial();
                j++;
            }
            txt_rom1.setText(serialRom1 != null ? serialRom1 : "NULL");
            txt_rom2.setText(serialRom2 != null ? serialRom2 : "NULL");
            
            CentralProcessor processor = si.getHardware().getProcessor();
            txt_cpu.setText(processor.getProcessorIdentifier().getName());
            
            OperatingSystem os = si.getOperatingSystem();
            txt_os.setText(os.getFamily());
            
            btn_register.setEnabled(true);
            JOptionPane.showMessageDialog(this, 
                "Đã lấy thông tin máy tính thành công!", 
                "Thành công", 
                JOptionPane.INFORMATION_MESSAGE);
            
        } catch (Exception e) {
            JOptionPane.showMessageDialog(this, 
                "Lỗi khi lấy thông tin: " + e.getMessage(), 
                "Lỗi", 
                JOptionPane.ERROR_MESSAGE);
        }
    }
    
    private void handleRegister() {
        try {
            mycls cls = new mycls();
            
            String tenmay = cls.mahoa(txt_tenmay.getText()).replace("+", "%2B");
            String ram1 = cls.mahoa(txt_ram1.getText()).replace("+", "%2B");
            String ram2 = cls.mahoa(txt_ram2.getText()).replace("+", "%2B");
            String rom1 = cls.mahoa(txt_rom1.getText()).replace("+", "%2B");
            String rom2 = cls.mahoa(txt_rom2.getText()).replace("+", "%2B");
            String cpu = cls.mahoa(txt_cpu.getText()).replace("+", "%2B");
            String os = cls.mahoa(txt_os.getText()).replace("+", "%2B");
            String id = cls.mahoa(iduser).replace("+", "%2B");
            
            String thamso = "tenmay=" + tenmay + "&ram1=" + ram1 + "&ram2=" + ram2 + 
                          "&rom1=" + rom1 + "&rom2=" + rom2 + "&tencpu=" + cpu + 
                          "&os=" + os + "&iduser=" + id;
            String url = Constants.API_REGISTER + thamso;
            
            cls.geturl(url);
            
            JOptionPane.showMessageDialog(this, 
                "Đăng ký máy tính thành công!", 
                "Thành công", 
                JOptionPane.INFORMATION_MESSAGE);
            
            ModernMainForm fm = new ModernMainForm(iduser, name, maGV);
            fm.setVisible(true);
            dispose();
            
        } catch (Exception e) {
            JOptionPane.showMessageDialog(this, 
                "Lỗi khi đăng ký: " + e.getMessage(), 
                "Lỗi", 
                JOptionPane.ERROR_MESSAGE);
        }
    }
}
