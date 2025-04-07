<?php
// Include the constants.php file
require_once('../../config/constants.php');
require_once('../../config/db_config.php');
session_start();

$recentlyViewedRecipes = [];

if (!empty($_SESSION['recently_viewed'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['recently_viewed']), '?'));
    $stmt = $pdo->prepare("
        SELECT recipes.*, users.username 
        FROM recipes 
        JOIN users ON recipes.created_by = users.id 
        WHERE recipes.id IN ($placeholders)
    ");

    $stmt->execute($_SESSION['recently_viewed']);
    $fetched = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Preserve order based on ID array
    $recentlyViewedRecipes = [];
    foreach ($_SESSION['recently_viewed'] as $id) {
        foreach ($fetched as $recipe) {
            if ($recipe['id'] == $id) {
                $recentlyViewedRecipes[] = $recipe;
                break;
            }
        }
    }
}

$userId = $_SESSION['user_id'];
$username = htmlspecialchars($_SESSION['username']);
$firstName = htmlspecialchars($_SESSION['first_name']);
$profilePic = !empty($_SESSION['profile_pic']) ? PROFILES_URL . $_SESSION['profile_pic'] : IMG_URL . 'profile.png';

// Fetch most recent recipe
$recentRecipeStmt = $pdo->prepare("SELECT * FROM recipes WHERE created_by = :uid ORDER BY created_at DESC LIMIT 1");
$recentRecipeStmt->execute([':uid' => $userId]);
$recentRecipe = $recentRecipeStmt->fetch(PDO::FETCH_ASSOC);

// Fetch recent comments on user's recipes
$commentsStmt = $pdo->prepare("
    SELECT c.*, u.username AS commenter, r.title AS recipe_title, r.id AS recipe_id
    FROM comments c
    JOIN recipes r ON c.recipe_id = r.id
    JOIN users u ON c.user_id = u.id
    WHERE r.created_by = :uid
    ORDER BY c.created_at DESC
    LIMIT 3
");
$commentsStmt->execute([':uid' => $userId]);
$recentComments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch 3 random recipes the user didn't create
$stmt = $pdo->prepare("
    SELECT recipes.*, users.username 
    FROM recipes 
    JOIN users ON recipes.created_by = users.id 
    WHERE created_by != :user_id 
    ORDER BY RAND() 
    LIMIT 3
");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$randomRecipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    <title>RecipeHub | My Dashboard</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<section class="hero-section less-hero">
        <div class="dashboard-profile">
                <img src="<?php echo $profilePic ?>" alt="Profile Picture" width="500" height="600">
            </div>
        <h1>Welcome back, <?php echo $firstName; ?></h1>
        <p>Here's what’s cooking today!</p>
</section>

<main class="dashboard-container">
    <section class="dashboard-section">
        <h3 style="text-align: center;">Recently Viewed Recipes</h3>
        <?php if (!empty($recentlyViewedRecipes)): ?>
            <div class="recipe-grid">
                <?php foreach ($recentlyViewedRecipes as $recipe): ?>
                    <?php
                    // Fetch favourite count for each recipe
                        $favCount = $recipe['favourite_count'] ?? 0;
                        ?>

                    <div class="recipe-card">
                        <img src="<?php echo htmlspecialchars($recipe['image_url'] ?? IMG_URL . 'thumbnails/default.png'); ?>" alt="Recipe Image">
                        <h4>
                            <a href="<?php echo RECIPE_URL . 'view-recipe.php?id=' . $recipe['id']; ?>" class="recipe-title-link">
                                <?php echo htmlspecialchars($recipe['title']); ?>
                            </a>
                        </h4>
                        <p> <a href="<?php echo USER_URL . 'view-user.php?username=' . urlencode($recipe['username']); ?>" class="author-link">By <?php echo htmlspecialchars($recipe['username']); ?>
                            </a>
                        </p>
                        <p>Time: <?php echo $recipe['ready_in_minutes']; ?> mins</p>
                        <p>Cuisine: <?php echo htmlspecialchars($recipe['cuisine_type']); ?></p>
                        <p class="favourite-count">❤️ <?php echo $favCount; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>You haven’t viewed any recipes yet.</p>
        <?php endif; ?>
    </section>

    <section class="dashboard-section">
        <h3>Quick Links</h3>
        <div class="dashboard-links">
            <a href="<?php echo RECIPE_URL; ?>user-recipes.php?username=<?php echo urlencode($username); ?>" class="btn">My Recipes</a>
            <a href="<?php echo RECIPE_URL; ?>favourite-recipes.php?username=<?php echo urlencode($username); ?>" class="btn">My Favourites</a>
            <a href="<?php echo RECIPE_URL; ?>add-recipe.php" class="btn">Post Recipe</a>
            <a href="<?php echo USER_URL; ?>edit-profile.php" class="btn">Edit Profile</a>
            <a href="<?php echo USER_URL; ?>user-settings.php" class="btn">Settings</a>
        </div>
    </section>

    <section class="dashboard-comments">
        <h3>Recent Comments on Your Recipes</h3>
        <?php if (!empty($recentComments)): ?>
            <?php foreach ($recentComments as $comment): ?>
                <div class="comment-card">
                    <p>
                    <strong><a href="<?php echo USER_URL . 'view-user.php?username=' . urlencode($comment['commenter']); ?>" class="comment-user-link">
                            <?php echo htmlspecialchars($comment['commenter']); ?>
                        </a></strong> on 
                        <a href="<?php echo RECIPE_URL . 'view-recipe.php?id=' . $comment['recipe_id']; ?>" class="comment-card-link">
                            <?php echo htmlspecialchars($comment['recipe_title']); ?>
                        </a>:
                    </p>
                    <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                    <small><?php echo date('F j, Y g:i A', strtotime($comment['created_at'])); ?></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="random-p">No comments yet. Keep sharing your recipes!</p>
        <?php endif; ?>
    </section>

    <section class="dashboard-section">
        <h3>Recipes You Might Like</h3>
        <?php if (!empty($randomRecipes)): ?>
            <div class="recipe-grid">
                <?php foreach ($randomRecipes as $recipe): ?>
                    <?php
                    // Fetch favourite count for each recipe
                        $favCount = $recipe['favourite_count'] ?? 0;
                        ?>
                    <div class="recipe-card">
                        <img src="<?php echo htmlspecialchars($recipe['image_url'] ?? IMG_URL . 'thumbnails/default.png'); ?>" alt="Suggested Recipe">
                        <h4>
                            <a href="<?php echo RECIPE_URL . 'view-recipe.php?id=' . $recipe['id']; ?>" class="recipe-title-link">
                                <?php echo htmlspecialchars($recipe['title']); ?>
                            </a>
                        </h4>
                        <p> <a href="<?php echo USER_URL . 'view-user.php?username=' . urlencode($recipe['username']); ?>" class="author-link">By <?php echo htmlspecialchars($recipe['username']); ?>
                            </a>
                        </p>
                        <p>Time: <?php echo $recipe['ready_in_minutes']; ?> mins</p>
                        <p>Cuisine: <?php echo htmlspecialchars($recipe['cuisine_type']); ?></p>
                        <p class="favourite-count">❤️ <?php echo $favCount; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="random-p">No suggestions available right now.</p>
        <?php endif; ?>
            <div class="dashboard-links">
                <a href="<?php echo USER_URL; ?>explore.php" class="btn">Explore Recipes</a>
            </div>
    </section>
</main>


<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
