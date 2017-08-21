<?php
require_once("keychain.php"); // contains the passwords we need


// README : 
// IF ONE DAY YOU DECIDE TO GO TO SHOPIFY CMS, DON'T FORGET TO ALSO EDIT THE FUNCTION get_the_cross_from_ps_by_id_order 

function makequeryforpsmysqli($query) {  
$db_conn = "";
$result = "";
try{
$db_conn = mysqli_connect(DBPS_HOST, DBPS_USER, DBPS_PASS, DBPS_DATABASE);

mysqli_query($db_conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

$result = mysqli_query($db_conn, $query) or die( mysqli_error( $db_conn ) );
return $result;
}catch (Exception $e) {
  echo  'Error :' . $e->getMessage();
  exit;
}
}

function makemultiqueriesforps($query) {

try{	
$db_conn = mysqli_connect(DBPS_HOST, DBPS_USER, DBPS_PASS, DBPS_DATABASE);
 
mysqli_query($db_conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

$result = mysqli_multi_query($db_conn, $query) or die( mysql_multi_query( $db_conn ) );
}catch (Exception $e) {
  echo  'Error : ' . $e->getMessage();
  exit;
}
return $result;

}

function makequeryforps($query){

try {
	$db_conn = new PDO('mysql:host='.DBPS_HOST.';dbname='.DBPS_DATABASE.';charset=utf8', DBPS_USER, DBPS_PASS); 
	

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




function report_all_datas_from_ps($date) {
	
	$query = "
	
SELECT o.id_order AS 'id_order', 
DATE_FORMAT(o.date_add,'%Y-%m-%d') AS 'date',
c.iso_code AS 'countrycode', 
o.total_paid_tax_incl/(1+21/100) AS 'total_paid_ps',
order_detail_summarized.price_product as 'fullpricing',
order_detail_summarized.sales_discount+o.total_discounts_tax_incl/(1+21/100) as 'discount',  
order_detail_summarized.cogs as 'cogs',
(o.total_shipping_tax_incl)/(1+21/100) as 'shipping',
o.payment AS 'payment_method',
ca.name AS 'carrier',
order_detail_summarized.product_quantity AS 'product_quantity',
(CASE
	when DATE_FORMAT(cu.date_add,'%Y-%m-%d') = DATE_FORMAT(o.date_add,'%Y-%m-%d') THEN
	1
	else
	0
	END)
AS 'new_customer'
FROM ps_orders o
inner join ps_address a on o.id_address_delivery=a.id_address
inner join ps_country c on c.id_country=a.id_country
inner join ps_carrier ca on ca.id_carrier = o.id_carrier
inner join ps_customer cu on o.id_customer=cu.id_customer
inner join
(
select od.id_order, sum(od.product_quantity) as 'product_quantity', sum(product_price) AS 'price_product', sum(product_price*reduction_percent/100) as 'sales_discount', sum(od.product_quantity*p.wholesale_price) as 'cogs'
from ps_order_detail od
inner join ps_product p on p.id_product = od.product_id
group by od.id_order
) As order_detail_summarized
on o.id_order =  order_detail_summarized.id_order

where DATE_FORMAT(o.date_add,'%Y-%m-%d') = '".$date."'
AND o.current_state in ('2','3','4','5','11','13','16','21', '17')

	
	";

	return makequeryforps($query);
	
}

function report_for_product_sales($date) { 

$query = '

SELECT psc.id_category AS "id_category", DATE_FORMAT(o.date_add,"%Y-%m-%d") AS "date", c.iso_code AS "countrycode",
od.product_id AS "id_product", REPLACE(ppl.name, "\'", " ") as "short_name_1", p.reference as "short_name_2",
od.product_quantity AS "unit_sold",
CASE WHEN od.reduction_percent = "0" THEN
"FULLPRICING"
ELSE "DISCOUNT"
END AS "fp/dis",
CASE 
WHEN psc.id_category = "'.MAN.'" OR psc.id_parent = "'.MAN.'" THEN
"Men"
WHEN psc.id_category = "'.WOMAN.'" OR psc.id_parent = "'.WOMAN.'" THEN 
"Women"
ELSE "Unknown"
end AS "gentle",
psl.name AS "category_name",
CASE 
WHEN la.name IS null THEN
"No size"
ELSE 
la.name
end  AS "size",
CASE WHEN od.reduction_percent = "0" THEN
od.product_price - o.total_discounts_tax_incl/(1+21/100)
ELSE 
od.product_price - (od.product_price*od.reduction_percent/100)/(1+21/100)
END AS "sales",
od.product_quantity*p.wholesale_price as "cogs"
 FROM ps_order_detail od 
inner join ps_orders o on od.id_order = o.id_order
inner join ps_address a on o.id_address_delivery=a.id_address
inner join ps_country c on c.id_country=a.id_country
inner join ps_product p on p.id_product = od.product_id 
inner join ps_category psc on psc.id_category = p.id_category_default
inner join ps_category_lang psl on psl.id_category = p.id_category_default AND psl.id_lang = "1" 
inner join ps_product_lang ppl on ppl.id_product = p.id_product AND ppl.id_lang = "1"
left join ps_product_attribute_combination co ON co.id_product_attribute = od.product_attribute_id
left join ps_attribute_lang la ON la.id_attribute = co.id_attribute and la.id_lang=6

WHERE DATE_FORMAT(o.date_add,"%Y-%m-%d") = "'.$date.'"  
';

return makequeryforps($query);

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
(sum((o.total_paid_tax_incl+(o.total_discounts_tax_incl)-o.total_shipping_tax_incl))/(1+".IVA."/100)) as 'Full Pricing',
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
	
$result = makequeryforps($query);
drop_temp_gateway_table();
return $result;	
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
			(ts.price + tes.fix)*(1+tes.percentage/100) AS 'majoreted'


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
			(ts.price + tes.fix)*(1+tes.percentage/100) AS 'majoreted'


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
	 drop_all_temp_ship_table();
	 $final_result = makequeryforps($query);
	 return $final_result;	
	
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

	$result = makequeryforps($query);
	drop_handling_table();
	return $result;	
	
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

function get_datas_for_cac_from_prestashop($date) { 
	$query = "
	
SELECT c.iso_code AS 'countrycode', COUNT(o.id_order) AS 'number_orders',
sum(CASE
	when DATE_FORMAT(cu.date_add,'%Y-%m-%d') = '".$date."' THEN
	1
	else
	0
	END)
AS 'number_new_cust',
(sum(o.total_paid_tax_incl)/(1+21/100))/COUNT(o.id_order) AS 'avg_order_value',
(sum(o.total_paid_tax_incl)/(1+21/100)) AS 'total_paid_for_avg'
 FROM ps_orders o 
inner join ps_address a on o.id_address_delivery=a.id_address
inner join ps_country c on c.id_country=a.id_country
inner join ps_customer cu on o.id_customer=cu.id_customer
WHERE DATE_FORMAT(o.date_add,'%Y-%m-%d') = '".$date."' GROUP BY c.iso_code	
	";
$result = makequeryforps($query);
$cac = $result->fetchAll();

$result->closeCursor();
return $cac;

}

function get_the_name_of_a_category($id_category) {  

	$query = "
SELECT id_category, name FROM ps_category_lang where id_category = '".$id_category."' AND id_lang = '1';	
";


$result = makequeryforps($query);
$datas = $result->fetchAll();
foreach ($datas as $data) {
    return $data['name']; // It will return the first object
}


$result->closeCursor();

 
return null;


}

function get_infos_for_the_cross_by_date($date) {


$query = '
SELECT od.id_order AS "id_order", c.iso_code AS "countrycode", DATE_FORMAT(o.date_add,"%Y-%m-%d") AS "date" FROM ps_order_detail od
inner join (SELECT id_order FROM ps_order_detail GROUP BY id_order having sum(product_quantity) > 1) od2 on od2.id_order = od.id_order
inner join ps_orders o on o.id_order = od2.id_order
inner join ps_address a on o.id_address_delivery=a.id_address
inner join ps_country c on c.id_country=a.id_country
inner join ps_product p on p.id_product = od.product_id 
inner join ps_category psc on psc.id_category = p.id_category_default
inner join ps_category_lang psl on psl.id_category = p.id_category_default AND psl.id_lang = "1" 
inner join ps_product_lang ppl on ppl.id_product = p.id_product AND ppl.id_lang = "1"
WHERE DATE_FORMAT(o.date_add,"%Y-%m-%d") = "'.$date.'" GROUP BY od.id_order

';

return makequeryforps($query);

}

function get_the_cross_from_ps_by_id_order($id_order) {  

$con=mysqli_connect(DBPS_HOST, DBPS_USER, DBPS_PASS, DBPS_DATABASE);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql = '
CREATE TABLE IF NOT EXISTS temp_match_1(
id int NOT NULL AUTO_INCREMENT,
id_order INT(10),
id_category INT (10),
PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS temp_match_2(
id int NOT NULL AUTO_INCREMENT,
id_order INT(10),
id_category INT (10),
PRIMARY KEY (id)
);



INSERT INTO temp_match_1 (id_order, id_category)
SELECT od.id_order, psc.id_category AS "id_category" FROM ps_order_detail od
inner join (SELECT id_order FROM ps_order_detail GROUP BY id_order having sum(product_quantity) > 1) od2 on od2.id_order = od.id_order
inner join ps_orders o on o.id_order = od2.id_order
inner join ps_address a on o.id_address_delivery=a.id_address
inner join ps_country c on c.id_country=a.id_country
inner join ps_product p on p.id_product = od.product_id 
inner join ps_category psc on psc.id_category = p.id_category_default
inner join ps_category_lang psl on psl.id_category = p.id_category_default AND psl.id_lang = "1" 
inner join ps_product_lang ppl on ppl.id_product = p.id_product AND ppl.id_lang = "1"
WHERE od.id_order = "'.$id_order.'";

INSERT INTO temp_match_2 (id_order, id_category)
SELECT id_order, id_category from temp_match_1;
SELECT tm.id_order, GROUP_CONCAT(tm.id_category) AS "cross" FROM temp_match_1 tm 
CROSS JOIN temp_match_2 tm2 on tm.id_order = tm2.id_order 
WHERE tm.id_order = "'.$id_order.'" GROUP BY tm.id_order;
DROP TABLE temp_match_1; DROP TABLE temp_match_2;
';
// Execute multi query
$cross = "";
if (mysqli_multi_query($con,$sql))
{
  do
    {
    // Store first result set
    if ($result=mysqli_store_result($con)) {
      // Fetch one and one row
      while ($row=mysqli_fetch_row($result)) $cross = $row[1];
      // Free result set
      mysqli_free_result($result);
      }
    }
  while (mysqli_next_result($con));
}

mysqli_close($con);

return $cross;
}

function get_infos_cat_order_by_day_from_ps($date) {  


$query = '

SELECT od.id_order AS "id_order", c.iso_code AS "countrycode", DATE_FORMAT(o.date_add,"%Y-%m-%d") AS "date",
REPLACE(ppl.name, "\'", " ") AS "name", od.product_id AS "product_id", psc.id_category AS "id_category", psl.name AS "name_category" FROM ps_order_detail od
inner join (SELECT id_order FROM ps_order_detail GROUP BY id_order having sum(product_quantity) > 1) od2 on od2.id_order = od.id_order
inner join ps_orders o on o.id_order = od2.id_order
inner join ps_address a on o.id_address_delivery=a.id_address
inner join ps_country c on c.id_country=a.id_country
inner join ps_product p on p.id_product = od.product_id 
inner join ps_category psc on psc.id_category = p.id_category_default
inner join ps_category_lang psl on psl.id_category = p.id_category_default AND psl.id_lang = "1" 
inner join ps_product_lang ppl on ppl.id_product = p.id_product AND ppl.id_lang = "1"
WHERE DATE_FORMAT(o.date_add,"%Y-%m-%d") = "'.$date.'"

';

return makequeryforps($query);

}

function get_daily_stocks_temp($date_yesterday) { 

$query = '
CREATE TABLE IF NOT EXISTS temp_orders(
id_order INT(10),
date DATE,
PRIMARY KEY (id_order)
);
CREATE TABLE IF NOT EXISTS temp_product_minimum_orders(
date DATE,
id_product INT(10),
PRIMARY KEY (id_product)
);

CREATE TABLE IF NOT EXISTS temp_interval(
id_product INT(10),
inter INT(10),
date DATE,
PRIMARY KEY (id_product)
);

CREATE TABLE IF NOT EXISTS temp_quantity(
id_product INT(10),
quantity INT(10),
PRIMARY KEY (id_product)
);
CREATE TABLE IF NOT EXISTS temp_size(
id_product INT(10),
count_size INT (10),
quantity_size INT (10),
PRIMARY KEY (id_product)
);


CREATE TABLE IF NOT EXISTS temp_daily_stocks(
id_category INT(10),
date DATE,
name_category VARCHAR(255),
id_product INT(10),
short_name_1 VARCHAR(255),
short_name_2 VARCHAR(255),
current_stock INT(10),
euro_stock FLOAT,
percentage_size FLOAT,
units_sold FLOAT,
days_stock FLOAT,
PRIMARY KEY (id_product)
);

INSERT INTO temp_size (id_product, count_size, quantity_size)
SELECT id_product, sum(CASE WHEN id_product_attribute = 0 THEN 0 ELSE 1 END)  AS "count_size",
sum(CASE WHEN quantity = 0 THEN 0 ELSE 1 END) AS "quantity_size" FROM ps_stock_available WHERE id_product_attribute != "0" GROUP BY id_product;

INSERT INTO temp_orders (id_order, date)
SELECT o.id_order, DATE_FORMAT(o.date_add,"%Y-%m-%d") FROM ps_orders o 
WHERE o.date_add BETWEEN (NOW()-INTERVAL 1 DAY) - INTERVAL 13 DAY AND (NOW()-INTERVAL 1 DAY)
;

INSERT INTO temp_product_minimum_orders (date, id_product)
SELECT min(tor.date), od.product_id FROM ps_order_detail od
inner join temp_orders tor on tor.id_order = od.id_order 
GROUP BY od.product_id
;

INSERT INTO temp_interval (id_product, inter, date)
SELECT p.id_product, 
IFNULL(DATEDIFF((NOW()-INTERVAL 1 DAY), tpmo.date)+1, 0),
IFNULL(tpmo.date, "1990-01-01") 
 FROM ps_product p
left join temp_product_minimum_orders tpmo on tpmo.id_product = p.id_product;

INSERT INTO temp_quantity (id_product, quantity)
SELECT od.product_id AS "product_id", sum(od.product_quantity) AS "quantity"  FROM ps_order_detail od 
inner join ps_orders o on o.id_order = od.id_order
WHERE DATE_FORMAT(o.date_add,"%Y-%m-%d") between (SELECT tir.date FROM temp_interval tir WHERE tir.id_product = od.product_id ) and (NOW()-INTERVAL 1 DAY)
GROUP BY od.product_id
; 

INSERT INTO temp_daily_stocks (id_category, date, name_category, id_product, short_name_1, short_name_2, current_stock, euro_stock, percentage_size, units_sold, days_stock)
SELECT psc.id_category AS "id_category", "'.$date_yesterday.'" AS "date", psl.name as "name_cateogry",  
od.product_id AS "id_product", REPLACE(ppl.name, "\'", " ") as "short_name_1", p.reference as "short_name_2",
 GREATEST(sa.quantity,0) AS "current_stock", TRUNCATE(GREATEST(sa.quantity,0)*p.wholesale_price,2) As "euro_stock",
tsz.quantity_size/tsz.count_size AS "percentage_size",
IFNULL(tq.quantity/tir.inter, 0) AS "units_sold", IFNULL(tq.quantity/tir.inter, 0)/sa.quantity AS "days_stock"
 FROM ps_product p 
left join ps_order_detail od on p.id_product = od.product_id
inner join ps_orders o on od.id_order = o.id_order
inner join ps_category psc on psc.id_category = p.id_category_default
inner join ps_category_lang psl 
 on psl.id_category = p.id_category_default and psl.id_lang="1"
inner join ps_product_lang ppl on ppl.id_product = p.id_product AND ppl.id_lang = "1"
inner join ps_stock_available sa on sa.id_product = p.id_product AND sa.id_product_attribute=0
inner join temp_size tsz on tsz.id_product = p.id_product

left join temp_quantity tq on tq.id_product = p.id_product
left join temp_interval tir on tir.id_product = p.id_product
WHERE sa.quantity > 0 GROUP BY od.product_id  ORDER BY p.id_product ASC;

DROP TABLE temp_orders;
DROP TABLE temp_product_minimum_orders;
DROP TABLE temp_interval;
DROP TABLE temp_quantity;
DROP TABLE temp_size

';
makemultiqueriesforps($query);

}

function get_daily_stocks() { 


$query_get = "SELECT * FROM temp_daily_stocks";

$result = makequeryforpsmysqli($query_get);
return $result;
}

function drop_daily_stocks() { 

$query_drop = "DROP TABLE temp_daily_stocks";
makequeryforps($query_drop);
}

function get_nuevos_clientes_mes_m($date_begin, $date_end, $distinct) {  

if($distinct) { 

$query = "

select count(DISTINCT(c.email)) AS 'count'
from ps_orders o 
inner join ps_customer c on c.id_customer=o.id_customer
where
o.current_state in ('2','3','4','5','16','17','18')
and o.date_add between '".$date_begin."' and '".$date_end."'
and c.email not in ('ivan.monells@gmail.com', 'ramonbarbero@gmail.com', 'ptaverna@gmail.com', 'ivan@bravafabrics.com', 'pau@bravafabrics.com','ramon@bravafabrics.com')
and c.email NOT IN
(
                                               select c.email 
                                               from ps_orders o 
                                               inner join ps_customer c on c.id_customer=o.id_customer
                                               where
                                               o.current_state in ('2','3','4','5','16','17','18')
            and o.date_add < '".$date_begin."'
)


";
} else {  
$query = "

select count(c.email) AS 'count'
from ps_orders o 
inner join ps_customer c on c.id_customer=o.id_customer
where
o.current_state in ('2','3','4','5','16','17','18')
and o.date_add between '".$date_begin."' and '".$date_end."'
and c.email not in ('ivan.monells@gmail.com', 'ramonbarbero@gmail.com', 'ptaverna@gmail.com', 'ivan@bravafabrics.com', 'pau@bravafabrics.com','ramon@bravafabrics.com')
and c.email NOT IN
(
                                               select c.email 
                                               from ps_orders o 
                                               inner join ps_customer c on c.id_customer=o.id_customer
                                               where
                                               o.current_state in ('2','3','4','5','16','17','18')
            and o.date_add < '".$date_begin."'
)


";

}
$result = makequeryforps($query);
$counts = $result->fetchAll();
foreach ($counts as $count) return $count['count'];

return null;

}


function get_reccur_m($date) { 


$query = "



SELECT YEAR(o.date_add) as año ,MONTH(o.date_add) as mes ,COUNT(*) AS 'count'
from ps_orders o 
inner join ps_customer c on c.id_customer=o.id_customer
where
o.current_state in ('2','3','4','5','16','17','18')
and o.date_add > '".$date."'
and c.email not in ('ivan.monells@gmail.com', 'ramonbarbero@gmail.com', 'ptaverna@gmail.com', 'ivan@bravafabrics.com', 'pau@bravafabrics.com','ramon@bravafabrics.com','alex@bravafabrics.com')
and c.email in
(
               select c.email
               from ps_orders o 
               inner join ps_customer c on c.id_customer=o.id_customer
               where
               o.current_state in ('2','3','4','5','16','17','18')
               and o.date_add between DATE_FORMAT('".$date."' ,'%Y-%m-01 00:00:00') and '".$date."'
    /*Filtro pedidos test*/
    and o.total_paid_tax_incl > 10
    /*filtro compras equipo*/
               and c.email not in ('ivan.monells@gmail.com', 'ramonbarbero@gmail.com', 'ptaverna@gmail.com', 'ivan@bravafabrics.com', 'pau@bravafabrics.com','ramon@bravafabrics.com','alex@bravafabrics.com')
               and c.email not in
                               (
                                                                              select c.email 
                                                                              from ps_orders o 
                                                                              inner join ps_customer c on c.id_customer=o.id_customer
                                                                              where
                                                                              o.current_state in ('2','3','4','5','16','17','18')
                    and o.total_paid_tax_incl > 10
                                                                              and o.date_add < DATE_FORMAT('".$date."' ,'%Y-%m-01 00:00:00')
                    and o.total_paid_tax_incl > 10
                               ) 
) 
group by YEAR(o.date_add)  ,MONTH(o.date_add)

";

return makequeryforps($query);
 }






//echo select_zones_and_insertin_temp_zones(); // ZONES	
//echo select_ship_and_insertin_temp_ship(); // SHIP
//echo select_extra_ship_and_insertin_temp_extra_ship(); // SHIP EXTRA FEES

//select_zones_and_insertin_temp_zones();
//select_extra_ship_and_insertin_temp_extra_ship();
//select_handling_and_insertin_temp_handling();

// report_shipping_logistics_from_ps_sale_by_date("2017-07-03");


?>