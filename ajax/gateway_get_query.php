<?php
include("../queries_database.php");
$gateway_info = get_all_gateways();
echo json_encode($gateway_info);
?>