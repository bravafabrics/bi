<?php

include("../queries_database.php");


ajax_update_handling($_POST['date'], $_POST['packaging_cost'], $_POST['handling_cost'], $_POST['shipping_materals_cost'], $_POST['preparation_cost']);


?>