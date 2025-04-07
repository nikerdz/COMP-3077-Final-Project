<?php
// Include the constants.php file
require_once('../../config/constants.php');

// Start the session to check if the user is logged in
session_start();

$theme = $_SESSION['theme'] ?? 'theme1';
$themeSuffix = $theme === 'theme2' ? '2' : ($theme === 'theme3' ? '3' : '');

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

// Extract data from session
$firstName = htmlspecialchars($_SESSION['first_name']);
$lastName = htmlspecialchars($_SESSION['last_name']);
$username = htmlspecialchars($_SESSION['username']);
$email = htmlspecialchars($_SESSION['email']);
$profilePic = !empty($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png';
$aboutMe = htmlspecialchars($_SESSION['about_me'] ?? '');
$isAdmin = $_SESSION['is_admin'] ?? false;
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

    <title>RecipeHub | User Settings</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <link rel="stylesheet" href="<?php echo THEME_URL . $theme . '.css'; ?>?v=<?php echo time(); ?>">
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main>
    <?php if (isset($_GET['password'])): ?>
        <?php if ($_GET['password'] === 'success'): ?>
            <script>alert("Password updated successfully!");</script>
        <?php elseif ($_GET['password'] === 'wrong'): ?>
            <script>alert("Incorrect current password. Please try again.");</script>
        <?php endif; ?>
    <?php endif; ?>

    <div class="settings-section">

        <!-- Change Theme -->
        <section class="settings-card">
            <h2 style="text-align: center;">Change Site Theme</h2>
            <div class="theme-options">

                <div class="theme-choice">
                    <img src="<?php echo IMG_URL; ?>logo.png" alt="Pink Theme" />
                    <form method="POST" action="<?php echo PHP_URL; ?>theme_change_submit.php">
                        <input type="hidden" name="theme" value="theme1">
                        <button type="submit" class="btn">Pink Theme</button>
                    </form>
                </div>

                <div class="theme-choice">
                    <img src="<?php echo IMG_URL; ?>logo2.png" alt="Blue Theme" />
                    <form method="POST" action="<?php echo PHP_URL; ?>theme_change_submit.php">
                        <input type="hidden" name="theme" value="theme2">
                        <button type="submit" class="btn">Blue Theme</button>
                    </form>
                </div>

                <div class="theme-choice">
                    <img src="<?php echo IMG_URL; ?>logo3.png" alt="Green Theme" />
                    <form method="POST" action="<?php echo PHP_URL; ?>theme_change_submit.php">
                        <input type="hidden" name="theme" value="theme3">
                        <button type="submit" class="btn">Green Theme</button>
                    </form>
                </div>

            </div>
        </section>

        <!-- Change Password -->
        <section class="settings-card">
            <h2 style="text-align: center;">Change Password</h2>
            <form action="<?php echo PHP_URL; ?>change_pass_submit.php" method="POST" class="contact-form">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>

                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>

                <button type="submit" class="btn">Update Password</button>
            </form>
        </section>

        <?php if (!$isAdmin): ?>
        <!-- Delete Account -->
        <section class="settings-card">
            <h2 style="text-align: center; color: #e63946;">Delete Account</h2>
            <p style="text-align: center;">This action is irreversible. Your recipes, comments, and favorites will be permanently deleted.</p>

            <form action="<?php echo PHP_URL; ?>delete_user_submit.php" method="POST" class="contact-form" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
                <label for="confirm_password">Confirm Your Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <button type="submit" class="btn" style="background-color: #e63946;">Delete My Account</button>
            </form>
        </section>
        <?php endif; ?>

    </div>
</main>


<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
