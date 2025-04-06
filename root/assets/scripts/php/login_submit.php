<?php
// Include the constants.php file and start the session
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php'); // Include the database connection
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // SQL query to check the username and password from the database
    $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Check if the user exists
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['profile_pic'] = $user['profile_pic'] ?? 'default.png';
            $_SESSION['about_me'] = $user['about_me'];

            // Redirect to the user dashboard
            header('Location: ' . PUBLIC_URL . 'user/dashboard.php');
            exit();
        } else {
            // Incorrect password
            $_SESSION['login_error'] = "Incorrect username or password.";
            header('Location: ' . PUBLIC_URL . 'login.php');
            exit();
        }
    } else {
        // User does not exist
        $_SESSION['login_error'] = "Incorrect username or password.";
        header('Location: ' . PUBLIC_URL . 'login.php');
        exit();
    }
}
