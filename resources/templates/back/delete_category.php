<?php

require_once("../../config.php");

if(isset($_GET['id'])) {

    $query = query("DELETE from categories WHERE cat_id=" . escape_string($_GET['id']));
    confirm($query);


    set_message("Category deleted");
    redirect("../../../public/admin/index.php?categories");
} else {
    redirect("../../../public/admin/index.php?categories");
}

?>