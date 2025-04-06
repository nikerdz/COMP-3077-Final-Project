<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$recipeId = $_POST['recipe_id'];

$title = trim($_POST['title']);
$cuisine = trim($_POST['cuisine_type']);
$difficulty = $_POST['difficulty'];
$time = (int) $_POST['cooking_time'];
$servings = (int) $_POST['servings'];
$readyInMinutes = (int) $_POST['ready_in_minutes'];
$prepTime = (int) $_POST['preparation_time'];
$vegetarian = isset($_POST['vegetarian']) ? 1 : 0;
$glutenFree = isset($_POST['gluten_free']) ? 1 : 0;
$dairyFree = isset($_POST['dairy_free']) ? 1 : 0;
$mealType = $_POST['meal_type'];
$ingredients = trim($_POST['ingredients']);
$instructions = trim($_POST['instructions']);

$imageUrl = null;
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . BASE_URL . 'assets/img/thumbnails/';

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Image upload if exists
if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($ext, $allowed)) {
        $fileName = uniqid('recipe_', true) . '.' . $ext;
        $destPath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $destPath)) {
            $imageUrl = BASE_URL . 'assets/img/thumbnails/' . $fileName;
        }
    }
}

try {
    if ($imageUrl) {
        $query = "UPDATE recipes SET 
            title = :title,
            image_url = :image,
            cuisine_type = :cuisine,
            difficulty = :difficulty,
            cooking_time = :cooking_time,
            servings = :servings,
            ready_in_minutes = :ready_in_minutes,
            preparation_time = :preparation_time,
            vegetarian = :vegetarian,
            gluten_free = :gluten_free,
            dairy_free = :dairy_free,
            meal_type = :meal_type,
            ingredients = :ingredients,
            instructions = :instructions
            WHERE id = :id AND created_by = :user";
        $params[':image'] = $imageUrl;
    } else {
        $query = "UPDATE recipes SET 
            title = :title,
            cuisine_type = :cuisine,
            difficulty = :difficulty,
            cooking_time = :cooking_time,
            servings = :servings,
            ready_in_minutes = :ready_in_minutes,
            preparation_time = :preparation_time,
            vegetarian = :vegetarian,
            gluten_free = :gluten_free,
            dairy_free = :dairy_free,
            meal_type = :meal_type,
            ingredients = :ingredients,
            instructions = :instructions
            WHERE id = :id AND created_by = :user";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':title' => $title,
        ':cuisine' => $cuisine,
        ':difficulty' => $difficulty,
        ':cooking_time' => $time,
        ':servings' => $servings,
        ':ready_in_minutes' => $readyInMinutes,
        ':preparation_time' => $prepTime,
        ':vegetarian' => $vegetarian,
        ':gluten_free' => $glutenFree,
        ':dairy_free' => $dairyFree,
        ':meal_type' => $mealType,
        ':ingredients' => $ingredients,
        ':instructions' => $instructions,
        ':id' => $recipeId,
        ':user' => $userId,
        ...(isset($imageUrl) ? [':image' => $imageUrl] : [])
    ]);

    header("Location: " . RECIPE_URL . "view-recipe.php?id=" . $recipeId);
    exit();

} catch (PDOException $e) {
    echo "Error updating recipe: " . $e->getMessage();
}
?>
