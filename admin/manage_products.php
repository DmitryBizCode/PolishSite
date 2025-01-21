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

if (isset($_GET['delete'])) {
    if ($productManager->deleteProduct($_GET['delete'])) {
        $success = "Produkt został usunięty.";
    } else {
        $error = "Błąd podczas usuwania produktu.";
    }
}

$products = $productManager->showProducts();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zarządzaj produktami</title>
    <link rel="stylesheet" href="../css/admin_manage_products.css">
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
                <th>Podatek VAT</th>
                <th>Ilość</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['title'] ?></td>
                    <td><?= $product['category_name'] ?></td>
                    <td><?= $product['net_price'] ?></td>
                    <td><?= $product['vat_rate'] * 100 ?>%</td>
                    <td><?= $product['stock'] ?></td>
                    <td><?= $product['availability_status'] ? 'Dostępny' : 'Niedostępny' ?></td>
                    <td>
                        <a class="action-link edit" href="edit_product.php?id=<?= $product['id'] ?>">Edytuj</a>
                        <a class="action-link delete" href="?delete=<?= $product['id'] ?>" onclick="return confirm('Czy na pewno chcesz usunąć?');">Usuń</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="actions">
            <a class="button add-category" href="add_product.php">Dodaj nową kategorię</a>
            <a class="button logout" href="index.php">Powrót</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Panel CMS</p>
    </footer>
</div>
</body>
</html>
