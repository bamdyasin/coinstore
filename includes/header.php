<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoinStoreBD - Premium Rare Coins</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php" title="CoinStoreBD">
                <span class="logo-icon">🪙</span>
            </a>
        </div>

        <div class="search-container">
            <form id="searchStatusForm">
                <input type="text" id="searchTrxID" name="search" placeholder="Enter TrxID for Order Status" aria-label="Search">
                <button type="submit">🔍</button>
            </form>
        </div>

        <div class="menu-toggle" id="mobile-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav id="nav-menu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?tab=promote">Promote</a></li>
                <li><a href="index.php?tab=getcoin">GetCoin</a></li>
                <li><a href="index.php?tab=business">Business</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="privacy.php">Privacy</a></li>
                <li><a href="https://wa.me/8801845464034" target="_blank" class="btn" style="background: #25D366; color: white !important; border: none;"><i class="fab fa-whatsapp"></i> Support</a></li>
            </ul>
        </nav>
    </header>

    <div class="tabs-bar">
        <div class="tabs-container">
            <div class="tabs-group">
                <a href="javascript:void(0)" class="tab-item active" data-tab="promote">Promote</a>
                <a href="javascript:void(0)" class="tab-item" data-tab="getcoin">GetCoin</a>
                <a href="javascript:void(0)" class="tab-item" data-tab="business">Business</a>
            </div>
        </div>
    </div>
