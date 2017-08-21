<?php
include("../queries_database.php");
$market_info = ajax_get_marketing($_GET['date']);
echo json_encode($market_info);
?>