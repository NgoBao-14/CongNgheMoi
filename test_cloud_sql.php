<?php
/**
 * Test Cloud SQL Connection
 * Chạy file này để test kết nối database
 * 
 * Cách chạy:
 * php test_cloud_sql.php
 * 
 * Hoặc truy cập qua browser:
 * http://localhost/CongNgheMoi/test_cloud_sql.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'mvc/core/DB_Config.php';

echo "<h1>🧪 Test Cloud SQL Connection</h1>";
echo "<hr>";

// Test tất cả môi trường
$environments = ['local', 'cloud', 'cloud_proxy', 'cloud_socket'];

foreach ($environments as $env) {
    echo "<h2>Testing: $env</h2>";
    
    try {
        DB_Config::setEnvironment($env);
        $config = DB_Config::get();
        
        echo "<strong>Config:</strong><br>";
        echo "<pre>";
        print_r([
            'host' => $config['host'] ?? 'N/A',
            'username' => $config['username'],
            'database' => $config['database'],
            'port' => $config['port'] ?? 'N/A',
            'socket' => $config['socket'] ?? 'N/A'
        ]);
        echo "</pre>";
        
        // Test connection
        echo "<strong>Testing connection...</strong><br>";
        
        if ($config['socket']) {
            // Socket connection
            $conn = mysqli_init();
            $success = @mysqli_real_connect(
                $conn,
                null,
                $config['username'],
                $config['password'],
                $config['database'],
                null,
                $config['socket']
            );
        } else {
            // TCP connection
            $conn = @mysqli_connect(
                $config['host'],
                $config['username'],
                $config['password'],
                $config['database'],
                $config['port']
            );
            $success = $conn !== false;
        }
        
        if ($success) {
            echo "✅ <span style='color: green;'>Kết nối thành công!</span><br>";
            
            // Test query
            $result = mysqli_query($conn, "SELECT DATABASE() as db, VERSION() as version");
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                echo "<strong>Database:</strong> " . $row['db'] . "<br>";
                echo "<strong>MySQL Version:</strong> " . $row['version'] . "<br>";
                
                // Count tables
                $result = mysqli_query($conn, "SHOW TABLES");
                $table_count = mysqli_num_rows($result);
                echo "<strong>Số bảng:</strong> $table_count<br>";
                
                // Test một query thực tế
                $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<strong>Số users:</strong> " . $row['total'] . "<br>";
                }
            }
            
            mysqli_close($conn);
        } else {
            echo "❌ <span style='color: red;'>Kết nối thất bại!</span><br>";
            echo "<strong>Error:</strong> " . mysqli_connect_error() . "<br>";
        }
        
    } catch (Exception $e) {
        echo "❌ <span style='color: red;'>Exception:</span> " . $e->getMessage() . "<br>";
    }
    
    echo "<hr>";
}

// Test với DB class
echo "<h2>Testing DB Class</h2>";

try {
    require_once 'mvc/core/DB_Updated.php';
    
    // Test local
    DB_Config::setEnvironment('local');
    $db = new DB();
    
    if ($db->isConnected()) {
        echo "✅ <span style='color: green;'>DB Class kết nối thành công!</span><br>";
        
        $info = $db->getConnectionInfo();
        echo "<pre>";
        print_r($info);
        echo "</pre>";
    } else {
        echo "❌ <span style='color: red;'>DB Class kết nối thất bại!</span><br>";
    }
    
} catch (Exception $e) {
    echo "❌ <span style='color: red;'>Exception:</span> " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>✅ Test hoàn tất!</h3>";
echo "<p><strong>Lưu ý:</strong></p>";
echo "<ul>";
echo "<li>Nếu 'local' thành công → Localhost OK</li>";
echo "<li>Nếu 'cloud' thành công → Cloud SQL OK</li>";
echo "<li>Nếu tất cả fail → Kiểm tra lại config</li>";
echo "</ul>";
?>
