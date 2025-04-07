<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . PUBLIC_URL . 'login.php');
    exit();
}

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $recipeId = isset($_POST['recipe_id']) ? (int)$_POST['recipe_id'] : 0;
    $commentText = trim($_POST['comment']);

    if ($recipeId <= 0 || empty($commentText)) {
        $redirectBase = !empty($_SESSION['is_admin']) ? ADMIN_URL : RECIPE_URL;
        header('Location: ' . $redirectBase . 'view-recipe.php?id=' . $recipeId . '&error=invalid');
        exit();
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO comments (recipe_id, user_id, comment) 
            VALUES (:recipe_id, :user_id, :comment)
        ");

        $stmt->execute([
            ':recipe_id' => $recipeId,
            ':user_id'   => $userId,
            ':comment'   => $commentText
        ]);

        $redirectBase = !empty($_SESSION['is_admin']) ? ADMIN_URL : RECIPE_URL;
        header('Location: ' . $redirectBase . 'view-recipe.php?id=' . $recipeId . '&comment=success');
        exit();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit();
    }
} else {
    // Block direct access
    header('Location: ' . PUBLIC_URL . 'index.php');
    exit();
}
