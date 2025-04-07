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

    <title>RecipeHub Wiki | Admin Guide</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>

<?php include_once('../../assets/includes/navbar.php'); ?>

<div class="hero-section less-hero">
        <h1>Admin Guide</h1>
        <p>This guide will walk you through all admin features on RecipeHub.</p>
    </div>

    <main class="wiki-guide">

    <nav class="wiki-nav">
        <h2>Contents</h2>
        <ul>
            <li><a href="#overview">1. Admin Overview</a></li>
            <li><a href="#login">2. Logging In as Admin</a></li>
            <li><a href="#manage-users">3. Managing Users</a></li>
            <li><a href="#manage-recipes">4. Managing Recipes</a></li>
            <li><a href="#delete-comments">5. Deleting Comments</a></li>
            <li><a href="#system-monitor">6. System Monitor</a></li>
            <li><a href="#demo-video">7. Demo Video</a></li>
        </ul>
    </nav>

    <section class="wiki-section" id="overview">
        <h2>1. Admin Overview</h2>
        <p>Admins have elevated privileges that allow them to view and manage users, edit or delete recipes, and monitor system activity. Admins cannot delete other admin accounts but can perform most other actions directly from the admin panel.</p>
    </section>

    <section class="wiki-section" id="login">
        <h2>2. Logging In as Admin</h2>
        <p>Admins log in just like regular users from the <strong>Login</strong> page. Once logged in, you'll be redirected to your custom admin dashboard if your account has <code>is_admin</code> set to <code>true</code>.</p>
        <img src="<?php echo IMG_URL; ?>wiki/login.png" alt="Admin Login Screenshot">
    </section>

    <section class="wiki-section" id="manage-users">
        <h2>3. Managing Users</h2>
        <p>From the <strong>Manage Users</strong> section of your admin dashboard, you can:</p>
        <ul>
            <li>Search users by name or email</li>
            <li>View user profiles</li>
            <li>Delete user accounts (non-admins only)</li>
        </ul>
        <img src="<?php echo IMG_URL; ?>wiki/manage-users.png" alt="Manage Users Screenshot">
    </section>

    <section class="wiki-section" id="manage-recipes">
        <h2>4. Moderating Recipes</h2>
        <p>The <strong>Manage Recipes</strong> section allows you to:</p>
        <ul>
            <li>View all user-created recipes and API recipes</li>
            <li>Edit or delete any recipe</li>
            <li>Sort recipes by title, time, or popularity</li>
        </ul>
        <img src="<?php echo IMG_URL; ?>wiki/manage-recipes.png" alt="Manage Recipes Screenshot">
    </section>

    <section class="wiki-section" id="delete-comments">
        <h2>5. Deleting Comments</h2>
        <p>
            When viewing a recipe and that recipe's comment section at the bottom, admin users will see a delete button. Regular users do not see this button. Pressing this button enables you to remove any innaproprate comments.
        </p>
        <img src="<?php echo IMG_URL; ?>wiki/delete-comment.png" alt="Delete comment Screenshot">
    </section>

    <section class="wiki-section" id="system-monitor">
        <h2>6. System Monitor</h2>
        <p>The <strong>System Monitor</strong> page reports on the health of core features, including:</p>
        <ul>
            <li>Database connection status</li>
            <li>Service status (login, recipe upload, API sync)</li>
            <li>Graph showing new user registrations and recipe activity</li>
        </ul>
        <img src="<?php echo IMG_URL; ?>wiki/monitor.png" alt="System Monitor Screenshot">
    </section>

    <section class="wiki-section" id="demo-video">
        <h2>7. Watch Admin Demo Video</h2>
        <p>Prefer to watch a walkthrough? This demo video covers everything from logging in to managing users and checking the system monitor.</p>

        <div class="video-wrapper">
            <video controls width="700">
                <source src="<?php echo IMG_URL; ?>admin-demo.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </section>

</main>

<?php include_once('../../assets/includes/footer.php'); ?>
</body>
</html>
