<?php
require_once('../../config/constants.php');
require_once('../../config/db_config.php');
session_start();

$theme = $_SESSION['theme'] ?? 'theme1';
$themeSuffix = $theme === 'theme2' ? '2' : ($theme === 'theme3' ? '3' : '');

if (!isset($_GET['username'])) {
    echo "No user specified.";
    exit();
}

$username = $_GET['username'];

$userStmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$userStmt->execute([':username' => $username]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit();
}

$userId = $user['id'];
$otherUserProfilePic = !empty($user['profile_pic']) ? PROFILES_URL . $user['profile_pic'] : IMG_URL . 'profile.png';
$recipesStmt = $pdo->prepare("SELECT * FROM recipes WHERE created_by = :id ORDER BY created_at DESC");
$recipesStmt->execute([':id' => $userId]);
$recipes = $recipesStmt->fetchAll(PDO::FETCH_ASSOC);
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

    <title>RecipeHub | All Recipes by <?php echo htmlspecialchars($username); ?></title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <link rel="stylesheet" href="<?php echo THEME_URL . $theme . '.css'; ?>?v=<?php echo time(); ?>">
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>

<!-- Main Content Section -->

<section class="hero-section less-hero">
        <div class="dashboard-profile">
                <img src="<?php echo $otherUserProfilePic ?>" alt="Profile Picture" width="500" height="600">
            </div>
            <p style="text-align:center">All Recipes by <?php echo htmlspecialchars($username); ?>
            </p>
</section>
<br>
<main>
    <div class="recipe-section">
        <div class="recipe-grid">
            <?php if (empty($recipes)): ?>
                <p><?php echo htmlspecialchars($username); ?> hasn’t posted any recipes yet.</p>
            <?php else: ?>
                <?php foreach ($recipes as $recipe): ?>

                    <?php
                        // Fetch favourite count for each recipe
                        $favCount = $recipe['favourite_count'] ?? 0;
                        ?>

                    <div class="recipe-card">
                    <?php
                        $imageSrc = $recipe['image_url'];
                        if (empty($imageSrc) || $imageSrc === 'default.png') {
                                $imageSrc = IMG_URL . 'thumbnails/default.png';
                        } elseif (!str_starts_with($imageSrc, 'http') && !str_contains($imageSrc, '/')) {
                            $imageSrc = IMG_URL . 'thumbnails/' . $imageSrc;
                        }
                    ?>
                        <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Recipe Image">
                        <h4><a class="recipe-link" href="<?php echo RECIPE_URL . 'view-recipe.php?id=' . $recipe['id']; ?>">
                            <?php echo htmlspecialchars($recipe['title']); ?>
                        </a></h4>
                        <p>Time: <?php echo $recipe['ready_in_minutes']; ?> mins</p>
                        <p>Cuisine: <?php echo htmlspecialchars($recipe['cuisine_type']); ?></p>
                        <p class="favourite-count">❤️ <?php echo $favCount; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>
<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
