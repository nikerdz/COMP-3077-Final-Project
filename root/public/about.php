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

    <title>RecipeHub | About</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
</head>
<body>


<!-- Navigation Bar -->
<header>
    <nav class="navbar">
        <div class="container">

            <div class="logo-container">
                <img src="<?php echo IMG_URL; ?>logo.png" alt="RecipeHub Logo">
                <a href="index.php" class="logo">RecipeHub</a>
            </div>

            <ul class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>


<!-- Main Content Section -->
<main>
    <div class="hero-section less-hero">
        <h1>About RecipeHub</h1>
    </div>
    <section class="features">
        <div class="container">
            <div class="feature">
                <h2>Why I Created RecipeHub</h2>
                <p>
                    RecipeHub was born out of my passion for cooking and the need for a convenient way to store and share recipes. 
                    I found myself constantly bookmarking recipes, writing them down on sticky notes, or losing them in endless folders. 
                    I wanted a simple, organized way to save my family’s traditional recipes, explore new dishes, and connect with others who love cooking. 
                    RecipeHub allows users to build their own digital recipe book, rate and review dishes, and discover hidden culinary gems from around the world. 
                    Whether you're a beginner or an experienced cook, this platform is designed to make cooking and recipe management easier and more enjoyable.
                </br></br>- Anika, Founder of RecipeHub
                </p>
                </br> </br>
                <img src="<?php echo IMG_URL; ?>book.png" alt="Girl with recipe book" width="400" height="350">
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
            <li><a href="contact.php">Contact</a></li>
            <li><a href="<?php echo WIKI_URL; ?>wiki-home.html">Help</a></li>
        </ul>
    </div>
</footer>

</body>
</html>
