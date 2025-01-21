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

$id = $_GET['id'] ?? null;

$stmt = $link->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("Produkt nie został znaleziony.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $expiry_date = $_POST['expiry_date'];
    $net_price = $_POST['net_price'];
    $vat_rate = $_POST['vat_rate'];
    $stock = $_POST['stock'];
    $availability_status = isset($_POST['availability_status']);
    $category_id = $_POST['category_id'];
    $dimensions = htmlspecialchars($_POST['dimensions']);
    $image_url = htmlspecialchars($_POST['image_url']);

    if ($productManager->editProduct($id, $title, $description, $expiry_date, $net_price, $vat_rate, $stock, $availability_status, $category_id, $dimensions, $image_url)) {
        $success = "Zmiany zostały zapisane.";
        $stmt = $link->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
    } else {
        $error = "Wystąpił problem podczas zapisywania zmian.";
    }
}

$result = $link->query("SELECT id, nazwa FROM categories");
$categories = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj produkt</title>
    <link rel="stylesheet" href="../css/admin_add_categories.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Edytuj produkt</h1>
    </header>
    <main>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <label>Tytuł: <input type="text" name="title" value="<?= htmlspecialchars($product['title']); ?>" required></label>
            <label>Opis: <textarea name="description" required><?= htmlspecialchars($product['description']); ?></textarea></label>
            <label>Data wygaśnięcia: <input type="date" name="expiry_date" value="<?= $product['expiry_date']; ?>"></label>
            <label>Cena netto: <input type="number" step="0.01" name="net_price" value="<?= $product['net_price']; ?>" required></label>
            <label>VAT: <input type="number" step="0.01" name="vat_rate" value="<?= $product['vat_rate']; ?>" required></label>
            <label>Stan magazynu: <input type="number" name="stock" value="<?= $product['stock']; ?>" required></label>
            <label>Status dostępności: <input type="checkbox" name="availability_status" <?= $product['availability_status'] ? 'checked' : ''; ?>></label>
            <label>Kategoria:
                <select name="category_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($category['nazwa']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Gabaryty: <input type="text" name="dimensions" value="<?= htmlspecialchars($product['dimensions']); ?>"></label>
            <label>Adres URL zdjęcia: <input type="text" name="image_url" value="<?= htmlspecialchars($product['image_url']); ?>"></label>
            <button type="submit">Zapisz zmiany</button>
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
