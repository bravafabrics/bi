<?php

include("../queries_database.php");

$service = (string)$_POST['service'];
$service = str_replace('_', ' ', $service);
$service = str_replace('__', '(', $service);
$service = str_replace('--', ')', $service);
ajax_update_ship_extra($_POST['date'], $service, $_POST['percentage'], $_POST['fix']);


?>