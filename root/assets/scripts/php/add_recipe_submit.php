<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$cuisine = trim($_POST['cuisine_type']);
$difficulty = $_POST['difficulty'];
$time = (int) $_POST['cooking_time'];

$imageUrl = null;
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . BASE_URL . 'assets/img/thumbnails/';

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($ext, $allowed)) {
        $fileName = uniqid('recipe_', true) . '.' . $ext;
        $destPath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $destPath)) {
            // ✅ FIXED: Pointing to the correct folder
            $imageUrl = BASE_URL . 'assets/img/thumbnails/' . $fileName;
        }
    }
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO recipes (title, description, image_url, cuisine_type, difficulty, cooking_time, created_by)
        VALUES (:title, :description, :image, :cuisine, :difficulty, :time, :created_by)
    ");

    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':image' => $imageUrl,
        ':cuisine' => $cuisine,
        ':difficulty' => $difficulty,
        ':time' => $time,
        ':created_by' => $userId
    ]);

    header('Location: ' . USER_URL . 'profile.php?recipe=success');
    exit();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
