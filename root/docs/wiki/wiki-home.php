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

    <title>RecipeHub Wiki | Home</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main>
    <div class="hero-section less-hero">
        <h1>RecipeHub Wiki</h1>
        <p>Need help using RecipeHub? Browse the articles below for a solution.</p>
    </div>

    <section class="articles">
            <div class="article">
                <h2>
                    <a href="<?php echo WIKI_URL; ?>wiki-faq.php">FAQ</a>
                </h2>
                <p>Find answers to the most frequently asked questions about RecipeHub features, accounts, and troubleshooting.</p>
                <br>
                <img src="<?php echo IMG_URL; ?>faq.png" alt="FAQ Icon" width="200" height="200">
            </div>

            <div class="article">
                <h2>
                    <a href="<?php echo WIKI_URL; ?>wiki-guide.php">User Guide</a>
                </h2>
                <p>A step-by-step guide for users: how to register, post recipes, comment, favorite, and customize your profile.</p>
                <br>
                <img src="<?php echo IMG_URL; ?>guide.png" alt="User Guide Icon" width="200" height="200">
            </div>

            <div class="article">
                <h2>
                    <a href="<?php echo WIKI_URL; ?>wiki-admin.php">Admin Guide</a>
                </h2>
                <p>Details on administrative tasks such as managing users, moderating content, and using the system monitor.</p>
                <br>
                <img src="<?php echo IMG_URL; ?>admin.png" alt="Admin Guide Icon" width="250" height="200">
            </div>

            <div class="article">
                <h2>
                    <a href="<?php echo WIKI_URL; ?>wiki-documentation.php">Docs & Installation</a>
                </h2>
                <p>Set up RecipeHub on a different server, explore the file structure, and learn about the database schema.</p>
                <br>
                <img src="<?php echo IMG_URL; ?>install.png" alt="Installation Guide Icon" width="250" height="200">
            </div>
    </section>
</main>

<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
