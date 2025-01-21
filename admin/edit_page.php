<?php
session_start();
require_once '../cfg.php';
require_once '../classes/Auth.php';
require_once '../classes/PageManager.php';

// Перевірка авторизації
if (!Auth::isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$pageManager = new PageManager($link);

$id = $_GET['id'] ?? null;
$page = $pageManager->EdytujPodstrone($id);

if (!$page) {
    die("Podstrona nie została znaleziona.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($pageManager->ZapiszPodstrone(array_merge($_POST, ['id' => $id]))) {
        $success = "Zmiany zostały zapisane.";
        $page = $pageManager->EdytujPodstrone($id);
    } else {
        $error = "Wystąpił problem podczas zapisywania zmian.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj podstronę</title>
    <link rel="stylesheet" href="../css/admin_add.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Edytuj podstronę</h1>
    </header>
    <main>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="post">
            <label>
                <span>Tytuł:</span>
                <input type="text" name="page_title" value="<?php echo htmlspecialchars($page['page_title']); ?>" placeholder="Wprowadź tytuł..." required>
            </label>

            <label>
                <span>Treść:</span>
                <textarea name="page_content" placeholder="Wprowadź treść..." rows="10" required><?php echo htmlspecialchars($page['page_content']); ?></textarea>
            </label>

            <label>
                <input type="checkbox" name="status" <?php echo $page['status'] ? 'checked' : ''; ?>>
                <span>Aktywna</span>
            </label>

            <button type="submit">Zapisz zmiany</button>
        </form>
        <a href="manage_pages.php" class="button back-button">Zarządzaj podstronami</a>

    </main>
    <footer>
        <p>&copy; 2025 Panel CMS</p>
    </footer>
</div>
</body>
</html>

