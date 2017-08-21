<?php


include("../queries_database.php");

ajax_insert_zone($_POST['country_code'], $_POST['service'], $_POST['zone']);

?>