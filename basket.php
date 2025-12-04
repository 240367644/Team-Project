<?php
// basket.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
session_start();

// Connect to the products database
$db_host = "localhost";
$db_name = "cs2team49_product";
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
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $e->getMessage()
    ]);
    exit;
}

// Initialize basket in session if not already
if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}

$path = $_GET['path'] ?? '';

if ($path === "addItem") {
    $product_id = $_POST['product_id'] ?? null;
    if (!$product_id) {
        echo json_encode(["status" => "error", "message" => "No product ID provided"]);
        exit;
    }

    // Get product info from database
    $stmt = $db->prepare("SELECT id, product_name, product_price FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo json_encode(["status" => "error", "message" => "Product not found"]);
        exit;
    }

    // Add to session basket
    if (isset($_SESSION['basket'][$product_id])) {
        $_SESSION['basket'][$product_id]['quantity'] += 1;
    } else {
        $_SESSION['basket'][$product_id] = [
            "name" => $product['product_name'],
            "price" => $product['product_price'],
            "quantity" => 1
        ];
    }

    echo json_encode(["status" => "success", "message" => "Item added to basket"]);
    exit;
}

if ($path === "removeItem") {
    $product_id = $_POST['product_id'] ?? null;
    if ($product_id && isset($_SESSION['basket'][$product_id])) {
        unset($_SESSION['basket'][$product_id]);
        echo json_encode(["status" => "success", "message" => "Item removed from basket"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Item not in basket"]);
    }
    exit;
}

if ($path === "updateQuantity") {
    $product_id = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    if (!$product_id || !isset($_SESSION['basket'][$product_id]) || !is_numeric($quantity)) {
        echo json_encode(["status" => "error", "message" => "Invalid request"]);
        exit;
    }

    if ($quantity <= 0) {
        unset($_SESSION['basket'][$product_id]);
    } else {
        $_SESSION['basket'][$product_id]['quantity'] = intval($quantity);
    }

    echo json_encode(["status" => "success", "message" => "Quantity updated"]);
    exit;
}

if ($path === "getBasket") {
    $basket_items = $_SESSION['basket'] ?? [];
    $subtotal = 0;

    foreach ($basket_items as &$item) {
        $item['total'] = $item['price'] * $item['quantity'];
        $subtotal += $item['total'];
    }

    $delivery = 0; // Optional delivery logic
    $total = $subtotal + $delivery;

    echo json_encode([
        "status" => "success",
        "basket" => $basket_items,
        "summary" => [
            "subtotal" => $subtotal,
            "delivery" => $delivery,
            "total" => $total
        ]
    ]);
    exit;
}

// fallback for invalid path
echo json_encode(["status" => "error", "message" => "Invalid endpoint"]);
exit;
?>
