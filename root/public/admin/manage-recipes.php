<?php
require_once('../../config/constants.php');
require_once('../../config/db_config.php');
session_start();

$theme = $_SESSION['theme'] ?? 'theme1';
$themeSuffix = $theme === 'theme2' ? '2' : ($theme === 'theme3' ? '3' : '');

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

// Pagination
$recipesPerPage = 24;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recipesPerPage;

$category = $_GET['category'] ?? '';

// Category mapping
switch ($category) {
    case 'Vegetarian Delights':
        $_GET['vegetarian'] = 1;
        break;
    case 'Gluten-Free Goodness':
        $_GET['gluten_free'] = 1;
        break;
    case 'User-Created Recipes':
        $_GET['api'] = 'no';
        break;
    case 'Quick & Easy (Under 30 Min)':
        $_GET['time'] = 'under30';
        break;
    case 'Featured Recipes':
        $_GET['favourite_min'] = 6;
        break;
}

// Filters
$search = $_GET['search'] ?? '';
$meal = $_GET['meal_type'] ?? '';
$cuisine = $_GET['cuisine_type'] ?? '';
$time = $_GET['time'] ?? '';
$vegetarian = isset($_GET['vegetarian']);
$gluten_free = isset($_GET['gluten_free']);
$dairy_free = isset($_GET['dairy_free']);

$conditions = [];
$params = [];

if (!empty($search)) {
    $conditions[] = "(recipes.title LIKE :search_title OR recipes.ingredients LIKE :search_ingredients)";
    $params[':search_title'] = '%' . $search . '%';
    $params[':search_ingredients'] = '%' . $search . '%';
}
if (!empty($_GET['favourite_min'])) {
    $conditions[] = "favourite_count >= :fav_min";
    $params[':fav_min'] = (int)$_GET['favourite_min'];
}
if (!empty($_GET['api']) && $_GET['api'] === 'no') {
    $conditions[] = "is_api = 0";
}
if (!empty($meal)) {
    $conditions[] = "meal_type = :meal";
    $params[':meal'] = $meal;
}
if (!empty($cuisine)) {
    $conditions[] = "cuisine_type LIKE :cuisine";
    $params[':cuisine'] = '%' . $cuisine . '%';
}
if ($vegetarian) {
    $conditions[] = "vegetarian = 1";
}
if ($gluten_free) {
    $conditions[] = "gluten_free = 1";
}
if ($dairy_free) {
    $conditions[] = "dairy_free = 1";
}
if (!empty($time)) {
    if ($time == 'under30') {
        $conditions[] = "ready_in_minutes <= 30";
    } elseif ($time == 'under60') {
        $conditions[] = "ready_in_minutes <= 60";
    } elseif ($time == 'over60') {
        $conditions[] = "ready_in_minutes > 60";
    }
}

$where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

// Total for pagination
$totalStmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM recipes
    JOIN users ON recipes.created_by = users.id
    $where
");
$totalStmt->execute($params);
$totalRecipes = $totalStmt->fetchColumn();
$totalPages = ceil($totalRecipes / $recipesPerPage);

// Recipes
$sql = "
    SELECT recipes.*, users.username
    FROM recipes
    JOIN users ON recipes.created_by = users.id
    $where
    ORDER BY recipes.title ASC
    LIMIT :limit OFFSET :offset
";
$stmt = $pdo->prepare($sql);
$params[':limit'] = $recipesPerPage;
$params[':offset'] = $offset;
$stmt->execute($params);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <title>RecipeHub | Manage Recipes</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <link rel="stylesheet" href="<?php echo THEME_URL . $theme . '.css'; ?>?v=<?php echo time(); ?>">
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main class="all-container">
<h1 style="text-align:center; margin: 40px 0;">Manage All Recipes</h1>

<form method="GET" class="filter-form">
    <input type="text" name="search" placeholder="Search recipes..." value="<?php echo htmlspecialchars($search); ?>">
    <select name="meal_type">
        <option value="">All Meal Types</option>
        <?php foreach (['Breakfast', 'Lunch', 'Dinner', 'Dessert', 'Snack'] as $type): ?>
            <option value="<?php echo $type; ?>" <?php if ($meal === $type) echo 'selected'; ?>><?php echo $type; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="text" name="cuisine_type" placeholder="Cuisine" value="<?php echo htmlspecialchars($cuisine); ?>">
    <select name="time">
        <option value="">Total Time</option>
        <option value="under30" <?php if ($time === 'under30') echo 'selected'; ?>>Under 30 min</option>
        <option value="under60" <?php if ($time === 'under60') echo 'selected'; ?>>Under 60 min</option>
        <option value="over60" <?php if ($time === 'over60') echo 'selected'; ?>>Over 60 min</option>
    </select>
    <label><input type="checkbox" name="vegetarian" <?php if ($vegetarian) echo 'checked'; ?>> Vegetarian</label>
    <label><input type="checkbox" name="gluten_free" <?php if ($gluten_free) echo 'checked'; ?>> Gluten-Free</label>
    <label><input type="checkbox" name="dairy_free" <?php if ($dairy_free) echo 'checked'; ?>> Dairy-Free</label>
    <button type="submit" class="btn">Search</button>
</form>

<div class="recipe-grid">
    <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-card">
            <img src="<?php echo htmlspecialchars($recipe['image_url'] ?? IMG_URL . 'thumbnails/default.png'); ?>" alt="Recipe Image">
            <h4>
                <a href="<?php echo ADMIN_URL . 'view-recipe.php?id=' . $recipe['id']; ?>" class="recipe-title-link">
                    <?php echo htmlspecialchars($recipe['title']); ?>
                </a>
            </h4>
            <p>
                <a href="<?php echo ADMIN_URL . 'view-user.php?username=' . urlencode($recipe['username']); ?>" class="author-link">
                    By <?php echo htmlspecialchars($recipe['username']); ?>
                </a>
            </p>
            <p>Time: <?php echo $recipe['ready_in_minutes']; ?> mins</p>
            <p>Cuisine: <?php echo htmlspecialchars($recipe['cuisine_type']); ?></p>
            <p class="favourite-count">❤️ <?php echo $recipe['favourite_count']; ?></p>

            <!-- Admin Actions -->
            <div style="margin-top: 10px;">
                <a href="<?php echo ADMIN_URL . 'edit-recipe.php?id=' . $recipe['id']; ?>" class="btn" style="margin-right: 8px;">Edit</a>
                <a href="<?php echo PHP_URL . 'delete_recipe_submit.php?id=' . $recipe['id']; ?>" class="btn" style="background-color: #e63946;" onclick="return confirm('Are you sure you want to delete this recipe?');">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a class="page-link <?php if ($i == $page) echo 'active'; ?>" href="?<?php
                $query = $_GET;
                $query['page'] = $i;
                echo http_build_query($query);
            ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

</main>


<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
