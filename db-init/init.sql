CREATE DATABASE IF NOT EXISTS moja_strona;

USE moja_strona;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matka INT DEFAULT 0,
    nazwa VARCHAR(255) NOT NULL
);


CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    expiry_date DATETIME,
    net_price DECIMAL(10, 2) NOT NULL,
    vat_rate DECIMAL(5, 2) NOT NULL DEFAULT 0.23,
    stock INT DEFAULT 0,
    availability_status BOOLEAN DEFAULT TRUE,
    category_id INT NOT NULL,
    dimensions VARCHAR(100),
    image_url VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);


CREATE TABLE page_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_title VARCHAR(255) NOT NULL,
    page_content TEXT NOT NULL,
    status INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);