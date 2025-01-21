<?php
    // Параметри підключення до бази даних
    $dbhost = 'db';             // Ім'я сервісу MySQL з docker-compose.yml
    $dbuser = 'user';           // Ім'я користувача з docker-compose.yml
    $dbpass = 'password';       // Пароль користувача з docker-compose.yml
    $dbaza = 'moja_strona';     // Назва бази даних з docker-compose.yml

    // Створюємо підключення до бази даних
    $link = new mysqli($dbhost, $dbuser, $dbpass, $dbaza);

    // Перевірка підключення
    if ($link->connect_error) {
        die("<b>Przerwane połączenie: </b>" . $link->connect_error);
    }

    // Пробні логін і пароль (залишимо для подальшого використання)
    $login = "alina";
    $pass = "123qweasd";
