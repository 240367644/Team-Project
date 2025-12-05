<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = [];

// Destroy the session cookie (optional but recommended)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session itself
session_destroy();

// Redirect user back to homepage (or login page)
header("Location: index.html");
exit();
?>
