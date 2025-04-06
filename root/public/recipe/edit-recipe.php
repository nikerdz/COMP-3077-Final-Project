<?php
require_once('../../config/constants.php');
require_once('../../config/db_config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid recipe ID.";
    exit();
}

$recipeId = $_GET['id'];
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = :id AND created_by = :user");
$stmt->execute([':id' => $recipeId, ':user' => $userId]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    echo "Recipe not found or you don't have permission to edit it.";
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

    <title>RecipeHub | Edit Recipe</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main>
<div class="add-recipe-section">
    <form class="recipe-form" action="<?php echo PHP_URL; ?>edit_recipe_submit.php" method="POST" enctype="multipart/form-data">
        <h2>Edit Recipe</h2>

        <input type="hidden" name="recipe_id" value="<?php echo $recipeId; ?>">

        <label for="title">Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>

        <label for="cuisine_type">Cuisine Type</label>
        <input type="text" name="cuisine_type" value="<?php echo htmlspecialchars($recipe['cuisine_type']); ?>">

        <label for="difficulty">Difficulty</label>
        <select name="difficulty" required>
            <option value="Easy" <?php if ($recipe['difficulty'] === 'Easy') echo 'selected'; ?>>Easy</option>
            <option value="Medium" <?php if ($recipe['difficulty'] === 'Medium') echo 'selected'; ?>>Medium</option>
            <option value="Hard" <?php if ($recipe['difficulty'] === 'Hard') echo 'selected'; ?>>Hard</option>
        </select>

        <label for="image">Change Image (optional)</label>
        <input type="file" name="image">

        <label for="servings">Servings</label>
        <input type="number" name="servings" value="<?php echo $recipe['servings']; ?>">

        <label for="ready_in_minutes">Ready In (minutes)</label>
        <input type="number" name="ready_in_minutes" value="<?php echo $recipe['ready_in_minutes']; ?>">

        <label for="preparation_time">Preparation Time</label>
        <input type="number" name="preparation_time" value="<?php echo $recipe['preparation_time']; ?>">

        <label for="cooking_time">Cooking Time</label>
        <input type="number" name="cooking_time" value="<?php echo $recipe['cooking_time']; ?>">

        <div class="checkbox-group">
            <label class="checkbox-item">
                <input type="checkbox" name="vegetarian" <?php if ($recipe['vegetarian']) echo 'checked'; ?>>
                <span>Vegetarian</span>
            </label>

            <label class="checkbox-item">
                <input type="checkbox" name="gluten_free" <?php if ($recipe['gluten_free']) echo 'checked'; ?>>
                <span>Gluten Free</span>
            </label>

            <label class="checkbox-item">
                <input type="checkbox" name="dairy_free" <?php if ($recipe['dairy_free']) echo 'checked'; ?>>
                <span>Dairy Free</span>
            </label>
        </div>

        <label for="meal_type">Meal Type</label>
        <select name="meal_type">
            <?php
            $types = ['Breakfast', 'Lunch', 'Dinner', 'Dessert', 'Snack'];
            foreach ($types as $type) {
                $selected = ($recipe['meal_type'] === $type) ? 'selected' : '';
                echo "<option value=\"$type\" $selected>$type</option>";
            }
            ?>
        </select>

        <label for="ingredients">Ingredients</label>
        <textarea name="ingredients" rows="5"><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>

        <label for="instructions">Instructions</label>
        <textarea name="instructions" rows="7"><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>

        <button type="submit" class="btn">Update Recipe</button>

        <!-- Delete button -->
        <div style="margin-top: 20px; text-align: center;">
            <a href="<?php echo PHP_URL . 'delete_recipe_submit.php?id=' . $recipeId; ?>" class="btn" style="background-color: #e76f51;" onclick="return confirm('Are you sure you want to delete this recipe?');">Delete Recipe</a>
        </div>
    </form>
</div>

</main>


<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
