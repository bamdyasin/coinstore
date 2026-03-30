<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

// Handle Add TrxID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_trx'])) {
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }
    $trxid = trim($_POST['transaction_id']);
    $method = $_POST['payment_method'];
    $amount = $_POST['amount'];

    try {
        $stmt = $pdo->prepare("INSERT INTO trxids (transaction_id, payment_method, amount) VALUES (?, ?, ?)");
        $stmt->execute([$trxid, $method, $amount]);
        $message = "TrxID added successfully!";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $message = "Error: This TrxID already exists!";
        } else {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    if (!isset($_GET['csrf_token']) || !verify_csrf_token($_GET['csrf_token'])) {
        die("CSRF token validation failed.");
    }
    $pdo->prepare("DELETE FROM trxids WHERE id = ?")->execute([$_GET['id']]);
    header("Location: trxids.php");
    exit();
}

// Fetch TrxIDs
$trxids = $pdo->query("SELECT * FROM trxids ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage TrxIDs - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { padding: 1rem; max-width: 600px; margin: 0 auto; }
        .header-strip { background: var(--secondary-color); color: white; padding: 1rem; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; }
        
        .add-form {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border-top: 5px solid #27ae60;
        }

        .trx-card {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 5px solid #eee;
        }
        .trx-card.unused { border-left-color: #27ae60; }
        .trx-card.used { border-left-color: #e74c3c; opacity: 0.7; }

        .trx-info { flex: 1; }
        .trx-id-text { font-weight: bold; font-family: monospace; font-size: 1rem; color: var(--secondary-color); }
        .trx-meta { font-size: 0.8rem; color: #888; margin-top: 3px; }
        
        .status-badge {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-unused { background: #eafaf1; color: #2ecc71; }
        .status-used { background: #fdedec; color: #e74c3c; }

        .delete-link { color: #e74c3c; text-decoration: none; font-size: 1.2rem; margin-left: 1rem; }
    </style>
</head>
<body style="background: #f0f2f5;">
    <?php include 'navbar.php'; ?>

    <div class="header-strip">
        <a href="index.php" style="color: white; text-decoration: none; font-size: 1.2rem;">←</a>
        <h3 style="margin: 0;">Manage TrxIDs</h3>
        <div style="width: 20px;"></div>
    </div>

    <div class="admin-container">
        <?php if ($message): ?>
            <div style="background: #34495e; color: white; padding: 10px; border-radius: 8px; margin-bottom: 1rem; text-align: center; font-size: 0.9rem;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Add TrxID Form -->
        <div class="add-form">
            <h4 style="margin-bottom: 1rem; color: #27ae60;">➕ Add New Transaction ID</h4>
            <form action="" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group">
                    <label>Transaction ID</label>
                    <input type="text" name="transaction_id" placeholder="8N7X2M9P..." required>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="form-group">
                        <label>Method</label>
                        <select name="payment_method" required>
                            <option value="Bkash">Bkash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Rocket">Rocket</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount (৳)</label>
                        <input type="number" name="amount" placeholder="500" required>
                    </div>
                </div>
                <button type="submit" name="add_trx" class="btn" style="width: 100%; background: #27ae60; color: white; margin-top: 0.5rem;">Add TrxID</button>
            </form>
        </div>

        <h4 style="margin-bottom: 1rem; color: #666;">📜 TrxID List</h4>
        <?php if (empty($trxids)): ?>
            <p style="text-align: center; color: #aaa; padding: 2rem;">No TrxIDs added yet.</p>
        <?php endif; ?>

        <?php foreach ($trxids as $t): ?>
            <div class="trx-card <?php echo $t['status']; ?>">
                <div class="trx-info">
                    <div class="trx-id-text"><?php echo htmlspecialchars($t['transaction_id']); ?></div>
                    <div class="trx-meta">
                        <?php echo $t['payment_method']; ?> | ৳<?php echo number_format($t['amount'], 2); ?> | 
                        <span class="status-badge status-<?php echo $t['status']; ?>"><?php echo $t['status']; ?></span>
                    </div>
                </div>
                <a href="?action=delete&id=<?php echo $t['id']; ?>&csrf_token=<?php echo $_SESSION['csrf_token']; ?>" class="delete-link" onclick="return confirm('Delete this TrxID?')">🗑️</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
