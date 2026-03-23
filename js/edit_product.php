<?php
header("Content-Type: application/json");

$data=json_decode(file_get_contents("php://input"), true);

$id=$data['id'];
$name=$data['name'];
$category=$data['category'];
$price=$data['price'];
$stock=$data['stock'];

try {
    $db= new PDO("mysql:host=localhost;dbname=cs2team49_product", "cs2team49", "PASSWORD");

    $stmt=$db->prepare("UPDATE products 
        SET name=?,category=?,price=?,stock =? 
        WHERE id =?");

    $stmt->execute([$name, $category, $price, $stock, $id]);

    echo json_encode(["status"=>"success", "message"=>"Product updated"]);

} catch(PDOException $e){
    echo json_encode(["status"=>"error", "message"=> $e->getMessage()]);
}
?>