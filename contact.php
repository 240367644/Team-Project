<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $db_host = "localhost";
    $db_name = "cs2team49_login_system";
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
        die("Database error: " . $e->getMessage());
    }

    $user_id = $_SESSION['user_id'] ?? null;

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($name) && !empty($email) && !empty($message)) {

        $stmt = $db->prepare("
            INSERT INTO contact_messages (user_id, name, email, message)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$user_id, $name, $email, $message]);

        echo "<script>alert('Message sent!');</script>";
    }
}
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

    <main>
        <div class="contact-container">
            <div class="contact-left">
                <img src="images/contact_image.jpg" width="30%" height="30%" alt="">
            </div>

            <form method="POST" class="contact-right">
                <div class="contact-right-title">
                    <h2>Get in Touch</h2>
                    <hr>
                    <p>If you have any enquiries, email us at info@accom4u.com<br>
                        or use the contact form below!</p>
                    <hr>
                </div>

                <!-- Added IDs for JS targeting -->
                <input type="text" id="contactName" name="name" placeholder="Enter Name" class="contact-inputs" required>
                <input type="email" id="contactEmail" name="email" placeholder="Enter Email" class="contact-inputs" required>
                <textarea name="message" placeholder="Enter Message" class="contact-inputs" required></textarea>
                <button type="submit">Submit</button>
            </form>
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

    <script>
        // Dynamic login/logout link based on session
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const res = await fetch('session.php', { credentials: 'include' });
                const data = await res.json();

                const loginLink = document.getElementById('loginlink'); // match ID

                if (data.loggedIn) {
                    loginLink.href = 'logout.php';
                    loginLink.innerHTML = '<b>Logout</b>';
                }
            } catch (err) {
                console.error('Error checking session:', err);
            }
        });

        // Pre-fill user info when the page loads
        async function fetchUserInfo() {
            try {
                const res = await fetch("database_setup.php?path=getUserInfo", {
                    method: "GET",
                    headers: { "Content-Type": "application/json" },
                    credentials: "include"
                });

                const data = await res.json();

                if (data.status === "success") {
                    document.getElementById("contactName").value = data.username || '';
                    document.getElementById("contactEmail").value = data.email || '';
                } else {
                    console.warn(data.message);
                }
            } catch (err) {
                console.error("Error fetching user info:", err);
            }
        }

        window.addEventListener("DOMContentLoaded", fetchUserInfo);
    </script>

    <script src="js/sidemenu.js"></script>
</body>
</html>
