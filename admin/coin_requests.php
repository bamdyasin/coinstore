<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get current tab from URL, default to 'pending'
$current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'pending';
$allowed_tabs = ['pending', 'approved', 'completed', 'rejected'];
if (!in_array($current_tab, $allowed_tabs)) {
    $current_tab = 'pending';
}

// Handle Status Update or Delete
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'approve') {
        $pdo->prepare("UPDATE coin_requests SET status = 'approved' WHERE id = ?")->execute([$id]);
    } elseif ($action == 'complete') {
        $pdo->prepare("UPDATE coin_requests SET status = 'completed' WHERE id = ?")->execute([$id]);
    } elseif ($action == 'reject') {
        $pdo->prepare("UPDATE coin_requests SET status = 'rejected' WHERE id = ?")->execute([$id]);
    }
    // Redirect back to the same tab
    header("Location: coin_requests.php?tab=" . $current_tab);
    exit();
}

// Fetch requests for the current tab
$stmt = $pdo->prepare("SELECT * FROM coin_requests WHERE status = ? ORDER BY created_at DESC");
$stmt->execute([$current_tab]);
$requests = $stmt->fetchAll();

// Fetch counts for badges
$counts = [];
foreach ($allowed_tabs as $tab) {
    $counts[$tab] = $pdo->query("SELECT COUNT(*) FROM coin_requests WHERE status = '$tab'")->fetchColumn();
}

/**
 * AUTO-APPROVAL LOGIC
 */
if ($current_tab == 'pending') {
    $pending_requests = $pdo->query("SELECT id, transaction_id, total_price FROM coin_requests WHERE status = 'pending'")->fetchAll();
    foreach ($pending_requests as $req) {
        $trxid = $req['transaction_id'];
        $amount = $req['total_price'];
        
        $stmt_check = $pdo->prepare("SELECT id FROM trxids WHERE transaction_id = ? AND amount = ? AND status = 'unused' LIMIT 1");
        $stmt_check->execute([$trxid, $amount]);
        $match = $stmt_check->fetch();
        
        if ($match) {
            $pdo->prepare("UPDATE coin_requests SET status = 'approved' WHERE id = ?")->execute([$req['id']]);
            $pdo->prepare("UPDATE trxids SET status = 'used' WHERE id = ?")->execute([$match['id']]);
            $any_updated = true;
        }
    }
    if (isset($any_updated)) {
        header("Location: coin_requests.php?tab=pending&auto_approved=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coin Requests - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { padding: 1rem; max-width: 600px; margin: 0 auto; }
        .header-strip { background: var(--secondary-color); color: white; padding: 1rem; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; }
        
        /* Tab Styles */
        .admin-tabs {
            display: flex;
            background: #fff;
            padding: 0.5rem;
            position: sticky;
            top: 55px;
            z-index: 99;
            overflow-x: auto;
            border-bottom: 1px solid #ddd;
            gap: 10px;
        }
        .admin-tab-item {
            padding: 8px 15px;
            text-decoration: none;
            color: #666;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 20px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            background: #f8f9fa;
        }
        .admin-tab-item.active {
            background: var(--secondary-color);
            color: white;
        }
        .tab-badge {
            background: rgba(0,0,0,0.1);
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 5px;
            font-size: 0.7rem;
        }
        .admin-tab-item.active .tab-badge {
            background: rgba(255,255,255,0.2);
        }

        .request-card { background: white; border-radius: 12px; padding: 1.2rem; margin-top: 1rem; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-left: 5px solid #eee; }
        .request-card.pending { border-left-color: #f1c40f; }
        .request-card.approved { border-left-color: #3498db; }
        .request-card.completed { border-left-color: #2ecc71; }
        .request-card.rejected { border-left-color: #e74c3c; }

        .card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; }
        .request-id { font-weight: bold; color: #888; font-size: 0.9rem; }
        
        .info-row { margin-bottom: 0.5rem; font-size: 0.9rem; }
        .info-label { color: #777; font-weight: 500; width: 110px; display: inline-block; }
        .info-value { color: var(--secondary-color); font-weight: 600; }
        
        .card-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 1.2rem; border-top: 1px solid #eee; padding-top: 1rem; }
        .action-btn { padding: 10px; border-radius: 8px; text-align: center; text-decoration: none; font-weight: bold; font-size: 0.8rem; transition: 0.2s; }
        .btn-approve { background: #3498db; color: white; }
        .btn-complete { background: #2ecc71; color: white; }
        .btn-reject { background: #f39c12; color: white; }
    </style>
</head>
<body style="background: #f0f2f5;">
    <?php include 'navbar.php'; ?>

    <div class="header-strip">
        <a href="index.php" style="color: white; text-decoration: none; font-size: 1.2rem;">←</a>
        <h3 style="margin: 0;">Coin Requests</h3>
        <div style="width: 20px;"></div>
    </div>

    <!-- Filter Tabs -->
    <div class="admin-tabs">
        <a href="?tab=pending" class="admin-tab-item <?php echo $current_tab == 'pending' ? 'active' : ''; ?>">
            Pending <span class="tab-badge"><?php echo $counts['pending']; ?></span>
        </a>
        <a href="?tab=approved" class="admin-tab-item <?php echo $current_tab == 'approved' ? 'active' : ''; ?>">
            Approved <span class="tab-badge"><?php echo $counts['approved']; ?></span>
        </a>
        <a href="?tab=completed" class="admin-tab-item <?php echo $current_tab == 'completed' ? 'active' : ''; ?>">
            Completed <span class="tab-badge"><?php echo $counts['completed']; ?></span>
        </a>
        <a href="?tab=rejected" class="admin-tab-item <?php echo $current_tab == 'rejected' ? 'active' : ''; ?>">
            Rejected <span class="tab-badge"><?php echo $counts['rejected']; ?></span>
        </a>
    </div>

    <div class="admin-container">
        <?php if (empty($requests)): ?>
            <div style="text-align: center; padding: 3rem; color: #888;">
                <p>No <?php echo $current_tab; ?> requests found.</p>
            </div>
        <?php endif; ?>

        <?php foreach ($requests as $r): ?>
            <div class="request-card <?php echo $r['status']; ?>">
                <div class="card-header">
                    <span class="request-id">ID: #<?php echo $r['id']; ?></span>
                    <span style="font-size: 0.7rem; color: #aaa;"><?php echo date('d M, Y | h:i A', strtotime($r['created_at'])); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Coin Amount:</span>
                    <span class="info-value"><?php echo $r['coin_amount']; ?> Coins</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Price:</span>
                    <span class="info-value" style="color: #27ae60;">৳<?php echo number_format($r['total_price'], 2); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">WhatsApp:</span>
                    <span class="info-value"><?php echo $r['whatsapp']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment:</span>
                    <span class="info-value"><?php echo $r['payment_option']; ?></span>
                </div>
                
                <div style="background: #f8f9fa; padding: 8px; border-radius: 6px; font-size: 0.8rem; margin-top: 5px;">
                    <strong>Trx ID / Message:</strong><br>
                    <?php echo htmlspecialchars($r['transaction_id']); ?>
                </div>

                <div class="card-actions">
                    <?php if ($r['status'] == 'pending'): ?>
                        <a href="?action=approve&id=<?php echo $r['id']; ?>&tab=<?php echo $current_tab; ?>" class="action-btn btn-approve">Approve ✅</a>
                        <a href="?action=reject&id=<?php echo $r['id']; ?>&tab=<?php echo $current_tab; ?>" class="action-btn btn-reject">Reject ❌</a>
                    <?php elseif ($r['status'] == 'approved'): ?>
                        <a href="?action=complete&id=<?php echo $r['id']; ?>&tab=<?php echo $current_tab; ?>" class="action-btn btn-complete" style="grid-column: span 2;">Mark Complete ⭐</a>
                    <?php endif; ?>
                </div>
                </div>
                <?php endforeach; ?>

    </div>
</body>
</html>
