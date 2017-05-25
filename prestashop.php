<?php

function makequeryprestashop($query){


include("keychain.php"); // contains the passwords we need

try {
$db_conn = new PDO('mysql:host='.$host.';dbname='.$dbname['prestashop'] . ';charset=utf8', $db_user, $db_pass);
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
	include("keychain.php");
	// ***************** SHOWS A SUMUP for our new database warehouse ************* // 
	// ********* BE CAREFUL OF THE DATE FORMAT, FOR EXAMPLE 05-04-17 will be April 5th 2017 **** // 
	// ******* YOU CAN FIND ALL IVA IN THE KEYCHAIN FILE *********** //
	$query = "
SELECT o.id_order, c.iso_code, (sum(o.total_paid_tax_incl)/(1+".$iva['es'] ."/100)), sum(order_detail_summarized.sales_discount) as 'sales_discount',  (o.total_discounts_tax_incl/(1+".$iva['es'] ."/100)) as 'coupon discount', sum(order_detail_summarized.cogs) as 'cogs',
(SUM(o.total_shipping_tax_incl)/(1+".$iva['es'] ."/100)) as 'shipping'
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
where DATE_FORMAT(o.date_add,'%Y-%m-%d') = '".$date."'
GROUP BY iso_code ORDER BY o.date_add


	";
	
return makequeryprestashop($query);	
}



?>