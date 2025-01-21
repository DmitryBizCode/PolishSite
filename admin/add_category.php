<?php
session_start();
require_once '../cfg.php';
require_once '../classes/Auth.php';
require_once '../classes/CategoryManager.php';

if (!Auth::isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$categoryManager = new CategoryManager($link);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $nazwa = htmlspecialchars($_POST['nazwa']);
    $matka = (int) $_POST['matka'];
    if ($categoryManager->DodajKategorie($nazwa, $matka)) {
        $success = "Kategoria została dodana.";
    } else {
        $error = "Błąd podczas dodawania kategorii.";
    }
}

$stmt = $link->query("SELECT id, nazwa FROM categories");
$categories = $stmt->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj kategorię</title>
    <link rel="stylesheet" href="/css/admin_add_categories.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Dodaj nową kategorię</h1>
    </header>
    <main>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="post">
            <label for="nazwa">Nazwa kategorii:</label>
            <input type="text" id="nazwa" name="nazwa" required>

            <label for="matka">Kategoria nadrzędna:</label>
            <select id="matka" name="matka">
                <option value="0">Brak</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= $category['nazwa'] ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="add">Dodaj kategorię</button>
        </form>
        <div class="button back-button">
            <a href="/admin/manage_categories.php">Powrót</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Panel CMS</p>
    </footer>
</div>
</body>
</html>
