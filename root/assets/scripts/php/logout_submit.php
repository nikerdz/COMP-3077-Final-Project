<?php
require_once('../../../config/constants.php');
session_start(); // Start session to access session variables

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login page with a success message
header('Location: ' . PUBLIC_URL . 'login.php?success=logout');
exit();

?>
