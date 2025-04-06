<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid recipe ID.";
    exit();
}

$recipeId = $_GET['id'];
$userId = $_SESSION['user_id'];

// Confirm ownership
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = :id AND created_by = :uid");
$stmt->execute([':id' => $recipeId, ':uid' => $userId]);
$recipe = $stmt->fetch();

if (!$recipe) {
    echo "Recipe not found or you don't have permission to delete it.";
    exit();
}

// Delete recipe
$deleteStmt = $pdo->prepare("DELETE FROM recipes WHERE id = :id AND created_by = :uid");
$deleteStmt->execute([':id' => $recipeId, ':uid' => $userId]);

header("Location: " . USER_URL . "profile.php?deleted=1");
exit();
?>
