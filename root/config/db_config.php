<?php
// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'COMP-3077-Final-Project');
define('DB_USER', 'root'); // Change if using a different user
define('DB_PASS', ''); // Change if your MySQL has a password

try {
    // Connect to the database using PDO
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable error reporting
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch data as associative arrays
        PDO::ATTR_EMULATE_PREPARES => false, // Use real prepared statements
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
