<?php

require_once("../../../resources/config.php");

if(isset($_GET['delete_order_id'])) {

    $query = query("DELETE from orders WHERE order_id=" . escape_string($_GET['delete_order_id']));
    confirm($query);


    set_message("Order deleted");
    redirect("index.php?orders");

}

?>