<?php
include("../queries_database.php");
$all_infos = get_the_number_of_distinct_weight($_GET['service']);
echo json_encode($all_infos);
?>