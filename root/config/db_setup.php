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
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            profile_pic VARCHAR(255) DEFAULT 'default.png',
            about_me TEXT DEFAULT NULL
        ) ENGINE=InnoDB;
    ";

    $pdo->exec($createUsersTable);
    echo "Users table created successfully or already exists.<br>";

    // Insert Spoonacular user if not already exists
    $checkStmt = $pdo->prepare("SELECT id FROM users WHERE username = 'spoonacular'");
    $checkStmt->execute();

    if ($checkStmt->rowCount() === 0) {
        $insertStmt = $pdo->prepare("
            INSERT INTO users (
                username, email, first_name, last_name, password, profile_pic, about_me
            ) VALUES (
                'spoonacular',
                'main@spoonacular.com',
                'Spoonacular',
                'API',
                '',
                'spoonacular.svg',
                'Spoonacular API is a food management system that combines dining out, eating store-bought food, and cooking at home to help you find and organize the restaurants, products, and recipes that fit your diet and help you reach your nutrition goals.'
            )
        ");
        $insertStmt->execute();
        echo "Spoonacular user created.<br>";
    } else {
        echo "Spoonacular user already exists.<br>";
    }

    // Insert default admin user if not already exists
    $checkAdminStmt = $pdo->prepare("SELECT id FROM users WHERE username = 'admin'");
    $checkAdminStmt->execute();

    if ($checkAdminStmt->rowCount() === 0) {
        // Hash the admin password
        $adminPassword = password_hash('placeholder', PASSWORD_DEFAULT);

        $insertAdminStmt = $pdo->prepare("
            INSERT INTO users (
                username, email, first_name, last_name, password, profile_pic, about_me, is_admin
            ) VALUES (
                'admin',
                'admin@recipehub.com',
                'Admin',
                'User',
                :password,
                'admin.png',
                'This is the main administrator account for managing RecipeHub.',
                1
            )
        ");
        $insertAdminStmt->execute([':password' => $adminPassword]);
        echo "Default admin user created.<br>";
    } else {
        echo "Admin user already exists.<br>";
    }

    $createRecipesTable = "
    CREATE TABLE IF NOT EXISTS recipes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        image_url VARCHAR(255) DEFAULT 'default.png',
        cuisine_type VARCHAR(100),
        difficulty ENUM('Easy', 'Medium', 'Hard'),
        vegetarian BOOLEAN DEFAULT FALSE,
        gluten_free BOOLEAN DEFAULT FALSE,
        dairy_free BOOLEAN DEFAULT FALSE,
        meal_type ENUM('Breakfast', 'Lunch', 'Dinner', 'Dessert', 'Snack') DEFAULT 'Dinner',
        servings INT,
        ready_in_minutes INT,
        preparation_time INT,
        cooking_time INT,
        ingredients TEXT,
        instructions TEXT,
        is_api BOOLEAN DEFAULT FALSE,
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        favourite_count INT DEFAULT 0,
        is_admin BOOLEAN DEFAULT FALSE,
        FOREIGN KEY (created_by) REFERENCES users(id)
    ) ENGINE=InnoDB;
    ";

    $pdo->exec($createRecipesTable);
    echo "Recipes table created successfully or already exists.<br>";

    $createFavouritesTable = "
    CREATE TABLE IF NOT EXISTS favourites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    recipe_id INT NOT NULL,
    favourited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    UNIQUE (user_id, recipe_id)
    ) ENGINE=InnoDB;
    ";

    $pdo->exec($createFavouritesTable);
    echo "Favourites table created successfully or already exists.<br>";

    $createCommentsTable = "
    CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;
    ";

    $pdo->exec($createCommentsTable);
    echo "Comments table created successfully or already exists.<br>";

} catch (PDOException $e) {
    die("Database setup failed: " . $e->getMessage());
}

?>
