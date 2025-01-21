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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dodaj'])) {
    if ($pageManager->DodajNowaPodstrone($_POST)) {
        $success = "Nowa podstrona została dodana.";
    } else {
        $error = "Błąd podczas dodawania podstrony.";
    }
}

if (isset($_GET['delete'])) {
    if ($pageManager->UsunPodstrone($_GET['delete'])) {
        $success = "Podstrona została usunięta.";
    } else {
        $error = "Błąd podczas usuwania podstrony.";
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzaj podstronami</title>
    <link rel="stylesheet" href="/css/admin_manage.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Zarządzaj podstronami</h1>
    </header>
    <main>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <?php $pageManager->ListaPodstron(); ?>
        <div class="actions">
            <a class="button add-page" href="add_page.php">Dodaj nową podstronę</a>
            <a class="button logout" href="index.php">Powrót</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Panel CMS</p>
    </footer>
</div>
</body>
</html>

