<?php

include("queries_database.php"); // About our special database
include("prestashop.php"); // About the prestashop methods 
include("backoffice_logistics.php"); // About the special backoffice database
include("mail.php"); // About the mail action
include("facebook.php"); // About facebook API
include("google.php"); // About google adwords API


// LETS BEGIN AT THE 2016-12-18 !!!!


// Simulate the 730 Days for the first push WE STOP AT ROUND 4
$start  = new DateTime('-15 days', new DateTimeZone('UTC'));
$period = new DatePeriod($start, new DateInterval('P1D'), 13);



// ABOUT YESTERDAY : EXECUTE DAILY TIME.
/*
$start  = new DateTime('-45 days', new DateTimeZone('UTC'));
$period = new DatePeriod($start, new DateInterval('P1D'), 45);
*/
date_default_timezone_set("Europe/Madrid");		
$set_local_time = new DateTimeZone("Europe/Madrid"); // Lets Set the timezone (Europe)
$yesterday_date = new DateTime(date("Y-m-d"), $set_local_time); // Today's date !
$yesterday_date->modify('-1 day');
$date_yesterday = $yesterday_date->format("Y-m-d");

////////// ******************************** FULFILLING THE ONLY DATAS COMING FROM PRESTASHOP *********************** //


	// foreach($period as $date) { 
		// $date_yesterday = $date->format("Y-m-d");
$result = report_all_datas_from_ps($date_yesterday);
$datas = $result->fetchAll();
foreach($datas as $data) insert_all_datas_in_ecommerce_orders($data['id_order'], $data['date'], $data['countrycode'], $data['total_paid_ps'], $data['fullpricing'],
$data['discount'], $data['cogs'], $data['shipping'], $data['payment_method'], $data['carrier'], $data['product_quantity'], $data['new_customer']);

$result->closeCursor();



/// ******************************** FULLFILLING THE DATAS COMING FROM BRAVA DATA BASE *************** //


// ********************* STEP 1 : REFUNDS *************** //

$result = report_from_exchanges_and_refunds_about_devoluciones($date_yesterday);
$datas = $result->fetchAll();
foreach($datas as $data) 
insert_all_datas_in_refunds($data['id_refund'], $data['id_order'], $data['return_date'], $data['country'], $data['refunded_novat'], 
$data['pay_method'], $data['logistic_consideration']);

$result->closeCursor();




// ******************* STEP 2 : EXCHANGES ************** //
// foreach($period as $date) { 
$result = report_from_exchanges_about_envios($date_yesterday);
$datas = $result->fetchAll();
foreach($datas as $data) 
insert_all_datas_in_exchanges($data['date'], $data['country'], $data['number_returns'], $data['service_go_brava'], $data['service_go_cust']);

$result->closeCursor();
// }


/// ************************ PART ONE : ****************************************** //
///// ###################### NET SALES + COGS + GATEWAYS ! ########################################### ****/// 
/// ******************************* -------------***********************************//

// ********************* NET SALES INCLUDES : FullPricing, Discount, Shipping Paid, Gateway, Cogs, Net Sales Sum
// ************* THIS ONE INCLUDES 0 FOR ALL OTHER ITEMS !    ONLY FOR THE FIRST ONE !


$result = report_from_ecommerce_orders_net_sales_gateways_cogs_group_by_country($date_yesterday);
$datas = $result->fetchAll();
foreach($datas as $data) {
	
insert_datas_or_update_to_datawarehouse($date_yesterday, $data['countrycode'], 
$data['fullpricing'], $data['discount'], $data['cogs'], $data['shipping_paid'], '0', '0', $data['gateways'],
'0', 
'0', '0', '0', '0', '0', '0', 
'0', '0',
'0', '0', '0', '0', '0', 
'0', '0',
'0',
'0', '0',
'0',
'0', '0', '0');
}

$result->closeCursor();


// PRELIMINARY PART : EMPTY COUNTRIES ****************************//

// #################### IF A COUNTRY HAD NO SALES FROM THE CURRENT DATE AND THE RECURRENCY FOR CUSTOMER ACQUSITION ######--------

insert_empty_values_for_the_datawarehouse($date_yesterday); 
update_all_recurrency(get_recent_recurrency());

/// ************************ PART TWO 2-1 : ****************************************** //
///// ###################### SHIPPING LOGISTICS ! ########################################### ****/// 
/// ******************************* -------------***********************************//


$result = report_from_ecommerce_orders_shipping_logistics_group_by_country($date_yesterday);
$datas = $result->fetchAll();
foreach($datas as $data) {
	
insert_datas_or_update_to_datawarehouse($date_yesterday, $data['countrycode'], 
null, null, null, null, null, null, null,
$data['shipping_logistics'], 
null, null, null, null, null, null, 
null, null,
null, null, null, null, null, 
null, null,
null,
null, null,
null,
null, null, null);
}

$result->closeCursor();

/// ************************ PART TWO 2-2 AND 3.1 : ****************************************** //
///// ###################### HANDLING COST, ORDER PREPARATION, (TOTAL LOGISTICS), PACKAGING COST, SHIPPING MATERALS! ########################################### ****/// 
/// ******************************* -------------***********************************//

$result = report_from_ecommerce_orders_handling_cost_group_by_country($date_yesterday);
$datas = $result->fetchAll();
foreach($datas as $data) {
	
insert_datas_or_update_to_datawarehouse($date_yesterday, $data['countrycode'], 
null, null, null, null, null, null, null,
null, 
$data['handling_cost'], $data['preparation_cost'], null, $data['packaging_cost'], $data['materals_cost'], null, 
null, null,
null, null, null, null, null, 
null, null,
null,
null, null,
null,
null, null, null);
}

$result->closeCursor();




// FULFILL EMPTY ** //

// ********** PART THREE : REFUNDS ***************** //

$result = report_from_refunds_all_refunds_cost_group_by_country($date_yesterday);
$datas = $result->fetchAll();
foreach($datas as $data) 
insert_datas_or_update_to_datawarehouse($date_yesterday, $data['countrycode'], 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
null, $data['refunds_logistic'],
null, null, null, null, null, 
$data['refunds'], $data['refund_gateways'],
$data['refunds']*get_ratio_cogs(),
null, null,
null,
null, null, null);

$result->closeCursor();


// *********** PART FOUR : EXCHANGES LOGISTIC *********** //


$result = report_from_exchanges_all_logistic_cost_group_by_country($date_yesterday);
$datas = $result->fetchAll();
foreach($datas as $data) { 


insert_datas_or_update_to_datawarehouse($date_yesterday, $data['countrycode'], 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
$data['exchanges_logistic_cost'], null,
null, null, null, null, null, 
null, null,
null,
null, null,
null,
null, null, null);

}

$result->closeCursor();


/////// ******************* PART FIVE : FACEBOOK MARKETING ******************** // 

fulfill_market_with_facebook_api($date_yesterday);

// PART SIX : GOOGLE ADWORDS *********** //


fulfill_market_with_googleadwords_api($date_yesterday);










/// ************************ LAST PART : ****************************************** //
///// ###################### FULFILL ALL THE TOTAL (TOTAL COGS, TOTAL LOGISTICS) + PROFIT ########################################### ****/// 


// LETS FUFLFILL EVERYTHING !! 


$query_back_online_pl = "SELECT * FROM online_pl WHERE date = '".$date_yesterday."'";
$result_back = makequery($query_back_online_pl);
$datas_back = $result_back->fetchAll();

	foreach($datas_back AS $data_back) {  
						
			recompute_all_the_total($date_yesterday, $data_back['countrycode']);


	}
$result_back->closeCursor();
	
fullfil_the_online_cac_table($date_yesterday);
insert_empty_values_for_the_online_cac($date_yesterday);
	
	// } // end of the foreach

/// ******************************* -------------***********************************//

send_mail((get_net_sales($date_yesterday, '')+get_shipping_paid($date_yesterday, '')), (get_net_sales($date_yesterday, '')+get_shipping_paid($date_yesterday, ''))+get_refunds($date_yesterday, ''),
get_percentage_marketing_cost_from_total($date_yesterday, ''));




// ONLINE CAC !


// FACEBOOK TABLE

 fulfill_adset_with_facebook_api($date_yesterday);
fulfill_adset_header_by_period("yesterday", $date_yesterday, '');
// fulfill_adset_header_by_period("lifetime", "2017-08-02", "2017-07-29");
fulfill_adset_header_by_period("last_3d", $date_yesterday, '');
fulfill_adset_header_by_period("last_7d", $date_yesterday, '');
fulfill_adset_header_by_period("last_28d", $date_yesterday, '');


// GOOGLE HEADER


launch_fulfill_for_google_header($date_yesterday);



?>