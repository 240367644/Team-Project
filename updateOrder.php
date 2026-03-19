<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);

$order_id = $data['order_id'];
$status = $data['status'];

$db = new PDO("mysql:host=localhost;dbname=cs2team49_orders;charset=utf8", "cs2team49", "TxxB1oKh6zkcPBjuycWZvO8oz");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("UPDATE Orders SET status = ? WHERE order_id = ?");
$success = $stmt->execute([$status, $order_id]);

echo json_encode(["success" => $success]);
?>