<?php
include("../prestashop.php");
$countries_info = ajax_get_countrycode();
echo json_encode($countries_info);
?>