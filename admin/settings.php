<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// 1. Ensure settings table exists (Self-healing setup)
$pdo->exec("CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

$message = "";

// Handle Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_pixel'])) {
    $tiktok_pixel = trim($_POST['tiktok_pixel_id']);
    $facebook_pixel = trim($_POST['facebook_pixel_id']);
    
    // Update TikTok Pixel
    $stmt1 = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) 
                           VALUES ('tiktok_pixel_id', ?) 
                           ON DUPLICATE KEY UPDATE setting_value = ?");
    $stmt1->execute([$tiktok_pixel, $tiktok_pixel]);

    // Update Facebook Pixel
    $stmt2 = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) 
                           VALUES ('facebook_pixel_id', ?) 
                           ON DUPLICATE KEY UPDATE setting_value = ?");
    
    if ($stmt2->execute([$facebook_pixel, $facebook_pixel])) {
        $message = "Settings updated successfully!";
    } else {
        $message = "Error updating settings.";
    }
}

// Fetch current pixel IDs
$stmt = $pdo->prepare("SELECT setting_key, setting_value FROM site_settings WHERE setting_key IN ('tiktok_pixel_id', 'facebook_pixel_id')");
$stmt->execute();
$settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$tiktok_id = $settings['tiktok_pixel_id'] ?? "";
$facebook_id = $settings['facebook_pixel_id'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { padding: 1rem; max-width: 600px; margin: 0 auto; }
        .header-strip { background: var(--secondary-color); color: white; padding: 1rem; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; }
        .settings-card { background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); border-top: 5px solid var(--primary-color); }
        .help-text { font-size: 0.8rem; color: #666; margin-top: 5px; }
    </style>
</head>
<body style="background: #f0f2f5;">
    <?php include 'navbar.php'; ?>

    <div class="header-strip">
        <a href="index.php" style="color: white; text-decoration: none; font-size: 1.2rem;">←</a>
        <h3 style="margin: 0;">Site Settings</h3>
        <div style="width: 20px;"></div>
    </div>

    <div class="admin-container">
        <?php if ($message): ?>
            <div style="background: #34495e; color: white; padding: 10px; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="settings-card">
            <h4 style="margin-bottom: 1.5rem; color: var(--secondary-color);"><i class="fas fa-chart-line"></i> Analytics & Tracking</h4>
            
            <form action="" method="POST">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label><i class="fab fa-tiktok"></i> TikTok Pixel ID</label>
                    <input type="text" name="tiktok_pixel_id" value="<?php echo htmlspecialchars($tiktok_id); ?>" placeholder="e.g. C123456789ABC">
                </div>

                <div class="form-group">
                    <label><i class="fab fa-facebook-f"></i> Facebook Pixel ID</label>
                    <input type="text" name="facebook_pixel_id" value="<?php echo htmlspecialchars($facebook_id); ?>" placeholder="e.g. 123456789012345">
                    <p class="help-text">Enter your Meta (Facebook) Pixel ID here.</p>
                </div>
                
                <button type="submit" name="update_pixel" class="btn btn-primary" style="width: 100%; margin-top: 1.5rem;">Save All Settings</button>
            </form>
        </div>
    </div>
</body>
</html>
