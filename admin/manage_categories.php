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

if (isset($_GET['delete'])) {
    if ($categoryManager->UsunKategorie($_GET['delete'])) {
        $success = "Kategoria została usunięta.";
    } else {
        $error = "Błąd podczas usuwania kategorii.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzaj kategoriami</title>
    <link rel="stylesheet" href="/css/admin_categories.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Zarządzaj kategoriami</h1>
    </header>
    <main>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Kategoria nadrzędna</th>
                <th>Akcje</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $result = $link->query("SELECT * FROM categories ORDER BY matka ASC, nazwa ASC");
            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    $parent = $row['matka'] ? $categoryManager->getParentName($row['matka']) : 'Brak';
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nazwa'] ?></td>
                        <td><?= $parent ?></td>
                        <td>
                            <a class="action-link edit" href="edit_category.php?id=<?= $row['id'] ?>">Edytuj</a>
                            <a class="action-link delete" href="manage_categories.php?delete=<?= $row['id'] ?>" onclick="return confirm('Czy na pewno chcesz usunąć tę kategorię?');">Usuń</a>
                        </td>
                    </tr>
                <?php
                endwhile;
            else:
                ?>
                <tr>
                    <td colspan="4" class="no-categories">Brak kategorii w bazie danych.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <div class="actions">
            <a class="button add-category" href="add_category.php">Dodaj nową kategorię</a>
            <a class="button logout" href="index.php">Powrót</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Panel CMS</p>
    </footer>
</div>
</body>
</html>
