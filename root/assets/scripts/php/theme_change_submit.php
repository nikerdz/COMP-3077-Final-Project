<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme'])) {
    // Remove .css if included
    $_SESSION['theme'] = str_replace('.css', '', $_POST['theme']);
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
