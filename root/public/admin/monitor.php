<?php
require_once('../../config/constants.php');
require_once('../../config/db_config.php');
session_start();

$theme = $_SESSION['theme'] ?? 'theme1';
$themeSuffix = $theme === 'theme2' ? '2' : ($theme === 'theme3' ? '3' : '');

function checkHttpStatus($url, $timeout = 3) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $httpCode >= 200 && $httpCode < 400 ? 'Online' : 'Offline';
}


if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

$baseUrl = BASE_URL;
$statuses = [
    "Database Connection" => $pdo ? "Online" : "Offline",
    "Spoonacular API" => checkHttpStatus("https://spoonacular.com/food-api"),
    "User Registration" => checkHttpStatus(PUBLIC_URL . "login.php"),
    "Recipe Upload" => checkHttpStatus(RECIPE_URL . "add-recipe.php"),
    "Explore Page" => checkHttpStatus(USER_URL . "explore.php"),
    "User Profiles" => checkHttpStatus(USER_URL . "profile.php"),
];

// Collect data for the past 5 days
$activityData = [
    'labels' => [],
    'users' => [],
    'recipes' => []
];

for ($i = 4; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));

    $stmtUsers = $pdo->prepare("SELECT COUNT(*) FROM users WHERE DATE(created_at) = :date");
    $stmtUsers->execute([':date' => $date]);
    $activityData['users'][] = (int) $stmtUsers->fetchColumn();

    $stmtRecipes = $pdo->prepare("SELECT COUNT(*) FROM recipes WHERE is_api = 0 AND DATE(created_at) = :date");
    $stmtRecipes->execute([':date' => $date]);
    $activityData['recipes'][] = (int) $stmtRecipes->fetchColumn();

    $activityData['labels'][] = date('M j', strtotime($date));
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

    <title>RecipeHub | Systems Monitor</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <link rel="stylesheet" href="<?php echo THEME_URL . $theme . '.css'; ?>?v=<?php echo time(); ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>

<script>
//Systems Monitor Line Graph
document.addEventListener("DOMContentLoaded", function () {
    // Data for the chart
    const labels = <?php echo json_encode($activityData['labels']); ?>;
    const userCounts = <?php echo json_encode($activityData['users']); ?>;
    const recipeCounts = <?php echo json_encode($activityData['recipes']); ?>;

    // Initialize the Chart.js line chart
    const ctx = document.getElementById('activityChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'New Users',
                    data: userCounts,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'New User Recipes',
                    data: recipeCounts,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.1)',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: false
                },
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});

</script>


<!-- Navigation Bar and Side Bar Menu -->
<?php include_once('../../assets/includes/navbar.php'); ?>


<!-- Main Content Section -->
<main class="monitor-container">
    <h1>Systems Monitor</h1>

    <section class="status-table">
        <h2>Service Status Overview</h2>
        <table>
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($statuses as $service => $status): ?>
                    <tr>
                        <td><?php echo $service; ?></td>
                        <td class="<?php echo strtolower($status); ?>"><?php echo $status; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <div class="graph-container">
        <section class="chart-section">
            <h2>Website Activity (Past 5 Days)</h2>
            <canvas id="activityChart" style="width:100%;max-width:700px"></canvas>
        </section>
    </div>

</main>



<!-- Footer -->
<?php include_once('../../assets/includes/footer.php'); ?>

</body>
</html>
