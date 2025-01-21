CREATE DATABASE IF NOT EXISTS moja_strona;

USE moja_strona;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matka INT DEFAULT 0,
    nazwa VARCHAR(255) NOT NULL
);


CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tytul VARCHAR(255) NOT NULL,
    opis TEXT NOT NULL,
    data_utworzenia TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_modyfikacji TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    data_wygasniecia DATE NOT NULL,
    cena_netto DECIMAL(10,2) NOT NULL,
    podatek_vat DECIMAL(5,2) NOT NULL,
    ilosc_dostepnych_sztuk INT NOT NULL,
    status_dostepnosci ENUM('dostepny', 'niedostepny', 'wycofany') NOT NULL,
    kategoria VARCHAR(255) NOT NULL,
    gabaryt_produktu VARCHAR(255) NOT NULL,
    zdjecie_url VARCHAR(255)
);

CREATE TABLE page_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_title VARCHAR(255) NOT NULL,
    page_content TEXT NOT NULL,
    status INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);