<?php 

include("prestashop.php");
include("functions.php");


// 28,28,28,28,16,16,16,16,35,35,35,35,43,43,43,43,17,17,17,17,17,17,17,17,28,28,28
// ,28,28,28,28,28,28,28,28,28,16,16,16,16,35,35,35,35,43,43,43,43,17,17,17,17,17,17,
// 17,17,28,28,28,28,28,28,28,28


/*

insert_the_cross_from_ps_by_id_order("9052"); 

$data = "";
$result = get_the_cross_from_ps_by_id_order($id_order);
$crosses = $result->fetchAll();
var_dump($crosses);
/*
foreach ($crosses as $cross) {
    $data = $cross['cross']; // It will return the first object
}

$result->closeCursor();

drop_the_cross_from_ps_by_id_order();

*/
$id_order = "10416";
$data = get_the_cross_from_ps_by_id_order($id_order);

var_dump(getTheCoupleName(getTheCouple($data)));

//var_dump(getTheCoupleName(getTheCouple($data)));

// $data = get_the_cross_from_ps_by_id_order("9069");
// $array_with_Couple = getTheCouple($data);
// $array_with_Couple_Name = getTheCoupleName($array_with_Couple);
// var_dump($array_with_Couple);
// var_dump($array_with_Couple_Name);



?>