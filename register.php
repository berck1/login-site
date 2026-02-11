<?php
require 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (strlen($username) < 3 || strlen($password) < 4) {
        $message = "⚠️ Dados inválidos!";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "❌ Utilizador já existe!";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                $message = "✅ Conta criada com sucesso!";
            } else {
                $message = "❌ Erro ao criar conta.";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="wrapper">
<form method="POST">
<h1>Registo</h1>

<div class="input-box">
<input type="text" name="username" placeholder="Utilizador" required>
</div>

<div class="input-box">
<input type="password" name="password" placeholder="Password" required>
</div>

<button type="submit" class="btn">Registar</button>

<div class="message"><?= $message ?></div>

<p>Já tem conta? <a href="index.html">Login</a></p>
</form>
</div>
</body>
</html>
