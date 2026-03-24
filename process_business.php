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
        
        echo "<script>alert('Business application submitted successfully!'); window.location.href='index.php';</script>";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
