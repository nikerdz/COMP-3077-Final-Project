<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . PUBLIC_URL . 'login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];

    try {
        // Fetch user from DB
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($currentPassword, $user['password'])) {
            // Hash new password
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update password in DB
            $update = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
            $update->execute([
                ':password' => $newHashedPassword,
                ':id' => $userId
            ]);

            // Redirect with success alert
            header("Location: " . USER_URL . "user-settings.php?password=success");
            exit();
        } else {
            // Wrong current password
            header("Location: " . USER_URL . "user-settings.php?password=wrong");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Invalid access
    header('Location: ' . USER_URL . 'user-settings.php');
    exit();
}
