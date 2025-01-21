<?php

include('cfg.php');


function PokazPodstrone() {
    global $link;

    $query = "SELECT page_content FROM page_list WHERE status = 1 ORDER BY created_at ASC LIMIT 1";
    $result = $link->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['page_content'];
    }
    return "[nie_znaleziono_strony]";
}
