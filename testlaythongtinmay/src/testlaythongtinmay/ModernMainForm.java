package testlaythongtinmay;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.*;
import java.awt.*;
import java.util.Vector;
import org.json.JSONArray;
import org.json.JSONObject;

public class ModernMainForm extends JFrame {
    
    private String iduser, name, maGV;
    private JLabel lblWelcome, lblSinhVienName;
    private JTable tblDeTai, tblSinhVien, tblDiem;
    private JButton btnSave, btnRefresh, btnLogout, btnBackToSV;
    private JTextField txtIdDeTai, txtIdDangKy;
    private DefaultTableModel modelDeTai, modelSinhVien, modelDiem;
    private JPanel cardPanel;
    private CardLayout cardLayout;
    private String currentDeTaiName = "";
    private String currentSinhVienName = "";
    private String currentMSSV = "";
    
    public ModernMainForm(String iduser, String name, String maGV) {
        this.iduser = iduser;
        this.name = name;
        this.maGV = maGV;
        initComponents();
        loadDeTai();
    }
    
    private void initComponents() {
        setTitle("Hệ Thống Quản Lý Khóa Luận");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(1400, 850);
        setLocationRelativeTo(null);
        setExtendedState(JFrame.MAXIMIZED_BOTH);
        
        JPanel mainPanel = new JPanel(new BorderLayout());
        mainPanel.setBackground(ModernUI.LIGHT_BG);
        
        JPanel headerPanel = createHeaderPanel();
        mainPanel.add(headerPanel, BorderLayout.NORTH);
        
        JPanel contentPanel = new JPanel(new BorderLayout(15, 15));
        contentPanel.setBackground(ModernUI.LIGHT_BG);
        contentPanel.setBorder(new EmptyBorder(20, 20, 20, 20));
        
        // Panel đề tài (bên trái)
        JPanel leftPanel = createDeTaiPanel();
        leftPanel.setPreferredSize(new Dimension(400, 0));

        // Panel bên phải với CardLayout (Sinh viên / Phiếu điểm)
        cardLayout = new CardLayout();
        cardPanel = new JPanel(cardLayout);
        cardPanel.setBackground(ModernUI.LIGHT_BG);
        
        JPanel sinhVienPanel = createSinhVienPanel();
        JPanel diemPanel = createDiemPanel();
        
        cardPanel.add(sinhVienPanel, "SINHVIEN");
        cardPanel.add(diemPanel, "DIEM");
        
        JSplitPane splitPane = new JSplitPane(JSplitPane.HORIZONTAL_SPLIT, leftPanel, cardPanel);
        splitPane.setDividerLocation(400);
        splitPane.setOneTouchExpandable(true);
        splitPane.setBorder(null);
        
        contentPanel.add(splitPane, BorderLayout.CENTER);
        mainPanel.add(contentPanel, BorderLayout.CENTER);
        
        txtIdDeTai = new JTextField();
        txtIdDangKy = new JTextField();
        txtIdDeTai.setVisible(false);
        txtIdDangKy.setVisible(false);
        
        add(mainPanel);
    }
    
    private JPanel createHeaderPanel() {
        JPanel headerPanel = ModernUI.createGradientPanel();
        headerPanel.setPreferredSize(new Dimension(1400, 100));
        headerPanel.setLayout(new BorderLayout());
        headerPanel.setBorder(new EmptyBorder(20, 30, 20, 30));
        
        JPanel leftHeader = new JPanel(new FlowLayout(FlowLayout.LEFT, 15, 0));
        leftHeader.setOpaque(false);
        
        JLabel iconLabel = new JLabel("👨‍🏫");
        iconLabel.setFont(new Font("Segoe UI Emoji", Font.PLAIN, 40));
        
        JPanel textPanel = new JPanel();
        textPanel.setLayout(new BoxLayout(textPanel, BoxLayout.Y_AXIS));
        textPanel.setOpaque(false);
        
        lblWelcome = new JLabel("Xin chào, " + name);
        lblWelcome.setFont(new Font("Segoe UI", Font.BOLD, 24));
        lblWelcome.setForeground(Color.WHITE);
        
        JLabel subLabel = new JLabel("Giảng viên hướng dẫn khóa luận");
        subLabel.setFont(new Font("Segoe UI", Font.PLAIN, 14));
        subLabel.setForeground(new Color(255, 255, 255, 200));
        
        textPanel.add(lblWelcome);
        textPanel.add(Box.createRigidArea(new Dimension(0, 5)));
        textPanel.add(subLabel);

        leftHeader.add(iconLabel);
        leftHeader.add(textPanel);
        
        JPanel rightHeader = new JPanel(new FlowLayout(FlowLayout.RIGHT, 10, 10));
        rightHeader.setOpaque(false);
        
        btnRefresh = createHeaderButton("🔄 Làm mới", ModernUI.SUCCESS_COLOR);
        btnRefresh.addActionListener(e -> {
            loadDeTai();
            cardLayout.show(cardPanel, "SINHVIEN");
            modelSinhVien.setRowCount(0);
            JOptionPane.showMessageDialog(this, "Đã làm mới dữ liệu!", "Thông báo", JOptionPane.INFORMATION_MESSAGE);
        });
        
        btnLogout = createHeaderButton("🚪 Đăng xuất", ModernUI.DANGER_COLOR);
        btnLogout.addActionListener(e -> handleLogout());
        
        rightHeader.add(btnRefresh);
        rightHeader.add(btnLogout);
        
        headerPanel.add(leftHeader, BorderLayout.WEST);
        headerPanel.add(rightHeader, BorderLayout.EAST);
        
        return headerPanel;
    }
    
    private JButton createHeaderButton(String text, Color bgColor) {
        JButton button = new JButton(text) {
            @Override
            protected void paintComponent(Graphics g) {
                Graphics2D g2d = (Graphics2D) g.create();
                g2d.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
                if (getModel().isPressed()) {
                    g2d.setColor(bgColor.darker());
                } else if (getModel().isRollover()) {
                    g2d.setColor(bgColor.brighter());
                } else {
                    g2d.setColor(bgColor);
                }
                g2d.fillRoundRect(0, 0, getWidth(), getHeight(), 8, 8);
                g2d.dispose();
                super.paintComponent(g);
            }
        };
        button.setFont(new Font("Segoe UI", Font.BOLD, 13));
        button.setForeground(Color.WHITE);
        button.setFocusPainted(false);
        button.setBorderPainted(false);
        button.setContentAreaFilled(false);
        button.setCursor(new Cursor(Cursor.HAND_CURSOR));
        button.setPreferredSize(new Dimension(130, 40));
        return button;
    }

    private JPanel createDeTaiPanel() {
        JPanel panel = new JPanel(new BorderLayout(0, 10));
        panel.setBackground(Color.WHITE);
        panel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(220, 220, 220), 1),
            new EmptyBorder(15, 15, 15, 15)
        ));
        
        JLabel titleLabel = new JLabel("📋 Danh Sách Đề Tài");
        titleLabel.setFont(new Font("Segoe UI", Font.BOLD, 18));
        titleLabel.setForeground(ModernUI.PRIMARY_COLOR);
        
        String[] columns = {"ID", "Tên Đề Tài", "SL SV"};
        modelDeTai = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };
        
        tblDeTai = new JTable(modelDeTai);
        customizeTable(tblDeTai);
        tblDeTai.getColumnModel().getColumn(0).setPreferredWidth(40);
        tblDeTai.getColumnModel().getColumn(1).setPreferredWidth(250);
        tblDeTai.getColumnModel().getColumn(2).setPreferredWidth(50);
        
        tblDeTai.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                handleDeTaiSelection();
            }
        });
        
        JScrollPane scrollPane = new JScrollPane(tblDeTai);
        scrollPane.setBorder(BorderFactory.createLineBorder(new Color(220, 220, 220), 1));
        
        JPanel infoPanel = new JPanel(new FlowLayout(FlowLayout.LEFT));
        infoPanel.setBackground(new Color(240, 248, 255));
        infoPanel.setBorder(new EmptyBorder(8, 12, 8, 12));
        JLabel infoLabel = new JLabel("ℹ️ Chọn đề tài để xem danh sách sinh viên");
        infoLabel.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        infoPanel.add(infoLabel);
        
        panel.add(titleLabel, BorderLayout.NORTH);
        panel.add(scrollPane, BorderLayout.CENTER);
        panel.add(infoPanel, BorderLayout.SOUTH);
        
        return panel;
    }

    private JPanel createSinhVienPanel() {
        JPanel panel = new JPanel(new BorderLayout(0, 10));
        panel.setBackground(Color.WHITE);
        panel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(220, 220, 220), 1),
            new EmptyBorder(15, 15, 15, 15)
        ));
        
        JLabel titleLabel = new JLabel("👥 Danh Sách Sinh Viên Đăng Ký");
        titleLabel.setFont(new Font("Segoe UI", Font.BOLD, 18));
        titleLabel.setForeground(ModernUI.PRIMARY_COLOR);
        
        String[] columns = {"ID ĐK", "MSSV", "Họ và Tên", "Lớp", "Nhóm"};
        modelSinhVien = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };
        
        tblSinhVien = new JTable(modelSinhVien);
        customizeTable(tblSinhVien);
        tblSinhVien.getColumnModel().getColumn(0).setPreferredWidth(50);
        tblSinhVien.getColumnModel().getColumn(1).setPreferredWidth(80);
        tblSinhVien.getColumnModel().getColumn(2).setPreferredWidth(180);
        tblSinhVien.getColumnModel().getColumn(3).setPreferredWidth(80);
        tblSinhVien.getColumnModel().getColumn(4).setPreferredWidth(100);
        
        tblSinhVien.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                handleSinhVienSelection();
            }
        });
        
        JScrollPane scrollPane = new JScrollPane(tblSinhVien);
        scrollPane.setBorder(BorderFactory.createLineBorder(new Color(220, 220, 220), 1));
        
        JPanel infoPanel = new JPanel(new FlowLayout(FlowLayout.LEFT));
        infoPanel.setBackground(new Color(255, 248, 220));
        infoPanel.setBorder(new EmptyBorder(8, 12, 8, 12));
        JLabel infoLabel = new JLabel("ℹ️ Chọn sinh viên để xem và chấm phiếu điểm");
        infoLabel.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        infoPanel.add(infoLabel);
        
        panel.add(titleLabel, BorderLayout.NORTH);
        panel.add(scrollPane, BorderLayout.CENTER);
        panel.add(infoPanel, BorderLayout.SOUTH);
        
        return panel;
    }

    private JPanel createDiemPanel() {
        JPanel panel = new JPanel(new BorderLayout(0, 10));
        panel.setBackground(Color.WHITE);
        panel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(220, 220, 220), 1),
            new EmptyBorder(15, 15, 15, 15)
        ));
        
        // Header với nút quay lại
        JPanel headerPanel = new JPanel(new BorderLayout());
        headerPanel.setBackground(Color.WHITE);
        
        // Panel chứa tiêu đề và tên sinh viên
        JPanel titlePanel = new JPanel();
        titlePanel.setLayout(new BoxLayout(titlePanel, BoxLayout.Y_AXIS));
        titlePanel.setBackground(Color.WHITE);
        
        JLabel titleLabel = new JLabel("📝 Phiếu Chấm Điểm");
        titleLabel.setFont(new Font("Segoe UI", Font.BOLD, 18));
        titleLabel.setForeground(ModernUI.PRIMARY_COLOR);
        
        lblSinhVienName = new JLabel("Sinh viên: ");
        lblSinhVienName.setFont(new Font("Segoe UI", Font.BOLD, 14));
        lblSinhVienName.setForeground(new Color(100, 100, 100));
        
        titlePanel.add(titleLabel);
        titlePanel.add(Box.createRigidArea(new Dimension(0, 5)));
        titlePanel.add(lblSinhVienName);
        
        btnBackToSV = new JButton("← Quay lại DS Sinh viên");
        btnBackToSV.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        btnBackToSV.setCursor(new Cursor(Cursor.HAND_CURSOR));
        btnBackToSV.addActionListener(e -> cardLayout.show(cardPanel, "SINHVIEN"));
        
        headerPanel.add(titlePanel, BorderLayout.WEST);
        headerPanel.add(btnBackToSV, BorderLayout.EAST);
        
        String[] columns = {"STT", "CLO-PI", "Nội dung đánh giá", "Tỷ trọng", 
                           "Mức 1 (0-30%)", "Mức 2 (40-60%)", "Mức 3 (70-80%)", 
                           "Mức 4 (90-100%)", "Điểm /10"};
        modelDiem = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return column == 8;
            }
        };
        
        tblDiem = new JTable(modelDiem);
        tblDiem.putClientProperty("terminateEditOnFocusLost", Boolean.TRUE);
        customizeTable(tblDiem);
        
        tblDiem.getColumnModel().getColumn(0).setPreferredWidth(40);
        tblDiem.getColumnModel().getColumn(1).setPreferredWidth(60);
        tblDiem.getColumnModel().getColumn(2).setPreferredWidth(200);
        tblDiem.getColumnModel().getColumn(3).setPreferredWidth(70);
        tblDiem.getColumnModel().getColumn(8).setPreferredWidth(80);

        DefaultCellEditor diemEditor = new DefaultCellEditor(new JTextField()) {
            @Override
            public boolean stopCellEditing() {
                String value = ((JTextField) getComponent()).getText().trim();
                if (!value.isEmpty()) {
                    try {
                        double diem = Double.parseDouble(value);
                        if (diem < 0 || diem > 10) {
                            JOptionPane.showMessageDialog(tblDiem, "Điểm phải từ 0 đến 10!", "Lỗi", JOptionPane.ERROR_MESSAGE);
                            return false;
                        }
                    } catch (NumberFormatException e) {
                        JOptionPane.showMessageDialog(tblDiem, "Vui lòng nhập số!", "Lỗi", JOptionPane.ERROR_MESSAGE);
                        return false;
                    }
                }
                return super.stopCellEditing();
            }
        };
        tblDiem.getColumnModel().getColumn(8).setCellEditor(diemEditor);
        
        tblDiem.getColumnModel().getColumn(2).setCellRenderer(new TextAreaRenderer());
        tblDiem.getColumnModel().getColumn(4).setCellRenderer(new TextAreaRenderer());
        tblDiem.getColumnModel().getColumn(5).setCellRenderer(new TextAreaRenderer());
        tblDiem.getColumnModel().getColumn(6).setCellRenderer(new TextAreaRenderer());
        tblDiem.getColumnModel().getColumn(7).setCellRenderer(new TextAreaRenderer());
        
        JScrollPane scrollPane = new JScrollPane(tblDiem);
        scrollPane.setBorder(BorderFactory.createLineBorder(new Color(220, 220, 220), 1));
        
        JPanel buttonPanel = new JPanel(new FlowLayout(FlowLayout.RIGHT, 10, 10));
        buttonPanel.setBackground(Color.WHITE);
        
        btnSave = ModernUI.createModernButton("💾 LƯU ĐIỂM");
        btnSave.setPreferredSize(new Dimension(200, 45));
        btnSave.addActionListener(e -> handleSaveDiem());
        buttonPanel.add(btnSave);
        
        panel.add(headerPanel, BorderLayout.NORTH);
        panel.add(scrollPane, BorderLayout.CENTER);
        panel.add(buttonPanel, BorderLayout.SOUTH);
        
        return panel;
    }

    private void customizeTable(JTable table) {
        table.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        table.setRowHeight(35);
        table.setSelectionBackground(new Color(52, 152, 219, 50));
        table.setSelectionForeground(ModernUI.TEXT_COLOR);
        table.setGridColor(new Color(230, 230, 230));
        table.setShowGrid(true);
        table.setIntercellSpacing(new Dimension(1, 1));
        
        JTableHeader header = table.getTableHeader();
        header.setFont(new Font("Segoe UI", Font.BOLD, 13));
        header.setBackground(ModernUI.PRIMARY_COLOR);
        header.setForeground(Color.WHITE);
        header.setPreferredSize(new Dimension(header.getWidth(), 40));
        
        DefaultTableCellRenderer centerRenderer = new DefaultTableCellRenderer();
        centerRenderer.setHorizontalAlignment(SwingConstants.CENTER);
        for (int i = 0; i < table.getColumnCount(); i++) {
            table.getColumnModel().getColumn(i).setCellRenderer(centerRenderer);
        }
    }
    
    private void loadDeTai() {
        try {
            mycls cls = new mycls();
            
            String id = cls.mahoa(maGV).replace("+", "%2B");
            String url = Constants.API_GET_DETAI_GV + "id=" + id;
            System.out.println("Loading đề tài từ: " + url);
            
            JSONArray jarr = cls.docapi(url);
            
            modelDeTai.setRowCount(0);
            
            if (jarr != null && jarr.length() > 0) {
                for (int i = 0; i < jarr.length(); i++) {
                    JSONObject job = jarr.getJSONObject(i);
                    Vector<String> row = new Vector<>();
                    row.add(job.getString("IDDeTai"));
                    row.add(job.getString("TenDeTai"));
                    row.add(job.getString("SoLuongSVDangKy"));
                    modelDeTai.addRow(row);
                }
                System.out.println("Đã load " + jarr.length() + " đề tài");
            } else {
                System.out.println("Không có đề tài nào hoặc API trả về null");
            }
        } catch (Exception e) {
            System.out.println("Lỗi loadDeTai: " + e.getMessage());
            e.printStackTrace();
            JOptionPane.showMessageDialog(this, "Lỗi khi tải danh sách đề tài: " + e.getMessage(), "Lỗi", JOptionPane.ERROR_MESSAGE);
        }
    }

    private void handleDeTaiSelection() {
        int selectedRow = tblDeTai.getSelectedRow();
        if (selectedRow >= 0) {
            String idDeTai = modelDeTai.getValueAt(selectedRow, 0).toString();
            currentDeTaiName = modelDeTai.getValueAt(selectedRow, 1).toString();
            txtIdDeTai.setText(idDeTai);
            loadSinhVien(idDeTai);
            cardLayout.show(cardPanel, "SINHVIEN");
        }
    }
    
    private void loadSinhVien(String idDeTai) {
        try {
            mycls cls = new mycls();
            
            String id = cls.mahoa(idDeTai).replace("+", "%2B");
            String url = Constants.API_GET_SV_THEO_DETAI + "id=" + id;
            System.out.println("Loading sinh viên từ: " + url);
            
            JSONArray jarr = cls.docapi(url);
            
            modelSinhVien.setRowCount(0);
            
            if (jarr != null && jarr.length() > 0) {
                for (int i = 0; i < jarr.length(); i++) {
                    JSONObject job = jarr.getJSONObject(i);
                    Vector<String> row = new Vector<>();
                    row.add(job.getString("IDDangKy"));
                    row.add(job.getString("MaSV"));
                    row.add(job.getString("HoTen"));
                    row.add(job.getString("Lop"));
                    row.add(job.getString("TenNhom"));
                    modelSinhVien.addRow(row);
                }
                System.out.println("Đã load " + jarr.length() + " sinh viên");
            } else {
                System.out.println("Không có sinh viên nào");
            }
        } catch (Exception e) {
            System.out.println("Lỗi loadSinhVien: " + e.getMessage());
            e.printStackTrace();
            JOptionPane.showMessageDialog(this, "Lỗi khi tải danh sách sinh viên: " + e.getMessage(), "Lỗi", JOptionPane.ERROR_MESSAGE);
        }
    }
    
    private void handleSinhVienSelection() {
        int selectedRow = tblSinhVien.getSelectedRow();
        if (selectedRow >= 0) {
            String idDangKy = modelSinhVien.getValueAt(selectedRow, 0).toString();
            currentMSSV = modelSinhVien.getValueAt(selectedRow, 1).toString();
            currentSinhVienName = modelSinhVien.getValueAt(selectedRow, 2).toString();
            txtIdDangKy.setText(idDangKy);
            
            // Cập nhật label hiển thị tên sinh viên
            lblSinhVienName.setText("Sinh viên: " + currentMSSV + " - " + currentSinhVienName);
            
            loadDiem(idDangKy);
            cardLayout.show(cardPanel, "DIEM");
        }
    }

    private void loadDiem(String idDangKy) {
        try {
            String[][] rawData = {
                {"1", "1", "Hình thành và phát triển ý tưởng nghiên cứu", "15%",
                    "Không có hoặc ít đóng góp", "Có thảo luận và đóng góp theo gợi ý",
                    "Chủ động thảo luận, tự xây mục tiêu", "Chủ động đề xuất ý tưởng mới"},
                {"2", "2", "Cấu trúc báo cáo KLTN hợp lý khi thuyết trình", "15%",
                    "Không hoặc ít tham gia đề cương", "Có kế hoạch chưa chi tiết",
                    "Chi tiết, chưa có dự phòng hợp lý", "Chi tiết, có dự phòng hợp lý"},
                {"3", "3.1", "Sự tương tác giữa SV và CBHD", "10%",
                    "Không hoặc ít trao đổi với CBHD", "Không chủ động liên hệ với CBHD",
                    "Chủ động gặp CBHD", "Chủ động gặp CBHD và giải quyết vấn đề"},
                {"4", "3.2", "Sự tương tác giữa các thành viên nhóm", "10%",
                    "Không hoặc ít trao đổi, phân công, không hoàn thành công việc",
                    "Có tham gia nhưng cần nhiều nhắc nhở",
                    "Chủ động, hoàn thành nhưng còn cần nhắc", "Chủ động, hoàn thành đúng hạn"},
                {"5", "3.3", "Hoàn thành nhiệm vụ được phân công", "5%",
                    "Không hoặc luôn cần nhắc nhở", "Hoàn thành không đúng hạn",
                    "Hoàn thành đúng hạn nhưng chưa chủ động", "Chủ động hoàn thành đúng hạn"},
                {"6", "4.1", "Thu nhận kết quả và xử lý số liệu", "15%",
                    "Dữ liệu giả tạo >50%", "Thiếu minh chứng hoặc dữ liệu không rõ ràng",
                    "Dữ liệu thu thập hợp lý, có minh chứng", "Trung thực, minh chứng rõ ràng"},
                {"7", "4.2", "Thảo luận nghiên cứu", "15%",
                    "Giải thích không phù hợp", "Giải thích chưa so sánh NC liên quan",
                    "Giải thích đúng, kết luận rõ", "So sánh tốt, kết luận hướng đúng mục tiêu"},
                {"8", "5.1", "Tóm tắt kết quả nghiên cứu", "5%",
                    "Tóm tắt không phù hợp", "Tóm tắt chưa đầy đủ",
                    "Tóm tắt được nhưng chưa cô đọng", "Tóm tắt chính xác, cô đọng"},
                {"9", "5.2", "Kiến nghị", "5%",
                    "Phần lớn không phù hợp", "Một số phù hợp",
                    "Phần lớn phù hợp", "Tất cả phù hợp"},
                {"10", "6.1", "Tài liệu tham khảo", "5%",
                    "Sai quy định hình thức", "≥3 lỗi vị trí hoặc số lượng",
                    "1-2 lỗi vị trí/số lượng", "Không phát hiện lỗi"},
                {"11", "6.2", "Chú thích hình ảnh, bảng biểu", "5%",
                    "Không chú thích hoặc sai hoàn toàn", "Chưa đúng quy định",
                    "Đủ nhưng chưa chuẩn", "Đúng quy định"},
                {"12", "6.3", "Chính tả, định dạng, thuật ngữ", "5%",
                    ">20 lỗi, văn phong không phù hợp", "10-20 lỗi, chưa dùng đúng thuật ngữ",
                    "<10 lỗi, văn phong tạm ổn", "Hầu như không lỗi, đúng văn phong chuyên ngành"}
            };
            
            String[] mucKeys = {"Muc1", "Muc2", "Muc3.1", "Muc3.2", "Muc3.3",
                               "Muc4.1", "Muc4.2", "Muc5.1", "Muc5.2",
                               "Muc6.1", "Muc6.2", "Muc6.3"};

            mycls cls = new mycls();
            
            String id = cls.mahoa(idDangKy).replace("+", "%2B");
            String url = Constants.API_XEM_DSDIEM + "id=" + id;
            System.out.println("Loading điểm từ: " + url);
            
            JSONArray jarr = cls.docapi(url);
            
            modelDiem.setRowCount(0);
            
            if (jarr != null && jarr.length() > 0) {
                JSONObject diemObject = jarr.getJSONObject(0);
                
                for (int i = 0; i < rawData.length; i++) {
                    Vector<String> row = new Vector<>();
                    for (int j = 0; j < 8; j++) {
                        row.add(rawData[i][j]);
                    }
                    String diem = diemObject.optString(mucKeys[i], "");
                    row.add(diem);
                    modelDiem.addRow(row);
                }
            }
        } catch (Exception e) {
            JOptionPane.showMessageDialog(this, "Lỗi khi tải phiếu chấm điểm: " + e.getMessage(), "Lỗi", JOptionPane.ERROR_MESSAGE);
        }
    }
    
    private void handleSaveDiem() {
        try {
            if (tblDiem.isEditing()) {
                tblDiem.getCellEditor().stopCellEditing();
            }
            
            if (txtIdDangKy.getText().isEmpty()) {
                JOptionPane.showMessageDialog(this, "Vui lòng chọn sinh viên trước!", "Thông báo", JOptionPane.WARNING_MESSAGE);
                return;
            }
            
            mycls cls = new mycls();
            
            String[] muc = new String[12];
            for (int i = 0; i < 12; i++) {
                muc[i] = modelDiem.getValueAt(i, 8).toString();
            }
            
            String iddetai = txtIdDangKy.getText();
            StringBuilder thamso = new StringBuilder();
            thamso.append("Muc1=").append(muc[0])
                  .append("&Muc2=").append(muc[1])
                  .append("&Muc3_1=").append(muc[2])
                  .append("&Muc3_2=").append(muc[3])
                  .append("&Muc3_3=").append(muc[4])
                  .append("&Muc4_1=").append(muc[5])
                  .append("&Muc4_2=").append(muc[6])
                  .append("&Muc5_1=").append(muc[7])
                  .append("&Muc5_2=").append(muc[8])
                  .append("&Muc6_1=").append(muc[9])
                  .append("&Muc6_2=").append(muc[10])
                  .append("&Muc6_3=").append(muc[11])
                  .append("&iddetai=").append(iddetai);

            String url = Constants.API_NHAP_DIEM + thamso.toString();
            System.out.println("Saving điểm: " + url);
            cls.geturl(url);
            
            JOptionPane.showMessageDialog(this, "✅ Lưu điểm thành công!", "Thành công", JOptionPane.INFORMATION_MESSAGE);
        } catch (Exception e) {
            JOptionPane.showMessageDialog(this, "Lỗi khi lưu điểm: " + e.getMessage(), "Lỗi", JOptionPane.ERROR_MESSAGE);
        }
    }
    
    private void handleLogout() {
        int choice = JOptionPane.showConfirmDialog(this, 
            "Bạn có chắc muốn đăng xuất khỏi hệ thống?", 
            "Xác nhận đăng xuất", 
            JOptionPane.YES_NO_OPTION,
            JOptionPane.QUESTION_MESSAGE);
        
        if (choice == JOptionPane.YES_OPTION) {
            try {
                mycls cls = new mycls();
                cls.xoaToken();
                
                JOptionPane.showMessageDialog(this, 
                    "Đăng xuất thành công!\nHẹn gặp lại bạn!", 
                    "Thông báo", 
                    JOptionPane.INFORMATION_MESSAGE);
                
                ModernLoginForm loginForm = new ModernLoginForm();
                loginForm.setVisible(true);
                dispose();
            } catch (Exception e) {
                JOptionPane.showMessageDialog(this, "Lỗi khi đăng xuất: " + e.getMessage(), "Lỗi", JOptionPane.ERROR_MESSAGE);
            }
        }
    }
}
