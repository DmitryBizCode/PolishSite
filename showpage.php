<?php

include('cfg.php');


function PokazPodstrone($id) {
    global $link; 

    $id_clear = (int)$id;

    $query = "SELECT * FROM page_list WHERE id = '$id_clear' LIMIT 1";
    $result = $link->query($query);


    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    
        return $row['page_content'];
    }
    return "[nie_znaleziono_strony]";
}
