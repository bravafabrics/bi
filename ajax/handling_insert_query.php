<?php


include("../queries_database.php");


$set_local_time = new DateTimeZone("Europe/Madrid"); // Lets Set the timezone (Europe)
$now = new DateTime(date("Y-m-d"), $set_local_time);

// function ajax_insert_handling($date, $packaging_cost, $handling_cost, $shipping_materals_cost, $preparation_cost) 
ajax_insert_handling($now->format("Y-m-d"), $_POST['packaging_cost'], $_POST['handling_cost'],
 $_POST['shipping_materals_cost'], $_POST['preparation_cost']);

?>