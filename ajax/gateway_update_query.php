<?php

include("../queries_database.php");

$payment_method = (string)$_POST['payment_method'];
$payment_method = str_replace('_', ' ', $payment_method);
$payment_method = str_replace('0', '(', $payment_method);
$payment_method = str_replace('1', ')', $payment_method);

ajax_update_gateway($_POST['date'], $payment_method, $_POST['percentage'], $_POST['fix']);


?>