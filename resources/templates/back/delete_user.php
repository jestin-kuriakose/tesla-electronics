<?php 

require_once("../../../resources/config.php");

if(isset($_GET['delete_user_id'])) {

    $query = query(" DELETE FROM users where user_id=". escape_string($_GET['delete_user_id']) . " ");
    confirm($query);

    set_message("user deleted");
    redirect("index.php?users");
} else {
    redirect("index.php?users");
}


?>