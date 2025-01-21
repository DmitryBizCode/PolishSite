<?php
session_start();
require_once '../cfg.php';
require_once '../classes/Auth.php';
require_once '../classes/ProductManager.php';

if (!Auth::isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$productManager = new ProductManager($link);

// Видалення продукту
if (isset($_GET['delete'])) {
    if ($productManager->deleteProduct($_GET['delete'])) {
        $success = "Produkt został usunięty.";
    } else {
        $error = "Błąd podczas usuwania produktu.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzaj produktami</title>
    <link rel="stylesheet" href="/css/admin_products.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Zarządzaj produktami</h1>
    </header>
    <main>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Kategoria</th>
                <th>Cena netto</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $result = $link->query("SELECT * FROM product ORDER BY data_utworzenia DESC");
            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['tytul']) ?></td>
                        <td><?= htmlspecialchars($row['kategoria']) ?></td>
                        <td><?= number_format($row['cena_netto'], 2) ?> PLN</td>
                        <td><?= htmlspecialchars($row['status_dostepnosci']) ?></td>
                        <td>
                            <a class="action-link edit" href="edit_product.php?id=<?= $row['id'] ?>">Edytuj</a>
                            <a class="action-link delete" href="manage_products.php?delete=<?= $row['id'] ?>" onclick="return confirm('Czy na pewno chcesz usunąć ten produkt?');">Usuń</a>
                        </td>
                    </tr>
                <?php
                endwhile;
            else:
                ?>
                <tr>
                    <td colspan="6" class="no-products">Brak produktów w bazie danych.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <div class="actions">
            <a class="button add-product" href="add_product.php">Dodaj nowy produkt</a>
            <a class="button logout" href="logout.php">Wyloguj</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Panel CMS</p>
    </footer>
</div>
</body>
</html>
