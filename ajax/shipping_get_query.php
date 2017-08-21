<?php
include("../queries_database.php");
$all_infos = get_all_infos_from_shipping_courier($_GET['service']);
echo json_encode($all_infos);
?>