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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $expiry_date = $_POST['expiry_date'];
    $net_price = $_POST['net_price'];
    $vat_rate = $_POST['vat_rate'];
    $stock = $_POST['stock'];
    $availability_status = isset($_POST['availability_status']);
    $category_id = $_POST['category_id'];
    $dimensions = $_POST['dimensions'];
    $image_url = $_POST['image_url'];

    if ($productManager->addProduct($title, $description, $expiry_date, $net_price, $vat_rate, $stock, $availability_status, $category_id, $dimensions, $image_url)) {
        $success = "Produkt został dodany.";
    } else {
        $error = "Błąd podczas dodawania produktu.";
    }
}

$result = $link->query("SELECT id, nazwa FROM categories");
$categories = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj produkt</title>
    <link rel="stylesheet" href="../css/admin_add_categories.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Dodaj produkt</h1>
    </header>
    <main>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <label>Tytuł: <input type="text" name="title" required></label>
            <label>Opis: <textarea name="description"></textarea></label>
            <label>Data wygaśnięcia: <input type="date" name="expiry_date"></label>
            <label>Cena netto: <input type="number" step="0.01" name="net_price" required></label>
            <label>VAT: <input type="number" step="0.01" name="vat_rate"></label>
            <label>Stan magazynu: <input type="number" name="stock" required></label>
            <label>Status dostępności: <input type="checkbox" name="availability_status"></label>
            <label>Kategoria:
                <select name="category_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= $category['nazwa'] ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Gabaryty: <input type="text" name="dimensions"></label>
            <label>Adres URL zdjęcia: <input type="text" name="image_url"></label>
            <button type="submit">Dodaj</button>
        </form>
        <div class="back-button">
            <a href="manage_products.php">Powrót</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Panel CMS</p>
    </footer>
</div>
</body>
</html>
