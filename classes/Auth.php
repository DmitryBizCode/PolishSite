<?php
class Auth {
    public static function login($email, $password, $dbLogin, $dbPass): bool
    {
        if ($email === $dbLogin && $password === $dbPass) {
            $_SESSION['logged_in'] = true;
            return true;
        }
        return false;
    }

    public static function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
    }
}
