<?php
class PageManager {
    private $link;

    public function __construct($dbConnection) {
        $this->link = $dbConnection;
    }

    public function ListaPodstron() {
        $result = $this->link->query("SELECT id, page_title FROM page_list");
        if ($result->num_rows > 0) {
            echo '<table class="pages-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tytuł</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>';
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['page_title']}</td>
                        <td>
                            <a class='action-link edit' href='edit_page.php?id={$row['id']}'>Edytuj</a>
                            <a class='action-link delete' href='delete_page.php?id={$row['id']}' onclick='return confirm(\"Czy na pewno chcesz usunąć?\");'>Usuń</a>
                        </td>
                    </tr>";
            }
            echo '</tbody></table>';
        } else {
            echo '<p class="no-pages">Brak podstron w bazie danych.</p>';
        }
    }

    public function DodajNowaPodstrone($data) {
        $status = isset($data['status']) ? 1 : 0;
        $stmt = $this->link->prepare("INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $data['page_title'], $data['page_content'], $status);

        return $stmt->execute();
    }

    public function EdytujPodstrone($id) {
        $stmt = $this->link->prepare("SELECT page_title, page_content, status FROM page_list WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function ZapiszPodstrone($data) {
        $status = isset($data['status']) ? 1 : 0;
        $stmt = $this->link->prepare("UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ?");
        $stmt->bind_param('ssii', $data['page_title'], $data['page_content'], $status, $data['id']);

        return $stmt->execute();
    }

    public function UsunPodstrone($id) {
        $stmt = $this->link->prepare("DELETE FROM page_list WHERE id = ?");
        $stmt->bind_param('i', $id);

        return $stmt->execute();
    }
}
