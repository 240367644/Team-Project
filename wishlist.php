<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$db = new PDO(
    "mysql:host=localhost;dbname=cs2team49_product;charset=utf8",
    "cs2team49",
    "TxxB1oKh6zkcPBjuycWZvO8oz"
);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['path']) && $_GET['path'] === 'add') {

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["message" => "Please login"]);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $check = $db->prepare("SELECT * FROM wishlist WHERE user_id=? AND product_id=?");
    $check->execute([$user_id, $product_id]);

    if ($check->rowCount() == 0) {
        $stmt = $db->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $product_id]);
        echo json_encode(["message" => "Added to wishlist"]);
    } else {
        echo json_encode(["message" => "Already in wishlist"]);
    }

    exit;
}

if (isset($_GET['path']) && $_GET['path'] === 'remove') {

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["message" => "Not logged in"]);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    $stmt = $db->prepare("DELETE FROM wishlist WHERE user_id=? AND product_id=?");
    $stmt->execute([$user_id, $product_id]);

    echo json_encode(["message" => "Removed from wishlist"]);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    $items = [];
} else {
    $user_id = $_SESSION['user_id'];

    $stmt = $db->prepare("
        SELECT p.* 
        FROM wishlist w
        JOIN products p ON w.product_id = p.id
        WHERE w.user_id = ?
    ");
    $stmt->execute([$user_id]);

    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Wishlist | Accom4U</title>

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
            <a href="viewOrders.html">My Orders</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="settings.html">Settings</a>
            <br>
            <div class="admin-menu">
                <a href="#" onclick="toggleAdmin()">Admin Panel ▾</a>

                <div class="submenu" id="subMenu">
                    <a href="processOrders.html">Process Orders</a>
                    <a href="customers.html">Customer Management</a>
                    <a href="inventory.html">Inventory Management</a>
                    <a href="stock.html">Stock Control</a>
                    <a href="reports.html">Reports</a>
                </div>
            </div>
            <br>
            <a href="logout.php">Logout</a>
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

        <a id="loginLink" class="login" href="login.html"><b>Log In</b></a>
    </header>

    <main>
        <section class="wishlist-page">

            <h2>My Wishlist</h2>

            <?php if (count($items) === 0): ?>
                <p>Your wishlist is empty.</p>
            <?php endif; ?>

            <div class="wishlist-container">

                <?php foreach ($items as $item): ?>
                    <div class="product-card">
                        <span class="wishlist-star">★</span>
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">

                        <h3><?php echo $item['name']; ?></h3>
                        <p>£<?php echo $item['price']; ?></p>

                        <div class="wishlist-buttons">
                            <button class="add-basket">Add to Basket</button>
                            <button class="remove-wishlist" data-id="<?php echo $item['id']; ?>">Remove</button>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        </section>
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