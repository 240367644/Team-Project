<?php
session_start();

// connect to database
$db = new PDO("mysql:host=localhost;dbname=cs2team49_orders;charset=utf8", "cs2team49", "TxxB1oKh6zkcPBjuycWZvO8oz");

$order_id = $_GET['id'];

$stmt = $db->prepare("
    SELECT o.order_id, o.status, o.created_at,
           u.username, u.email, u.phone, u.address, u.postcode
    FROM Orders o
    JOIN cs2team49_login_system.users u 
        ON o.user_id = u.user_id
    WHERE o.order_id = ?
");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("
    SELECT p.name, p.price, oi.quantity
    FROM order_items oi
    JOIN cs2team49_product.products p 
        ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($items as $item) {
    $total += $item['price'] * $item['quantity'];
}
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
            <a href="processOrders.php" class="back-btn">← Back</a>

            <div class="order-view-container">

                <h2>Order #<?= $order['order_id'] ?></h2>

                <div class="order-info">
                    <p><b>Name:</b> <?= $order['username'] ?></p>
                    <p><b>Email:</b> <?= $order['email'] ?></p>
                    <p><b>Phone:</b> <?= $order['phone'] ?></p>
                    <p><b>Address:</b> <?= $order['address'] ?> (<?= $order['postcode'] ?>)</p>
                    <p><b>Date:</b> <?= $order['created_at'] ?></p>
                    <p>
                        <b>Status:</b> 
                        <span class="order-status <?= strtolower($order['status']) ?>">
                            <?= $order['status'] ?>
                        </span>
                    </p>
                </div>

                <h3>Items</h3>

                <table class="order-items-table">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>

                    <?php foreach ($items as $item): 
                        $itemTotal = $item['price'] * $item['quantity'];
                    ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td>£<?= $item['price'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>£<?= $itemTotal ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <div class="order-total">
                    Total: £<?= $total ?>
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

    <script src="js/sidemenu.js"></script>
    
    </body>
</html>