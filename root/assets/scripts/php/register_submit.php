<?php
session_start();
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if email is already registered
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email OR username = :username");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $errors[] = "Email or username is already taken.";
    }

    // If there are errors, redirect back with errors
    if (!empty($errors)) {
        $_SESSION['registration_errors'] = $errors;
        header("Location: " . PUBLIC_URL . "register.php");
        exit();
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            die("Error: Email already registered.");
        }

        // Insert the user into the database
        $stmt = $pdo->prepare("
            INSERT INTO users (first_name, last_name, username, email, password)
            VALUES (:first_name, :last_name, :username, :email, :password)
        ");
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();

        header("Location: " . PUBLIC_URL . "login.php?success=1");
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['registration_errors'] = ["Database error: " . $e->getMessage()];
        header("Location: " . PUBLIC_URL . "register.php");
        exit();
    }
}
?>
