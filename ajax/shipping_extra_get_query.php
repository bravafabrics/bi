<?php
include("../queries_database.php");
$extra_ship_info = get_all_extra_ship();
echo json_encode($extra_ship_info);
?>