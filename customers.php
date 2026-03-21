<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

    // Fetch customers
    $stmt = $db->query("SELECT * FROM users");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
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
                <li><a href="reviews.html">Reviews</a></li>
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
        <h2 class="page-title">Customer Management</h2>

        <div class="customer-controls">
            <input type="text" placeholder="Search customers..." class="search-bar">
            <button class="add-btn">+ Add Customer</button>
        </div>

        <div class="table-container">

        <table class="customer-table">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Orders</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
<?php foreach ($customers as $customer): ?>
    <tr>
        <td><?php echo $customer['user_id']; ?></td>
        <td><?php echo $customer['username']; ?></td>
        <td><?php echo $customer['email']; ?></td>
        <td><?php echo $customer['created_at']; ?></td>

        <td>

        </td>
		<td>

		</td>

		<td>
		    <button class="view-btn">View</button>
		    <button class="edit-btn" onclick="editCustomer(<?php echo $customer['user_id']; ?>)">Edit</button>
		    <button class="delete-btn" onclick="deleteCustomer(<?php echo $customer['user_id']; ?>)">Delete</button>	
		</td>
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
    
<script>

//delete customer
async function deleteCustomer(id) {
    if (!confirm("Are you sure you want to delete this customer?")) return;

    const formData = new FormData();
    formData.append("user_id", id);

    const res = await fetch('customerActions.php?action=delete', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();
    alert(data.message);

    if (data.status === "success") {
        location.reload(); // refresh table
    }
}


//edit customer
async function editCustomer(id) {

    const name = prompt("Enter new name:");
    const email = prompt("Enter new email:");


    if (!name || !email) {
        alert("Name and email required");
        return;
    }

    const formData = new FormData();
    formData.append("username", name);
    formData.append("email", email);
	formData.append("user_id", id);

    const res = await fetch('customerActions.php?action=update', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();
    alert(data.message);

    if (data.status === "success") {
        location.reload();
    }
}
</script>

</body>
</html>
