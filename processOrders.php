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

$stmt = $db->prepare("
    SELECT o.order_id, o.user_id, o.status, o.created_at,
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
");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <h2 class="page-title">Order Processing</h2>
        
        <div class="order-controls">
            
            <input type="text" id="searchInput" placeholder="Search orders..." class="search-orders">
            <select id="statusFilter" class="order-filter">
                <option>All Orders</option>
                <option>Pending</option>
                <option>Processing</option>
                <option>Shipped</option>
                <option>Cancelled</option>
            </select>
        </div>
        
        <div class="orders-container">
            
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($orders as $o) {
                        echo '
                        <tr>
                            <td>#'.$o["order_id"].'</td>
                            <td>'.$o["username"].'</td>
                            <td>'.$o["created_at"].'</td>
                            <td class="'.strtolower($o["status"]).'">'.$o["status"].'</td>
                            <td>£'.$o["total_price"].'</td>
                            <td>
                                '.($o["status"] == "Pending" ? '
                                    <button class="approve" onclick="updateOrder('.$o["order_id"].', \'Processing\')">Approve</button>
                                    <button class="cancel" onclick="updateOrder('.$o["order_id"].', \'Cancelled\')">Cancel</button>
                                ' : ($o["status"] == "Processing" ? '
                                    <button class="ship" onclick="updateOrder('.$o["order_id"].', \'Shipped\')">Ship</button>
                                ' : '
                                    <a href="viewOrder.php?id='.$o["order_id"].'">
                                        <button class="view">View</button>
                                    </a>
                                ')).'
                            </td>
                        </tr>';
                    }
                    ?>
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
    <script src="js/orders.js"></script>
</body>
</html>
