<?php
// Database configuration
define('DB_HOST', 'localhost'); // Set your database host/servername here
define('DB_NAME', 'coinstore'); // Set your database name here
define('DB_USER', 'root'); // Set your database username here
define('DB_PASS', ''); // Set your database password here

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: <br>" . $e->getMessage());
}

// Global functions (e.g., currency formatter)
function formatCurrency($amount) {
    return '৳' . number_format($amount, 2);
}

// CSRF Protection
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
