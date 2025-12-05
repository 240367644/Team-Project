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
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" class="checkout-inputs" placeholder="Your Full name" required>
                </div>

                <div class="form-group">
                    <label for="Phone">Phone Number</label>
                    <input type="text" id="phone" class="checkout-inputs"  placeholder="Phone Number"  required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" class="checkout-inputs" placeholder="Address"  required>
                </div>
                 
                <div class="form-group">
                    <label for="postcode">Post Code</label>
                    <input type="text" id="postcode" class="checkout-inputs" placeholder="Post Code"  required>
                </div>

                <div class="form-group">
                    <label for="cardNumber">Card Number</label>
                    <input type="text" id="cardNumber" class="checkout-inputs" placeholder="Card Number"  required>
                </div>
    
                <div class="form-group">
                    <label for="expiryDate">Expiry Date</label>
                    <input type="text" id="expiryDate" class="checkout-inputs" placeholder="Expiry date"  required>
                </div>

                
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" class="checkout-inputs" placeholder="CVV"  required>
               </div>
                

                <button type="submit">Place order</button>
            </form>
        </div>

</main>

        <footer class="footer">

            <p>© 2025 Accom4U. All rights reserved.</p>
            
        </footer>

    </body>
</html>