<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$userId = $_SESSION['user_id'];
$recipeId = $_POST['recipe_id'] ?? null;

if (!$recipeId || !is_numeric($recipeId)) {
    echo json_encode(['success' => false, 'message' => 'Invalid recipe ID']);
    exit();
}

// Check if already favourited
$check = $pdo->prepare("SELECT * FROM favourites WHERE user_id = :uid AND recipe_id = :rid");
$check->execute([':uid' => $userId, ':rid' => $recipeId]);

if ($check->fetch()) {
    // Remove favourite
    $remove = $pdo->prepare("DELETE FROM favourites WHERE user_id = :uid AND recipe_id = :rid");
    $remove->execute([':uid' => $userId, ':rid' => $recipeId]);
    $favourited = false;
} else {
    // Add favourite
    $add = $pdo->prepare("INSERT INTO favourites (user_id, recipe_id) VALUES (:uid, :rid)");
    $add->execute([':uid' => $userId, ':rid' => $recipeId]);
    $favourited = true;
}

// Get updated count
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM favourites WHERE recipe_id = :rid");
$countStmt->execute([':rid' => $recipeId]);
$count = $countStmt->fetchColumn();

echo json_encode([
    'success' => true,
    'favourited' => $favourited,
    'count' => $count
]);
exit();
