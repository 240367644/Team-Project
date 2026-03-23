<?php
session_start();

$db_host= "localhost";
$db_name= "cs2team49_login_system"; 
$db_user= "cs2team49";
$db_pass= "TxxB1oKh6zkcPBjuycWZvO8oz";

try {
    $dbReview = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $dbReview->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Connection failed."]);
    exit;
}


$product_id=$_POST['product_id'] ?? null;
$name =$_POST['reviewer_name'] ?? null;
$rating= $_POST['rating'] ?? null;
$text= $_POST['text'] ?? null;
$user_id= $_SESSION['user_id'] ?? null; // saves user id if perosn is logged in

if ($product_id && $name && $rating && $text) {
    //inserts the review into database
    $stmt = $dbReview->prepare("INSERT INTO reviews (user_id, product_id, reviewer_name, rating, text) VALUES (?, ?, ?, ?, ?)");
    
    
    if($stmt->execute([$user_id, $product_id, $name, $rating, $text])) {
        echo json_encode(["status" => "success", "message" => "Review submitted!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save review."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Please fill in all fields."]);
}
?>
