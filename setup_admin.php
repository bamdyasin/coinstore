<?php
require_once 'includes/config.php';

// Security Key Check
$secret_key = 'secure_setup_2024'; // Change this to something very unique
if (!isset($_GET['key']) || $_GET['key'] !== $secret_key) {
    die("Access Denied: Invalid Security Key.");
}

try {
    // 1. Create tables
    $sql = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS promotions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        video_link VARCHAR(255) NOT NULL,
        category VARCHAR(50) NOT NULL,
        budget DECIMAL(10, 2) NOT NULL,
        whatsapp VARCHAR(20) NOT NULL,
        payment_option VARCHAR(50) NOT NULL,
        transaction_id VARCHAR(100) NOT NULL,
        status ENUM('pending', 'approved', 'completed', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS coin_requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        coin_amount INT NOT NULL,
        total_price DECIMAL(10, 2) NOT NULL,
        whatsapp VARCHAR(20) NOT NULL,
        payment_option VARCHAR(50) NOT NULL,
        transaction_id VARCHAR(100) NOT NULL,
        status ENUM('pending', 'approved', 'completed', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS business_apps (
        id INT AUTO_INCREMENT PRIMARY KEY,
        biz_name VARCHAR(100) NOT NULL,
        contact_person VARCHAR(100) NOT NULL,
        biz_type VARCHAR(50) NOT NULL,
        experience INT NOT NULL,
        website VARCHAR(255),
        message TEXT,
        status ENUM('pending', 'approved', 'completed', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS site_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) NOT NULL UNIQUE,
        setting_value TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS trxids (
        id INT AUTO_INCREMENT PRIMARY KEY,
        transaction_id VARCHAR(100) NOT NULL UNIQUE,
        payment_method VARCHAR(50) NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        status ENUM('unused', 'used') DEFAULT 'unused',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";
    $pdo->exec($sql);

    // 2. Default Settings (Optional)
    $pdo->exec("INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES ('tiktok_pixel_id', ''), ('facebook_pixel_id', '')");

    // 3. Ensure admin user exists
    $username = 'admin';
    $password = 'admin';
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, password_hash, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, 'admin@coinstorebd.com', $password, $password_hash, 'admin']);
        echo "Admin user created successfully.<br>";
    } else {
        echo "Admin user already exists.<br>";
    }

    echo "Database setup completed successfully. <b>Please DELETE this file for security.</b>";

} catch (PDOException $e) {
    die("Error setting up database: " . $e->getMessage());
}
?>
