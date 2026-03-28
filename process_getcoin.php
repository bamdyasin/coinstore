<?php
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $coin_amount = $_POST['coin_amount'];
    $total_price = $coin_amount * 2; // Fixed rate as per request
    $whatsapp = $_POST['whatsapp'];
    $payment_option = $_POST['payment_option'];
    $transaction_id = trim($_POST['description']);

    // Check for duplicate Transaction ID in both tables
    $check_promo = $pdo->prepare("SELECT id FROM promotions WHERE transaction_id = ?");
    $check_promo->execute([$transaction_id]);
    
    $check_coin = $pdo->prepare("SELECT id FROM coin_requests WHERE transaction_id = ?");
    $check_coin->execute([$transaction_id]);

    if ($check_promo->fetch() || $check_coin->fetch()) {
        echo "<script>alert('Error: This Transaction ID has already been used. Please provide a unique TrxID.'); window.history.back();</script>";
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO coin_requests (coin_amount, total_price, whatsapp, payment_option, transaction_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$coin_amount, $total_price, $whatsapp, $payment_option, $transaction_id]);
        
        header("Location: index.php?success=1&title=Request Sent!&message=Your coin request has been submitted successfully. Please wait for admin approval.");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
