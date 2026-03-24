<?php
require_once 'includes/config.php';

if (isset($_GET['trxid']) && !empty($_GET['trxid'])) {
    $trxid = trim($_GET['trxid']);
    $found = false;
    $result = null;
    $type = "";

    // 1. Check in promotions table
    $stmt = $pdo->prepare("SELECT id, status, created_at, category, budget FROM promotions WHERE transaction_id = ? LIMIT 1");
    $stmt->execute([$trxid]);
    $promo = $stmt->fetch();

    if ($promo) {
        $found = true;
        $type = "Promotion Request";
        $result = $promo;
    } else {
        // 2. Check in coin_requests table
        $stmt = $pdo->prepare("SELECT id, status, created_at, coin_amount, total_price FROM coin_requests WHERE transaction_id = ? LIMIT 1");
        $stmt->execute([$trxid]);
        $coin = $stmt->fetch();

        if ($coin) {
            $found = true;
            $type = "Coin Request";
            $result = $coin;
        }
    }

    if ($found) {
        $status_label = ucfirst($result['status']);
        $status_class = strtolower($result['status']);
        $date = date('d M, Y | h:i A', strtotime($result['created_at']));
        
        $html = "
            <div class='status-card $status_class'>
                <div class='status-header'>
                    <h4>$type</h4>
                    <span class='status-badge'>$status_label</span>
                </div>
                <div class='status-body'>
                    <div class='status-row'>
                        <span>Order ID:</span>
                        <strong>#{$result['id']}</strong>
                    </div>
                    <div class='status-row'>
                        <span>Date:</span>
                        <strong>$date</strong>
                    </div>";

        if ($type == "Promotion Request") {
            $html .= "
                    <div class='status-row'>
                        <span>Type:</span>
                        <strong>{$result['category']}</strong>
                    </div>
                    <div class='status-row'>
                        <span>Budget:</span>
                        <strong>৳" . number_format($result['budget'], 2) . "</strong>
                    </div>";
        } else {
            $html .= "
                    <div class='status-row'>
                        <span>Amount:</span>
                        <strong>{$result['coin_amount']} Coins</strong>
                    </div>
                    <div class='status-row'>
                        <span>Total:</span>
                        <strong>৳" . number_format($result['total_price'], 2) . "</strong>
                    </div>";
        }

        $html .= "
                </div>
                <div class='status-footer'>
                    TrxID: $trxid
                </div>
            </div>";

        echo json_encode(['success' => true, 'html' => $html]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No order found with this Transaction ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Please enter a Transaction ID.']);
}
?>
