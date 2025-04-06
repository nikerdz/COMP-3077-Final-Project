<?php
// Include the constants.php file
require_once('../config/constants.php');

// Start the session to check if the user is logged in
session_start();

if (isset($_GET['success'])) {
    if ($_GET['success'] == '1') {
        echo "<script>alert('Registration successful! You can now log in.');</script>";
    } elseif ($_GET['success'] == 'logout') {
        echo "<script>alert('You have been successfully logged out.');</script>";
    }
}

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
    <meta property="og:url" content="https://yourwebsite.com/index.php">
    <meta property="og:type" content="website"> <!-- Enhance link previews when shared on Facebook, LinkedIn, and other platforms -->

    <link rel="canonical" href="https://yourwebsite.com/index.php"> <!-- Prevent duplicate content issues in search rankings -->

    <link rel="icon" type="image/x-icon" href="<?php echo IMG_URL; ?>favicon.ico"> <!-- Favicon of different sizes for better browser support -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo IMG_URL; ?>favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo IMG_URL; ?>favicon-16x16.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Just+Another+Hand&display=swap" rel="stylesheet">

    <title>RecipeHub | Log In</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main>
    <div class="hero-section less-hero">
        <h1>Log In to RecipeHub</h1>
    </div>
    </br></br></br>
    
        <!-- Form that sends POST request to login_submit.php -->
        <form action="<?php echo PHP_URL; ?>login_submit.php" method="POST" class="contact-form">
            <p>Sign In to your RecipeHub Account</p>
            <!-- Username -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <!-- Password -->
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <!-- Submit Button -->
            <button type="submit">Log In</button>

            <!-- Display error message if there's a login error -->
        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="error-messages">
                <p class="error">Error! <?php echo $_SESSION['login_error']; ?></p>
            </div>
            <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>
        </form>
        </br></br>/<br>
</main>


<!-- Footer -->
<?php include_once('../assets/includes/footer.php'); ?>

</body>
</html>
