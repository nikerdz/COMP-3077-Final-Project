<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

$recipeId = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];
$isAdmin = $_SESSION['is_admin'] ?? false;

if (!$recipeId || !is_numeric($recipeId)) {
    echo "Invalid recipe ID.";
    exit();
}

// Fetch the recipe
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
$stmt->execute([':id' => $recipeId]);
$recipe = $stmt->fetch();

if (!$recipe) {
    echo "Recipe not found.";
    exit();
}

// Check permission: must be owner OR admin
if ($recipe['created_by'] != $userId && !$isAdmin) {
    echo "You don't have permission to delete this recipe.";
    exit();
}

// Delete recipe
$deleteStmt = $pdo->prepare("DELETE FROM recipes WHERE id = :id");
$deleteStmt->execute([':id' => $recipeId]);

// Redirect depending on role
if ($isAdmin) {
    header("Location: " . ADMIN_URL . "manage-recipes.php?deleted=1");
} else {
    header("Location: " . USER_URL . "profile.php?deleted=1");
}
exit();

?>
