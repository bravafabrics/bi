<?php

include("queries_database.php"); // About our special database
include("prestashop.php"); // About the prestashop methods 
include("backoffice_logistics.php"); // About the special backoffice database
include("mail.php"); // About the mail action


// Simulate the 730 Days for the first push

$start  = new DateTime('-1 days', new DateTimeZone('UTC'));
$period = new DatePeriod($start, new DateInterval('P1D'), 1);


// ABOUT YESTERDAY : EXECUTE DAILY TIME.
/*
$start  = new DateTime('-45 days', new DateTimeZone('UTC'));
$period = new DatePeriod($start, new DateInterval('P1D'), 45);
*/


foreach ($period as $date) {
	
	$result = report_from_ps_sale_by_date($date->format('Y-m-d'));
$requests = $result->fetchAll();
foreach ($requests as $request) {
	$net_sales = ($request['Full Pricing'] - ($request['sales_discount'] + $request['coupon discount']));
	$profit = ($request['Full Pricing'] - ($request['sales_discount'] + $request['coupon discount']) - $request['gateways']);
    insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request['iso_code'], 
$request['Full Pricing'], ($request['sales_discount'] + $request['coupon discount']), $request['cogs'], $request['shipping'], $net_sales, 
$profit, $request['gateways'],
'0', 
'0', '0', '0', '0', '0', '0', 
'0', '0',
'0', '0', '0', '0', '0',
'0', '0',
'0',
'0', '0');
 
}

$result->closeCursor();




// WE HAVE TO FULFILL AGAIN BUT NOW ITS AN UPDATE 

	$result = report_shipping_logistics_from_ps_sale_by_date($date->format('Y-m-d'));
$requests_ship = $result->fetchAll();
foreach ($requests_ship as $request_ship) {
	
      insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request_ship['countrycode'], 
null, null, null, null, null, null, null,
$request_ship['shipping_logistics'], 
null, null, null, null, null, null, 
null, null,
null, null, null, null, null,
null, null,
null,
null, null); 
   
}

$result->closeCursor();


// ABOUT HANDLING COSTS
	$result = report_handling_from_ps_sale_by_date($date->format('Y-m-d'));
$requests_handling = $result->fetchAll();
foreach ($requests_handling as $request_handling) {
			$which_things_to_update = "
				SELECT * FROM zzz_online_pl WHERE date = '".$date->format('Y-m-d') . "' AND countrycode = '".$request_handling['countrycode'] . "'
			"; 
			$results_about_update = makequery($which_things_to_update);
			$old_variables = $results_about_update->fetchAll();
			foreach ($old_variables as $old_variable) {  
			
    insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request_handling['countrycode'], 
null, null, null, null, null, $old_variable['profit'] - (($old_variable['cogs']+($request_handling['packaging_cost'] + $request_handling['materals_cost']))) - (($old_variable['shipping_logistics'] + ($request_handling['handling_cost']+$request_handling['preparation_cost']) - $old_variable['shipping_paid'])), null,
null, 
$request_handling['handling_cost'], ($request_handling['preparation_cost'] + $request_handling['handling_cost']), ($old_variable['shipping_logistics'] + ($request_handling['handling_cost']+$request_handling['preparation_cost']) - $old_variable['shipping_paid']), 
($request_handling['packaging_cost'] + $request_handling['materals_cost']), $request_handling['materals_cost'], ($old_variable['cogs']+($request_handling['packaging_cost'] + $request_handling['materals_cost'])), 
null, null,
null, null, null, null, null,
null, null,
null,
null, null); // Now we dont push the amount

			}
			$results_about_update->closeCursor();
   
   
   
}

$result->closeCursor();
// END ABOUT HANDLING COST 



}


// STEP 3 FOR GATEWAYS (SEE PRESTASHOP REPORT_FROM_PS_SALE_BY_DATE DOC //

drop_temp_gateway_table();

// STEP 3  FOR SHIPPING LOGISTICS

drop_all_temp_ship_table();

// STEP 3 : FOR HANDLING DROP IT !
drop_handling_table();




foreach ($period as $date) {
	
	// WE HAVE TO BE CAREFUL : WE CAN HAVE NO ORDER FOR A DAY BUT A REFUND FOR THE SAME DAY !!!!!!*
	
insert_empty_values_for_the_datawarehouse($date->format('Y-m-d')); 
}


// NOW WE CAN FULFILL !


$start  = new DateTime('-10 days', new DateTimeZone('UTC'));
$period = new DatePeriod($start, new DateInterval('P1D'), 10);

foreach($period as $date) { 
	$result = report_refunds_from_bv_returns_by_date($date->format('Y-m-d'));
$requests_refund = $result->fetchAll();
foreach ($requests_refund as $request_refund) {
				$which_things_to_update = "
				SELECT * FROM zzz_online_pl WHERE date = '".$date->format('Y-m-d') . "' AND countrycode = '".$request_refund['countrycode'] . "'
			"; 
			$results_about_update = makequery($which_things_to_update);
			$old_variables = $results_about_update->fetchAll();
			foreach ($old_variables as $old_variable) {  
			
		   insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request_refund['countrycode'], 
null, null, null, null, null, ($old_variable['profit'] - $request_refund['refunds_log']), null,
null, 
null, null, ($old_variable['total_logistics']+$request_refund['refunds_log']), null, null, null, 
null, $request_refund['refunds_log'],
null, null, null, null, null,
null, null,
null,
null, null); // Now we dont push the amount 

// Prolfit : ($old_variable['profit'] - ($old_variable['total_logistics'] + $request_refund['refunds_log']) - $old_variable['total_cogs'])
// 		
			
			}
		$results_about_update->closeCursor();	  
}

$result->closeCursor();
}


// STEP 3 : DROP EVERY TEMP TABLE FROM BACKOFFICE BRAVA

drop_all_temp_bv_ship_table();


// DO THE OTHER TABLE RIGHT NOW ! AFTER DROPING !!!!

// DO NOT FORGET !!!!


foreach($period as $date) { 
	$result = report_returns_from_bv_returns_by_date($date->format('Y-m-d'));
$requests_refund = $result->fetchAll();
foreach ($requests_refund as $request_refund) {
				$which_things_to_update = "
				SELECT * FROM zzz_online_pl WHERE date = '".$date->format('Y-m-d') . "' AND countrycode = '".$request_refund['countrycode'] . "'
			"; 
			$results_about_update = makequery($which_things_to_update);
			$old_variables = $results_about_update->fetchAll();
			foreach ($old_variables as $old_variable) {  
			
		   insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request_refund['countrycode'], 
null, null, null, null, null, ($old_variable['profit'] - $request_refund['total_returns']), null,
null, 
null, null, ($old_variable['total_logistics']+$request_refund['total_returns']), null, null, null, 
$request_refund['total_returns'], null,
null, null, null, null, null,
null, null,
null,
null, null); // Now we dont push the amount 

 		
			
			}
		$results_about_update->closeCursor();	  
}

$result->closeCursor();
}


foreach($period as $date) { 
	$result = report_refunds_from_net_sales_from_bv_returns_by_date($date->format('Y-m-d'));
$requests_refund = $result->fetchAll();
foreach ($requests_refund as $request_refund) {
				$which_things_to_update = "
				SELECT * FROM zzz_online_pl WHERE date = '".$date->format('Y-m-d') . "' AND countrycode = '".$request_refund['countrycode'] . "'
			"; 
			$results_about_update = makequery($which_things_to_update);
			$old_variables = $results_about_update->fetchAll();
			foreach ($old_variables as $old_variable) {  
			
		   insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request_refund['countrycode'], 
null, null, null, null, ($old_variable['net_sales'] - $request_refund['refunds']), ($old_variable['profit'] - $request_refund['refunds']), null,
null, 
null, null, null, null, null, null, 
null, null,
null, null, null, null, null,
$request_refund['refunds'], null,
null,
null, null); // Now we dont push the amount 

 		
			
			}
		$results_about_update->closeCursor();	  
}

$result->closeCursor();
}

// REFUND GATEWAYS

foreach($period as $date) { 
	$result = report_refunds_gateways_from_net_sales_from_bv_returns_by_date($date->format('Y-m-d'));
$requests_refund = $result->fetchAll();
foreach ($requests_refund as $request_refund) {
				$which_things_to_update = "
				SELECT * FROM zzz_online_pl WHERE date = '".$date->format('Y-m-d') . "' AND countrycode = '".$request_refund['countrycode'] . "'
			"; 
			$results_about_update = makequery($which_things_to_update);
			$old_variables = $results_about_update->fetchAll();
			foreach ($old_variables as $old_variable) {  
			
		   insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request_refund['countrycode'], 
null, null, null, null, null, ($old_variable['profit'] - $request_refund['refunds_gateways']), ($old_variable['gateways'] - $request_refund['refunds_gateways']),
null, 
null, null, null, null, null, null, 
null, null,
null, null, null, null, null,
null, $request_refund['refunds_gateways'],
null,
null, null); // Now we dont push the amount 

 		
			
			}
		$results_about_update->closeCursor();	  
}

$result->closeCursor();
}

// Refund Cogs !

foreach($period as $date) { 
	$result = report_refunds_from_net_sales_from_bv_returns_by_date($date->format('Y-m-d'));
$requests_refund = $result->fetchAll();
foreach ($requests_refund as $request_refund) {
				$which_things_to_update = "
				SELECT * FROM zzz_online_pl WHERE date = '".$date->format('Y-m-d') . "' AND countrycode = '".$request_refund['countrycode'] . "'
			"; 
			$results_about_update = makequery($which_things_to_update);
			$old_variables = $results_about_update->fetchAll();
			foreach ($old_variables as $old_variable) {  
		   insert_datas_or_update_to_datawarehouse($date->format('Y-m-d'), $request_refund['countrycode'], 
null, null, null, null, null, ($old_variable['profit'] + (get_ratio_cogs()*$request_refund['refunds'])), null,
null, 
null, null, null, null, null, ($old_variable['total_cogs'] + (get_ratio_cogs()*$request_refund['refunds'])), 
null, null,
null, null, null, null, null,
null, null,
$refund_cogs,
null, null); // Now we dont push the amount 

 		
			
			}
		$results_about_update->closeCursor();	  
}

$result->closeCursor();
}


// !!!!
/// !!!! 

// Sending the mail !
date_default_timezone_set("Europe/Madrid");		
$set_local_time = new DateTimeZone("Europe/Madrid"); // Lets Set the timezone (Europe)

$yesterday_date = new DateTime(date("Y-m-d"), $set_local_time); // Today's date !
$yesterday_date->modify('-1 day');

$finale_yesterday = $yesterday_date->format("Y-m-d");
// $finale_yesterday = '2017-05-05';

send_mail((get_net_sales($finale_yesterday, '')+get_shipping_paid($finale_yesterday, '')));
 
?>