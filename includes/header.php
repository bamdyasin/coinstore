<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoinStoreBD - Premium Rare Coins</title>
    <link rel="stylesheet" href="assets/css/style.css">
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
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="#">Categories</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="cart.php" class="btn">Cart (0)</a></li>
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
