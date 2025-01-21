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

$id = $_GET['id'] ?? null;

if ($id && $pageManager->UsunPodstrone($id)) {
    header("Location: manage_pages.php?success=Podstrona została usunięta.");
    exit;
} else {
    header("Location: manage_pages.php?error=Błąd podczas usuwania podstrony.");
    exit;
}
