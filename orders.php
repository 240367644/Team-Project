<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
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

        <header class="header">
            <div class="logo-header">
                <img src="images/A4U_logo.png" class="logo">
                <h1 class="title">Accom4U</h1>
            </div>

            <nav class="navibar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
            </nav>

        <div class="login">
            <?php if (isset($_SESSION['user_id'])): ?>
                Logged in
            <?php else: ?>
                <a href="login.html">Login</a> | 
            <?php endif; ?>
        </div>

        </header>

        <main class="orders">

    <h2>Your orders</h2>

    <div class="ordersContainer">

    </div>

</main>

        <footer class="footer">

            <p>© 2025 Accom4U. All rights reserved.</p>
            
        </footer>

    </body>
</html>