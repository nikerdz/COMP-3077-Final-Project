<?php
require_once('../../config/constants.php');
require_once('../../config/db_config.php');
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
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

$favCount = $recipe['favourite_count'] ?? 0;

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

$imageUrlRaw = $recipe['image_url'] ?? '';
    $imagePath = '';
                        
    if (strpos($imageUrlRaw, 'http') === 0 || strpos($imageUrlRaw, '/') === 0) {
        $imagePath = $imageUrlRaw; // Use as-is (full URL or local path)
    } else {
        $imagePath = IMG_URL . 'thumbnails/' . ($imageUrlRaw ?: 'default.png'); // fallback to default
    }

if (!isset($_SESSION['recently_viewed'])) {
    $_SESSION['recently_viewed'] = [];
}

// Remove if already exists to avoid duplicates
$_SESSION['recently_viewed'] = array_filter($_SESSION['recently_viewed'], fn($id) => $id !== $recipeId);

// Add current recipe to the beginning
array_unshift($_SESSION['recently_viewed'], $recipeId);

// Keep only the last 3
$_SESSION['recently_viewed'] = array_slice($_SESSION['recently_viewed'], 0, 3);


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
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Recipe Image">
            <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
            <p style="text-align:center;">By 
            <a href="<?php echo ADMIN_URL . 'view-user.php?username=' . urlencode($recipe['username']); ?>" class="author-link">
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

        <div class="recipe-meta" style="justify-content:center;">
            <p><strong>Cuisine:</strong> <?php echo ucfirst($recipe['cuisine_type']); ?></p>
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

        <div style="text-align: right;">
                <a href="<?php echo ADMIN_URL . 'edit-recipe.php?id=' . $recipe['id']; ?>" class="btn">Edit Recipe</a>
            </div>
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
                <div class="comment-card-view">
                    <div class="comment-header">
                        <div>
                            <a href="<?php echo USER_URL . 'view-user.php?username=' . urlencode($comment['username']); ?>" class="author-link">
                                <strong><?php echo htmlspecialchars($comment['username']); ?></strong>
                            </a>
                            <span> says:</span><br>
                        </div>

                        <?php if ($_SESSION['is_admin']): ?>
                            <form method="POST" action="<?php echo PHP_URL; ?>delete_comment_submit.php" onsubmit="return confirm('Delete this comment?');">
                                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                <button type="submit" class="delete-comment-btn">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>

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
