<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// connect to database
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
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    // add
    if ($data['action'] === 'add') {

        if (!isset($_SESSION['user_id'])) {
            echo "not_logged_in";
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $rating = $data['rating'];
        $text = $data['text'];

        $stmt = $db->prepare("INSERT INTO reviews (user_id, rating, text) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $rating, $text]);

        echo "success";
        exit();
    }

    // delete
    if ($data['action'] === 'delete') {

        if (!isset($_SESSION['user_id'])) {
            exit();
        }

        $review_id = $data['id'];
        $user_id = $_SESSION['user_id'];

        $stmt = $db->prepare("DELETE FROM reviews WHERE id=? AND user_id=?");
        $stmt->execute([$review_id, $user_id]);

        echo "deleted";
        exit();
    }
}
//get
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['reviews'])) {

    $currentUser = $_SESSION['user_id'] ?? null;

    $sql = "SELECT reviews.*, users.username 
            FROM reviews 
            JOIN users ON reviews.user_id = users.user_id
            ORDER BY created_at DESC";

    $stmt = $db->query($sql);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($reviews as &$row) {
        $row['isOwner'] = ($currentUser == $row['user_id']);
    }

    echo json_encode($reviews);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reviews | Accom4U</title>

    <link rel="icon" type="image/png" href="images/A4U_logo.png">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

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
                <li><a href="reviews.php">Reviews</a></li>
            </ul>
        </nav>

        <a class="basket-icon" href="basket.html">
            <img src="images/basket.png" class="basket-icon" alt="Basket">
        </a>
        <!-- Login/Logout link -->
        <a id="loginLink" class="login" href="login.html"><b>Log In</b></a>
    </header>


<main class="reviews-page">

    <h2>Customer Reviews</h2>

    <div class="review-form">

        <select id="review-rating">
            <option value="5">⭐⭐⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="2">⭐⭐</option>
            <option value="1">⭐</option>
        </select>

        <textarea id="review-text" placeholder="Write your review"></textarea>

        <button type="button" id="submit-review">Submit Review</button>

    </div>

    <div id="reviews-display"></div>

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
        // login session
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

<script src="js/reviews.js"></script>
<script src="js/sidemenu.js"></script>

</body>
</html>