<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$db_host = "localhost";
$db_name = "cs2team49_product";
$db_user = "cs2team49";
$db_pass = "TxxB1oKh6zkcPBjuycWZvO8oz";

try {
    $db = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8",
        $db_user,
        $db_pass
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Accom4U</title>
        <link rel="icon" type="image/png" href="images/A4U_logo.png">
        <link rel="stylesheet" href="../css/style.css?v=10">
    </head>

    <body>

        <div class="overlay" id="overlay" onclick="closeMenu()"></div>

    <header class="header">

        <div class="menu-icon" onclick="toggleMenu()">
            ☰
        </div>

        <div class="side-menu" id="sideMenu">
    <a href="profile.html">Profile</a>
            <a href="viewOrders.html">My Orders</a>
            <a href="wishlist.html">Wishlist</a>
            <a href="settings.html">Settings</a>
            <br>
            <div class="admin-menu">
                <a href="#" onclick="toggleAdmin()">Admin Panel ▾</a>

                <div class="submenu" id="subMenu">
                    <a href="processOrders.html">Process Orders</a>
                    <a href="customers.html">Customer Management</a>
                    <a href="inventory.php">Inventory Management</a>
                    <a href="reports.html">Reports</a>
                </div>
                </div>
    <br>
    <a href="logout.html">Logout</a>
</div>

        <div class="logo-header">
            <img src="images/A4U_logo.png" class="logo" alt="logo">
            <h1 class="title">Accom4U</h1>
        </div>

        <nav class="navibar">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="aboutus.html">About Us</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>

        <a class="basket-icon" href="basket.html">
            <img src="images/basket.png" class="basket-icon" alt="Basket">
        </a>
        <!-- Login/Logout link -->
        <a id="loginLink" class="login" href="login.html"><b>Log In</b></a>
    </header>


        <main class="product-main">

            <div class="filter-sidebar">
                <h3>Categories</h3>
                <button class="button-val" data-category="all">All</button>
                <button class="button-val" data-category="bedroom">Bedroom</button>
                <button class="button-val" data-category="kitchen">Kitchen</button>
                <button class="button-val" data-category="bathroom">Bathroom</button>
                <button class="button-val" data-category="desk-study">Desk & Study</button>
                <button class="button-val" data-category="decor-lighting">Decor & Lighting</button>
                <h3>Price</h3>
                <input type="number" id="min-price" placeholder="Min (£)">
                <input type="number" id="max-price" placeholder="Max (£)">
                <button id="price-filter-btn" class="button-val">Apply</button>
            </div>

            <div class="products-section">
                <div class="product-container">
                    <div class="search">
                        <input type="search" id="search-input" placeholder="Search...">
                        <button id="search-button">Search</button>
                    </div>

                    <div id="products-display">
                        <?php
                        $stmt = $db->prepare("SELECT * FROM products");
                        $stmt->execute();
                        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($products as $p) {
                            echo '
                            <a href="productDetails.php?id='.$p["id"].'" 
                            class="card '.$p["category"].'"
                            data-id="'.$p["id"].'"
                            data-name="'.$p["name"].'"
                            data-price="'.$p["price"].'"
                            data-description="'.$p["description"].'"
                            data-image="'.$p["image"].'">
                                <span class="wishlist-heart">♡</span>
                                <div class="image-container">
                                    <img src="'.$p["image"].'">
                                </div>
                                <div class="container">
                                    <h5 class="product-name">'.strtoupper($p["name"]).'</h5>
                                    <h6>£'.$p["price"].'</h6>
                                </div>
                            </a>';
                        }
                        ?>
                    </div>
                </div>

            </div>

        </main>

        <footer class="footer">
            <div class="footer-container">

                <div class="footer-column">
                    <h3>Accom4U</h3>
                </div>

                <div class="footer-column">
                    <h4>Quick Links</h4>
                    <a href="aboutus.html">About Us</a>
                    <a href="products.html">Products</a>
                    <a href="#">FAQ</a>
                    <a href="#">Shipping Info</a>
                </div>

                <div class="footer-column">
                    <h4>Customer Service</h4>
                    <a href="contact.html">Contact Us</a>
                    <a href="#">Returns</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms & Conditions</a>
                </div>

                <div class="footer-column">
                    <h4>Contact Us</h4>
                    <p>123 Commerce Street, Birmingham</p>
                    <p>+44 123 123 12312</p>
                    <p>accom4u@gmail.com</p>
                </div>

            </div>

            <hr>

            <div class="footer-bottom">
                Copyright © 2025 - 2026 Accom4U. All Rights Reserved.
            </div>
        </footer>

        <script src="js/products.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', async () => {
                try {
                    const res = await fetch('session.php', { credentials: 'include' });
                    const data = await res.json();

                    const loginLink = document.getElementById('loginLink');
                    if (data.loggedIn) {
                        loginLink.href = 'logout.php';
                        loginLink.innerHTML = '<b>Logout</b>';
                    }
                } catch (err) {
                    console.error('Error checking session:', err);
                }
            });
        </script>

    <script src="js/sidemenu.js"></script>
    </body>
</html>