<?php
//this php script automatically updates stock after purchase. 
// It reads the basket, creates the order, 
// and subtracts the purchasd quantity from the products table
session_start();

$db=new 
PDO("mysql:host=localhost;dbname=cs2team49_orders;charset=utf8", "cs2team49_orders", "TxxB1oKh6zkcPBjuycWZvO8oz");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($_SERVER['REQUEST_METHOD']=== 'POST' && !empty($_SESSION['basket'])) {
    

    $user_id=$_SESSION['user_id'] ?? 1; //get logged in user ID
    
    try{
        //here the new order is created.
        $stmt=$db->prepare("INSERT INTO Orders (user_id, status) VALUES (?, 'Pending')");
        $stmt->execute([$user_id]);
        $order_id=$db->lastInsertId();

        //a loop goes through the items in the basket.
        foreach($_SESSION['basket']as $product_id=>$item){
            $quantity=$item['quantity'];

            //the basket items in the order are added to the orderItems table.
            $stmt=$db->prepare("INSERT INTO orderItems (order_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$order_id, $product_id, $quantity]);

            // The stock is updated in the product database.
            $stmt_stock= $db->prepare("UPDATE cs2team49_product.products SET product_quantity = product_quantity - ? WHERE id = ?");
            $stmt_stock->execute([$quantity, $product_id]);

        }

        //after the order is successful the basket is cleared.
        unset($_SESSION['basket']);

        //after the order is processed the user is redirected to a success page.
        header("Location: orderDone.html");
        exit;
    
    
        } catch(PDOException $e) {
        echo "Checkout Failed: " . $e->getMessage();

    }
}
?>