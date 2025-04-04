<?php
// Include the constants.php file
require_once('../../config/constants.php');

// Start the session to check if the user is logged in
session_start();
?>

<!-- HTML Structure -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <meta name="description" content="RecipeHub is your go-to platform for discovering, sharing, and organizing delicious recipes from around the world. Create your own digital recipe book and connect with fellow food lovers!">
    <meta name="keywords" content="recipes, cooking, food, meal planning, digital cookbook, share recipes, best recipes, easy cooking">
    <meta name="author" content="RecipeHub">
    <meta name="robots" content="index, follow"> <!-- Allows search engines to index and follow links -->

    <meta property="og:title" content="RecipeHub - Discover & Share Recipes">
    <meta property="og:description" content="Join RecipeHub and explore a world of delicious recipes. Share your favorites and organize your own recipe collection!">
    <meta property="og:image" content="<?php echo IMG_URL; ?>logo.png">
    <meta property="og:url" content="https://yourwebsite.com/index.php">
    <meta property="og:type" content="website"> <!-- Enhance link previews when shared on Facebook, LinkedIn, and other platforms -->

    <link rel="canonical" href="https://yourwebsite.com/index.php"> <!-- Prevent duplicate content issues in search rankings -->

    <link rel="icon" type="image/x-icon" href="<?php echo IMG_URL; ?>favicon.ico"> <!-- Favicon of different sizes for better browser support -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo IMG_URL; ?>favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo IMG_URL; ?>favicon-16x16.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Just+Another+Hand&display=swap" rel="stylesheet">

    <title>RecipeHub | My Dashboard</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar -->
<header>
    <nav class="navbar">
        <div class="container">

            <div class="logo-container">
            <img 
                src="<?php echo IMG_URL; ?>logo.png" 
                alt="RecipeHub Logo"
                id="logo-img"
                data-menu-icon="<?php echo IMG_URL; ?>menu.png"
                data-logo="<?php echo IMG_URL; ?>logo.png">

                <a href="<?php echo PUBLIC_URL; ?>index.php" class="logo">RecipeHub</a>
            </div>

            <ul class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="<?php echo USER_URL; ?>explore.php">Explore</a></li>
                    <li><a href="<?php echo USER_URL; ?>profile.php">Profile</a></li>
                    <li><a href="<?php echo USER_URL; ?>dashboard.php">Dashboard</a></li>
                    <li><a href="<?php echo PHP_URL; ?>logout_submit.php">Log Out</a></li>
                <?php else: ?>
                    <li><a href="login.php">Log In</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>

            <!-- Sidebar -->
            <div id="sidebar" class="sidebar">
                <ul class="sidebar-links">
                    <li><a href="<?php echo PUBLIC_URL; ?>index.php">Home</a></li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="<?php echo USER_URL; ?>dashboard.php">Dashboard</a></li>
                        <li><a href="<?php echo USER_URL; ?>profile.php">Profile</a></li>
                        <li><a href="<?php echo USER_URL; ?>explore.php">Explore</a></li>
                    <?php endif; ?>

                    <li><a href="<?php echo PUBLIC_URL; ?>about.php">About</a></li>
                    <li><a href="<?php echo WIKI_URL; ?>wiki-home.php">Help</a></li>
                    <li><a href="<?php echo PUBLIC_URL; ?>contact.php">Contact</a></li>
                </ul>

            <!-- Profile Section at Bottom -->
            <div class="sidebar-profile">
                <img src="<?php echo IMG_URL; ?>profile.png" alt="Profile Picture">
                <div class="profile-info">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <p>Welcome, <?php echo $_SESSION['username']; ?></p>
                        <a href="<?php echo PHP_URL; ?>logout_submit.php" class="logout-btn">Log Out</a>
                    <?php else: ?>
                        <a href="<?php echo PUBLIC_URL; ?>login.php" class="auth-link">Log In</a>
                        <a href="<?php echo PUBLIC_URL; ?>register.php" class="auth-link">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>


<!-- Main Content Section -->
<main>
    <div>
        <h1>Name's Dashboard</h1>
    </div>
</main>


<!-- Footer -->
<footer>
    <div class="container">
        <p>&copy; 2025 RecipeHub. All rights reserved.</p>

        <ul class="nav-links">
            <li><a href="<?php echo PUBLIC_URL; ?>about.php">About</a></li>
            <li><a href="<?php echo WIKI_URL; ?>wiki-home.php">Help</a></li>
            <li><a href="<?php echo PUBLIC_URL; ?>contact.php">Contact</a></li>
        </ul>
    </div>
</footer>

</body>
</html>
