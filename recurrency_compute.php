<?php 


include("prestashop.php");
include("queries_database.php");
include("mail.php");


// **************** ALL ABOUT TODAY'S DATE *********/
date_default_timezone_set("Europe/Madrid");		
$set_local_time = new DateTimeZone("Europe/Madrid"); // Lets Set the timezone (Europe)
$current_month = new DateTime(date("Y-m-d"), $set_local_time);

$matrix_absolutios = fulfill_valores_matrix($current_month); // Fulfilling the valores Matrix
$matrix_relativos = fulfill_relativos_matrix($current_month); // Fulfilling the relativos Matrix
echo "<h1>Valores absolutos = número de pedidos</h1>";
see_a_matrix_in_a_table($matrix_absolutios); // Show the matrix in HTML
echo "<br />";
echo "<h1>Valores relativos (pedido / cliente de la cohorte)</h1><br />";
see_a_matrix_in_a_table($matrix_relativos); // Show the matrix

$average = average_from_relativos_matrix($matrix_relativos, $current_month); // Fulfilling the average matrix
$average_first_half = array_slice($average, 0, count($average) / 2); // fulfillong the average but only the half (to get the 12 months recurrency report).
see_array_and_return_recurrency($average); // show it

echo array_sum($average); // Sum the average to get the recurrency

ajax_insert_recurrency($current_month->format("Y-m-01"), array_sum($average)); // Insert it in the database
send_mail_recurrency (array_sum($average), array_sum($average_first_half)); // Send the mail

function get_the_number_month_to_add($int, $to_add) { 
// THIS FUNCTION JUST RETURNS THE NUMBER OF THE MONTH, IF IT IS 13, it returns 1

for ($i = 0; $i < $to_add; $i++) { 
$int++;
if($int == 13) $int = 1;


}
return $int;
}

function year_to_add($int, $to_add, $year_begin) { 

// THIS FUNCTION JUST THE YEAR, IF THE MONTH IS 13, IT JUMPS A YEAR
$year_to_add = 0;

for ($i = 0; $i < $to_add; $i++) { 
$int++;
if($int == 13) {  $int = 1;  $year_to_add++; }


}
return $year_begin + $year_to_add;
}

function fulfill_valores_matrix($today) {  
// FULFILLING VALORES MATRIX
$valores_absolutos = array(); 
$return_number = return_number_month_before_may_fifteen("2015-05-01", $today->format("Y-m-01"));

// FIRST FULFILLING, JUST MONTH AND NUEVOS CLIENTES MES M
for ($i = 0; $i < $return_number; $i++) { 
$new_month = date('M-y',strtotime(date("2015-05-01", time()) . " + ".$i." month"));
$new_month_format = new DateTime(date('Y-m-d',strtotime(date("2015-05-01", time()) . " + ".$i." month")));
$end_month_format = $new_month_format->modify("+1 month");
$end_month_format = $new_month_format->modify("-1 day");
$valores_absolutos[$i] = array($new_month, get_nuevos_clientes_mes_m($new_month_format->format("Y-m-01 00:00:00"), $end_month_format->format("Y-m-d 23:59:59"), true),
get_nuevos_clientes_mes_m($new_month_format->format("Y-m-01 00:00:00"), $end_month_format->format("Y-m-d 23:59:59"), false),
null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
}

// OTHER NUMBERS BY USING THE SECOND QUERY
for ($i = 0; $i < $return_number; $i++) { 
$new_month = date('M-y',strtotime(date("2015-05-01", time()) . " + ".$i." month"));
$new_month_format = new DateTime(date('Y-m-d',strtotime(date("2015-05-01", time()) . " + ".$i." month")));
$end_month_format = $new_month_format->modify("+1 month");
$end_month_format = $new_month_format->modify("-1 day");
$reccur_m_number = intval($end_month_format->format("m"));
// +1, +2, +3, .... +25
$result = get_reccur_m($end_month_format->format("Y-m-d 23:59:59"));
$datas = $result->fetchAll();
// USE THE PRESTASHOP REQUEST
foreach($datas as $data) { 


if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 1) && $data['año'] == year_to_add($reccur_m_number, 1, intval($end_month_format->format("Y")))) $valores_absolutos[$i][3] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 2) && $data['año'] == year_to_add($reccur_m_number, 2, intval($end_month_format->format("Y")))) $valores_absolutos[$i][4] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 3) && $data['año'] == year_to_add($reccur_m_number, 3, intval($end_month_format->format("Y")))) $valores_absolutos[$i][5] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 4) && $data['año'] == year_to_add($reccur_m_number, 4, intval($end_month_format->format("Y")))) $valores_absolutos[$i][6] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 5) && $data['año'] == year_to_add($reccur_m_number, 5, intval($end_month_format->format("Y")))) $valores_absolutos[$i][7] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 6) && $data['año'] == year_to_add($reccur_m_number, 6, intval($end_month_format->format("Y")))) $valores_absolutos[$i][8] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 7) && $data['año'] == year_to_add($reccur_m_number, 7, intval($end_month_format->format("Y")))) $valores_absolutos[$i][9] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 8) && $data['año'] == year_to_add($reccur_m_number, 8, intval($end_month_format->format("Y")))) $valores_absolutos[$i][10] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 9) && $data['año'] == year_to_add($reccur_m_number, 9, intval($end_month_format->format("Y")))) $valores_absolutos[$i][11] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 10) && $data['año'] == year_to_add($reccur_m_number, 10, intval($end_month_format->format("Y")))) $valores_absolutos[$i][12] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 11) && $data['año'] == year_to_add($reccur_m_number, 11, intval($end_month_format->format("Y")))) $valores_absolutos[$i][13] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 12) && $data['año'] == year_to_add($reccur_m_number, 12, intval($end_month_format->format("Y")))) $valores_absolutos[$i][14] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 13) && $data['año'] == year_to_add($reccur_m_number, 13, intval($end_month_format->format("Y")))) $valores_absolutos[$i][15] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 14) && $data['año'] == year_to_add($reccur_m_number, 14, intval($end_month_format->format("Y")))) $valores_absolutos[$i][16] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 15) && $data['año'] == year_to_add($reccur_m_number, 15, intval($end_month_format->format("Y")))) $valores_absolutos[$i][17] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 16) && $data['año'] == year_to_add($reccur_m_number, 16, intval($end_month_format->format("Y")))) $valores_absolutos[$i][18] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 17) && $data['año'] == year_to_add($reccur_m_number, 17, intval($end_month_format->format("Y")))) $valores_absolutos[$i][19] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 18) && $data['año'] == year_to_add($reccur_m_number, 18, intval($end_month_format->format("Y")))) $valores_absolutos[$i][20] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 19) && $data['año'] == year_to_add($reccur_m_number, 19, intval($end_month_format->format("Y")))) $valores_absolutos[$i][21] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 20) && $data['año'] == year_to_add($reccur_m_number, 20, intval($end_month_format->format("Y")))) $valores_absolutos[$i][22] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 21) && $data['año'] == year_to_add($reccur_m_number, 21, intval($end_month_format->format("Y")))) $valores_absolutos[$i][23] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 22) && $data['año'] == year_to_add($reccur_m_number, 22, intval($end_month_format->format("Y")))) $valores_absolutos[$i][24] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 23) && $data['año'] == year_to_add($reccur_m_number, 23, intval($end_month_format->format("Y")))) $valores_absolutos[$i][25] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 24) && $data['año'] == year_to_add($reccur_m_number, 24, intval($end_month_format->format("Y")))) $valores_absolutos[$i][26] = $data['count']; 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 25) && $data['año'] == year_to_add($reccur_m_number, 25, intval($end_month_format->format("Y")))) $valores_absolutos[$i][27] = $data['count']; 


 }

}


return $valores_absolutos;
}  



function fulfill_relativos_matrix($today) {  


// SAME THING FOR RELATIVOS BUT IT MAKES THE DIVISON
$valores_absolutos = array(); 
$return_number = return_number_month_before_may_fifteen("2015-05-01", $today->format("Y-m-01"));

for ($i = 0; $i < $return_number; $i++) { 
$new_month = date('M-y',strtotime(date("2015-05-01", time()) . " + ".$i." month"));
$new_month_format = new DateTime(date('Y-m-d',strtotime(date("2015-05-01", time()) . " + ".$i." month")));
$end_month_format = $new_month_format->modify("+1 month");
$end_month_format = $new_month_format->modify("-1 day");
$get_nuevos = get_nuevos_clientes_mes_m($new_month_format->format("Y-m-01 00:00:00"), $end_month_format->format("Y-m-d 23:59:59"), true);
$get_nuevos_false = get_nuevos_clientes_mes_m($new_month_format->format("Y-m-01 00:00:00"), $end_month_format->format("Y-m-d 23:59:59"), false)/$get_nuevos;
$valores_absolutos[$i] = array($new_month, $get_nuevos, ROUND($get_nuevos_false,2),
null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
}

for ($i = 0; $i < $return_number; $i++) { 
$new_month = date('M-y',strtotime(date("2015-05-01", time()) . " + ".$i." month"));
$new_month_format = new DateTime(date('Y-m-d',strtotime(date("2015-05-01", time()) . " + ".$i." month")));
$end_month_format = $new_month_format->modify("+1 month");
$end_month_format = $new_month_format->modify("-1 day");
$reccur_m_number = intval($end_month_format->format("m"));
// +1, +2, +3, .... +25
$result = get_reccur_m($end_month_format->format("Y-m-d 23:59:59"));
$datas = $result->fetchAll();

foreach($datas as $data) { 


if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 1) && $data['año'] == year_to_add($reccur_m_number, 1, intval($end_month_format->format("Y")))) $valores_absolutos[$i][3] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 2) && $data['año'] == year_to_add($reccur_m_number, 2, intval($end_month_format->format("Y")))) $valores_absolutos[$i][4] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 3) && $data['año'] == year_to_add($reccur_m_number, 3, intval($end_month_format->format("Y")))) $valores_absolutos[$i][5] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 4) && $data['año'] == year_to_add($reccur_m_number, 4, intval($end_month_format->format("Y")))) $valores_absolutos[$i][6] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 5) && $data['año'] == year_to_add($reccur_m_number, 5, intval($end_month_format->format("Y")))) $valores_absolutos[$i][7] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 6) && $data['año'] == year_to_add($reccur_m_number, 6, intval($end_month_format->format("Y")))) $valores_absolutos[$i][8] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 7) && $data['año'] == year_to_add($reccur_m_number, 7, intval($end_month_format->format("Y")))) $valores_absolutos[$i][9] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 8) && $data['año'] == year_to_add($reccur_m_number, 8, intval($end_month_format->format("Y")))) $valores_absolutos[$i][10] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 9) && $data['año'] == year_to_add($reccur_m_number, 9, intval($end_month_format->format("Y")))) $valores_absolutos[$i][11] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 10) && $data['año'] == year_to_add($reccur_m_number, 10, intval($end_month_format->format("Y")))) $valores_absolutos[$i][12] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 11) && $data['año'] == year_to_add($reccur_m_number, 11, intval($end_month_format->format("Y")))) $valores_absolutos[$i][13] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 12) && $data['año'] == year_to_add($reccur_m_number, 12, intval($end_month_format->format("Y")))) $valores_absolutos[$i][14] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 13) && $data['año'] == year_to_add($reccur_m_number, 13, intval($end_month_format->format("Y")))) $valores_absolutos[$i][15] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 14) && $data['año'] == year_to_add($reccur_m_number, 14, intval($end_month_format->format("Y")))) $valores_absolutos[$i][16] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 15) && $data['año'] == year_to_add($reccur_m_number, 15, intval($end_month_format->format("Y")))) $valores_absolutos[$i][17] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 16) && $data['año'] == year_to_add($reccur_m_number, 16, intval($end_month_format->format("Y")))) $valores_absolutos[$i][18] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 17) && $data['año'] == year_to_add($reccur_m_number, 17, intval($end_month_format->format("Y")))) $valores_absolutos[$i][19] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 18) && $data['año'] == year_to_add($reccur_m_number, 18, intval($end_month_format->format("Y")))) $valores_absolutos[$i][20] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 19) && $data['año'] == year_to_add($reccur_m_number, 19, intval($end_month_format->format("Y")))) $valores_absolutos[$i][21] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 20) && $data['año'] == year_to_add($reccur_m_number, 20, intval($end_month_format->format("Y")))) $valores_absolutos[$i][22] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 21) && $data['año'] == year_to_add($reccur_m_number, 21, intval($end_month_format->format("Y")))) $valores_absolutos[$i][23] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 22) && $data['año'] == year_to_add($reccur_m_number, 22, intval($end_month_format->format("Y")))) $valores_absolutos[$i][24] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 23) && $data['año'] == year_to_add($reccur_m_number, 23, intval($end_month_format->format("Y")))) $valores_absolutos[$i][25] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 24) && $data['año'] == year_to_add($reccur_m_number, 24, intval($end_month_format->format("Y")))) $valores_absolutos[$i][26] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 
if($data['mes'] == get_the_number_month_to_add($reccur_m_number, 25) && $data['año'] == year_to_add($reccur_m_number, 25, intval($end_month_format->format("Y")))) $valores_absolutos[$i][27] = ROUND(($data['count']/$valores_absolutos[$i][1]), 4); 


 }

}


return $valores_absolutos;
} 


function sum_divide_by_total($array, $today, $number) { 
// ALL ABOUT THE AVERAGE
$s = 0;
foreach ($array as $matrix) { 

$s+= floatval($matrix[$number]);
}
return ROUND($s/return_number_month_before_may_fifteen("2015-05-01", $today->format("Y-m-01")),3);
}

function average_from_relativos_matrix($array, $today) { 
$recurrencia_media = array();

for ($i = 0; $i < 26; $i++)
	if($i == 25) $recurrencia_media[$i] = ROUND(-0.005*log(24)+0.0339, 4);
		else 
$recurrencia_media[$i] = sum_divide_by_total($array, $today, ($i+2)); // 2 until 27


return $recurrencia_media;

}


function return_number_month_before_may_fifteen($d1, $d2) {  

// Get the number of the month before May 15'
$d1 = strtotime($d1);
$d2 = strtotime($d2);
$min_date = min($d1, $d2);
$max_date = max($d1, $d2);
$i = 0;

while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) $i++;
return $i;
 } 
  
function see_array_and_return_recurrency($array) { 

	
?>

<table style="width:100%">
  <tr>
    <th>Mes Primera Compra</th>
    <th>Nuevos Clientes Mes M</th> 
    <th>Pedidos nuevos clientes mes M</th>
	<th>Recurr. M+1</th>
	<th>Recurr. M+2</th>
	<th>Recurr. M+3</th>
	<th>Recurr. M+4</th>
	<th>Recurr. M+5</th>
	<th>Recurr. M+6</th>
	<th>Recurr. M+7</th>
	<th>Recurr. M+8</th>
	<th>Recurr. M+9</th>
	<th>Recurr. M+10</th>
	<th>Recurr. M+11</th>
	<th>Recurr. M+12</th>
	<th>Recurr. M+13</th>
	<th>Recurr. M+14</th>
	<th>Recurr. M+15</th>
	<th>Recurr. M+16</th>
	<th>Recurr. M+17</th>
	<th>Recurr. M+18</th>
	<th>Recurr. M+19</th>
	<th>Recurr. M+20</th>
	<th>Recurr. M+21</th>
	<th>Recurr. M+22</th>
	<th>Recurr. M+23</th>
	<th>Recurr. M+24</th>
	<th>Recurr. M+25</th>
  </tr>
  <tr style="text-align:center;">
  <td>Reccurencia media</td>
  <td>+proyectada</td>
  <?php
  foreach($array as $line)  { 
	?>
	<td style="background-color:green;"><?php echo $line; ?></td>
	<?php

  }
  
  ?>
	</tr>
</table>	
<?php

}  
  
function see_a_matrix_in_a_table($array) { 



?>

<table style="width:100%">
  <tr>
    <th>Mes Primera Compra</th>
    <th>Nuevos Clientes Mes M</th> 
    <th>Pedidos nuevos clientes mes M</th>
	<th>Recurr. M+1</th>
	<th>Recurr. M+2</th>
	<th>Recurr. M+3</th>
	<th>Recurr. M+4</th>
	<th>Recurr. M+5</th>
	<th>Recurr. M+6</th>
	<th>Recurr. M+7</th>
	<th>Recurr. M+8</th>
	<th>Recurr. M+9</th>
	<th>Recurr. M+10</th>
	<th>Recurr. M+11</th>
	<th>Recurr. M+12</th>
	<th>Recurr. M+13</th>
	<th>Recurr. M+14</th>
	<th>Recurr. M+15</th>
	<th>Recurr. M+16</th>
	<th>Recurr. M+17</th>
	<th>Recurr. M+18</th>
	<th>Recurr. M+19</th>
	<th>Recurr. M+20</th>
	<th>Recurr. M+21</th>
	<th>Recurr. M+22</th>
	<th>Recurr. M+23</th>
	<th>Recurr. M+24</th>
	<th>Recurr. M+25</th>
  </tr>
  <tr style="text-align:center;">
<?php
foreach ($array as $matrix) {
	$sizeMatrix = sizeOf($matrix);
	for ($j = 0; $j < $sizeMatrix; $j++) { 
		if($matrix[$j] != null && $j > 1) $style = "text-align:center;background-color:green;";
		else if($j == 1) $style = "text-align:center;background-color:blue;color:white";
		else $style = "text-align:center;";
	?>
	<td style="<?php echo $style; ?>">
	<?php
	echo $matrix[$j];
	?>
	</td>
	<?php
	}
    ?>
	</tr>
	<?php
}
?>

 
  
</table>
<?php

}  
  
// echo $valores_absolutos[0][0].": In stock: ".$valores_absolutos[0][1].", sold: ".$valores_absolutos[0][2].".<br>";
// echo $valores_absolutos[1][0].": In stock: ".$valores_absolutos[1][1].", sold: ".$valores_absolutos[1][2].".<br>";
// echo $valores_absolutos[2][0].": In stock: ".$valores_absolutos[2][1].", sold: ".$valores_absolutos[2][2].".<br>";
// echo $valores_absolutos[3][0].": In stock: ".$valores_absolutos[3][1].", sold: ".$valores_absolutos[3][2].".<br>";  
  
?>