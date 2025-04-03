/* =====================================
   Logo Change to Menu Icon + Open Menu
========================================= */

document.addEventListener("DOMContentLoaded", function () {
    const logoImg = document.getElementById("logo-img");
    const sidebar = document.getElementById("sidebar");

    // Store original logo and menu icon URLs
    const menuIcon = logoImg.getAttribute("data-menu-icon");
    const logoIcon = logoImg.getAttribute("data-logo");

    if (logoImg) {
        logoImg.addEventListener("mouseover", function () {
            if (sidebar.style.left !== "0px") {
                this.src = menuIcon; // Change to menu icon on hover if sidebar is closed
            }
        });

        logoImg.addEventListener("mouseout", function () {
            if (sidebar.style.left == "0px") return;
            this.src = logoIcon; // Keep menu icon if sidebar is open
        });

        logoImg.addEventListener("click", function () {
            if (sidebar.style.left === "0px") {
                sidebar.style.left = "-250px"; // Close sidebar
                this.src = logoIcon; // Revert to original logo
            } else {
                sidebar.style.left = "0"; // Open sidebar
                this.src = menuIcon; // Keep menu icon
            }
        });
    }
});
