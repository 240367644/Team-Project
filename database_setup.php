<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
session_start();

// database settings, change if needed to check another database
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
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $e->getMessage()
    ]);
    exit;
}

$path = $_GET['path'] ?? '';

// register section
if ($path === "register") {
    $data = json_decode(file_get_contents("php://input"), true);

    $email = trim($data["email"] ?? "");
    $password = trim($data["password"] ?? "");
    $username = trim($data["username"] ?? ""); // optional username field

    if (!$email || !$password || !$username) {
        echo json_encode(["status" => "error", "message" => "Missing email, password, or username"]);
        exit;
    }

    try {
        // verifies whether the email already exists
        $stmt = $db->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode(["status" => "error", "message" => "Email already registered"]);
            exit;
        }

        // verifies whether the username already exists
        $stmt = $db->prepare("SELECT user_id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            echo json_encode(["status" => "error", "message" => "Username already taken"]);
            exit;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed]);

        echo json_encode(["status" => "success", "message" => "Registration successful!"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
    exit;
}

// login section
if ($path === "login") {
    $data = json_decode(file_get_contents("php://input"), true);

    $usernameOrEmail = trim($data["usernameOrEmail"] ?? "");
    $password = trim($data["password"] ?? "");

    if (!$usernameOrEmail || !$password) {
        echo json_encode(["status" => "error", "message" => "Missing username/email or password"]);
        exit;
    }

    try {
        // Check if username or email matches
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo json_encode(["status" => "error", "message" => "Invalid username or email"]);
            exit;
        }

        if (!password_verify($password, $user["password"])) {
            echo json_encode(["status" => "error", "message" => "Incorrect password"]);
            exit;
        }

        // Stores the userid in session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        echo json_encode(["status" => "success", "message" => "Login successful!"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
    exit;
}

// get the user info, utilised for the contact page
if ($path === "getUserInfo") {
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        echo json_encode(["status" => "error", "message" => "Not logged in"]);
        exit;
    }

    try {
        $stmt = $db->prepare("SELECT username, email FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode([
                "status" => "success",
                "username" => $user['username'],
                "email" => $user['email']
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "User not found"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
    exit;
}

// validate contact form inputs
if ($path === "validateContactForm") {
    $data = json_decode(file_get_contents("php://input"), true);

    $username = trim($data['username'] ?? '');
    $email = trim($data['email'] ?? '');

    if (!$username || !$email) {
        echo json_encode(["status" => "error", "message" => "Username and email are required"]);
        exit;
    }

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
        $stmt->execute([$username, $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode(["status" => "success", "message" => "User validated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Username and email do not match"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
    exit;
}

// invalid endpoint error message
echo json_encode(["status" => "error", "message" => "Invalid endpoint"]);
exit;
?>
