<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include('cfg.php');
include('showpage.php');

$idp = isset($_GET['idp']) ? $_GET['idp'] : 'glowna';

if ($idp === 'contact') {
    include('сontact.php');
    $contact = new Contact();
}

$page_ids = [
    'glowna' => 1,
    'history' => 'html/history.html',
    'recommendation' => 'html/recommendation.html',
    'films' => 'html/films.html',
    'news' => 'html/news.html',
    'criticism' => 'html/criticism.html',
    'movies' => 'html/movies.html'
];

if ($idp === 'glowna') {
    $page_id = $page_ids['glowna'];
    $strona = PokazPodstrone($page_id);
} elseif ($idp === 'contact') {
    ob_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $contact->WyslijMailKontakt();
    } else {
        $contact->PokazKontakt();
    }
    $strona = ob_get_clean();
} else {
    $file_path = isset($page_ids[$idp]) ? $page_ids[$idp] : null;
    if ($file_path && file_exists($file_path)) {
        $strona = file_get_contents($file_path);
    } else {
        $strona = '<p>Strona nie została znaleziona.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="FilmWeb Team">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Discover award-winning films and read critiques, recommendations, and history of the Oscars.">
    <link rel="stylesheet" href="css/menu.css">
    <title>Filmy Oskarowe</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
<header>
    <nav>
        <button class="nav-toggle" id="nav-toggle">☰</button>
        <ul class="menu">
            <li><a href="index.php?idp=glowna">Strona Główna</a></li>
            <li><a href="index.php?idp=history">Historia</a></li>
            <li><a href="index.php?idp=recommendation">Recomendacje</a></li>
            <li><a href="index.php?idp=films">Filmy Oskarowe</a></li>
            <li><a href="index.php?idp=news">Nowości</a></li>
            <li><a href="index.php?idp=criticism">Krytyka</a></li>
            <li><a href="index.php?idp=contact">Kontakt</a></li>
            <li><a href="index.php?idp=movies">Filmy</a></li>
        </ul>
    </nav>
</header>

<main>
    <?php echo $strona; ?>
</main>

<footer class="footer">
    <p>
        <?php
        $nr_indeksu = '169407';
        $nrGrupy = 'ISI4';
        echo 'Autor: Alina Upyrova ' . $nr_indeksu . ' grupa ' . $nrGrupy . '   |  ';
        ?>
        Wszelkie prawa zastrzeżone © 2024
    </p>
</footer>

<script>
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.querySelector('nav ul');

    navToggle.addEventListener('click', () => {
        navMenu.classList.toggle('show');
    });
</script>
</body>
</html>
