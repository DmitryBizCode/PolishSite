<?php
session_start();
require_once '../cfg.php';
require_once '../classes/Auth.php';
require_once '../classes/PageManager.php';

if (!Auth::isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$pageManager = new PageManager($link);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($pageManager->DodajNowaPodstrone($_POST)) {
        $success = "Podstrona została dodana pomyślnie.";
    } else {
        $error = "Wystąpił problem podczas dodawania podstrony.";
    }
}
?>

<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj podstronę</title>
    <link rel="stylesheet" href="../css/admin_add.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Dodaj nową podstronę</h1>
    </header>
    <main>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="post">
            <label>
                <span>Tytuł:</span>
                <input type="text" name="page_title" placeholder="Wprowadź tytuł..." required>
            </label>

            <label>
                <span>Treść:</span>
                <textarea name="page_content" placeholder="Wprowadź treść..." rows="10" required></textarea>
            </label>

            <label>
                <input type="checkbox" name="status">
                <span>Aktywna</span>
            </label>

            <button type="submit">Dodaj podstronę</button>
        </form>
        <div class="button back-button">
            <a href="/admin/manage_pages.php">Powrót</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Panel CMS</p>
    </footer>
</div>
</body>
</html>
