<?php
// Include the constants.php file
require_once('../../config/constants.php');
require_once('../../config/db_config.php');

// Start the session to check if the user is logged in
session_start();
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

    <title>RecipeHub | Edit Profile</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main>
    <?php if (isset($_GET['update']) && $_GET['update'] === 'success'): ?>
        <script>alert("Your profile has been updated successfully!");</script>
    <?php endif; ?>

    <div class="profile-section">
        <form action="<?php echo PHP_URL; ?>edit_profile_submit.php" method="POST" enctype="multipart/form-data" class="contact-form">
            <p>Edit Your Profile</p>
            </br>

            <!-- Profile Picture Upload Preview + Trigger -->
            <div style="text-align: center; margin-bottom: 20px;">
                <div class="profile-image">
                    <img src="<?php echo $profilePic; ?>" alt="Profile Picture" id="previewImage">
                </div>

                <input type="file" id="pfpInput" name="profile_pic" accept="image/*" style="display: none;">
                <button type="button" class="btn" style="background: #6c5b7b;" onclick="document.getElementById('pfpInput').click();">Upload New Profile Picture</button>
                <?php if (isset($_GET['pfp']) && $_GET['pfp'] === 'success'): ?>
                    <script>alert("Profile picture uploaded successfully!");</script>
                <?php endif; ?>

            </div>

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $firstName; ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $lastName; ?>" required>

            <label for="about_me">About Me:</label>
            <textarea id="about_me" name="about_me" rows="5"><?php echo $aboutMe; ?></textarea>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</main>


<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
