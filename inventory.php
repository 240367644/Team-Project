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
                <li><a href="reviews.php">Reviews</a></li>
            </ul>
        </nav>

        <a class="basket-icon" href="basket.html">
            <img src="images/basket.png" class="basket-icon" alt="Basket">
        </a>
        
        <a id="loginLink" class="login" href="login.html"><b>Log In</b></a>
    </header>

    <main class="admin-main">

        <div class="admin-top-menu">
            <a href="processOrders.php">Process Orders</a>
            <a href="customers.php">Customer Management</a>
            <a href="inventory.php">Inventory Management</a>
            <a href="reports.php">Reports</a>
        </div>

        <br><br>
        <h2 class="page-title">Product & Inventory Management</h2>

        <div class="inventory-alerts">

            <div class="alert low">
                ⚠<span id="low-count">0</span> products are low in stock
            </div>

            <div class="alert out">
                ❗ <span id="out-count">0</span> products are out of stock
            </div>
        </div>

        <div class="product-controls">
             
            <div class="search-filter-container">
                <input type="text" placeholder="Search product" class="search-bar" id="searchInput">
                <select class="filter-dropdown" id="categoryFilter">
                    <option value="">All categories</option>
                </select>
                <select class="filter-dropdown" id="statusFilter">
                    <option value="">All statuses</option>
                    <option value="in stock">In Stock</option>
                    <option value="low stock">Low Stock</option>
                    <option value="out of stock">Out of Stock</option>
                </select>
                <button class="filter-btn" id="filterBtn">Filter</button>
            </div>
            <button class="add-product">+ Add Product</button>
        </div>

        <div class="table-container">

            <table class="product-table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                   <?php
                    $db=new PDO("mysql:host=localhost;dbname=cs2team49_product", "cs2team49", "TxxB1oKh6zkcPBjuycWZvO8oz");

                    $stmt=$db->query("SELECT * FROM products");

                    while ($product=$stmt->fetch(PDO::FETCH_ASSOC)){
                        $qty=$product['stock'];
                        

                        if ($qty<=0){
                            $statusClass="out-stock";
                            $statusText= "Out of Stock";
                        } elseif ($qty<=10){
                            $statusClass="low-stock";
                            $statusText="Low Stock";
                        }else{
                            $statusClass="in-stock";
                            $statusText= "In Stock";    
                        }
                        echo '<tr class="'.$statusClass.'-row">';
                        echo '<td>' . htmlspecialchars($product['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($product['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($product['category']) . '</td>';
                        echo '<td>£' . number_format($product['price'],2) . '</td>';
                        echo '<td>' . htmlspecialchars($qty) . '</td>';
                        echo '<td class="' . $statusClass . '">' . $statusText . '</td>';
                        echo '<td>';
                        echo '<button class="view-btn">View</button>';
                        
                        echo '<button class="edit-btn" 
                        data-id="' . htmlspecialchars($product['id']) . '" 
                        data-name="' . htmlspecialchars($product['name']) . '" 
                        data-category="' . htmlspecialchars($product['category']) . '" 
                        data-price="' . htmlspecialchars($product['price']) . '" 
                        data-stock="' . htmlspecialchars($product['stock']) . '">
                        Edit
                        </button>';
                        
                        echo '<button class="stock-btn">Update Stock</button>';
                        echo '<button class="restock-btn">Restock</button>';
                        echo '<button class="delete-btn">Delete</button>';
                        echo '</td>';
                        echo '</tr>';
                    }
        
                    ?>
                </tbody>
            </table>
        </div>

        <div class="product-view-modal">
            
            <h3>Product Details</h3>
            <p><strong>Product ID:</strong> P001</p>
            <p><strong>Name:</strong> Desk Lamp</p>
            <p><strong>Category:</strong> Lighting</p>
            <p><strong>Price:</strong> £24.99</p>
            <p><strong>Stock Level:</strong> 53</p>
            <p><strong>Status:</strong> In Stock</p>

            <button class="close-view">Close</button>
     
        </div>

        <div class="restock-modal">

            <h3>Restock Product</h3>
            <label>Product ID</label>
            <input type="text" placeholder="Enter product ID">
            <label>Quantity Received</label>
            <input type="number" placeholder="Enter quantity">
            <button class="confirm-restock">Confirm Restock</button>
            <button class="cancel-restock">Cancel</button>
        </div>
            
        <div class="product-edit-modal" id="editModal" style="display:none;">
            <h3>Edit Product</h3>
            <input type="hidden" id="edit-id">
            <label>Product Name</label>
            <input type="text" id="edit-name">
            <label>Category</label>
            <input type="text" id="edit-category">
            <label>Price (£)</label>
            <input type="number" step="0.01" id="edit-price">
            <label>Stock</label><input type="number" id="edit-stock">
            <button id="saveEdit">Save Changes</button>
            <button id="closeEdit">Cancel</button>
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
    <script src="js/admin.js"></script>

</body>
</html>
