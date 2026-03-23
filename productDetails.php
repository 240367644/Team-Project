<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// connect to database
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

if (!isset($_GET['id'])) {
    die("No product ID");
}

$id = $_GET['id'];

$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found");
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

    <body class="about-body">

        <div class="overlay" id="overlay" onclick="closeMenu()"></div>

        <header class="header">

            <div class="menu-icon" onclick="toggleMenu()">
                ☰
            </div>

            <div class="side-menu" id="sideMenu">
                <a href="profile.html">Profile</a>
                <a href="myOrders.php">My Orders</a>
                <a href="wishlist.php">Wishlist</a>
                <a href="settings.html">Settings</a>
                <br>
                <div class="admin-menu">
                    <a href="#" onclick="toggleAdmin()">Admin Panel ▾</a>

                    <div class="submenu" id="subMenu">
                        <a href="processOrders.php">Process Orders</a>
                        <a href="customers.php">Customer Management</a>
                        <a href="inventory.php">Inventory Management</a>
                        <a href="reports.php">Reports</a>
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
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>

            <a class="basket-icon" href="basket.html">
                <img src="images/basket.png" class="basket-icon" alt="Basket">
            </a>

            <a id="loginLink" class="login" href="login.html"><b>Log In</b></a>
        </header>

        <br><br><br>

        <main>

            <div class="product-view">

                <div class="product-left">
                    <img src="<?php echo $product['image']; ?>" alt="Desk Chair">
                </div>

                <div class="product-right">
                    <p class="product-breadcrumb">Home / Products / <?php echo $product['name']; ?></p>
                    <h1 class="product-title"><?php echo $product['name']; ?></h1>
                    <p class="product-price">£<?php echo $product['price']; ?></p>

                    <div class="product-actions">
                        <input type="number" value="1" min="1" class="qty-box">
                        <button class="addToCart">Add to Basket</button>
                        <button class="wishlist-btn">♡</button>
                    </div>

                    <div class="product-details">
                        <h3>Product Details</h3>
                        <p>
                        <?php echo $product['description']; ?>
                        </p>
                    </div>
                </div>
            </div>

        </main>

        <br><br><br>

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


         <script>
         // Dynamic login/logout link based on session
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
            document.addEventListener('DOMContentLoaded', () => {

            // add to cart button
            document.querySelector('.addToCart').addEventListener('click', async () => {

                const productId = <?php echo $product['id']; ?>;
                const quantity = document.querySelector('.qty-box').value;
                const formData = new FormData();
                formData.append('product_id', productId);
                formData.append('quantity', quantity);

                try {
                    const res = await fetch('basket.php?path=addItem', {
                        method: 'POST',
                        body: formData,
                        credentials: 'include'
                    });

                    const data = await res.json();
                    alert(data.message);

                } catch (err) {
                    console.error(err);
                    alert('Error adding to basket');
                }
            });

        });

        // wishlist button
        document.querySelector('.wishlist-btn').addEventListener('click', async () => {
            const productId = <?php echo $product['id']; ?>;

            const formData = new FormData();
            formData.append('product_id', productId);
			formData.append('quantity', quantity);

            const res = await fetch('wishlist.php?path=add', {
                method: 'POST',
                body: formData,
                credentials: 'include'
            });

            const data = await res.json();
            alert(data.message);

            window.location.href = "wishlist.php";
        });
    </script>

    <script src="js/sidemenu.js"></script>
    </body>
</html>