<?php
// Include the constants.php file
require_once('../config/constants.php');

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

    <title>RecipeHub | Home</title>

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

                <a href="index.php" class="logo">RecipeHub</a>
            </div>

            <ul class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="user/explore.php">Explore</a></li>
                    <li><a href="user/profile.php">Profile</a></li>
                    <li><a href="user/dashboard.php">Dashboard</a></li>
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
                        <li><a href="<?php echo PUBLIC_URL; ?>user/dashboard.php">Dashboard</a></li>
                        <li><a href="<?php echo PUBLIC_URL; ?>user/profile.php">Profile</a></li>
                        <li><a href="<?php echo PUBLIC_URL; ?>user/explore.php">Explore</a></li>
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
    <div class="hero-section">
        <h1>Welcome to RecipeHub!</h1>
        <p>Discover and share your favorite recipes from around the world.  
        Create your own digital recipe book, explore new cuisines, and connect with fellow cooking enthusiasts.</p>
                </br>
                </br>
                <?php if (isset($_SESSION['user_id'])): ?>
            <a href="user/dashboard.php" class="btn">My Dashboard</a>
        <?php else: ?>
            <a href="register.php" class="btn">Get Started</a>
        <?php endif; ?>
    </div>

    <section class="features">
        <div class="container">
            <div class="feature">
                <h2>Your Recipe Book</h2>
                <p>Save and organize your personal recipes, add images, and categorize them by cuisine.</p>
                </br>
                <img src="<?php echo IMG_URL; ?>recipe_graphic.png" alt="Girl with recipe book" width="200" height="200">
            </div>

            <div class="feature">
                <h2>Rate & Review</h2>
                <p>Rate and review recipes from other users. Explore different cuisines and discover hidden gems!</p>
                </br>
                <img src="<?php echo IMG_URL; ?>rate_graphic.png" alt="Hands with yes or no signs" width="200" height="200">
            </div>

            <div class="feature">
                <h2>Explore & Share</h2>
                <p>Browse recipes by category, region, or popularity. Share your creations with the community.</p>
                </br>
                <img src="<?php echo IMG_URL; ?>share_graphic.png" alt="2 girls cooking" width="250" height="200">
            </div>
        </div>
    </section>
</main>


<!-- Footer -->
<footer>
    <div class="container">
        <p>&copy; 2025 RecipeHub. All rights reserved.</p>

        <ul class="nav-links">
            <li><a href="about.php">About</a></li>
            <li><a href="<?php echo WIKI_URL; ?>wiki-home.php">Help</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</footer>

</body>
</html>
