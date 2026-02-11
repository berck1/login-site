<?php
session_start();
require 'config.php';

if (isset($_SESSION['user_id'])) {

    $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
}

session_unset();
session_destroy();

setcookie("remember_me", "", time() - 3600, "/");

header("Location: index.html");
exit();
?>
