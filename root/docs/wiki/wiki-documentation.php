<?php
require_once('../../config/constants.php');
session_start();

$theme = $_SESSION['theme'] ?? 'theme1';
$themeSuffix = $theme === 'theme2' ? '2' : ($theme === 'theme3' ? '3' : '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <meta name="description" content="RecipeHub is your go-to platform for discovering, sharing, and organizing delicious recipes from around the world. Create your own digital recipe book and connect with fellow food lovers!">
    <meta name="keywords" content="recipes, cooking, food, meal planning, digital cookbook, share recipes, best recipes, easy cooking">
    <meta name="author" content="RecipeHub">
    <meta name="robots" content="index, follow"> <!-- Allows search engines to index and follow links -->

    <meta property="og:title" content="RecipeHub - Discover & Share Recipes">
    <meta property="og:description" content="Join RecipeHub and explore a world of delicious recipes. Share your favourites and organize your own recipe collection!">
    <meta property="og:image" content="<?php echo IMG_URL; ?>logo.png">
    <meta property="og:url" content="https://khan661.myweb.cs.uwindsor.ca/COMP-3077-Final-Project/root/public/index.php">
    <meta property="og:type" content="website"> <!-- Enhance link previews when shared on Facebook, LinkedIn, and other platforms -->

    <link rel="canonical" href="https://khan661.myweb.cs.uwindsor.ca/COMP-3077-Final-Project/root/public/index.php"> <!-- Prevent duplicate content issues in search rankings -->

    <link rel="icon" type="image/x-icon" href="<?php echo IMG_URL; ?>favicon.ico"> <!-- Favicon of different sizes for better browser support -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo IMG_URL; ?>favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo IMG_URL; ?>favicon-16x16.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Just+Another+Hand&display=swap" rel="stylesheet">

    <title>RecipeHub Wiki | Project Documentation</title>

    <link rel="stylesheet" href="<?php echo CSS_URL; ?>?v=<?php echo time(); ?>"> <!-- Disable caching of style.css so I can properly load the changes I make -->
    <link rel="stylesheet" href="<?php echo THEME_URL . $theme . '.css'; ?>?v=<?php echo time(); ?>">
    <script src="<?php echo JS_URL; ?>script.js?v=<?php echo time(); ?>"></script>
</head>
<body>

<?php include_once('../../assets/includes/navbar.php'); ?>

<div class="hero-section less-hero">
    <h1>Project Documentation</h1>
    <p>Set up RecipeHub on a different server, explore the file structure, and learn about the database schema.</p>
</div>

<main class="wiki-guide">

    <nav class="wiki-nav">
        <h2>Contents</h2>
        <ul>
            <li><a href="#requirements">1. Requirements</a></li>
            <li><a href="#install">2. Installation Steps</a></li>
            <li><a href="#structure">3. Folder Structure</a></li>
            <li><a href="#schema">4. Database Schema</a></li>
            <li><a href="#user">5. User Features</a></li>
            <li><a href="#admin">7. Admin Features</a></li>
            <li><a href="#api">8. API Integration</a></li>
            <li><a href="#custom">9. Customization</a></li>
        </ul>
    </nav>

    <section class="wiki-section" id="requirements">
        <h2>1. Requirements</h2>
        <p>RecipeHub was built with HTML for front-end, CSS for UI styling, PHP and JS for back-end, and uses a MySQL database.
            <br>To build and host RecipeHub, you would need:
        </p>
        <ul>
            <li>PHP 8.0 or higher</li>
            <li>MySQL / MariaDB</li>
            <li>XAMPP, MAMP, or live server</li>
            <li>Internet access (for Spoonacular API)</li>
        </ul>
    </section>

    <section class="wiki-section" id="install">
        <h2>2. Installation Steps</h2>
        <ol>
            <li>Start Apache and MySQL.</li>
            <li>Clone or download the project into your `htdocs/` folder (XAMPP) or your web host's public directory.</li>
            <li>Create your RecipeHub database in phpMyAdmin.</li>
            <li>Open your browser and run the PHP script: <code>/config/db_setup.php</code> to create the necessary tables.</li>
            <li>Update DB credentials in <code>/config/db_config.php</code>.</li>
            <li>Edit <code>/config/constants.php</code> to match your server's URL and folder paths.</li>
            <li>Include your Spoonacular API key in the PHP script: <code>/assets/scripts/php/fetch_api_recipes.php</code>.</li>
            <li>Open your browser and open <code>/assets/scripts/php/fetch_api_recipes.php</code> to populate the resipes table with Spoonacular recipes.</li>
            <li>Access <code>http://localhost/your-folder/public/index.php</code> in your browser.</li>
        </ol>
    </section>

    <section class="wiki-section" id="structure">
        <h2>3. Folder Structure</h2>
        <p>The RecipeHub folder structure is organized for modularity, scalability, and ease of development. Assets, configurations, and public-facing scripts are clearly separated to support team collaboration, maintain clean code practices, and simplify deployment.</p>
        <pre><code><br>
/root
│
├── /assets                      → Static files (media, scripts, styles)
│   ├── /img                     → Image assets
│   │   ├── /profiles            → User profile pictures
│   │   ├── /thumbnails          → Recipe thumbnails
│   │   └── /wiki                → Wiki-related images
│   ├── /includes                → PHP snippet files (navbar, footer, etc.)
│   ├── /scripts
│   │   ├── /js                  → JavaScript script
│   │   └── /php                 → Reusable backend PHP scripts
│   └── /styles
│       ├── /templates           → Shared CSS templates (e.g., header, sidebar)
│       └── /themes              → Theme-specific stylesheets
│
├── /config                      → Site and database configuration
│   ├── constants.php            → URL paths and global constants
│   ├── db_config.php            → Database connection settings
│   └── db_setup.php             → Auto-create database schema
│
├── /docs                        → Project documentation
│   └── /wiki                    → All wiki/help pages
│
├── /public                      → Public-facing entry points
│   ├── /admin                   → Admin-only tools and dashboard
│   ├── /recipe                  → Add/view/edit recipes
│   ├── /user                    → Profile, settings, and user pages
│   ├── about.php                → About the website
│   ├── contact.php              → Contact website creator
│   ├── index.php                → Homepage
│   ├── login.php                → Login form
│   └── register.php             → Registration form
└── 

</code></pre>
    </section>

    <section class="wiki-section" id="schema">
        <h2>4. Database Schema (Simplified)</h2>

        <p><strong>Table: users</strong>
            <br>Stores all user account information including login credentials, profile details, and admin status.
        </p>
        <ul>
            <li><code>id</code> (INT, PK, AUTO_INCREMENT)</li>
            <li><code>first_name</code>, <code>last_name</code> (VARCHAR)</li>
            <li><code>username</code> (UNIQUE), <code>email</code> (UNIQUE)</li>
            <li><code>password</code> (hashed), <code>profile_pic</code> (image path)</li>
            <li><code>about_me</code> (TEXT), <code>is_admin</code> (BOOLEAN)</li>
            <li><code>created_at</code> (TIMESTAMP)</li>
        </ul><br>

        <p><strong>Table: recipes</strong>
            <br>Contains all user-submitted and API-sourced recipes, including dietary filters, metadata, and ownership.
        </p>
        <ul>
            <li><code>id</code> (INT, PK, AUTO_INCREMENT)</li>
            <li><code>created_by</code> (FK → users.id)</li>
            <li><code>title</code>, <code>image_url</code>, <code>cuisine_type</code>, <code>difficulty</code></li>
            <li><code>vegetarian</code>, <code>gluten_free</code>, <code>dairy_free</code></li>
            <li><code>meal_type</code> (ENUM), <code>servings</code>, <code>ready_in_minutes</code></li>
            <li><code>preparation_time</code>, <code>cooking_time</code></li>
            <li><code>ingredients</code>, <code>instructions</code> (TEXT)</li>
            <li><code>is_api</code> (BOOLEAN), <code>is_admin</code> (BOOLEAN)</li>
            <li><code>favourite_count</code> (INT), <code>created_at</code> (TIMESTAMP)</li>
        </ul><br>

        <p><strong>Table: favourites</strong> 
            <br>Tracks which users have favorited which recipes to enable personalized recipe collections.
        </p>
        <ul>
            <li><code>id</code> (INT, PK, AUTO_INCREMENT)</li>
            <li><code>user_id</code> (FK → users.id)</li>
            <li><code>recipe_id</code> (FK → recipes.id)</li>
            <li><code>favourited_at</code> (TIMESTAMP)</li>
            <li><strong>UNIQUE</strong> constraint on <code>(user_id, recipe_id)</code></li>
        </ul><br>

        <p><strong>Table: comments</strong>
        <br>Stores user comments on recipes to support community feedback and discussion.
        </p>
        <ul>
            <li><code>id</code> (INT, PK, AUTO_INCREMENT)</li>
            <li><code>user_id</code> (FK → users.id)</li>
            <li><code>recipe_id</code> (FK → recipes.id)</li>
            <li><code>comment</code> (TEXT), <code>created_at</code> (TIMESTAMP)</li>
        </ul>
    </section>


    <section class="wiki-section" id="user">
        <h2>5. User Features</h2>
        <ul>
            <li>Create an account and log in to access your dashboard</li>
            <li>Post your own recipes with ingredients, instructions, and thumbnail image</li>
            <li>Browse and search recipes submitted by other users or pulled from the Spoonacular API</li>
            <li>Favorite recipes you like and view them on your profile</li>
            <li>Comment on other users' recipes to give feedback or ask questions</li>
            <li>Edit your profile, update your “About Me”, and upload a profile picture</li>
            <li>Switch between visual themes (e.g., pink, blue, green) for a customized experience</li>
            <li>Delete your account permanently through the Settings page</li>
        </ul>
    </section>

    <section class="wiki-section" id="admin">
        <h2>6. Admin Features</h2>
        <ul>
            <li>Manage users: search, view, delete</li>
            <li>Manage recipes: search, view, and edit/delete inappropriate content</li>
            <li>View site health and service statuses on the Monitor page</li>
            <li>Track user and recipe activity via the monitor page graph</li>
            <li>Delete user comments on recipes</li>
        </ul>
    </section>

    <section class="wiki-section" id="api">
        <h2>7. API Integration</h2>
        <p>This app uses the <a href="https://spoonacular.com/food-api" target="_blank">Spoonacular API</a> to fetch recipes for the Explore page.</p>
        <p>Your API key should be saved in your fetch_api_recipes.php script and referenced when needed. Avoid exposing it in public repositories.</p>
    </section>

    <section class="wiki-section" id="custom">
        <h2>8. Customization</h2>
        <ul>
            <li>Change themes in <code>/public/user/user-settings.php</code></li>
            <li>Edit navigation or sidebar menu structure via <code>assets/includes/navbar.php and assets/includes/sidebar.php</code></li>
            <li>Enable email/OAuth by customizing login and register forms</li>
            <li>Update constants like URLs and asset paths in <code>constants.php</code></li>
        </ul>
    </section>

</main>


<?php include_once('../../assets/includes/footer.php'); ?>
</body>
</html>
