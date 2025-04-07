<?php
// Include the constants.php file
require_once('../config/constants.php');

// Start the session to check if the user is logged in
session_start();

$theme = $_SESSION['theme'] ?? 'theme1';
$themeSuffix = $theme === 'theme2' ? '2' : ($theme === 'theme3' ? '3' : '');
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

    <title>RecipeHub | Contact Us</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <link rel="stylesheet" href="<?php echo THEME_URL . $theme . '.css'; ?>?v=<?php echo time(); ?>">
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main>
    <div class="hero-section less-hero">
        <h1>Contact RecipeHub Support</h1>
    </div>
    <div class="container">

        <form action="<?php echo PHP_URL; ?>contact_submit.php" method="POST" class="contact-form">
            <p>Have a question or suggestion? Send me a message!</p>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" 
                   value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>" 
                   required <?php echo isset($_SESSION['user_email']) ? 'readonly' : ''; ?>>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>

    <div class="map-section">
        <section class="settings-card">
            <h2 style="text-align: center;">Contact Information</h2>
            <p><strong>Phone:</strong> (123) 456-789</p>
            <p><strong>Email:</strong> <a href="mailto:help@recipehub.ca">help@recipehub.ca</a></p>
            <p><strong>Address:</strong> 401 Sunset Ave, Windsor, ON N9B 3P4</p>
            <br>
        <iframe 
            src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=401%20Sunset%20Ave,%20Windsor,%20ON%20N9B%203P4+(University%20of%20Windsor)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" 
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
        </section>
    </div>
</main>


<!-- Footer -->
<?php include_once('../assets/includes/footer.php'); ?>

</body>
</html>
