<?php 

require_once("../../config.php");

if(isset($_GET['id'])) {

    $query = query(" DELETE FROM users where user_id=". escape_string($_GET['id']) . " ");
    confirm($query);

    set_message("user deleted");
    redirect("../../../public/admin/index.php?users");
} else {
    redirect("../../../public/admin/index.php?users");
}


?>