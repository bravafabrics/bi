<?php


include("../queries_database.php");


$set_local_time = new DateTimeZone("Europe/Madrid"); // Lets Set the timezone (Europe)
$now = new DateTime(date("Y-m-d"), $set_local_time);
$payment_method = (string)$_POST['payment_method'];
$payment_method = str_replace('_', ' ', $payment_method);
$payment_method = str_replace('0', '(', $payment_method);
$payment_method = str_replace('1', ')', $payment_method);
ajax_insert_gateway($now->format("Y-m-d"), $payment_method, $_POST['percentage'], $_POST['fix']);

?>