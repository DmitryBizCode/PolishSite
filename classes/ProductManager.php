<?php
class ProductManager {
    private $link;

    public function __construct($dbConnection) {
        $this->link = $dbConnection;
    }

    /** Додати новий продукт */
    public function addProduct($tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_dostepnych_sztuk, $status_dostepnosci, $kategoria, $gabaryt_produktu, $zdjecie_url) {
        $stmt = $this->link->prepare("INSERT INTO product (tytul, opis, data_wygasniecia, cena_netto, podatek_vat, ilosc_dostepnych_sztuk, status_dostepnosci, kategoria, gabaryt_produktu, zdjecie_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssdidssss', $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_dostepnych_sztuk, $status_dostepnosci, $kategoria, $gabaryt_produktu, $zdjecie_url);
        return $stmt->execute();
    }

    /** Видалити продукт */
    public function deleteProduct($id) {
        $stmt = $this->link->prepare("DELETE FROM product WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    /** Редагувати продукт */
    public function editProduct($id, $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_dostepnych_sztuk, $status_dostepnosci, $kategoria, $gabaryt_produktu, $zdjecie_url) {
        $stmt = $this->link->prepare("UPDATE product SET tytul = ?, opis = ?, data_wygasniecia = ?, cena_netto = ?, podatek_vat = ?, ilosc_dostepnych_sztuk = ?, status_dostepnosci = ?, kategoria = ?, gabaryt_produktu = ?, zdjecie_url = ? WHERE id = ?");
        $stmt->bind_param('sssdidssssi', $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_dostepnych_sztuk, $status_dostepnosci, $kategoria, $gabaryt_produktu, $zdjecie_url, $id);
        return $stmt->execute();
    }

    /** Показати всі продукти */
    public function showProducts() {
        $result = $this->link->query("SELECT * FROM product ORDER BY data_utworzenia DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /** Отримати продукт за ID */
    public function getProductById($id) {
        $stmt = $this->link->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
