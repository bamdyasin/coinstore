<?php
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $biz_name = $_POST['biz_name'];
    $contact_person = $_POST['contact_person'];
    $biz_type = $_POST['biz_type'];
    $experience = $_POST['experience'];
    $website = $_POST['website'];
    $message = $_POST['message'];

    try {
        $stmt = $pdo->prepare("INSERT INTO business_apps (biz_name, contact_person, biz_type, experience, website, message) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$biz_name, $contact_person, $biz_type, $experience, $website, $message]);
        
        header("Location: index.php?success=1&title=Application Received!&message=Thank you for your interest. Our team will review your business application and contact you soon.");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
