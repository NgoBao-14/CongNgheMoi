package testlaythongtinmay;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import java.awt.*;
import java.awt.geom.RoundRectangle2D;

/**
 * Class chứa các component UI hiện đại
 */
public class ModernUI {
    
    // Màu sắc chủ đạo
    public static final Color PRIMARY_COLOR = new Color(41, 128, 185);
    public static final Color PRIMARY_DARK = new Color(31, 97, 141);
    public static final Color ACCENT_COLOR = new Color(52, 152, 219);
    public static final Color SUCCESS_COLOR = new Color(46, 204, 113);
    public static final Color DANGER_COLOR = new Color(231, 76, 60);
    public static final Color TEXT_COLOR = new Color(44, 62, 80);
    public static final Color LIGHT_BG = new Color(236, 240, 241);
    public static final Color WHITE = Color.WHITE;
    
    /**
     * Tạo JTextField hiện đại với bo góc
     */
    public static JTextField createModernTextField(String placeholder) {
        JTextField textField = new JTextField();
        textField.setFont(new Font("Segoe UI", Font.PLAIN, 14));
        textField.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(189, 195, 199), 1),
            new EmptyBorder(10, 15, 10, 15)
        ));
        textField.setForeground(TEXT_COLOR);
        return textField;
    }
    
    /**
     * Tạo JPasswordField hiện đại
     */
    public static JPasswordField createModernPasswordField() {
        JPasswordField passwordField = new JPasswordField();
        passwordField.setFont(new Font("Segoe UI", Font.PLAIN, 14));
        passwordField.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(189, 195, 199), 1),
            new EmptyBorder(10, 15, 10, 15)
        ));
        passwordField.setForeground(TEXT_COLOR);
        return passwordField;
    }
    
    /**
     * Tạo JButton hiện đại với gradient
     */
    public static JButton createModernButton(String text) {
        JButton button = new JButton(text) {
            @Override
            protected void paintComponent(Graphics g) {
                Graphics2D g2d = (Graphics2D) g.create();
                g2d.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
                
                if (getModel().isPressed()) {
                    g2d.setColor(PRIMARY_DARK);
                } else if (getModel().isRollover()) {
                    g2d.setColor(ACCENT_COLOR);
                } else {
                    GradientPaint gp = new GradientPaint(0, 0, PRIMARY_COLOR, 0, getHeight(), PRIMARY_DARK);
                    g2d.setPaint(gp);
                }
                
                g2d.fillRoundRect(0, 0, getWidth(), getHeight(), 10, 10);
                g2d.dispose();
                
                super.paintComponent(g);
            }
        };
        
        button.setFont(new Font("Segoe UI", Font.BOLD, 14));
        button.setForeground(WHITE);
        button.setFocusPainted(false);
        button.setBorderPainted(false);
        button.setContentAreaFilled(false);
        button.setCursor(new Cursor(Cursor.HAND_CURSOR));
        button.setPreferredSize(new Dimension(200, 45));
        
        return button;
    }
    
    /**
     * Tạo JLabel cho tiêu đề
     */
    public static JLabel createTitleLabel(String text) {
        JLabel label = new JLabel(text);
        label.setFont(new Font("Segoe UI", Font.BOLD, 28));
        label.setForeground(PRIMARY_COLOR);
        return label;
    }
    
    /**
     * Tạo JLabel cho text thường
     */
    public static JLabel createLabel(String text) {
        JLabel label = new JLabel(text);
        label.setFont(new Font("Segoe UI", Font.PLAIN, 14));
        label.setForeground(TEXT_COLOR);
        return label;
    }
    
    /**
     * Tạo JPanel với background gradient
     */
    public static JPanel createGradientPanel() {
        return new JPanel() {
            @Override
            protected void paintComponent(Graphics g) {
                super.paintComponent(g);
                Graphics2D g2d = (Graphics2D) g;
                g2d.setRenderingHint(RenderingHints.KEY_RENDERING, RenderingHints.VALUE_RENDER_QUALITY);
                int w = getWidth();
                int h = getHeight();
                GradientPaint gp = new GradientPaint(0, 0, new Color(52, 152, 219), 0, h, new Color(41, 128, 185));
                g2d.setPaint(gp);
                g2d.fillRect(0, 0, w, h);
            }
        };
    }
    
    /**
     * Tạo JPanel bo góc với shadow
     */
    public static JPanel createRoundedPanel(Color bgColor) {
        JPanel panel = new JPanel() {
            @Override
            protected void paintComponent(Graphics g) {
                Graphics2D g2d = (Graphics2D) g.create();
                g2d.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
                
                // Shadow
                g2d.setColor(new Color(0, 0, 0, 30));
                g2d.fillRoundRect(5, 5, getWidth() - 10, getHeight() - 10, 20, 20);
                
                // Background
                g2d.setColor(bgColor);
                g2d.fillRoundRect(0, 0, getWidth() - 10, getHeight() - 10, 20, 20);
                g2d.dispose();
            }
        };
        panel.setOpaque(false);
        return panel;
    }
}
