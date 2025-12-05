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
                <img src="images/A4U_logo.png" class="logo" alt="logo">
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

            <a class="login" href="login.html"><b>Log In</b></a>
            <a class="basket-icon" href="basketpage.php">
                <img src="images/basket.png" class="basket-icon" alt="Basket">
            </a>

        </header>

        <main class="checkout-page">

        <main>
        <div class="contact-container">
            <div class="contact-left">
            	<div class="contact-right-title">
            		<h2>Order Summary</h2>
					<hr>
   		         	<b>Cart data goes here</b>
   		         	<hr>
       			    <b>Total: (data from total cart cost here)</b>
                </div>
            </div>

            <form action="" class="contact-right">
                <div class="contact-right-title">
                    <h2>Checkout</h2>
                    <hr>
                    <p> Enter your payment and delivery details here</p>
                    <hr>
                </div>
                <input type="text" name="name" placeholder="Your Full name" class="contact-inputs" required>
                <input type="email" name="email" placeholder="Phone Number" class="contact-inputs" required>
                <input type="email" name="email" placeholder="Address" class="contact-inputs" required>
                <input type="email" name="email" placeholder="Post Code" class="contact-inputs" required>
                <input type="email" name="email" placeholder="Card Number" class="contact-inputs" required>
                <input type="email" name="email" placeholder="Expiry date" class="contact-inputs" required>
                <input type="email" name="email" placeholder="CVV" class="contact-inputs" required>
                <button type="submit">Place order</button>
            </form>
        </div>

</main>

        <footer class="footer">

            <p>© 2025 Accom4U. All rights reserved.</p>
            
        </footer>

    </body>
</html>