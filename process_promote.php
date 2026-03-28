<?php
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $video_link = trim($_POST['coin_title']);
    $category = $_POST['category'];
    $budget = $_POST['price'];
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
        $stmt = $pdo->prepare("INSERT INTO promotions (video_link, category, budget, whatsapp, payment_option, transaction_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$video_link, $category, $budget, $whatsapp, $payment_option, $transaction_id]);
        
        header("Location: index.php?success=1&title=Submitted!&message=Your promotion request has been received and is now under review. We will contact you soon.");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
