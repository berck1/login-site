<?php
session_start();
require 'config.php';

$message = "";

// Ativar erros (REMOVE depois de testar)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['username'], $_POST['password'])) {
        $message = "❌ Dados não recebidos.";
    } else {

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $remember = isset($_POST['remember']);

        if (empty($username) || empty($password)) {
            $message = "❌ Preencha todos os campos.";
        } else {

            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
            
            if (!$stmt) {
                die("Erro SQL: " . $conn->error);
            }

            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {

                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    if ($remember) {
                        $token = bin2hex(random_bytes(32));

                        setcookie(
                            "remember_me",
                            $token,
                            time() + (86400 * 30),
                            "/",
                            "",
                            false,
                            true
                        );

                        $update = $conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                        $update->bind_param("si", $token, $user['id']);
                        $update->execute();
                        $update->close();
                    }

                    header("Location: dashboard.php");
                    exit();

                } else {
                    $message = "❌ Password incorreta!";
                }

            } else {
                $message = "❌ Utilizador não encontrado!";
            }

            $stmt->close();
        }
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
<h1>Login</h1>

<div class="input-box">
<input type="text" name="username" placeholder="Utilizador" required>
</div>

<div class="input-box">
<input type="password" name="password" placeholder="Password" required>
</div>

<div>
<label><input type="checkbox" name="remember"> Lembre-me</label>
</div>

<button type="submit" class="btn">Login</button>

<div class="message"><?= htmlspecialchars($message) ?></div>

<p>Não tem conta? <a href="register.php">Registe-se</a></p>

</form>
</div>
</body>
</html>
