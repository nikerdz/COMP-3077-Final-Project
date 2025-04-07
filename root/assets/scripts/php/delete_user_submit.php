<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

$currentUserId = $_SESSION['user_id'];
$isAdmin = $_SESSION['is_admin'] ?? false;

// Admin deletes another user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAdmin && isset($_POST['admin_delete_id'])) {
    $userIdToDelete = (int)$_POST['admin_delete_id'];

    // Don't allow deletion of self this way
    if ($userIdToDelete === $currentUserId) {
        echo "Admins must delete their own account from their settings.";
        exit();
    }

    // Get user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $userIdToDelete]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "User not found.";
        exit();
    }

    if ($user['is_admin']) {
        echo "You cannot delete another admin account.";
        exit();
    }

    // Delete related data
    $pdo->prepare("DELETE FROM comments WHERE user_id = :id")->execute([':id' => $userIdToDelete]);
    $pdo->prepare("DELETE FROM favourites WHERE user_id = :id")->execute([':id' => $userIdToDelete]);
    $pdo->prepare("DELETE FROM recipes WHERE created_by = :id")->execute([':id' => $userIdToDelete]);

    // Delete user
    $pdo->prepare("DELETE FROM users WHERE id = :id")->execute([':id' => $userIdToDelete]);

    header("Location: " . ADMIN_URL . "manage-users.php?deleted=1");
    exit();
}

//  Self-deletion (user confirms password)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_password'])) {
    $enteredPassword = $_POST['confirm_password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $currentUserId]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "User not found.";
        exit();
    }

    if (!password_verify($enteredPassword, $user['password'])) {
        header("Location: " . USER_URL . "user-settings.php?password=wrong");
        exit();
    }

    $pdo->prepare("DELETE FROM comments WHERE user_id = :id")->execute([':id' => $currentUserId]);
    $pdo->prepare("DELETE FROM favourites WHERE user_id = :id")->execute([':id' => $currentUserId]);
    $pdo->prepare("DELETE FROM recipes WHERE created_by = :id")->execute([':id' => $currentUserId]);
    $pdo->prepare("DELETE FROM users WHERE id = :id")->execute([':id' => $currentUserId]);

    session_unset();
    session_destroy();
    header("Location: " . PUBLIC_URL . "index.php?account_deleted=1");
    exit();
}

echo "Invalid request.";
exit();
?>
