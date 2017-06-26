<?php

include("../queries_database.php");

ajax_update_marketing($_POST['date'], $_POST['country'], $_POST['name'], $_POST['value']);
// *********** INSERTION DATAWARE HOUSE **// 
update_marketing_cost($_POST['date'], $_POST['country'], $_POST['name'], $_POST['value']);

?>