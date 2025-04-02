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
    <title>RecipeHub | Home</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
</head>
<body>


<!-- Navigation Bar -->
<header>
    <nav class="navbar">
        <div class="container">

            <div class="logo-container">
                <img src="<?php echo IMG_URL; ?>logo.png" alt="RecipeHub Logo" width="65" height="65">
                <a href="index.php" class="logo">RecipeHub</a>
            </div>

            <ul class="nav-links">
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
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
    <div class="hero-section">
        <h1>Welcome to RecipeHub!</h1>
        <p>Discover and share your favorite recipes from around the world.  
        Create your own digital recipe book, explore new cuisines, and connect with fellow cooking enthusiasts.</p>
                </br>
                </br>
        <a href="register.php" class="btn">Get Started</a>
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
    </div>
</footer>

</body>
</html>
