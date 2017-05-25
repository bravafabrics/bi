<?php

include("queries_database.php"); // About our special database
include("prestashop.php"); // About the prestashop methods 

//create_tables(); // First we create the tables


// Simulate the last seven days
$start  = new DateTime('-7 days', new DateTimeZone('UTC'));
$period = new DatePeriod($start, new DateInterval('P1D'), 7);


foreach ($period as $date) {
	
	
	$result = report_from_ps_sale_by_date($date->format('Y-m-d'));
$requests = $result->fetchAll();
foreach ($requests as $request) {
   insert_datas_or_update($date->format('Y-m-d'), $request['iso_code'], $request['Full Pricing'], ($request['sales_discount'] + $request['coupon_discount']), $request['cogs'], $request['shipping']);

}

$result->closeCursor();
}

 
?>