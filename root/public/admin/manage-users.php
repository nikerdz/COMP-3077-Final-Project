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

// Handle search
$search = $_GET['search'] ?? '';
$params = [];
$where = '';

if (!empty($search)) {
    $stmt = $pdo->prepare("
        SELECT * FROM users
        WHERE username LIKE :search1 
           OR first_name LIKE :search2 
           OR last_name LIKE :search3 
           OR email LIKE :search4
        ORDER BY username ASC
    ");
    $stmt->execute([
        ':search1' => "%$search%",
        ':search2' => "%$search%",
        ':search3' => "%$search%",
        ':search4' => "%$search%",
    ]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY username ASC");
    $stmt->execute();
}

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <title>RecipeHub | Manage Users</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <link rel="stylesheet" href="<?php echo THEME_URL . $theme . '.css'; ?>?v=<?php echo time(); ?>">
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main class="all-container">
    <h1 style="text-align:center; margin: 40px 0;">Manage Users</h1>

    <form method="GET" class="filter-form" style="text-align:center;">
        <input type="text" name="search" placeholder="Search users..." value="<?php echo htmlspecialchars($search); ?>" style="max-width:300px;">
        <button type="submit" class="btn">Search</button>
    </form>

    <div class="user-grid">
        <?php foreach ($users as $user): ?>
            <?php
                $username = htmlspecialchars($user['username']);
                $fullName = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
                $email = htmlspecialchars($user['email']);
                $joinDate = date('F j, Y', strtotime($user['created_at']));
                $profilePic = !empty($user['profile_pic']) ? PROFILES_URL . $user['profile_pic'] : IMG_URL . 'profile.png';
            ?>
            <div class="user-card">
                <img src="<?php echo $profilePic . '?v=' . time(); ?>" alt="User Profile" style="object-fit:cover;">
                <h4>
                    <a href="<?php echo ADMIN_URL . 'view-user.php?username=' . urlencode($username); ?>" class="recipe-title-link">
                        <?php echo $username; ?>
                    </a>
                </h4>
                <p><?php echo $fullName; ?></p>
                <p><?php echo $email; ?></p>
                <p>Joined: <?php echo $joinDate; ?></p>
                <?php if ($user['username'] !== 'admin'): ?>
                    <form method="POST" action="<?php echo PHP_URL . 'delete_user_submit.php'; ?>" 
                        onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                        <input type="hidden" name="admin_delete_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" class="btn" style="background-color:#e63946;">Delete User</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>


<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
