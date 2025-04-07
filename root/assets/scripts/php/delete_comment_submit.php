<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ' . PUBLIC_URL . 'login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id']) && is_numeric($_POST['comment_id'])) {
    $commentId = $_POST['comment_id'];

    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");
    $stmt->execute([':id' => $commentId]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo "Invalid request.";
}
