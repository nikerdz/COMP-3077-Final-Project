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
$profilePic = !empty($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png';
$aboutMe = htmlspecialchars($_SESSION['about_me'] ?? '');

$userId = $_SESSION['user_id'];
$query = "SELECT * FROM recipes WHERE created_by = :userId ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([':userId' => $userId]);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get favourite recipes for this user
$stmt = $pdo->prepare("
    SELECT r.*, u.username
    FROM recipes r
    JOIN favourites f ON r.id = f.recipe_id
    JOIN users u ON r.created_by = u.id
    WHERE f.user_id = :user_id
    ORDER BY f.favourited_at DESC
");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$favRecipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <title>RecipeHub | My Profile</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main>
    <div class="profile-section">
        <div class="profile-card">
            <div class="profile-image">
                <img src="<?php echo $profilePic ?>" alt="Profile Picture">
            </div>

            <div class="profile-info">
                <h2><?php echo $username; ?>'s Profile</h2>
                <p><strong>Name:</strong> <?php echo $firstName; ?> <?php echo $lastName; ?></p>
                <?php if (!empty($_SESSION['about_me'])): ?>
                    <p><strong>About Me:</strong> <?php echo nl2br(htmlspecialchars($_SESSION['about_me'])); ?></p>
                <?php else: ?>
                    <p><strong>About Me:</strong> <em>No bio yet.</em></p>
                <?php endif; ?>
                <div class="profile-actions">
                    <a href="<?php echo USER_URL; ?>edit-profile.php" class="btn">Edit Profile</a>
                    <a href="<?php echo USER_URL; ?>user-settings.php" class="btn">User Settings</a>
                </div>
            </div>
        </div>
    </div>

    <div class="recipe-section">
        <div class="recipe-posts">
            <h2>Posted Recipes</h2>

            <?php if (empty($recipes)): ?>
                <div style="text-align: center; width: 100%;">
                    <p>You haven’t posted any recipes yet.</p>
                    <br> <br>
                    <a href="<?php echo RECIPE_URL; ?>add-recipe.php" class="btn">Post a Recipe</a>
                </div>
            <?php else: ?>
                <div class="recipe-grid">
                    <?php foreach (array_slice($recipes, 0, 4) as $recipe): ?>
                        <?php
                        $imageUrlRaw = $recipe['image_url'] ?? '';
                        $imagePath = '';
                        
                        if (strpos($imageUrlRaw, 'http') === 0 || strpos($imageUrlRaw, '/') === 0) {
                            $imagePath = $imageUrlRaw; // Use as-is (full URL or local path)
                        } else {
                            $imagePath = IMG_URL . 'thumbnails/' . ($imageUrlRaw ?: 'default.png'); // fallback to default
                        }

                        // Fetch favourite count for each recipe
                        $favCount = $recipe['favourite_count'] ?? 0;
                        ?>
                        <div class="recipe-card">
                            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Recipe Image">
                            <h4>
                                <a href="<?php echo RECIPE_URL . 'view-recipe.php?id=' . $recipe['id']; ?>" class="recipe-link">
                                    <?php echo htmlspecialchars($recipe['title']); ?>
                                </a>
                            </h4>
                            <p>Time: <?php echo $recipe['ready_in_minutes']; ?> mins</p>
                            <p>Cuisine: <?php echo htmlspecialchars($recipe['cuisine_type']); ?></p>
                            <p class="favourite-count">❤️ <?php echo $favCount; ?></p>
                        </div>
                    <?php endforeach; ?>
                    <?php if (count($recipes) > 4): ?>
                        <div style="text-align: center; margin-top: 20px;">
                            <a href="<?php echo RECIPE_URL . 'user-recipes.php?username=' . urlencode($username); ?>" class="btn">
                                View All My Recipes
                            </a>
                        </div>
                    <?php endif; ?>
                    <div style="text-align: center; width: 100%;">
                        <a href="<?php echo RECIPE_URL; ?>add-recipe.php" class="btn">Post a Recipe</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="recipe-section">
        <div class="recipe-posts">
            <h2>Favourite Recipes</h2>
            <?php if (empty($favRecipes)): ?>
                <div style="text-align: center; width: 100%;">
                    <p>You haven’t favourited any recipes yet.</p>
                    <br>
                </div>
            <?php else: ?>
                <div class="recipe-grid">
                    <?php foreach (array_slice($favRecipes, 0, 4) as $recipe): ?>
                        <?php
                        $imageUrlRaw = $recipe['image_url'] ?? '';
                        $imagePath = '';
                        
                        if (strpos($imageUrlRaw, 'http') === 0 || strpos($imageUrlRaw, '/') === 0) {
                            $imagePath = $imageUrlRaw;
                        } else {
                            $imagePath = IMG_URL . 'thumbnails/' . ($imageUrlRaw ?: 'default.png'); // fallback to default
                        }

                        // Fetch favourite count for each recipe
                        $favCount = $recipe['favourite_count'] ?? 0;
                        ?>
                        <div class="recipe-card">
                            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Recipe Image">
                            <h4>
                                <a href="<?php echo RECIPE_URL . 'view-recipe.php?id=' . $recipe['id']; ?>" class="recipe-link">
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

                <?php if (count($favRecipes) > 4): ?>
                    <div style="text-align: center; margin-top: 20px;">
                        <a href="<?php echo RECIPE_URL . 'favourite-recipes.php?username=' . urlencode($username); ?>" class="btn">
                            View All My Favourites
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

</main>


<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
