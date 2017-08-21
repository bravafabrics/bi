<?php
include("../queries_database.php");
$hand_info = get_all_handling();
echo json_encode($hand_info);
?>