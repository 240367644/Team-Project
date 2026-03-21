<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

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

$stmt = $db->query("
    SELECT COUNT(*) AS total 
    FROM cs2team49_product.products
");
$totalProducts = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $db->query("
    SELECT COUNT(*) AS total 
    FROM Orders 
    WHERE DATE(created_at) = CURDATE()
");
$ordersToday = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $db->query("
    SELECT COUNT(*) AS total 
    FROM Orders 
    WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)
");
$ordersWeek = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $db->query("
    SELECT COUNT(*) as total 
    FROM cs2team49_product.products 
    WHERE stock < 10 AND stock > 0
");
$lowStock = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$stmt = $db->query("
    SELECT name, stock 
    FROM cs2team49_product.products
");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare("
    SELECT o.order_id, o.created_at, o.status,
           u.username,
           SUM(p.price * oi.quantity) AS total_price
    FROM Orders o
    JOIN cs2team49_login_system.users u 
        ON o.user_id = u.user_id
    JOIN order_items oi 
        ON o.order_id = oi.order_id
    JOIN cs2team49_product.products p 
        ON oi.product_id = p.id
    GROUP BY o.order_id
    ORDER BY o.created_at DESC
    LIMIT 5
");
$stmt->execute();
$recentOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Accom4U</title>
    <link rel="icon" type="image/png" href="images/A4U_logo.png">
    <link rel="stylesheet" href="css/style.css">
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
                    <a href="inventory.html">Inventory Management</a>
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

    <main class="admin-main">

        <div class="admin-top-menu">
            <a href="processOrders.html">Process Orders</a>
            <a href="customers.html">Customer Management</a>
            <a href="inventory.html">Inventory Management</a>
            <a href="reports.html">Reports</a>
        </div>

        <br><br>

        <h2 class="page-title">Reports & Monitoring</h2>

        <div class="report-cards">

            <div class="report-card">
                <h3>Total Products</h3>
                <p class="report-number"><?= $totalProducts ?></p>
            </div>

            <div class="report-card">
                <h3>Low Stock Items</h3>
                <p class="report-number warning"><?= $lowStock ?></p>
            </div>

            <div class="report-card">
                <h3>Orders Today</h3>
                <p class="report-number"><?= $ordersToday ?></p>

            </div>

            <div class="report-card">
                <h3>Orders This Week</h3>
                <p class="report-number"><?= $ordersWeek ?></p>
            </div>

        </div>

        <h3 class="section-title">Stock Level Report</h3>

        <div class="table-container">

            <table class="report-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Stock Level</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($products as $p): 

                    if ($p['stock'] == 0) {
                        $status = "Out of Stock";
                        $class = "out-stock";
                    } elseif ($p['stock'] < 10) {
                        $status = "Low Stock";
                        $class = "low-stock";
                    } else {
                        $status = "In Stock";
                        $class = "in-stock";
                    }
                ?>

                <tr>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td class="<?= $class ?>"><?= $status ?></td>
                </tr>

                <?php endforeach; ?>
                </tbody>
            </table>

        </div>


        <h3 class="section-title">Recent Orders</h3>

        <div class="table-container">

            <table class="report-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($recentOrders as $order): ?>

                <tr>
                    <td>#<?= $order['order_id'] ?></td>
                    <td><?= htmlspecialchars($order['username']) ?></td>
                    <td><?= date("d M Y", strtotime($order['created_at'])) ?></td>
                    <td class="<?= strtolower($order['status']) ?>"><?= $order['status'] ?></td>
                    <td>£<?= number_format($order['total_price'], 2) ?></td>
                </tr>

                <?php endforeach; ?>
                </tbody>
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
                <a href="#">About Us</a>
                <a href="#">Products</a>
                <a href="#">FAQ</a>
                <a href="#">Shipping Info</a>
            </div>

            <div class="footer-column">
                <h4>Customer Service</h4>
                <a href="#">Contact Us</a>
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
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const res = await fetch('session.php');
                const data = await res.json();

                const loginLink = document.getElementById('loginLink');

                if(data.loggedIn) {
                    loginLink.href = 'logout.php';
                    loginLink.innerHTML = '<b>Logout</b>';
                }
            } catch(err) {
                console.error('Error checking session:', err);
            }
        });
    </script>

    <script src="js/sidemenu.js"></script>

</body>
</html>
