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

$id = $_GET['id'] ?? null;

$stmt = $link->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();
$stmt->close();

if (!$category) {
    die("Kategoria nie została znaleziona.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazwa = htmlspecialchars($_POST['nazwa']);
    $matka = (int) $_POST['matka'];

    if ($categoryManager->EdytujKategorie($id, $nazwa, $matka)) {
        $success = "Zmiany zostały zapisane.";

        $stmt = $link->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();
        $stmt->close();
    } else {
        $error = "Wystąpił problem podczas zapisywania zmian.";
    }
}

$stmt = $link->query("SELECT id, nazwa FROM categories WHERE id != $id");
$categories = $stmt->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj kategorię</title>
    <link rel="stylesheet" href="../css/admin_add_categories.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Edytuj kategorię</h1>
    </header>
    <main>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="post">
            <label for="nazwa">Nazwa kategorii:</label>
            <input type="text" id="nazwa" name="nazwa" value="<?= htmlspecialchars($category['nazwa']); ?>" required>

            <label for="matka">Kategoria nadrzędna:</label>
            <select id="matka" name="matka">
                <option value="0" <?= $category['matka'] == 0 ? 'selected' : ''; ?>>Brak</option>
                <?php foreach ($categories as $parent): ?>
                    <option value="<?= $parent['id'] ?>" <?= $parent['id'] == $category['matka'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($parent['nazwa']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Zapisz zmiany</button>
        </form>
        <div class="button back-button">
            <a href="manage_categories.php">Powrót</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Panel CMS</p>
    </footer>
</div>
</body>
</html>
