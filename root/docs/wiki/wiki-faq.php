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

    <title>RecipeHub Wiki | FAQ</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main>
    <div class="faq-container">
        <h1>Frequently Asked Questions</h1>

        <div class="faq-item">
            <h3>How do I create an account? <span class="toggle-icon">+</span></h3>
            <p>Click on the “Register” button on the homepage, fill out the form with your details, and you’re in! Make sure to use a valid email address.</p>
        </div>

        <div class="faq-item">
            <h3>How do I post a recipe? <span class="toggle-icon">+</span></h3>
            <p>Once logged in, click the "Post Recipe" button under your dashboard. Fill in the title, ingredients, instructions, and upload a thumbnail image. You can also tag it as vegetarian, gluten-free, or dairy-free.</p>
        </div>

        <div class="faq-item">
            <h3>Can I edit or delete a recipe after posting? <span class="toggle-icon">+</span></h3>
            <p>Yes! Go to your profile or dashboard, click on the recipe you posted, and you'll find options to edit it at the bottom of the page. An option to delete is available while editing your recipe.</p>
        </div>

        <div class="faq-item">
            <h3>How do favorites work? <span class="toggle-icon">+</span></h3>
            <p>When viewing a recipe, you can click the heart icon on any recipe to add it to your favorites. View all your favorites from your profile page.</p>
        </div>

        <div class="faq-item">
            <h3>Is my profile public? <span class="toggle-icon">+</span></h3>
            <p>Yes, other users can view your public profile, including your posted recipes and bio. You can customize your "About Me" section anytime.</p>
        </div>

        <div class="faq-item">
            <h3>I forgot my password. What should I do? <span class="toggle-icon">+</span></h3>
            <p>Currently, password resets are not automated. Please contact the site administrator to help you reset your password.</p>
        </div>

        <div class="faq-item">
            <h3>How do I change my password? <span class="toggle-icon">+</span></h3>
            <p>There is a section in the settings page to change your password,  you must first enter your current password accurately, and then your new password.</p>
        </div>

        <div class="faq-item">
            <h3>How do I delete my account? <span class="toggle-icon">+</span></h3>
            <p>Head to the Settings page while logged in and scroll to the “Delete Account” section. You’ll need to confirm your password to permanently remove your account and all associated data.</p>
        </div>
    </div>>
</main>

<script>
//Toggle FAQ items
document.querySelectorAll(".faq-item h3").forEach(header => {
    header.addEventListener("click", () => {
        const item = header.parentElement;
        item.classList.toggle("active");

        // Change icon
        const icon = header.querySelector(".toggle-icon");
        icon.textContent = item.classList.contains("active") ? "−" : "+";
    });
});
</script>

<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
