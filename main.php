<?php

include("queries_database.php"); // About our special database
include("prestashop.php"); // About the prestashop methods 



// Simulate the 730 Days for the first push
/*
$start  = new DateTime('-730 days', new DateTimeZone('UTC'));
$period = new DatePeriod($start, new DateInterval('P1D'), 730);
*/

// ABOUT YESTERDAY : EXECUTE DAILY TIME.

$start  = new DateTime('-730 days', new DateTimeZone('UTC'));
$period = new DatePeriod($start, new DateInterval('P1D'), 730);



foreach ($period as $date) {
	
	$result = report_from_ps_sale_by_date($date->format('Y-m-d'));
$requests = $result->fetchAll();
foreach ($requests as $request) {
   insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request['iso_code'], $request['Full Pricing'], 
   ($request['sales_discount'] + $request['coupon discount']), $request['cogs'], $request['shipping'], ($request['Full Pricing'] - ($request['sales_discount'] + $request['coupon discount'])),
   $request['gateways'], '0', '0', '0', '0', '0'); // Now we dont push the amount
}

$result->closeCursor();



// WE HAVE TO FULFILL AGAIN BUT NOW ITS AN UPDATE 

	$result = report_shipping_logistics_from_ps_sale_by_date($date->format('Y-m-d'));
$requests_ship = $result->fetchAll();
foreach ($requests_ship as $request_ship) {
   insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request_ship['countrycode'], null, 
   null, null, null, null,
   null, $request_ship['shipping_logistics'], null, null, null, null); // Now we dont push the amount
}

$result->closeCursor();


// ABOUT HANDLING COSTS
	$result = report_handling_from_ps_sale_by_date($date->format('Y-m-d'));
$requests_handling = $result->fetchAll();
foreach ($requests_handling as $request_handling) {
   insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request_handling['countrycode'], null, 
   null, null, null, null,
   null, null, $request_handling['packaging_cost'], $request_handling['handling_cost'], $request_handling['preparation_cost'], $request_handling['materals_cost']); // Now we dont push the amount
}
// END ABOUT HANDLING COST 

}


// STEP 3 FOR GATEWAYS (SEE PRESTASHOP REPORT_FROM_PS_SALE_BY_DATE DOC //

drop_temp_gateway_table();

// STEP 3  FOR SHIPPING LOGISTICS

drop_all_temp_ship_table();

// STEP 3 : FOR HANDLING DROP IT !
drop_handling_table();


foreach ($period as $date) {
insert_empty_values_for_the_datawarehouse($date->format('Y-m-d'));
}

 
?>