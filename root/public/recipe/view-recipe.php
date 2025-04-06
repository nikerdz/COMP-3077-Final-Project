<?php
require_once('../../config/constants.php');
require_once('../../config/db_config.php');
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

// Check for recipe ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid recipe ID.";
    exit();
}

$recipeId = $_GET['id'];

// Fetch recipe
$stmt = $pdo->prepare("
    SELECT recipes.*, users.username 
    FROM recipes 
    JOIN users ON recipes.created_by = users.id 
    WHERE recipes.id = :id
");
$stmt->execute([':id' => $recipeId]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    echo "Recipe not found.";
    exit();
}

$isOwner = $recipe['created_by'] == $_SESSION['user_id'];

$favCountStmt = $pdo->prepare("SELECT COUNT(*) FROM favourites WHERE recipe_id = :id");
$favCountStmt->execute([':id' => $recipeId]);
$favCount = $favCountStmt->fetchColumn();

$isFavourited = false;
if (isset($_SESSION['user_id'])) {
    $favCheck = $pdo->prepare("SELECT * FROM favourites WHERE user_id = :uid AND recipe_id = :rid");
    $favCheck->execute([
        ':uid' => $_SESSION['user_id'],
        ':rid' => $recipeId
    ]);
    $isFavourited = $favCheck->fetch() ? true : false;
}

if (isset($_GET['comment']) && $_GET['comment'] === 'success') {
    echo "<script>alert('Your comment was posted successfully!'); </script>";
}

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
    <meta property="og:url" content="https://yourwebsite.com/index.php">
    <meta property="og:type" content="website"> <!-- Enhance link previews when shared on Facebook, LinkedIn, and other platforms -->

    <link rel="canonical" href="https://yourwebsite.com/index.php"> <!-- Prevent duplicate content issues in search rankings -->

    <link rel="icon" type="image/x-icon" href="<?php echo IMG_URL; ?>favicon.ico"> <!-- Favicon of different sizes for better browser support -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo IMG_URL; ?>favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo IMG_URL; ?>favicon-16x16.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Just+Another+Hand&display=swap" rel="stylesheet">

    <title>RecipeHub | <?php echo htmlspecialchars($recipe['title']); ?></title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>

<?php include_once('../../assets/includes/navbar.php'); ?>

<main>
    <div class="recipe-view-container">
        <div class="recipe-header">
            <img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" alt="Recipe Image">
            <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
            <p style="text-align:center;">By 
            <a href="<?php echo USER_URL . 'view-user.php?username=' . urlencode($recipe['username']); ?>" class="author-link">
                    <?php echo htmlspecialchars($recipe['username']); ?>
                </a>
            </p>
        </div>
         <!-- Favourite count -->
         <div class="favourite-section">
                <button id="fav-btn" class="favourite-btn <?php echo $isFavourited ? 'active' : ''; ?>">
                    ❤️ <span id="fav-count"><?php echo $favCount; ?></span>
                </button>
            </div>

        <div class="recipe-meta">
            <p><strong>Meal Type:</strong> <?php echo ucfirst($recipe['meal_type']); ?></p>
            <p><strong>Servings:</strong> <?php echo $recipe['servings']; ?></p>
            <p><strong>Prep Time:</strong> <?php echo $recipe['preparation_time']; ?> mins</p>
            <p><strong>Cook Time:</strong> <?php echo $recipe['cooking_time']; ?> mins</p>
            <p><strong>Total Time:</strong> <?php echo $recipe['ready_in_minutes']; ?> mins</p>
        </div>

        <div class="recipe-diet">
            <?php if ($recipe['vegetarian']) echo '<span class="badge green">Vegetarian</span>'; ?>
            <?php if ($recipe['gluten_free']) echo '<span class="badge orange">Gluten Free</span>'; ?>
            <?php if ($recipe['dairy_free']) echo '<span class="badge blue">Dairy Free</span>'; ?>
        </div>

        <div class="recipe-section">
            <h2>Ingredients</h2>
            <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
        </div>

        <div class="recipe-section">
            <h2>Instructions</h2>
            <p><?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></p>
        </div>

        <?php if ($isOwner): ?>
            <div style="text-align: right;">
                <a href="<?php echo RECIPE_URL . 'edit-recipe.php?id=' . $recipe['id']; ?>" class="btn">Edit Recipe</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Comments Section -->
    <div class="recipe-comments">
        <h2>Comments</h2><br>

        <?php
        // Fetch existing comments
        $commentStmt = $pdo->prepare("
            SELECT comments.*, users.username 
            FROM comments 
            JOIN users ON comments.user_id = users.id 
            WHERE recipe_id = :recipe_id 
            ORDER BY created_at DESC
        ");
        $commentStmt->execute([':recipe_id' => $recipeId]);
        $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <!-- Show comments -->
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-card">
                    <a href="<?php echo USER_URL . 'view-user.php?username=' . urlencode($recipe['username']); ?>" class="author-link">
                        <p><?php echo htmlspecialchars($comment['username']); ?></a> says:</p>
                    
                    <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                    <small><?php echo date('F j, Y g:i A', strtotime($comment['created_at'])); ?></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No comments yet. Be the first!</p>
        <?php endif; ?>

        <!-- Comment form -->
        <form action="<?php echo PHP_URL; ?>comment_submit.php" method="POST" class="comment-form">
            <textarea name="comment" rows="3" placeholder="Write a comment..." required></textarea>
            <input type="hidden" name="recipe_id" value="<?php echo $recipeId; ?>">
            <button type="submit">Post Comment</button>
        </form>
    </div>

</main>

<?php include_once('../../assets/includes/footer.php'); ?>
<script>
document.getElementById('fav-btn')?.addEventListener('click', () => {
    fetch('<?php echo PHP_URL; ?>favourite_submit.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'recipe_id=' + <?php echo $recipeId; ?>
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const btn = document.getElementById('fav-btn');
            const count = document.getElementById('fav-count');
            btn.classList.toggle('active', data.favourited);
            count.textContent = data.count;
        }
    });
});
</script>

</body>
</html>
