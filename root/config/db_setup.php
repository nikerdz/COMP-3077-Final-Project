<?php
// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'COMP-3077-Final-Project');
define('DB_USER', 'root'); // Change this if needed
define('DB_PASS', ''); // Change this if needed

try {
    // Connect to MySQL (without specifying a database yet)
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Create database if it doesn’t exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "`");
    echo "Database created successfully or already exists.<br>";

    // Connect to the newly created database
    $pdo->exec("USE `" . DB_NAME . "`");

    // Create users table
    $createUsersTable = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ";

    $pdo->exec($createUsersTable);
    echo "Users table created successfully or already exists.<br>";

} catch (PDOException $e) {
    die("Database setup failed: " . $e->getMessage());
}

?>
