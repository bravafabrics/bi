<?php
include("../queries_database.php");
$zone_info = get_all_zones();
echo json_encode($zone_info);
?>