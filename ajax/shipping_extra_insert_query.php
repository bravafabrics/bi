<?php


include("../queries_database.php");


$set_local_time = new DateTimeZone("Europe/Madrid"); // Lets Set the timezone (Europe)
$now = new DateTime(date("Y-m-d"), $set_local_time);
$service = (string)$_POST['service'];
ajax_insert_ship_extra($now->format("Y-m-d"), $service, $_POST['percentage'], $_POST['fix']);

?>