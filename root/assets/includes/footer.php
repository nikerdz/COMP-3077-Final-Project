<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<footer>
    <div class="container">
        <p>&copy; 2025 RecipeHub. All rights reserved.</p>

        <ul class="nav-links">
            <li><a href="about.php">About</a></li>
            <li><a href="<?php echo WIKI_URL; ?>wiki-home.php">Help</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</footer>
