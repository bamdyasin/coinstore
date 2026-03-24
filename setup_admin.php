<?php
require_once 'includes/config.php';

try {
    // 1. Create tables for form submissions
    $sql = "
    CREATE TABLE IF NOT EXISTS promotions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        video_link VARCHAR(255) NOT NULL,
        category VARCHAR(50) NOT NULL,
        budget DECIMAL(10, 2) NOT NULL,
        whatsapp VARCHAR(20) NOT NULL,
        payment_option VARCHAR(50) NOT NULL,
        transaction_id VARCHAR(100) NOT NULL,
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS coin_requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        coin_amount INT NOT NULL,
        total_price DECIMAL(10, 2) NOT NULL,
        whatsapp VARCHAR(20) NOT NULL,
        payment_option VARCHAR(50) NOT NULL,
        transaction_id VARCHAR(100) NOT NULL,
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
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
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";
    $pdo->exec($sql);

    // 2. Ensure admin user exists
    $username = 'admin';
    $password = 'admin';
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, 'admin@coinstorebd.com', $password_hash, 'admin']);
        echo "Admin user created successfully.<br>";
    } else {
        echo "Admin user already exists. Updating password to 'admin'.<br>";
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE username = ?");
        $stmt->execute([$password_hash, $username]);
    }

    echo "Database setup completed successfully.";

} catch (PDOException $e) {
    die("Error setting up database: " . $e->getMessage());
}
?>
