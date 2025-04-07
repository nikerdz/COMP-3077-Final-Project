<?php
require_once('../../config/constants.php');
session_start();
?>

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
    <meta property="og:description" content="Join RecipeHub and explore a world of delicious recipes. Share your favourites and organize your own recipe collection!">
    <meta property="og:image" content="<?php echo IMG_URL; ?>logo.png">
    <meta property="og:url" content="https://khan661.myweb.cs.uwindsor.ca/COMP-3077-Final-Project/root/public/index.php">
    <meta property="og:type" content="website"> <!-- Enhance link previews when shared on Facebook, LinkedIn, and other platforms -->

    <link rel="canonical" href="https://khan661.myweb.cs.uwindsor.ca/COMP-3077-Final-Project/root/public/index.php"> <!-- Prevent duplicate content issues in search rankings -->

    <link rel="icon" type="image/x-icon" href="<?php echo IMG_URL; ?>favicon.ico"> <!-- Favicon of different sizes for better browser support -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo IMG_URL; ?>favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo IMG_URL; ?>favicon-16x16.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Just+Another+Hand&display=swap" rel="stylesheet">

    <title>RecipeHub Wiki | User Guide</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>

<?php include_once('../../assets/includes/navbar.php'); ?>

<div class="hero-section less-hero">
        <h1>User Guide</h1>
        <p>Welcome to RecipeHub! This guide will walk you through all site features to get you started.</p>
    </div>

<main class="wiki-guide">

    <nav class="wiki-nav">
        <h2>Contents</h2>
        <ul>
            <li><a href="#register">1. Registering an Account</a></li>
            <li><a href="#login">2. Logging In</a></li>
            <li><a href="#post">3. Posting a Recipe</a></li>
            <li><a href="#explore">4. Browsing Recipes</a></li>
            <li><a href="#favorite">5. Favoriting Recipes</a></li>
            <li><a href="#profile">6. Editing Your Profile</a></li>
            <li><a href="#delete">7. Deleting Your Account</a></li>
            <li><a href="#demo-video">8. Demo Video</a></li>
        </ul>
    </nav>

    <section class="wiki-section" id="register">
        <h2>1. Registering an Account</h2>
        <p>Click the <strong>Register</strong> button on the homepage or in the navigation bar. Fill out your first name, last name, email, and choose a unique username and password.</p>
        <img src="<?php echo IMG_URL; ?>wiki/register.png" alt="Register form">
    </section>

    <section class="wiki-section" id="login">
        <h2>2. Logging In</h2>
        <p>Already have an account? Click <strong>Login</strong> and enter your credentials. Once logged in, you'll be redirected to your dashboard.</p>
        <img src="<?php echo IMG_URL; ?>wiki/login.png" alt="Login form">
    </section>

    <section class="wiki-section" id="post">
        <h2>3. Posting a Recipe</h2>
        <p>Go to <strong>Add Recipe</strong> from your dashboard. Add a title, thumbnail, ingredients, steps, cooking/prep times, and dietary tags. When done, click <em>Submit</em>!</p>
        <img src="<?php echo IMG_URL; ?>wiki/add-recipe.png" alt="Add Recipe">
    </section>

    <section class="wiki-section" id="explore">
        <h2>4. Browsing Recipes</h2>
        <p>The <strong>Explore</strong> page lets you browse recipes by category, meal type, or search term. You’ll see user-submitted and Spoonacular recipes mixed together.</p>
        <img src="<?php echo IMG_URL; ?>wiki/explore.png" alt="Explore Recipes">
    </section>

    <section class="wiki-section" id="favorite">
        <h2>5. Favoriting Recipes</h2>
        <p>Click the ❤️ icon on any recipe to add it to your favorites. View your favorited recipes in your profile.</p>
        <img src="<?php echo IMG_URL; ?>wiki/fave.png" alt="Explore Recipes">
    </section>

    <section class="wiki-section" id="profile">
        <h2>6. Editing Your Profile</h2>
        <p>Click <strong>Profile</strong> to view your public page. On the top-right, click <em>Edit Profile</em> to change your “About Me” text and profile picture.</p>
        <img src="<?php echo IMG_URL; ?>wiki/profile.png" alt="Explore Recipes">
    </section>

    <section class="wiki-section" id="delete">
        <h2>7. Deleting Your Account</h2>
        <p>From your <strong>Settings</strong> page, scroll to the <em>Delete Account</em> section. Enter your password to confirm deletion. This action is permanent.</p>
        <img src="<?php echo IMG_URL; ?>wiki/delete.png" alt="Explore Recipes">
    </section>

    <section class="wiki-section" id="demo-video">
        <h2>8. Watch a Demo Video</h2>
        <p>If you'd rather watch a walkthrough, this short demo covers the basics of using RecipeHub from start to finish.</p>
        
        <div class="video-wrapper">
            <!-- Replace the video link below with your own hosted demo.mp4 or a YouTube embed -->
            <video controls width="700">
                <source src="<?php echo IMG_URL; ?>demo.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </section>
</main>

<?php include_once('../../assets/includes/footer.php'); ?>
</body>
</html>
