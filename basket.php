<?php

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

    $stmt = $db->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo json_encode(["status" => "error", "message" => "Product not found"]);
        exit;
    }

    if (isset($_SESSION['basket'][$product_id])) {
        $_SESSION['basket'][$product_id]['quantity'] += 1;
    } else {
        $_SESSION['basket'][$product_id] = [
            "id" => $product['id'],
            "name" => $product['name'],
            "price" => (float)$product['price'],
            "image" => $product['image'],
            "quantity" => 1
        ];
    }

    session_write_close();
    echo json_encode([
        "status" => "success",
        "message" => "Item added to basket",
        "basket" => $_SESSION['basket']
    ]);
    exit;
}

if ($path === "removeItem") {
    $product_id = $_POST['product_id'] ?? null;
    if ($product_id && isset($_SESSION['basket'][$product_id])) {
        unset($_SESSION['basket'][$product_id]);
        session_write_close();
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

    session_write_close();
    echo json_encode(["status" => "success", "message" => "Quantity updated"]);
    exit;
}

if ($path === "getBasket") {
    $basket_items = $_SESSION['basket'] ?? [];
    $subtotal = 0;

    foreach ($basket_items as &$item) {
        $item['price'] = (float)$item['price'];
        $item['quantity'] = (int)$item['quantity'];
        $item['total'] = $item['price'] * $item['quantity'];
        $subtotal += $item['total'];
    }

    $delivery = 0;
    $total = $subtotal + $delivery;

    echo json_encode([
        "status" => "success",
        "basket" => array_values($basket_items),
        "summary" => [
            "subtotal" => $subtotal,
            "delivery" => $delivery,
            "total" => $total
        ]
    ]);
    exit;
}

if ($path === "checkout") {

    if (!isset($_SESSION['basket']) || empty($_SESSION['basket'])) {
        echo json_encode(["status" => "error", "message" => "Basket is empty"]);
        exit;
    }

    $user_id = $_SESSION['user_id'] ?? 1;

    $orders_db = new PDO(
        "mysql:host=localhost;dbname=cs2team49_orders;charset=utf8",
        "cs2team49",
        "TxxB1oKh6zkcPBjuycWZvO8oz"
    );
    $orders_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $users_db = new PDO(
        "mysql:host=localhost;dbname=cs2team49_login_system;charset=utf8",
        "cs2team49",
        "TxxB1oKh6zkcPBjuycWZvO8oz"
    );

    $phone = $_POST['phone'] ?? null;
    $address = $_POST['address'] ?? null;
    $postcode = $_POST['postcode'] ?? null;

    $stmt = $users_db->prepare("
        UPDATE users 
        SET phone = ?, address = ?, postcode = ?
        WHERE user_id = ?
    ");
    $stmt->execute([$phone, $address, $postcode, $user_id]);

    $stmt = $orders_db->prepare("
        INSERT INTO Orders (user_id, created_at, status)
        VALUES (?, NOW(), 'Pending')
    ");
    $stmt->execute([$user_id]);

    $order_id = $orders_db->lastInsertId();

    foreach ($_SESSION['basket'] as $item) {

        $stmt = $orders_db->prepare("
            INSERT INTO order_items (order_id, product_id, quantity)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$order_id, $item['id'], $item['quantity']]);

        $stmt = $db->prepare("
            UPDATE products
            SET stock = stock - ?
            WHERE id = ?
        ");
        $stmt->execute([$item['quantity'], $item['id']]);
    }

    $_SESSION['basket'] = [];

    echo json_encode([
        "status" => "success",
        "message" => "Order placed",
        "order_id" => $order_id
    ]);
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid endpoint"]);
exit;
?>