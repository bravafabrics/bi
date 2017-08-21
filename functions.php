<?php
function getTheCouple($data) {
$array = explode(",", $data); // Into an Array
$array = array_values(array_unique($array)); 
$finale_array = array();

for ($i = 0; $i < sizeOf($array); $i++) {  

	for ($j = 0; $j < sizeOf($array); $j++) { 
	if($array[$i] != $array[$j])
				array_push($finale_array, min($array[$i], $array[$j]) . "-" . max($array[$i], $array[$j]));
	
	} 

}
return array_values(array_unique($finale_array));
}

function getTheCoupleName($array) {  
$array_with_Couple_Name = array();
foreach ($array as $value) {
$temporary_array = explode("-", $value);
array_push($array_with_Couple_Name, get_the_name_of_a_category($temporary_array[0]) . " - ".get_the_name_of_a_category($temporary_array[1])); 
 }
 
return $array_with_Couple_Name; 


 }

?>