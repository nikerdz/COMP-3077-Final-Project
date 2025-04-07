# 📦 Installation Guide and Documentation for RecipeHub

**Last Updated:** 2025-04-07  
RecipeHub is a dynamic recipe-sharing web application built using PHP, MySQL, HTML/CSS, and JavaScript. This document will help you install and run it locally or on a web host.

---

## ✅ 1. Requirements

Before installing RecipeHub, ensure your environment includes the following:

- PHP 8.0 or higher
- MySQL / MariaDB
- XAMPP, MAMP, or live server
- Internet connection (required for Spoonacular API access)

---

## ⚙️ 2. Installation Steps

1. **Start your local server** (Apache + MySQL via XAMPP/MAMP).
2. **Clone or download** this project into your `htdocs/` directory (for XAMPP) or your server’s public directory.
3. **Create the database:**
   - Open [phpMyAdmin](http://localhost/phpmyadmin).
   - Create a new database (e.g., `COMP-3077-Final-Project`).
4. **Edit your credentials:**
   - Open `/config/db_config.php` and enter your MySQL DB username and password.
5. **Generate tables and default data:**
   - Visit `/config/db_setup.php` in your browser to auto-create tables and default users.
6. **Adjust path constants:**
   - In `/config/constants.php`, set your `BASE_URL`, `IMG_URL`, etc., to match your folder structure.
7. **Add your Spoonacular API key:**
   - Open `/assets/scripts/php/fetch_api_recipes.php` and insert your key.
8. **Fetch API Recipes:**
   - Visit `/assets/scripts/php/fetch_api_recipes.php` in your browser to load Spoonacular recipes into your database.
9. **Launch the app:**
   - Open your browser and visit `http://localhost/your-folder/public/index.php`.

---

## 🗂️ 3. Folder Structure

RecipeHub is structured to support modular development, scalability, and maintainability:

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


---

## 🛢️ 4. Database Schema (Simplified)

### **`users`** – User profiles and credentials  
- `id`, `first_name`, `last_name`, `username`, `email`, `password`, `profile_pic`, `about_me`, `is_admin`, `created_at`

### **`recipes`** – User/API recipe content  
- `id`, `created_by`, `title`, `image_url`, `cuisine_type`, `difficulty`, `vegetarian`, `gluten_free`, `dairy_free`, `meal_type`, `servings`, `ready_in_minutes`, `preparation_time`, `cooking_time`, `ingredients`, `instructions`, `is_api`, `is_admin`, `favourite_count`, `created_at`

### **`favourites`** – Track favorited recipes  
- `user_id`, `recipe_id`, `favourited_at`, (unique constraint on `user_id` + `recipe_id`)

### **`comments`** – User discussion  
- `user_id`, `recipe_id`, `comment`, `created_at`

---

## 👤 5. User Features

- Register, log in, and create a profile
- Post, edit, and manage your own recipes
- Browse user- and API-submitted recipes
- Favorite and comment on recipes
- Customize your profile and theme
- Permanently delete your account

---

## 🛠️ 6. Admin Features

- View/delete user accounts
- Moderate all recipes and comments
- Monitor service health and system metrics
- View graphs of user and recipe activity

---

## 🌐 7. API Integration

RecipeHub uses the [Spoonacular API](https://spoonacular.com/food-api) to display external recipes.  

- Insert your key in `/assets/scripts/php/fetch_api_recipes.php`
- **DO NOT** expose this key in public repositories

---

## 🎨 8. Customization

- Themes can be changed in `user-settings.php`
- Navbar and sidebar templates live in `/assets/includes/`
- SEO/meta tag support is included in the `<head>` of each page
- You can expand authentication to support email, OAuth, etc.

---

**Happy Cooking and Coding! 🥘👩‍💻**