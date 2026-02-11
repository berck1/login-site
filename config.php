<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "arteamorim";

$conn = new mysqli("localhost", "root", "", "arteamorim");

if ($conn->connect_error) {
    die("Erro na ligação: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>

