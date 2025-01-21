<?php
session_start();
require_once '../cfg.php';
require_once '../classes/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['login_email'] ?? '';
    $password = $_POST['login_pass'] ?? '';

    if (Auth::login($email, $password, $login, $pass)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Nieprawidłowy login lub hasło.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="../css/admin_login.css">
</head>
<body>
<div class="login-container">
    <h1>Panel CMS</h1>
    <form method="post" action="">
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <label>
            Email:
            <input type="text" name="login_email" required>
        </label>
        <label>
            Hasło:
            <input type="password" name="login_pass" required>
        </label>
        <button type="submit">Zaloguj</button>
    </form>
</div>
</body>
</html>
