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

                <a href="<?php echo PUBLIC_URL; ?>index.php" class="logo">RecipeHub</a>
            </div>

            <ul class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (!empty($_SESSION['is_admin'])): ?>
                        <li><a href="<?php echo ADMIN_URL; ?>dashboard.php">Dashboard</a></li>
                        <li><a href="<?php echo ADMIN_URL; ?>monitor.php">Systems Monitor</a></li>
                        <li><a href="<?php echo USER_URL; ?>user-settings.php">Settings</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo USER_URL; ?>explore.php">Explore</a></li>
                        <li><a href="<?php echo USER_URL; ?>dashboard.php">My Dashboard</a></li>
                        <li><a href="<?php echo USER_URL; ?>profile.php">My Profile</a></li>
                        <li><a href="<?php echo USER_URL; ?>user-settings.php">Settings</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo PHP_URL; ?>logout_submit.php">Log Out</a></li>
                <?php else: ?>
                    <li><a href="<?php echo PUBLIC_URL; ?>login.php">Log In</a></li>
                    <li><a href="<?php echo PUBLIC_URL; ?>register.php">Register</a></li>
                <?php endif; ?>
            </ul>

            <!-- Sidebar -->
            <?php include_once('sidebar.php'); ?>
        </div>
    </nav>
</header>
