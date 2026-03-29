<?php
require_once 'includes/config.php';
// Fetch Pixel IDs from database
$stmt = $pdo->prepare("SELECT setting_key, setting_value FROM site_settings WHERE setting_key IN ('tiktok_pixel_id', 'facebook_pixel_id')");
$stmt->execute();
$settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$tiktok_pixel_id = $settings['tiktok_pixel_id'] ?? "";
$facebook_pixel_id = $settings['facebook_pixel_id'] ?? "";
?>
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

    <?php if ($tiktok_pixel_id): ?>
    <!-- TikTok Pixel Code Start -->
    <script>
    !function (w, d, t) {
      w.Tawk_Emoji = w.Tawk_Emoji || [];
      var n = function () {
        var t = d.createElement("script");
        t.type = "text/javascript", t.async = !0, t.src = "https://analytics.tiktok.com/i18n/pixel/sdk.js?sdkid=<?php echo $tiktok_pixel_id; ?>";
        var a = d.getElementsByTagName("script")[0];
        a.parentNode.insertBefore(t, a)
      };
      "complete" === d.readyState ? n() : w.addEventListener("load", n)
    }(window, document, "script");
    </script>
    <script>
    ttq.load('<?php echo $tiktok_pixel_id; ?>');
    ttq.page();
    </script>
    <!-- TikTok Pixel Code End -->
    <?php endif; ?>

    <?php if ($facebook_pixel_id): ?>
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?php echo $facebook_pixel_id; ?>');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" border="0" style="display:none"
    src="https://www.facebook.com/tr?id=<?php echo $facebook_pixel_id; ?>&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
    <?php endif; ?>
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
