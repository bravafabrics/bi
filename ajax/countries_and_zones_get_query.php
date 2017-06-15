<?php
include("../queries_database.php");
$countries_info = get_all_countrycode_coming_from_service($_GET['service']);
echo json_encode($countries_info);
?>