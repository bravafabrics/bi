<?php
require_once("keychain.php"); // contains the passwords we need

function makemultiqueriesforps($query) {

try{	
$db_conn = mysqli_connect(DBLPS, DBPS_USER, DBPS_PASS, DBPS_DATABASE);
 
mysqli_query($db_conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

$result = mysqli_multi_query($db_conn, $query) or die( mysql_multi_query( $db_conn ) );
}catch (Exception $e) {
  echo  'Error ' . $e->getMessage();
  exit;
}
return $result;

}

function makequeryforps($query){

try {
	$db_conn = new PDO('mysql:host='.DBLPS.';dbname='.DBPS_DATABASE.';charset=utf8', DBPS_USER, DBPS_PASS); 
	

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
	
	// ******** HERE THE PROCESS : 
	// FIRST WE CREATE A TEMP TABLE IN ORDER TO STORE GATEWAYS VALUES **//
	// THEN WE INSERT IN ALL WITH A MULTI QUERIES 
	// THEN WE SELECT ALL DATAS
	// FINALLY WE DROP THE TABLE **//
	
	// STEP 1 : CREATING + INSERING AS A MULTIQUERIES
makemultiqueriesforps(select_gateways_and_insertin_temp_gateways());


	// STEP 2 : SELECT DATAS //
	$query = "
(
SELECT c.iso_code, 
(sum(o.total_paid_tax_incl)/(1+".IVA."/100)) as 'Full Pricing',
sum(order_detail_summarized.sales_discount) as 'sales_discount',  
sum(o.total_discounts_tax_incl/(1+".IVA."/100)) as 'coupon discount', 
sum(order_detail_summarized.cogs) as 'cogs',
sum((o.total_shipping_tax_incl)/(1+".IVA."/100)) as 'shipping', 

sum(
CASE
when o.payment='Pago contra reembolso' THEN
GREATEST(o.total_paid_tax_incl*g.percentage/100, g.fix)
else
o.total_paid_tax_incl*g.percentage/100 + g.fix 
END
) as 'gateways'

FROM ps_orders o
inner join ps_address a on o.id_address_delivery=a.id_address
inner join ps_country c on c.id_country=a.id_country
inner join (

SELECT g2.payment_method,g2.percentage,g2.fix
FROM temp_gateway g2
INNER JOIN(
  SELECT tg.payment_method, MAX(tg.date) AS date
  FROM temp_gateway tg
  GROUP BY tg.payment_method
) AS g1 on g1.payment_method=g2.payment_method and g1.date=g2.date
) g
on g.payment_method=o.payment

inner join
(
select od.id_order, sum(product_price*reduction_percent/100) as 'sales_discount', sum(od.product_quantity*p.wholesale_price) as 'cogs'
from ps_order_detail od
inner join ps_product p on p.id_product = od.product_id
group by od.id_order
) As order_detail_summarized
on o.id_order =   order_detail_summarized.id_order

where DATE_FORMAT(o.date_add,'%Y-%m-%d') = '".$date."'
AND o.current_state in ('2','3','4','5','11','13','16','21')
GROUP BY c.iso_code
ORDER BY c.iso_code
)

	";
return makequeryforps($query);	
}

function drop_temp_gateway_table() {
	$query = "DROP TABLE temp_gateway";
	return makequeryforps($query);
}

function drop_all_temp_ship_table() {
	$query = "DROP TABLE temp_zones;
DROP TABLE temp_shipping;
DROP TABLE temp_extra_shipping;";
	return makemultiqueriesforps($query);
}

function drop_handling_table() {
	$query = "DROP TABLE temp_handling";
	return makequeryforps($query);
}

function select_gateways_and_insertin_temp_gateways() {
	
	// FIRST CREATE IT (IF TEMPORY) 
	
	$the_total_request = "
CREATE TABLE IF NOT EXISTS temp_gateway (
date DATE,
payment_method VARCHAR(255),
percentage FLOAT,
fix FLOAT,
PRIMARY KEY (date, payment_method));
	";
	include_once("queries_database.php");
	$gateways = get_all_gateways();

	foreach($gateways as $gateway) {
		$the_total_request .= "
	INSERT INTO temp_gateway
	(
	date,
	payment_method,
	percentage,
	fix
	)
	VALUES
	(
	'".$gateway['date']."',
	'".$gateway['payment_method']."',
	'".$gateway['percentage']."',
	'".$gateway['fix']."'
	);		
		";
	}
	//echo $the_total_request;
		
return $the_total_request;
}


function select_zones_and_insertin_temp_zones() {
	
	// FIRST CREATE IT (IF TEMPORY) 
	
	$the_total_request = "
CREATE TABLE IF NOT EXISTS temp_zones (
country VARCHAR(10),
service VARCHAR(255),
zone VARCHAR(30),
PRIMARY KEY (country, service));
	";
	include_once("queries_database.php");
	$zones = get_all_zones();

	foreach($zones as $zone) {
		$the_total_request .= "
	INSERT INTO temp_zones
	(
	country,
	service,
	zone
	)
	VALUES
	(
	'".$zone['country']."',
	'".$zone['service']."',
	'".$zone['zone']."'
	);		
		";
	}
	//echo $the_total_request;
		
return $the_total_request;
}

function select_ship_and_insertin_temp_ship() {
	
	// FIRST CREATE IT (IF TEMPORY) 
	
	$the_total_request = "
CREATE TABLE IF NOT EXISTS temp_shipping (
zone VARCHAR(30),
service VARCHAR(255),
weight FLOAT,
price FLOAT,
PRIMARY KEY (zone, service, weight));
	";
	include_once("queries_database.php");
	$ships = get_all_ship();

	foreach($ships as $ship) {
		$the_total_request .= "
	INSERT INTO temp_shipping
	(
	zone,
	service,
	weight, 
	price
	)
	VALUES
	(
	'".$ship['zone']."',
	'".$ship['service']."',
	'".$ship['weight']."',
	'".$ship['price']."'
	);		
		";
	}
		
return $the_total_request;
}

function select_extra_ship_and_insertin_temp_extra_ship() {
	
	// FIRST CREATE IT (IF TEMPORY) 
	
	$the_total_request = "
CREATE TABLE IF NOT EXISTS temp_extra_shipping (
service VARCHAR(255),
percentage FLOAT,
fix FLOAT,
PRIMARY KEY (service));
	";
	include_once("queries_database.php");
	$ships = get_most_recent_extra_ship();

	foreach($ships as $ship) {
		$the_total_request .= "
	INSERT INTO temp_extra_shipping
	(
	service,
	percentage, 
	fix
	)
	VALUES
	(
	'".$ship['service']."',
	'".$ship['percentage']."',
	'".$ship['fix']."'
	);		
		";
	}
		
return $the_total_request;
}

function report_shipping_logistics_from_ps_sale_by_date($date) {
	
	
	// STEP ONE : CREATE THE TEMPORARY TABLES :
	
	makemultiqueriesforps(select_zones_and_insertin_temp_zones()); // ZONES	
	makemultiqueriesforps(select_ship_and_insertin_temp_ship()); // SHIP
	makemultiqueriesforps(select_extra_ship_and_insertin_temp_extra_ship()); // SHIP EXTRA FEES
	
	//echo select_zones_and_insertin_temp_zones();
	//echo select_ship_and_insertin_temp_ship();
	//echo select_extra_ship_and_insertin_temp_extra_ship();
	// STEP TWO : MAKING THE QUERY 
	
	$query = "
	
select subquery.iso_code AS 'countrycode', sum(subquery.majoreted) AS 'shipping_logistics'
from
(
			SELECT temp_select.number_items, 
			temp_select.name_carrier, 
			temp_select.iso_code, 
			DATE_FORMAT(temp_select.date_add,'%Y-%m-%d') AS 'date_finale_temp',
			ts.weight AS 'weight temp', 
			temp_select.weight AS 'real weight',
			ts.price AS 'price', 
			(ts.price*(1+tes.percentage/100) + tes.fix) AS 'majoreted'


			 FROM (
								SELECT c.iso_code AS 'iso_code', 
								o.id_order AS 'id_order', 
								sum(od.product_quantity) AS 'number_items', 
								ca.name AS 'name_carrier',
								o.date_add,
								CASE
								when sum(od.product_quantity) >= 1 AND sum(od.product_quantity) <= 4  THEN
								1
								else
								2
								END
								as 'weight'
								FROM ps_orders o 
								inner join ps_order_detail od on od.id_order = o.id_order
								inner join ps_address a on o.id_address_delivery=a.id_address
								inner join ps_country c on c.id_country=a.id_country
								inner join ps_carrier ca on ca.id_carrier = o.id_carrier

								where o.current_state in ('2','3','4','5','11','13','16','21') and DATE_FORMAT(o.date_add,'%Y-%m-%d') = '".$date."'  
								GROUP BY o.id_order 

			) AS temp_select

			inner join temp_zones tz on temp_select.iso_code = tz.country and tz.service = temp_select.name_carrier
			inner join temp_shipping ts on (temp_select.weight = ts.weight) AND tz.zone = ts.zone AND temp_select.name_carrier = ts.service
			inner join temp_extra_shipping AS tes on tes.service = tz.service

			WHERE DATE_FORMAT(temp_select.date_add,'%Y-%m-%d') = '".$date."' 
) as subquery
group by iso_code


UNION
(

select subquery.iso_code AS 'countrycode', sum(subquery.majoreted) AS 'shipping_logistics'
from
(
			SELECT temp_select.number_items, 
			temp_select.name_carrier, 
			temp_select.iso_code, 
			DATE_FORMAT(temp_select.date_add,'%Y-%m-%d') AS 'date_finale_temp',
			ts.weight AS 'weight temp', 
			temp_select.weight AS 'real weight',
			ts.price AS 'price', 
			(ts.price*(1+tes.percentage/100) + tes.fix) AS 'majoreted'


			 FROM (
								SELECT c.iso_code AS 'iso_code', 
								o.id_order AS 'id_order', 
								sum(od.product_quantity) AS 'number_items', 
								ca.name AS 'name_carrier',
								o.date_add,
								CASE
								when sum(od.product_quantity) >= 1 AND sum(od.product_quantity) <= 4  THEN
								1
								else
								2
								END
								as 'weight'
								FROM (
											SELECT o1.* FROM ps_orders o1
											inner join ps_order_detail od2 on od2.id_order = o1.id_order
											inner join ps_address a2 on o1.id_address_delivery=a2.id_address
											inner join ps_country c2 on c2.id_country=a2.id_country
											inner join ps_carrier ca2 on ca2.id_carrier = o1.id_carrier
											WHERE c2.iso_code NOT IN (
											SELECT country FROM temp_zones z WHERE z.country <> 'ZZ' and z.service=ca2.name
											)
									) 
								AS o 
								inner join ps_order_detail od on od.id_order = o.id_order
								inner join ps_address a on o.id_address_delivery=a.id_address
								inner join ps_country c on c.id_country=a.id_country
								inner join ps_carrier ca on ca.id_carrier = o.id_carrier

								where o.current_state in ('2','3','4','5','11','13','16','21') and DATE_FORMAT(o.date_add,'%Y-%m-%d') = '".$date."' 
								GROUP BY o.id_order 

			) AS temp_select

			inner join temp_zones tz on temp_select.iso_code = tz.country and tz.service = temp_select.name_carrier
			inner join temp_shipping ts on (temp_select.weight = ts.weight) AND ts.zone = 'ZZ' AND temp_select.name_carrier = ts.service
			inner join temp_extra_shipping AS tes on tes.service = tz.service

			WHERE DATE_FORMAT(temp_select.date_add,'%Y-%m-%d') = '".$date."' 
) as subquery
group by iso_code

)

	
	";

	return makequeryforps($query);	
	
}

function report_handling_from_ps_sale_by_date($date) {
	
	
	// STEP ONE : CREATE THE TEMPORARY TABLES :
	
	makemultiqueriesforps(select_handling_and_insertin_temp_handling()); // ZONES	
	
	// STEP TWO : MAKING THE QUERY 
	
	$query = "
	
(SELECT 
sum((th.packaging*finale_select.number_items)) AS 'packaging_cost',
sum((th.handling*finale_select.number_items)) AS 'handling_cost',
sum((th.preparation)) AS 'preparation_cost',
sum((th.shipping_materals)) AS 'materals_cost',
finale_select.iso_code AS 'countrycode' FROM 
(SELECT temp_select.id_order, temp_select.number_items, temp_select.iso_code, 
DATE_FORMAT(temp_select.date_add,'%Y-%m-%d') AS 'date'
 FROM (
SELECT c.iso_code AS 'iso_code', 
o.id_order AS 'id_order', 
sum(od.product_quantity) AS 'number_items', 
o.date_add

FROM ps_orders o
inner join ps_order_detail od on od.id_order = o.id_order
inner join ps_address a on o.id_address_delivery=a.id_address
inner join ps_country c on c.id_country=a.id_country


where o.current_state in ('2','3','4','5','11','13','16','21') 
GROUP BY o.id_order
) AS temp_select 

) 

AS finale_select 
inner join (SELECT packaging, handling, preparation, shipping_materals FROM temp_handling ORDER BY date DESC LIMIT 1) th
WHERE date = '".$date."' GROUP BY iso_code)
 ;
;

	
	";

	return makequeryforps($query);	
	
}


function ajax_get_countrycode() {
	
$query = "SELECT iso_code FROM ps_country GROUP BY iso_code";
$result = makequeryforps($query);
$countries = $result->fetchAll();

$result->closeCursor();
return $countries;
	
}


function select_handling_and_insertin_temp_handling() {
	
	// FIRST CREATE IT (IF TEMPORY) 
	
	$the_total_request = "
CREATE TABLE IF NOT EXISTS temp_handling (
date DATE,
packaging FLOAT,
handling FLOAT, 
preparation FLOAT,
shipping_materals FLOAT,
PRIMARY KEY (date)
);
	";
	include_once("queries_database.php");
	$handlings = get_all_handling();

	foreach($handlings as $handling) {
		$the_total_request .= "
	INSERT INTO temp_handling
	(
	date,
	packaging,
	handling, 
	preparation,
	shipping_materals
	)
	VALUES
	(
	'".$handling['date']."',
	'".$handling['packaging']."',
	'".$handling['handling']."',
	'".$handling['preparation']."',
	'".$handling['shipping_materals']."'
	);		
		";
	}
	//echo $the_total_request;	
return $the_total_request;
}


//echo select_zones_and_insertin_temp_zones(); // ZONES	
//echo select_ship_and_insertin_temp_ship(); // SHIP
//echo select_extra_ship_and_insertin_temp_extra_ship(); // SHIP EXTRA FEES

//select_zones_and_insertin_temp_zones();
//select_extra_ship_and_insertin_temp_extra_ship();
//select_handling_and_insertin_temp_handling();
?>