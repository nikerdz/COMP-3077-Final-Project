<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Navigation Bar -->
<header>
    <nav class="navbar">
        <div class="container">

            <div class="logo-container">
            <img 
                src="<?php echo IMG_URL; ?>logo.png" 
                alt="RecipeHub Logo"
                id="logo-img"
                data-menu-icon="<?php echo IMG_URL; ?>menu.png"
                data-logo="<?php echo IMG_URL; ?>logo.png">

                <a href="index.php" class="logo">RecipeHub</a>
            </div>

            <ul class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="user/explore.php">Explore</a></li>
                    <li><a href="user/profile.php">Profile</a></li>
                    <li><a href="user/dashboard.php">Dashboard</a></li>
                    <li><a href="<?php echo PHP_URL; ?>logout_submit.php">Log Out</a></li>
                <?php else: ?>
                    <li><a href="login.php">Log In</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>

            <!-- Sidebar -->
            <?php include_once('sidebar.php'); ?>
    </nav>
</header>