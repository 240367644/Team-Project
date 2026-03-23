<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// connect to database
$db_host = "localhost";
$db_name = "cs2team49_orders";
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

$user_id = $_GET['id'];

$stmt = $db->prepare("
    SELECT * 
    FROM cs2team49_login_system.users
    WHERE user_id = ?
");
$stmt->execute([$user_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("
    SELECT o.order_id, o.status, o.created_at,
           SUM(p.price * oi.quantity) AS total
    FROM Orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN cs2team49_product.products p ON oi.product_id = p.id
    WHERE o.user_id = ?
    GROUP BY o.order_id
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accom4U</title>
        <link rel="icon" type="image/png" href="images/A4U_logo.png">
        <link rel="stylesheet" href="/css/style.css?v=2">
    </head>

    <body>

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
        <!-- Login/Logout link -->
        <a id="loginLink" class="login" href="login.html"><b>Log In</b></a>
    </header>

        <main class="admin-main">
            <a href="customers.php" class="back-btn">← Back</a>
                <div class="order-view-container">

                    <h2>Customer #<?= $customer['user_id'] ?></h2>

                    <div class="order-info">
                        <p><b>Name:</b> <?= $customer['username'] ?></p>
                        <p><b>Email:</b> <?= $customer['email'] ?></p>
                        <p><b>Phone:</b> <?= $customer['phone'] ?></p>
                        <p><b>Address:</b> <?= $customer['address'] ?> (<?= $customer['postcode'] ?>)</p>
                        <p><b>Role:</b> <?= $customer['role'] ?></p>
                    </div>

                    <h3>Orders</h3>

                    <table class="order-items-table">
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>

                        <?php foreach ($orders as $o): ?>
                        <tr>
                            <td>#<?= $o['order_id'] ?></td>
                            <td><?= $o['created_at'] ?></td>
                            <td class="<?= strtolower($o['status']) ?>">
                                <?= $o['status'] ?>
                            </td>
                            <td>£<?= $o['total'] ?></td>
                        </tr>
                        <?php endforeach; ?>

                    </table>

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

    <script src="js/sidemenu.js"></script>
    
    </body>
</html>