<?php
require_once("keychain.php"); // contains the passwords we need
function makequeryforps($query, $name_db){

try {
	$db_conn = "";
	if($name_db == 'prestashop') { 
	echo 'mysql:host='.DBPS_HOST.';dbname='.DBPS_DATABASE.';charset=utf8'.DBPS_USER.DBPS_PASS;
	$db_conn = new PDO('mysql:host='.DBPS_HOST.';dbname='.DBPS_DATABASE.';charset=utf8', DBPS_USER, DBPS_PASS); }
	else { $db_conn = new PDO('mysql:host='.DBDW_HOST.';dbname='.DBDW_DATABASE.';charset=utf8', DBDW_USER, DBDW_PASS); }
$db_conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$result = $db_conn->prepare($query);
$result->execute();
$db_conn = null; // Which permits not to have to much connection 
}
catch(Exception $e) {
	die('Special error :' . $e->getMessage());
	exit;
} // and show if there is a particular problem.
return $result;
}


function report_from_ps_sale_by_date($date) {

	// ***************** SHOWS A SUMUP for our new database warehouse ************* // 
	// ********* BE CAREFUL OF THE DATE FORMAT, FOR EXAMPLE 05-04-17 will be April 5th 2017 **** // 
	// ******* YOU CAN FIND ALL IVA IN THE KEYCHAIN FILE *********** //
	$query = "
SELECT o.id_order, c.iso_code, (sum(o.total_paid_tax_incl)/(1+".IVA ."/100)) as 'Full Pricing', sum(order_detail_summarized.sales_discount) as 'sales_discount',  
(o.total_discounts_tax_incl/(1+".IVA ."/100)) as 'coupon discount', sum(order_detail_summarized.cogs) as 'cogs',
(SUM(o.total_shipping_tax_incl)/(1+".IVA."/100)) as 'shipping'
FROM ps_orders o
inner join ps_address a on o.id_address_delivery=a.id_address
inner join ps_country c on c.id_country=a.id_country
INNER JOIN
(
select od.id_order, sum(product_price*reduction_percent/100) as 'sales_discount', sum(od.product_quantity*p.wholesale_price) as 'cogs'
from ps_order_detail od
inner join ps_product p on p.id_product = od.product_id
group by od.id_order
) As order_detail_summarized
on o.id_order =   order_detail_summarized.id_order
where DATE_FORMAT(o.date_add,'%Y-%m-%d') = '".$date."' AND o.current_state in ('2','3','4','5','11','13','16','21')
GROUP BY iso_code ORDER BY o.date_add


	";
	
return makequeryforps($query, "prestashop");	
}

function insert_empty_values_for_the_datawarehouse($date) {

	// ***************** SHOWS A SUMUP for our new database warehouse ************* // 
	// ********* BE CAREFUL OF THE DATE FORMAT, FOR EXAMPLE 05-04-17 will be April 5th 2017 **** // 
	// ******* YOU CAN FIND ALL IVA IN THE KEYCHAIN FILE *********** //
	$query = "
insert into
online_pl( date,countrycode,fullpricing, discount, cogs, shipping_paid, net_sales)
select '".$date."',countrycode ,0,0,0,0,0
from online_pl
where countrycode not in
(
select countrycode from online_pl where date='".$date."' 
)
group by countrycode

	";
	
return makequeryforps($query, "datawarehouse");	
}


?>