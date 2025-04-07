<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

// Validate the user ID to delete
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid user ID.";
    exit();
}

$userIdToDelete = (int)$_GET['id'];

// Prevent deleting the main admin (or any admin)
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $userIdToDelete]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit();
}

// Do not allow deletion of admin accounts
if ($user['is_admin']) {
    echo "You cannot delete an admin account.";
    exit();
}

// Delete the user’s related data if needed (optional: comments, recipes, etc.)

// Delete user
$deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
$deleteStmt->execute([':id' => $userIdToDelete]);

header("Location: " . ADMIN_URL . "manage-users.php?deleted=1");
exit();
