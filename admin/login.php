<?php
session_start();
require_once '../includes/config.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        // First check if 'users' table exists
        $tableCheck = $pdo->query("SHOW TABLES LIKE 'users'")->rowCount();
        if ($tableCheck == 0) {
            $error = "Error: 'users' table does not exist. Please run setup_admin.php first.";
        } else {
            // Fetch user from database
            $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ? AND role = 'admin' LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user) {
                // Check plain text password directly from 'password' column
                if ($password === $user['password']) {
                    // Success: Set session variables
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_user'] = $user['username'];
                    $_SESSION['admin_role'] = $user['role'];
                    
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Incorrect password.";
                }
            } else {
                $error = "Admin user not found.";
            }
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CoinStoreBD</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-top: 5px solid var(--primary-color);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .error-message {
            color: #e74c3c;
            background: #fdeaea;
            padding: 0.8rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>
<body style="background: #f4f7f6;">
    <div class="login-container">
        <div class="login-header">
            <h2 style="color: var(--primary-color);">🔐 Admin Login</h2>
            <p style="color: #666; font-size: 0.9rem;">CoinStoreBD Management Portal</p>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="admin" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="admin" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login</button>
        </form>
        
        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="../index.php" style="color: #888; text-decoration: none; font-size: 0.9rem;">← Back to Website</a>
        </div>
    </div>
</body>
</html>
