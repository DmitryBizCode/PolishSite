<?php
class CategoryManager {
    private $link;

    public function __construct($dbConnection) {
        $this->link = $dbConnection;
    }

    /** Додати нову категорію */
    public function DodajKategorie($nazwa, $matka = 0) {
        $stmt = $this->link->prepare("INSERT INTO categories (nazwa, matka) VALUES (?, ?)");
        $stmt->bind_param('si', $nazwa, $matka);
        return $stmt->execute();
    }

    /** Видалити категорію */
    public function UsunKategorie($id) {
        // Видалення підкатегорій
        $stmt = $this->link->prepare("DELETE FROM categories WHERE matka = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        // Видалення самої категорії
        $stmt = $this->link->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    /** Редагувати категорію */
    public function EdytujKategorie($id, $nazwa, $matka) {
        $stmt = $this->link->prepare("UPDATE categories SET nazwa = ?, matka = ? WHERE id = ?");
        $stmt->bind_param('sii', $nazwa, $matka, $id);
        return $stmt->execute();
    }

    /** Показати категорії */
    public function PokazKategorie() {
        $result = $this->link->query("SELECT * FROM categories ORDER BY matka ASC, nazwa ASC");
        $categories = $result->fetch_all(MYSQLI_ASSOC);

        // Вивести всі категорії
        $this->wyswietlKategorie($categories, 0);
    }
    public function getParentName(int $id): string {
        $stmt = $this->link->prepare("SELECT nazwa FROM categories WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['nazwa'];
        }
        return 'Brak';
    }


    /** Вивести категорії рекурсивно */
    private function wyswietlKategorie($categories, $matka, $poziom = 0) {
        foreach ($categories as $category) {
            if ($category['matka'] == $matka) {
                echo str_repeat('&nbsp;', $poziom * 4) . $category['nazwa'];
                echo " <a href='edit_category.php?id={$category['id']}'>Edytuj</a> | ";
                echo "<a href='manage_categories.php?delete={$category['id']}' onclick='return confirm(\"Czy na pewno chcesz usunąć?\");'>Usuń</a><br>";
                $this->wyswietlKategorie($categories, $category['id'], $poziom + 1);
            }
        }
    }
}
