<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require_once 'includes/config.php';
    
    // Test a simple query
    $stmt = $pdo->query("SELECT 1");
    if ($stmt) {
        echo "<h2 style='color: green;'>✅ Database connection is working!</h2>";
        echo "<p>Connected to database: <strong>" . DB_NAME . "</strong></p>";
        
        // Check if tables exist
        $tables = ['users', 'promotions', 'coin_requests', 'business_apps'];
        echo "<h3>Table Check:</h3><ul>";
        foreach ($tables as $table) {
            $check = $pdo->query("SHOW TABLES LIKE '$table'")->rowCount();
            echo "<li>Table <strong>$table</strong>: " . ($check > 0 ? "<span style='color: green;'>Exists</span>" : "<span style='color: red;'>Missing</span>") . "</li>";
        }
        echo "</ul>";
        
    }
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Connection Failed!</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
<br>
<a href="index.php">Go back to Homepage</a>
