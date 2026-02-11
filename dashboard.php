<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {

    $token = $_COOKIE['remember_me'];

    $stmt = $conn->prepare("SELECT id, username FROM users WHERE remember_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
?>
