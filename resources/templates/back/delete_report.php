<?php

require_once("../../../resources/config.php");

if(isset($_GET['delete_report_id'])) {

    $query = query(" DELETE FROM reports where report_id=" . escape_string($_GET['delete_report_id']) . " ");
    confirm($query);

    set_message("Report deleted");

    redirect("index.php?reports");
} else {
    redirect("index.php?reports");
}


?>