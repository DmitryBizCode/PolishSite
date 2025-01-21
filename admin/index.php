<?php
session_start();
require_once '../cfg.php';
require_once '../classes/Auth.php';

if (!Auth::isLoggedIn()) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel CMS</title>
    <link rel="stylesheet" href="../css/admin_index.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Panel CMS</h1>
    </header>
    <main>
        <div class="actions">
            <a href="manage_pages.php" class="button">Zarządzaj podstronami</a>
            <a href="manage_categories.php" class="button">Zarządzaj kategoriami</a>
            <a href="manage_products.php" class="button">Zarządzaj produkt</a>
            <a href="logout.php" class="button logout">Wyloguj</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Panel CMS</p>
    </footer>
</div>
</body>
</html>
