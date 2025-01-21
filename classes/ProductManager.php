<?php
class ProductManager {
    private $link;

    public function __construct($dbConnection) {
        $this->link = $dbConnection;
    }

    public function addProduct($title, $description, $expiry_date, $net_price, $vat_rate, $stock, $availability_status, $category_id, $dimensions, $image_url) {
        $stmt = $this->link->prepare("
            INSERT INTO products (title, description, expiry_date, net_price, vat_rate, stock, availability_status, category_id, dimensions, image_url)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param('sssddiisds', $title, $description, $expiry_date, $net_price, $vat_rate, $stock, $availability_status, $category_id, $dimensions, $image_url);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $stmt = $this->link->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function editProduct($id, $title, $description, $expiry_date, $net_price, $vat_rate, $stock, $availability_status, $category_id, $dimensions, $image_url) {
        $stmt = $this->link->prepare("
        UPDATE products
        SET title = ?, description = ?, expiry_date = ?, net_price = ?, vat_rate = ?, stock = ?, availability_status = ?, category_id = ?, dimensions = ?, image_url = ?
        WHERE id = ?
    ");
        $stmt->bind_param('sssddiisisi', $title, $description, $expiry_date, $net_price, $vat_rate, $stock, $availability_status, $category_id, $dimensions, $image_url, $id);
        return $stmt->execute();
    }


    public function showProducts() {
        $result = $this->link->query("
            SELECT products.*, categories.nazwa AS category_name
            FROM products
            JOIN categories ON products.category_id = categories.id
            ORDER BY created_at DESC
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
