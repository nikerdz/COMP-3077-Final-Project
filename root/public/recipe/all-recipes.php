<?php
require_once('../../config/constants.php');
require_once('../../config/db_config.php');
session_start();

// Pagination
$recipesPerPage = 24;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recipesPerPage;

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

// Get total for pagination
$totalStmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM recipes
    JOIN users ON recipes.created_by = users.id
    $where
");

$totalStmt->execute($params);
$totalRecipes = $totalStmt->fetchColumn();
$totalPages = ceil($totalRecipes / $recipesPerPage);

// Get recipes
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

    <title>RecipeHub | All Recipes</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main class="all-container">
    
<h1 style="text-align:center; margin: 40px 0;">All Recipes</h1>

<form method="GET" class="filter-form">
    <input type="text" name="search" placeholder="Search recipes..." value="<?php echo htmlspecialchars($search); ?>">
    
    <select name="meal_type">
        <option value="">All Meal Types</option>
        <option value="Breakfast" <?php if ($meal === 'Breakfast') echo 'selected'; ?>>Breakfast</option>
        <option value="Lunch" <?php if ($meal === 'Lunch') echo 'selected'; ?>>Lunch</option>
        <option value="Dinner" <?php if ($meal === 'Dinner') echo 'selected'; ?>>Dinner</option>
        <option value="Dessert" <?php if ($meal === 'Dessert') echo 'selected'; ?>>Dessert</option>
        <option value="Snack" <?php if ($meal === 'Snack') echo 'selected'; ?>>Snack</option>
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

    <button type="submit" class="btn">Apply Filters</button>
</form>

<div class="recipe-grid">
    <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-card">
            <img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" alt="Recipe Image">
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
            <p class="favourite-count">❤️ <?php echo $recipe['favourite_count']; ?></p>
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
