<?php
// Include the constants.php file
require_once('../../config/constants.php');

// Start the session to check if the user is logged in
session_start();
// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
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

    <title>RecipeHub | Post a Recipe</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main>
    <div class="add-recipe-section">
        <form action="<?php echo PHP_URL; ?>add_recipe_submit.php" method="POST" enctype="multipart/form-data" class="recipe-form">
            <h2>Post a Recipe</h2>

            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>

            <label for="image">Image</label>
            <input type="file" name="image" id="image" accept="image/*">

            <label for="cuisine_type">Cuisine Type</label>
            <input type="text" name="cuisine_type" id="cuisine_type">

            <label for="servings">Servings</label>
            <input type="number" name="servings" id="servings" min="1" required>

            <label for="ready_in_minutes">Ready In (minutes)</label>
            <input type="number" name="ready_in_minutes" id="ready_in_minutes" min="1" required>

            <label for="preparation_time">Preparation Time (minutes)</label>
            <input type="number" name="preparation_time" id="preparation_time" min="0">

            <label for="cooking_time">Cooking Time (minutes)</label>
            <input type="number" name="cooking_time" id="cooking_time" required>

            <label for="vegetarian">Vegetarian</label>
            <input type="checkbox" name="vegetarian" id="vegetarian" value="1">

            <label for="gluten_free">Gluten Free</label>
            <input type="checkbox" name="gluten_free" id="gluten_free" value="1">

            <label for="dairy_free">Dairy Free</label>
            <input type="checkbox" name="dairy_free" id="dairy_free" value="1">

            <label for="meal_type">Meal Type</label>
            <select name="meal_type" id="meal_type">
                <option value="Breakfast">Breakfast</option>
                <option value="Lunch">Lunch</option>
                <option value="Dinner" selected>Dinner</option>
                <option value="Dessert">Dessert</option>
                <option value="Snack">Snack</option>
            </select>

            <label for="ingredients">Ingredients (one per line)</label>
            <textarea name="ingredients" id="ingredients" rows="5" required></textarea>

            <label for="instructions">Instructions</label>
            <textarea name="instructions" id="instructions" rows="6" required></textarea>

            <label for="difficulty">Difficulty</label>
            <select name="difficulty" id="difficulty">
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
            </select>

            <button type="submit">Post Recipe</button>
        </form>
    </div>
</main>


<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
