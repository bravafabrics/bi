<?php

include("queries_database.php"); // About our special database
include("prestashop.php"); // About the prestashop methods 



// Simulate the 730 Days for the first push
/*
$start  = new DateTime('-730 days', new DateTimeZone('UTC'));
$period = new DatePeriod($start, new DateInterval('P1D'), 730);
*/

// ABOUT YESTERDAY : EXECUTE DAILY TIME.
$start  = new DateTime('-1 days', new DateTimeZone('UTC'));
$period = new DatePeriod($start, new DateInterval('P1D'), 1);

foreach ($period as $date) {
	
	
	$result = report_from_ps_sale_by_date($date->format('Y-m-d'));
$requests = $result->fetchAll();
foreach ($requests as $request) {
   insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request['iso_code'], $request['Full Pricing'], 
   ($request['sales_discount'] + $request['coupon discount']), $request['cogs'], $request['shipping'], ($request['Full Pricing'] - ($request['sales_discount'] + $request['coupon discount'])));

}

$result->closeCursor();
}
foreach ($period as $date) {
insert_empty_values_for_the_datawarehouse($date->format('Y-m-d'));
}

 
?>