<?php
// update_stock.php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
header("Content-Type: application/json");// this line lets the php script send data to the javascript

// Read POST data from JS fetch request
$data = json_decode(file_get_contents("php://input"), true); //this line gets the data from the javascript
$product_id = $data['product_id'] ?? null; //
$amount = $data['amount'] ?? null;
//the line below ensures only numeric values are taken in
//as that is the format that's expected in database
//improves security
$product_id = preg_replace('/[^0-9]/', '', $product_id);

//here product id and amount are checked to see if theyre valid
if (!$product_id || !$amount || $amount <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid Product ID or Quantity"]);
    exit;
}

$db_host = "localhost";
$db_name = "cs2team49_product";
$db_user = "cs2team49";
$db_pass = "TxxB1oKh6zkcPBjuycWZvO8oz";


try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Updates the stock (increase by amount)
    $stmt = $db->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
    $stmt->execute([$amount, $product_id]);

    // a success message is shown if the stock is updated
    if ($stmt->rowCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Stock updated successfully"]);
    } else { //otherwise an error message is shown
        echo json_encode(["status" => "error", "message" => "Product ID not found or stock unchanged"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}
?>