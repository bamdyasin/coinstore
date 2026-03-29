<header class="admin-header">
    <div class="logo">
        <a href="index.php" style="text-decoration:none; color:inherit;">
            <span style="font-size: 1.5rem;">🪙 Admin Panel</span>
        </a>
    </div>

    <div class="menu-toggle" id="admin-mobile-menu" style="display: flex;">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <nav id="admin-nav-menu" class="admin-nav">
        <div class="nav-header">
            <span style="font-size: 1.2rem; font-weight: bold; color: var(--admin-accent);">Menu Options</span>
            <span id="close-menu" style="cursor: pointer; font-size: 1.5rem; color: #ff7675;">&times;</span>
        </div>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="promotions.php">Promotions</a></li>
            <li><a href="coin_requests.php">Coin Requests</a></li>
            <li><a href="business.php">Business Apps</a></li>
            <li><a href="trxids.php">TrxIDs</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php" class="logout-link">Logout</a></li>
        </ul>
    </nav>
</header>

<style>
    :root {
        --admin-bg: #2d3436;
        --admin-accent: #f1c40f;
    }

    .admin-header {
        background-color: var(--admin-bg);
        color: white;
        padding: 1rem 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        position: sticky;
        top: 0;
        z-index: 9999;
    }

    /* Standardized Toggle Menu for ALL Devices */
    .admin-nav {
        position: fixed !important;
        top: 0;
        right: -100% !important; /* Initially hidden on all devices */
        width: 300px !important;
        height: 100vh !important;
        background-color: var(--admin-bg) !important;
        box-shadow: -5px 0 15px rgba(0,0,0,0.3) !important;
        transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        z-index: 10000;
        display: flex !important;
        flex-direction: column;
        overflow-y: auto;
    }

    .admin-nav.active {
        right: 0 !important;
    }

    .nav-header {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .admin-nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        width: 100%;
    }

    .admin-nav ul li {
        width: 100%;
    }

    .admin-nav ul li a {
        display: block;
        padding: 1.2rem 2rem;
        color: #dfe6e9 !important;
        text-decoration: none;
        font-weight: 500;
        font-size: 1rem;
        transition: 0.3s;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .admin-nav ul li a:hover {
        background: rgba(255,255,255,0.1);
        color: var(--admin-accent) !important;
        padding-left: 2.5rem;
    }

    .logout-link {
        color: #ff7675 !important;
        font-weight: bold !important;
    }

    /* Menu Toggle Button Style */
    .menu-toggle {
        display: flex;
        flex-direction: column;
        cursor: pointer;
        gap: 5px;
    }

    .menu-toggle span {
        width: 25px;
        height: 3px;
        background-color: var(--admin-accent);
        border-radius: 2px;
        transition: 0.3s;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('admin-mobile-menu');
        const navMenu = document.getElementById('admin-nav-menu');
        const closeMenu = document.getElementById('close-menu');

        if (menuToggle && navMenu) {
            const toggleAction = function(e) {
                e.stopPropagation();
                navMenu.classList.toggle('active');
            };

            menuToggle.addEventListener('click', toggleAction);
            if(closeMenu) closeMenu.addEventListener('click', toggleAction);

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (navMenu.classList.contains('active') && !navMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                    navMenu.classList.remove('active');
                }
            });

            // Prevent closing when clicking inside the menu
            navMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
</script>
