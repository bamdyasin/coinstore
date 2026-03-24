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
        $pdo->prepare("UPDATE business_apps SET status = 'approved' WHERE id = ?")->execute([$id]);
    } elseif ($action == 'complete') {
        $pdo->prepare("UPDATE business_apps SET status = 'completed' WHERE id = ?")->execute([$id]);
    } elseif ($action == 'reject') {
        $pdo->prepare("UPDATE business_apps SET status = 'rejected' WHERE id = ?")->execute([$id]);
    }
    // Redirect back to the same tab
    header("Location: business.php?tab=" . $current_tab);
    exit();
}

// Fetch applications for the current tab
$stmt = $pdo->prepare("SELECT * FROM business_apps WHERE status = ? ORDER BY created_at DESC");
$stmt->execute([$current_tab]);
$apps = $stmt->fetchAll();

// Fetch counts for badges
$counts = [];
foreach ($allowed_tabs as $tab) {
    $counts[$tab] = $pdo->query("SELECT COUNT(*) FROM business_apps WHERE status = '$tab'")->fetchColumn();
}

/**
 * AUTO-APPROVAL LOGIC
 * Note: Business apps normally require manual review, but if they have a transaction 
 * mechanism, we can add it here. For now, following the same pattern as others.
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Apps - Admin</title>
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
        .request-card.pending { border-left-color: #3498db; }
        .request-card.approved { border-left-color: #f1c40f; }
        .request-card.completed { border-left-color: #2ecc71; }
        .request-card.rejected { border-left-color: #e74c3c; }

        .card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; }
        .request-id { font-weight: bold; color: #888; font-size: 0.9rem; }
        
        .info-row { margin-bottom: 0.5rem; font-size: 0.9rem; }
        .info-label { color: #777; font-weight: 500; width: 120px; display: inline-block; }
        .info-value { color: var(--secondary-color); font-weight: 600; }
        .message-box { background: #f8f9fa; padding: 10px; border-radius: 6px; font-size: 0.85rem; margin-top: 0.5rem; color: #555; border: 1px solid #eee; }

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
        <h3 style="margin: 0;">Business Apps</h3>
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
        <?php if (empty($apps)): ?>
            <div style="text-align: center; padding: 3rem; color: #888;">
                <p>No <?php echo $current_tab; ?> applications found.</p>
            </div>
        <?php endif; ?>

        <?php foreach ($apps as $a): ?>
            <div class="request-card <?php echo $a['status']; ?>">
                <div class="card-header">
                    <span class="request-id">ID: #<?php echo $a['id']; ?></span>
                    <span style="font-size: 0.7rem; color: #aaa;"><?php echo date('d M, Y | h:i A', strtotime($a['created_at'])); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Business:</span>
                    <span class="info-value"><?php echo htmlspecialchars($a['biz_name']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Contact:</span>
                    <span class="info-value"><?php echo htmlspecialchars($a['contact_person']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Type:</span>
                    <span class="info-value"><?php echo ucfirst($a['biz_type']); ?></span>
                </div>
                
                <?php if ($a['website']): ?>
                <div class="info-row">
                    <span class="info-label">Website:</span>
                    <a href="<?php echo $a['website']; ?>" target="_blank" style="color: #3498db; font-size: 0.85rem;">Visit Site 🔗</a>
                </div>
                <?php endif; ?>

                <div class="message-box">
                    <strong>Message:</strong><br>
                    <?php echo nl2br(htmlspecialchars($a['message'])); ?>
                </div>

                <div class="card-actions">
                    <?php if ($a['status'] == 'pending'): ?>
                        <a href="?action=approve&id=<?php echo $a['id']; ?>&tab=<?php echo $current_tab; ?>" class="action-btn btn-approve">Approve ✅</a>
                        <a href="?action=reject&id=<?php echo $a['id']; ?>&tab=<?php echo $current_tab; ?>" class="action-btn btn-reject">Reject ❌</a>
                    <?php elseif ($a['status'] == 'approved'): ?>
                        <a href="?action=complete&id=<?php echo $a['id']; ?>&tab=<?php echo $current_tab; ?>" class="action-btn btn-complete" style="grid-column: span 2;">Mark Complete ⭐</a>
                    <?php endif; ?>
                </div>
                </div>
                <?php endforeach; ?>

    </div>
</body>
</html>
