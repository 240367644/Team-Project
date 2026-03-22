<?php
header("Content-Type: application/json");
session_start();

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
} catch (PDOException $e) {
    echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
    exit;
}

$action = $_GET['action'] ?? '';

// DELETE CUSTOMER
if ($action === "delete") {
    $id = $_POST['user_id'] ?? null;

    if (!$id) {
        echo json_encode(["status"=>"error","message"=>"No ID"]);
        exit;
    }

    $stmt = $db->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->execute([$id]);

    echo json_encode(["status"=>"success","message"=>"Customer deleted"]);
    exit;
}

// UPDATE CUSTOMER
if ($action === "update") {
    $id = $_POST['user_id'] ?? null;
    $name = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!$id) {
        echo json_encode(["status"=>"error","message"=>"No ID"]);
        exit;
    }

    $stmt = $db->prepare("SELECT username, email FROM users WHERE user_id=?");
    $stmt->execute([$id]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($name === '') $name = $current['username'];
    if ($email === '') $email = $current['email'];

    $stmt = $db->prepare("
        UPDATE users 
        SET username=?, email=? 
        WHERE user_id=?
    ");
    $stmt->execute([$name, $email, $id]);

    echo json_encode(["status"=>"success","message"=>"Customer updated"]);
    exit;
}


// role
if ($action === "role") {
    $id = $_POST['user_id'] ?? null;
    $role = $_POST['role'] ?? 'user';

    if (!$id) {
        echo json_encode(["status"=>"error","message"=>"No ID"]);
        exit;
    }

    $stmt = $db->prepare("
        UPDATE users 
        SET role = ? 
        WHERE user_id = ?
    ");
    $stmt->execute([$role, $id]);

    echo json_encode(["status"=>"success","message"=>"Role updated"]);
    exit;
}

// ADD CUSTOMER
if ($action === "add") {
    $name = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || !$password) {
        echo json_encode(["status"=>"error","message"=>"All fields required"]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("
        INSERT INTO users (username, email, password, role) 
        VALUES (?, ?, ?, 'user')
    ");
    $stmt->execute([$name, $email, $hashedPassword]);

    echo json_encode(["status"=>"success","message"=>"Customer added"]);
    exit;
}

// DEFAULT
echo json_encode(["status"=>"error","message"=>"Invalid action"]);