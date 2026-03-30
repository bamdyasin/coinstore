<?php
session_start();
require_once '../includes/config.php';

// Auth Check
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch summaries with error handling
$counts = [
    'promotions' => 0,
    'coin_requests' => 0,
    'business_apps' => 0,
    'trxids' => 0
];

try {
    $counts['promotions'] = $pdo->query("SELECT COUNT(*) FROM promotions WHERE status = 'pending'")->fetchColumn();
    $counts['coin_requests'] = $pdo->query("SELECT COUNT(*) FROM coin_requests WHERE status = 'pending'")->fetchColumn();
    $counts['business_apps'] = $pdo->query("SELECT COUNT(*) FROM business_apps WHERE status = 'pending'")->fetchColumn();
    $counts['trxids'] = $pdo->query("SELECT COUNT(*) FROM trxids WHERE status = 'unused'")->fetchColumn();
} catch (Exception $e) {
    // Some tables might not exist yet, we'll just keep the default 0
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - CoinStoreBD</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .badge {
            background: #e74c3c;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            margin-left: 5px;
            vertical-align: middle;
        }
        .tab-item {
            position: relative;
            display: flex;
            align-items: center;
        }
        .stat-card-admin {
            background: white;
            padding: 3rem 2rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
            text-align: center;
            max-width: 500px;
            margin: 2rem auto;
            border-top: 5px solid var(--primary-color);
        }
        .stat-card-admin h2 {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        .stat-card-admin p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
            font-weight: 500;
        }
        .btn-view {
            background: var(--primary-gradient);
            color: var(--secondary-color);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: var(--transition);
        }
        .btn-view:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="tabs-bar">
        <div class="tabs-container">
            <div class="tabs-group">
                <a href="javascript:void(0)" class="tab-item active" data-tab="promote">
                    Promote <span class="badge"><?php echo $counts['promotions']; ?></span>
                </a>
                <a href="javascript:void(0)" class="tab-item" data-tab="getcoin">
                    GetCoin <span class="badge"><?php echo $counts['coin_requests']; ?></span>
                </a>
                <a href="javascript:void(0)" class="tab-item" data-tab="business">
                    Business <span class="badge"><?php echo $counts['business_apps']; ?></span>
                </a>
            </div>
        </div>
    </div>

    <main class="container" style="padding-top: 2rem; min-height: 60vh;">
        <!-- Promote Stats -->
        <div id="promote-section" class="tab-content">
            <div class="stat-card-admin">
                <h2><?php echo $counts['promotions']; ?></h2>
                <p>Pending Promotions Requests</p>
                <a href="promotions.php" class="btn-view">View All Requests</a>
            </div>
        </div>

        <!-- GetCoin Stats -->
        <div id="getcoin-section" class="tab-content" style="display: none;">
            <div class="stat-card-admin" style="border-top-color: var(--primary-color);">
                <h2><?php echo $counts['coin_requests']; ?></h2>
                <p>Pending Coin Requests</p>
                <a href="coin_requests.php" class="btn-view">View All Requests</a>
            </div>
        </div>

        <!-- Business Stats -->
        <div id="business-section" class="tab-content" style="display: none;">
            <div class="stat-card-admin" style="border-top-color: #3498db;">
                <h2><?php echo $counts['business_apps']; ?></h2>
                <p>Pending Business Applications</p>
                <a href="business.php" class="btn-view" style="background: linear-gradient(135deg, #3498db, #2980b9); color: white;">View All Applications</a>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabItems = document.querySelectorAll('.tab-item');
            const sections = {
                'promote': document.getElementById('promote-section'),
                'getcoin': document.getElementById('getcoin-section'),
                'business': document.getElementById('business-section')
            };

            tabItems.forEach(item => {
                item.addEventListener('click', () => {
                    const targetTab = item.getAttribute('data-tab');

                    // Deactivate all tabs
                    tabItems.forEach(i => i.classList.remove('active'));
                    // Activate clicked tab
                    item.classList.add('active');

                    // Hide all sections
                    Object.values(sections).forEach(s => s.style.display = 'none');

                    // Show target section
                    if (sections[targetTab]) {
                        sections[targetTab].style.display = 'block';
                    }
                });
            });
        });
    </script>

    <footer style="text-align: center; padding: 2rem; color: #888; font-size: 0.9rem;">
        &copy; <?php echo date('Y'); ?> CoinStoreBD Admin Management
    </footer>
</body>
</html>
