<?php


include("../queries_database.php");


ajax_insert_marketing($_POST['date'], $_POST['name'], $_POST['country'], $_POST['value']);


// *********** INSERTION DATAWARE HOUSE **// 
update_marketing_cost($_POST['date'], $_POST['country'], $_POST['name'], $_POST['value']);


// UPDATE ALL THE COST

recompute_all_the_total($_POST['date'], $_POST['country']);
	
?>