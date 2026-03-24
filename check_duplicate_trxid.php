<?php
require_once 'includes/config.php';

if (isset($_GET['trxid']) && !empty($_GET['trxid'])) {
    $trxid = trim($_GET['trxid']);

    // Check in promotions
    $stmt1 = $pdo->prepare("SELECT id FROM promotions WHERE transaction_id = ? LIMIT 1");
    $stmt1->execute([$trxid]);
    
    // Check in coin_requests
    $stmt2 = $pdo->prepare("SELECT id FROM coin_requests WHERE transaction_id = ? LIMIT 1");
    $stmt2->execute([$trxid]);

    if ($stmt1->fetch() || $stmt2->fetch()) {
        echo json_encode(['duplicate' => true]);
    } else {
        echo json_encode(['duplicate' => false]);
    }
} else {
    echo json_encode(['duplicate' => false]);
}
?>
