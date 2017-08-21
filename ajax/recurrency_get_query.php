<?php
include("../queries_database.php");
$recurrencies = ajax_get_recurrency();
echo json_encode($recurrencies);
?>