/* =====================================
   Logo Change to Menu Icon + Open Menu
========================================= */

document.addEventListener("DOMContentLoaded", function () {
    const logoImg = document.getElementById("logo-img");
    const sidebar = document.getElementById("sidebar");

    const menuIcon = logoImg.getAttribute("data-menu-icon");
    const logoIcon = logoImg.getAttribute("data-logo");

    function openSidebar() {
        sidebar.style.left = "0";
        logoImg.src = menuIcon;
    }

    function closeSidebar() {
        sidebar.style.left = "-250px";
        logoImg.src = logoIcon;
    }

    if (logoImg) {
        logoImg.addEventListener("mouseover", function () {
            if (sidebar.style.left !== "0px") {
                this.src = menuIcon;
            }
        });

        logoImg.addEventListener("mouseout", function () {
            if (sidebar.style.left !== "0px") {
                this.src = logoIcon;
            }
        });

        logoImg.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent click from bubbling to document
            if (sidebar.style.left === "0px") {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    // Close sidebar if click occurs outside of it or the logo
    document.addEventListener("click", function (event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnLogo = logoImg.contains(event.target);

        if (!isClickInsideSidebar && !isClickOnLogo && sidebar.style.left === "0px") {
            closeSidebar();
        }
    });
});

