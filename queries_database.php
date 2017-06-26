<?php 
require_once("keychain.php"); // contains the passwords we need

// ****************************************** 
// ****************************************** 
// *******************************
// ********************** THAT FILE CREATES TABLE AND CONTAINS EVERY QUERIES TO DEAL WITH DATAS FOR DATABASEWHEREHOUSE  ******** //
// *********
// ***



function makequery($query){

try {
	

$db_conn = new PDO('mysql:host='.DBLDW_HOST.';dbname='.DBLDW_DATABASE.';charset=utf8', DBLDW_USER, DBLDW_PASS);
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

function makemultiqueries($query) {

try{	
$db_conn = mysqli_connect(DBLDW_HOST, DBLDW_USER, DBLDW_PASS, DBLDW_DATABASE);
 
mysqli_query($db_conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

$result = mysqli_multi_query($db_conn, $query) or die( mysql_multi_query( $db_conn ) );
}catch (Exception $e) {
  echo  'Error ' . $e->getMessage();
  exit;
}
return $result;

}


function createtables_online_pl()
{
	
	// ***** THIS FONCTION JUST CREATES THE zzz_online_pl table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS zzz_online_pl(
date DATE,
countrycode VARCHAR(2),
fullpricing FLOAT,
discount FLOAT,
cogs FLOAT, 
shipping_paid FLOAT,
net_sales FLOAT,
profit FLOAT,
gateways FLOAT,
shipping_logistics FLOAT,
handling_cost FLOAT,
order_preparation FLOAT,
total_logistics FLOAT,
packaging_cost FLOAT,
shipping_materals FLOAT,
total_cogs FLOAT,
exchanges_logistic_cost FLOAT,
returns_logistic_cost FLOAT,
facebook_conversion FLOAT,
facebook_branding FLOAT,
total_facebook FLOAT,
google_adwords FLOAT,
marketing_cost FLOAT,
refunds FLOAT,
refunds_gateways FLOAT,
refunds_cogs FLOAT,
affiliates_market FLOAT,
influencers_market FLOAT,

PRIMARY KEY (date, countrycode)

);

";	

makequery($query);

}

function createtables_gateway()
{
	
	// ***** THIS FONCTION JUST CREATES THE gateways table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS zzz_gateway(
date DATE,
payment_method VARCHAR(255),
percentage FLOAT,
fix FLOAT,
PRIMARY KEY (date, payment_method)

);

";	

makequery($query);

}

function createtables_marketing()
{
	
	// ***** THIS FONCTION JUST CREATES THE gateways table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS zzz_marketing(
date DATE,
name VARCHAR(255),
country VARCHAR(10),
value FLOAT,
PRIMARY KEY (date, name, country)

);

";	

makequery($query);

}

function createtables_zones()
{
	
	// ***** THIS FONCTION JUST CREATES THE zones table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS zzz_zones(
country VARCHAR(10),
service VARCHAR(255),
zone VARCHAR(30),
PRIMARY KEY (country, service)

);

";	

makequery($query);

}

function createtables_shipping()
{
	
	// ***** THIS FONCTION JUST CREATES THE zones table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS zzz_shipping(
zone VARCHAR(30),
service VARCHAR(255),
weight FLOAT,
price FLOAT,
PRIMARY KEY (zone, service, weight)

);

";	

makequery($query);

}

function createtables_extra_ship()
{
	
	// ***** THIS FONCTION JUST CREATES THE extra_ship table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS zzz_extra_ship(
date DATE,
service VARCHAR(255),
percentage FLOAT,
fix FLOAT,
PRIMARY KEY (date, service)

);

";	

makequery($query);

}

function createtables_handling_costs()
{
	
	// ***** THIS FONCTION JUST CREATES THE zzz_handling_costs table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS zzz_handling_costs(
date DATE,
countrycode VARCHAR(2),
packaging FLOAT,
handling FLOAT, 
preparation FLOAT,
shipping_materals FLOAT,
PRIMARY KEY (date, countrycode)

);

";	

makequery($query);

}


function createtables_edit_handling_costs()
{
	
	// ***** THIS FONCTION JUST CREATES THE zzz_handling_costs table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS zzz_edit_handling_costs(
date DATE,
packaging FLOAT,
handling FLOAT, 
preparation FLOAT,
shipping_materals FLOAT,
PRIMARY KEY (date)

);

";	

makequery($query);

}

function delete_shipping_one_by_one($service) { 

	$query = "
DELETE FROM zzz_shipping where service = '".$service."' LIMIT 1
	";
makequery($query);

}

function delete_zone($service, $country) { 

	$query = "
DELETE FROM zzz_zones where service = '".$service."' AND country = '".$country."'
	";
makequery($query);

}


function get_ratio_cogs() {
// ************** THIS FONCTION RETURNS THE "FIRST" RATIO COGS *******************//
// *****************   ************//

$query = "
SELECT sum(cogs)/sum(fullpricing - discount) AS 'ratio' FROM zzz_online_pl WHERE date BETWEEN DATE_FORMAT(DATE_ADD(now(), INTERVAL -8 DAY),'%Y-%m-%d')
 AND DATE_FORMAT(now(),'%Y-%m-%d')
";

$result = makequery($query);
$ratios = $result->fetchAll();
foreach ($ratios as $ratio) {
    return $ratio['ratio']; // It will return the first object
}


$result->closeCursor();

 
return 0.3;
}



function get_all_service() {
	
	$query = "SELECT service FROM zzz_zones GROUP BY service";
$result = makequery($query);
$services = $result->fetchAll();

$result->closeCursor();
return $services;
	
}

function get_the_number_of_distinct_weight($service) {


	$query = "
SELECT COUNT(DISTINCT weight) as count FROM zzz_shipping WHERE service = '".$service."' 
";


$result = makequery($query);
$fullps = $result->fetchAll();
foreach ($fullps as $fullp) {
    return $fullp['count']; // It will return the first object
}

$result->closeCursor();

return 0;

}

function get_all_countrycode_coming_from_service($service) {
	
	$query = "SELECT zone FROM zzz_zones WHERE service = '".$service."' GROUP BY zone";
$result = makequery($query);
$countries = $result->fetchAll();

$result->closeCursor();
return $countries;
	
}

function get_all_infos_from_shipping_courier($service) {
	
	$query = "SELECT zone, weight, price FROM zzz_shipping WHERE service = '".$service."' ORDER BY zone";
	$result = makequery($query);
	$all_infos = $result->fetchAll();
	$result->closeCursor();
return $all_infos;
}

function get_all_gateways() {

$query = "SELECT * from zzz_gateway";
$result = makequery($query);
$gateways = $result->fetchAll();

$result->closeCursor();
return $gateways;

}

function get_all_handling() {

$query = "SELECT * from zzz_edit_handling_costs";
$result = makequery($query);
$hands = $result->fetchAll();

$result->closeCursor();
return $hands;

}

function get_all_extra_ship() {

$query = "SELECT * from zzz_extra_ship";
$result = makequery($query);
$extra_ships = $result->fetchAll();

$result->closeCursor();
return $extra_ships;

}

function get_most_recent_extra_ship() {

$query = "SELECT s2.service AS 'service' ,s2.percentage AS 'percentage', s2.fix AS 'fix'
FROM zzz_extra_ship s2
INNER JOIN(
  SELECT tg.service, MAX(tg.date) AS date
  FROM zzz_extra_ship tg
  GROUP BY tg.service
) AS s1 on s1.service=s2.service and s1.date=s2.date";
$result = makequery($query);
$extra_ships = $result->fetchAll();

$result->closeCursor();
return $extra_ships;

}

function get_most_recent_extra_ship_filtrer_by_service($service) {

$query = "SELECT s2.service AS 'service' ,s2.percentage AS 'percentage', s2.fix AS 'fix'
FROM zzz_extra_ship s2
INNER JOIN(
  SELECT tg.service, MAX(tg.date) AS date
  FROM zzz_extra_ship tg
  GROUP BY tg.service
) AS s1 on s1.service=s2.service and s1.date=s2.date
WHERE s2.service = '".$service."'";
$result = makequery($query);
$extra_ships = $result->fetchAll();

$result->closeCursor();
return $extra_ships;

}

function get_all_ship() {

$query = "SELECT * from zzz_shipping";
$result = makequery($query);
$ships = $result->fetchAll();

$result->closeCursor();
return $ships;

}

function get_all_ship_filtrer_by_service($service) {

$query = "SELECT * from zzz_shipping WHERE service = '".$service."'";
$result = makequery($query);
$ships = $result->fetchAll();

$result->closeCursor();
return $ships;

}

function get_all_zones() {

$query = "SELECT * FROM zzz_zones ORDER BY service, country";
$result = makequery($query);
$zones = $result->fetchAll();

$result->closeCursor();
return $zones;

}

function get_all_zones_filtrer_by_service($service) {

$query = "SELECT * FROM zzz_zones WHERE service = '".$service."' ORDER BY service, country";
$result = makequery($query);
$zones = $result->fetchAll();

$result->closeCursor();
return $zones;

}

function ajax_insert_shipping_from_array($array) { 

	// INSERT THE SHIPPING COST IN THE DATAWAREHOUSE FROM AN ARRAY !
	
$query = "";

	for ($i = 0; $i < sizeof($array); $i++) { 
		$query .= "
		
	INSERT INTO zzz_shipping
	(
	zone,
	service,
	weight,
	price
	)
	VALUES
	(
	'".$array[$i]['zone'] . "',
	'".$array[$i]['service'] . "',
	'".$array[$i]['weight'] . "',
	'".$array[$i]['price'] . "'
	);		
		";
	
	}

makemultiqueries($query);

}

function ajax_insert_ship_extra($date, $service, $percentage, $fix) {

$query = "

	INSERT INTO zzz_extra_ship
	(
	date,
	service,
	percentage,
	fix
	)
	VALUES
	(
	'".$date . "',
	'".$service . "',
	'".$percentage . "',
	'".$fix . "'
	);
";
makequery($query);


}

function ajax_insert_gateway($date, $payment_method, $percentage, $fix) {

$query = "

	INSERT INTO zzz_gateway
	(
	date,
	payment_method,
	percentage,
	fix
	)
	VALUES
	(
	'".$date . "',
	'".$payment_method . "',
	'".$percentage . "',
	'".$fix . "'
	);
";
makequery($query);


}

function ajax_insert_handling($date, $packaging_cost, $handling_cost, $shipping_materals_cost, $preparation_cost) {
$query = "

	INSERT INTO zzz_edit_handling_costs
	(
	date,
	packaging,
	handling,
	preparation,
	shipping_materals
	)
	VALUES
	(
	'".$date . "',
	'".$packaging_cost . "',
	'".$handling_cost . "',
	'".$preparation_cost . "',
	'".$shipping_materals_cost . "'
	);
";
makequery($query);


}

function ajax_insert_marketing($date, $name, $countrycode, $value) {
$query = "

	INSERT INTO zzz_marketing
	(
	date,
	name,
	country,
	value
	)
	VALUES
	(
	'".$date . "',
	'".$name . "',
	'".$countrycode . "',
	'".$value . "'
	);
";
makequery($query);


}

function ajax_get_marketing($date) {
$query = "

SELECT * FROM zzz_marketing WHERE date = '".$date."' ;
";
$result = makequery($query);
$marketings = $result->fetchAll();

$result->closeCursor();

return $marketings;


}

function ajax_insert_zone($countrycode, $service, $zone) {

$query = "

	INSERT INTO zzz_zones
	(
	country,
	service,
	zone
	)
	VALUES
	(
	'".$countrycode . "',
	'".$service. "',
	'".$zone . "'
	);
";
$already_exist = "
	SELECT IF( EXISTS(
             SELECT *
             FROM zzz_zones
             WHERE service = '".$service."'), 1, 0);
";

$result = makequery($already_exist);
$exist = $result->fetchAll();



if($exist[0][0] == 0) { 

$query .= "
	INSERT INTO zzz_zones
	(
	country,
	service,
	zone
	)
	VALUES
	(
	'ZZ',
	'".$service. "',
	'Default'
	);
";
makemultiqueries($query);
} else { makequery($query); }





}




function ajax_update_gateway($date, $payment_method, $percentage, $fix) {

$query = "

UPDATE zzz_gateway
SET percentage = '".$percentage."',
    fix = '".$fix . "'

WHERE date = '".$date."' AND payment_method = '".$payment_method . "'	
";
makequery($query);


}

function ajax_update_marketing($date, $country, $name, $value) {

$query = "

UPDATE zzz_marketing
SET value = '".$value."'

WHERE date = '".$date."' AND country = '".$country . "' AND name = '".$name."'	
";
makequery($query);


}

function ajax_update_ship_extra($date, $service, $percentage, $fix) {

$query = "

UPDATE zzz_extra_ship
SET percentage = '".$percentage."',
    fix = '".$fix . "'

WHERE date = '".$date."' AND service = '".$service . "'	
";
makequery($query);


}


function ajax_update_handling($date, $packaging_cost, $handling_cost, $shipping_materals_cost, $preparation_cost) {


$query = "

UPDATE zzz_edit_handling_costs
SET packaging = '".$packaging_cost."',
    handling = '".$handling_cost . "',
	preparation = '".$preparation_cost."',
	shipping_materals = '".$shipping_materals_cost."'

WHERE date = '".$date."' 
";
makequery($query);


}


function get_countries_top_five($date) {
// ************** THIS FONCTION RETURNS THE TOP FIVE (HIGHEST FULLPRICING) OF COUNTRIES *******************//
// *****************   ************//
$query = "
SELECT countrycode FROM zzz_online_pl WHERE date = '".$date."' ORDER BY net_sales DESC, marketing_cost DESC LIMIT 5
";

$result = makequery($query);
$countries = $result->fetchAll();

$result->closeCursor();

return $countries;

}

function get_fullpricing($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" FULLPRICING FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//
// **** ALSO TAKE THE CASE OF A NON COUNTRYCIDE 
if($countrycode == '') {
$query = "
SELECT SUM(fullpricing) as 'fullpricing' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT fullpricing FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 


$result = makequery($query);
$fullps = $result->fetchAll();
foreach ($fullps as $fullp) {
    return $fullp['fullpricing']; // It will return the first object
}

$result->closeCursor();

return 0;

}

function get_cogs($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" COGS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT SUM(cogs) as 'cogs' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT cogs FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$cogs = $result->fetchAll();
foreach ($cogs as $cog) {
    return $cog['cogs']; // It will return the first object
}


$result->closeCursor();

 
return null;
}


function get_gateways($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" gateways FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(gateways),1) as 'gateways' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT gateways FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$gateways = $result->fetchAll();
foreach ($gateways as $cog) {
    return $cog['gateways']; // It will return the first object
}


$result->closeCursor();

 
return null;
}




function get_discount($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT SUM(discount) as 'discount' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT discount AS 'discount' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$discounts = $result->fetchAll();
foreach ($discounts as $discount) {
    return $discount['discount']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_refund_log($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" returns_logistic_cost FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(returns_logistic_cost),1) as 'returns_logistic_cost' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT ROUND(returns_logistic_cost,1) as 'returns_logistic_cost' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$returns_logistic_costs = $result->fetchAll();
foreach ($returns_logistic_costs as $returns_logistic_cost) {
    return $returns_logistic_cost['returns_logistic_cost']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_net_sales($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" net_sales FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT SUM(net_sales) as 'net_sales' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT net_sales FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$net_saless = $result->fetchAll();
foreach ($net_saless as $net_sales) {
    return $net_sales['net_sales']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_total_logs($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" net_sales FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(total_logistics),1) as 'total_logistics' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT ROUND(total_logistics,1) as 'total_logistics' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$total_logisticss = $result->fetchAll();
foreach ($total_logisticss as $total_logistics) {
    return $total_logistics['total_logistics']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_total_cogs($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" net_sales FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(total_cogs),1) as 'total_cogs' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT ROUND(total_cogs,1) as 'total_cogs' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$total_cogss = $result->fetchAll();
foreach ($total_cogss as $total_cogs) {
    return $total_cogs['total_cogs']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_marketing_cost($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" net_sales FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(marketing_cost),1) as 'marketing_cost' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT ROUND(marketing_cost,1) as 'marketing_cost' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$marketing_costs = $result->fetchAll();
foreach ($marketing_costs as $marketing_cost) {
    return $marketing_cost['marketing_cost']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_total_facebook($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" net_sales FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(total_facebook),1) as 'total_facebook' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT ROUND(total_facebook,1) as 'total_facebook' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$total_facebooks = $result->fetchAll();
foreach ($total_facebooks as $total_facebook) {
    return $total_facebook['total_facebook']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_shipping_paid($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT SUM(shipping_paid) as 'shipping_paid' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT shipping_paid FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$shipping_paids = $result->fetchAll();
foreach ($shipping_paids as $shipping_paid) {
    return $shipping_paid['shipping_paid']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_shipping_logistics($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(shipping_logistics),1) as 'shipping_logistics' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT ROUND(shipping_logistics,1) AS 'shipping_logistics' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$shipping_logisticss = $result->fetchAll();
foreach ($shipping_logisticss as $shipping_logistics) {
    return $shipping_logistics['shipping_logistics']; // It will return the first object
}


$result->closeCursor();

return null;
}

function get_shipping_materals($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(shipping_materals),1) as 'shipping_materals' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT shipping_materals AS 'shipping_materals' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$shipping_materalss = $result->fetchAll();
foreach ($shipping_materalss as $shipping_materals) {
    return $shipping_materals['shipping_materals']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_order_preparation($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(order_preparation),1) as 'order_preparation' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT ROUND(order_preparation,1) AS 'order_preparation' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$order_preparations = $result->fetchAll();
foreach ($order_preparations as $order_preparation) {
    return $order_preparation['order_preparation']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_handling_cost($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT SUM(handling_cost) as 'handling_cost' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT handling_cost AS 'handling_cost' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$handling_costs = $result->fetchAll();
foreach ($handling_costs as $handling_cost) {
    return $handling_cost['handling_cost']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_packaging_cost($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(packaging_cost),1) as 'packaging_cost' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT packaging_cost AS 'packaging_cost' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$packaging_costs = $result->fetchAll();
foreach ($packaging_costs as $packaging_cost) {
    return $packaging_cost['packaging_cost']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_google_adwords($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(google_adwords),1) as 'google_adwords' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT google_adwords AS 'google_adwords' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$google_adwordss = $result->fetchAll();
foreach ($google_adwordss as $google_adwords) {
    return $google_adwords['google_adwords']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_facebook_branding($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(facebook_branding),1) as 'facebook_branding' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT facebook_branding AS 'facebook_branding' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$facebook_brandings = $result->fetchAll();
foreach ($facebook_brandings as $facebook_branding) {
    return $facebook_branding['facebook_branding']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_facebook_conversion_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" packaging FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(facebook_conversion),1) AS 'sum_packaging' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(facebook_conversion),1) AS 'sum_packaging' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$packagingss = $result->fetchAll();
foreach ($packagingss as $packagings) {
    return $packagings['sum_packaging']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_facebook_conversion($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(facebook_conversion),1) as 'facebook_conversion' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT facebook_conversion AS 'facebook_conversion' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$facebook_conversions = $result->fetchAll();
foreach ($facebook_conversions as $facebook_conversion) {
    return $facebook_conversion['facebook_conversion']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_profit($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PROFIT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//
if($countrycode == '') {
$query = "
SELECT SUM((profit)) AS 'diff' FROM zzz_online_pl WHERE date = '".$date."'
";		
}
else {
$query = "
SELECT (profit) AS 'diff' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 


$result = makequery($query);
$profits = $result->fetchAll();
foreach ($profits as $profit) {
    return $profit['diff']; // It will return the first object
}


$result->closeCursor();

return 0;
}

function get_marketing($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PROFIT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//
if($countrycode == '') {
$query = "
SELECT SUM((marketing_cost)) AS 'diff' FROM zzz_online_pl WHERE date = '".$date."'
";		
}
else {
$query = "
SELECT (marketing_cost) AS 'diff' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 


$result = makequery($query);
$markets = $result->fetchAll();
foreach ($markets as $market) {
    return $market['diff']; // It will return the first object
}


$result->closeCursor();

return 0;
}

function get_all_marketing() {
// ************** THIS FONCTION RETURNS THE PROFIT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//
$query = "
SELECT * FROM zzz_marketing ORDER BY date
";


$result = makequery($query);
$markets = $result->fetchAll();
return $markets;
}



function get_percentage_cogs_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(cogs)/SUM(total_cogs))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((cogs/total_cogs)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$cogs_percs = $result->fetchAll();
foreach ($cogs_percs as $cogs_perc) {
    return $cogs_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_refunds_cogs($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" refunds_cogs FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT SUM(refunds_cogs) as 'refunds_cogs' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT refunds_cogs FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$refunds_cogs = $result->fetchAll();
foreach ($refunds_cogs as $cog) {
    return $cog['refunds_cogs']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_refunds_cogs_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT refunds_cogs REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(refunds_cogs)/SUM(total_cogs))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((refunds_cogs/total_cogs)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$refunds_cogs_percs = $result->fetchAll();
foreach ($refunds_cogs_percs as $refunds_cogs_perc) {
    return $refunds_cogs_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_refunds_cogs_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" refunds_cogs FROM A PARTICULAR INTERVALL BETWEEN DATE AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT SUM(refunds_cogs) as 'total_refunds_cogs' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(fullpricing) AS 'total_refunds_cogs' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$refunds_cogs = $result->fetchAll();
foreach ($refunds_cogs as $cog) {
    return $cog['total_refunds_cogs']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_refunds_cogs_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT refunds_cogs REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(refunds_cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(refunds_cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$refunds_cogs_percs = $result->fetchAll();
foreach ($refunds_cogs_percs as $refunds_cogs_perc) {
    return $refunds_cogs_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_logs_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(total_logistics)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((total_logistics/net_sales)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$logs_percs = $result->fetchAll();
foreach ($logs_percs as $logs_perc) {
    return $logs_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}


function get_percentage_total_cogs_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT total_cogs REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(total_cogs)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((total_cogs/net_sales)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$total_cogs_percs = $result->fetchAll();
foreach ($total_cogs_percs as $total_cogs_perc) {
    return $total_cogs_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_marketing_cost_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT marketing_cost REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(marketing_cost)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((marketing_cost/net_sales)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$marketing_cost_percs = $result->fetchAll();
foreach ($marketing_cost_percs as $marketing_cost_perc) {
    return $marketing_cost_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_total_facebook_from_marketing_cost($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT total_facebook REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(total_facebook)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((total_facebook/marketing_cost)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$total_facebook_percs = $result->fetchAll();
foreach ($total_facebook_percs as $total_facebook_perc) {
    return $total_facebook_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_facebook_conversion_from_total_facebook($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT facebook_conversion REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(facebook_conversion)/SUM(total_facebook))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((facebook_conversion/total_facebook)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$facebook_conversion_percs = $result->fetchAll();
foreach ($facebook_conversion_percs as $facebook_conversion_perc) {
    return $facebook_conversion_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}


function get_percentage_facebook_branding_between_two_dates_from_total_facebook($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT facebook_branding REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(facebook_branding)/SUM(total_facebook))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(facebook_branding)/SUM(total_facebook))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$facebook_branding_percs = $result->fetchAll();
foreach ($facebook_branding_percs as $facebook_branding_perc) {
    return $facebook_branding_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_facebook_branding_from_total_facebook($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT facebook_branding REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(facebook_branding)/SUM(total_facebook))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((facebook_branding/total_facebook)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$facebook_branding_percs = $result->fetchAll();
foreach ($facebook_branding_percs as $facebook_branding_perc) {
    return $facebook_branding_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_gateways_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT gateways REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(gateways)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((gateways/net_sales)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$gateways_percs = $result->fetchAll();
foreach ($gateways_percs as $gateways_perc) {
    return $gateways_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_discount_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT DISCOUNT REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((sum(discount)/sum(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((discount/net_sales)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 

$result = makequery($query);
$discount_percs = $result->fetchAll();
foreach ($discount_percs as $discount_perc) {
    return $discount_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_net_sales_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT net_sales REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((sum(net_sales)/sum(fullpricing))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((net_sales/fullpricing)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 

$result = makequery($query);
$net_sales_percs = $result->fetchAll();
foreach ($net_sales_percs as $net_sales_perc) {
    return $net_sales_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_shipping_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT SHIPPING REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((sum(shipping_paid)/sum(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((shipping_paid/net_sales)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$ships_percs = $result->fetchAll();
foreach ($ships_percs as $ship_perc) {
    return $ship_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_profit_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT PROFIT REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND((((SUM(profit))/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND((((profit)/net_sales)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 

$result = makequery($query);
$profits_percs = $result->fetchAll();
foreach ($profits_percs as $profit_perc) {
    return $profit_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}


function get_fullpricing_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" FULLPRICING FROM AN INTERVALL BETWEEN TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT sum(fullpricing) AS 'fullpricing' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(fullpricing) AS 'fullpricing' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$fullps = $result->fetchAll();
foreach ($fullps as $fullp) {
    return $fullp['fullpricing']; // It will return the first object
}

$result->closeCursor();

 
return null;

}


function get_cogs_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" COGS FROM A PARTICULAR INTERVALL BETWEEN DATE AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT SUM(cogs) as 'total_cogs' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(cogs) AS 'total_cogs' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$cogs = $result->fetchAll();
foreach ($cogs as $cog) {
    return $cog['total_cogs']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_gateways_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" gateways FROM A PARTICULAR INTERVALL BETWEEN DATE AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(SUM(gateways),1) as 'total_gateways' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(gateways),1) AS 'total_gateways' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$gateways = $result->fetchAll();
foreach ($gateways as $cog) {
    return $cog['total_gateways']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_refund_log_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" returns_logistic_cost FROM A PARTICULAR INTERVALL BETWEEN DATE AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(SUM(returns_logistic_cost),1) as 'total_returns_logistic_cost' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(returns_logistic_cost),1) AS 'total_returns_logistic_cost' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$returns_logistic_cost = $result->fetchAll();
foreach ($returns_logistic_cost as $cog) {
    return $cog['total_returns_logistic_cost']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_discount_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT sum(discount) as 'sum_discount' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(discount) as 'sum_discount' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$discounts = $result->fetchAll();
foreach ($discounts as $discount) {
    return $discount['sum_discount']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_net_sales_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" net_sales FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT sum(net_sales) as 'sum_net_sales' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(net_sales) as 'sum_net_sales' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$net_saless = $result->fetchAll();
foreach ($net_saless as $net_sales) {
    return $net_sales['sum_net_sales']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_total_logs_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" total_logs FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(sum(total_logistics),1) as 'sum_total_logistics' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(total_logistics),1) as 'sum_total_logistics' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$total_logisticss = $result->fetchAll();
foreach ($total_logisticss as $total_logistics) {
    return $total_logistics['sum_total_logistics']; // It will return the first object
}


$result->closeCursor();

 
return null;
}


function get_total_cogs_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" total_cogs FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(sum(total_cogs),1) as 'sum_total_cogs' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(total_cogs),1) as 'sum_total_cogs' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$total_cogss = $result->fetchAll();
foreach ($total_cogss as $total_cogs) {
    return $total_cogs['sum_total_cogs']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_marketing_cost_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" marketing_cost FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(sum(marketing_cost),1) as 'sum_marketing_cost' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(marketing_cost),1) as 'sum_marketing_cost' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$marketing_costs = $result->fetchAll();
foreach ($marketing_costs as $marketing_cost) {
    return $marketing_cost['sum_marketing_cost']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_total_facebook_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" total_facebook FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(sum(total_facebook),1) as 'sum_total_facebook' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(total_facebook),1) as 'sum_total_facebook' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$total_facebooks = $result->fetchAll();
foreach ($total_facebooks as $total_facebook) {
    return $total_facebook['sum_total_facebook']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_shipping_paid_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT sum(shipping_paid) AS 'sum_shipping' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(shipping_paid) AS 'sum_shipping' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$shipping_paids = $result->fetchAll();
foreach ($shipping_paids as $shipping_paid) {
    return $shipping_paid['sum_shipping']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_shipping_logistics_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(shipping_logistics),1) AS 'sum_shipping' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(shipping_logistics),1) AS 'sum_shipping' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$shipping_logisticss = $result->fetchAll();
foreach ($shipping_logisticss as $shipping_logistics) {
    return $shipping_logistics['sum_shipping']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_shipping_materals_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(shipping_materals),1) AS 'sum_shipping' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(shipping_materals),1) AS 'sum_shipping' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$shipping_materalss = $result->fetchAll();
foreach ($shipping_materalss as $shipping_materals) {
    return $shipping_materals['sum_shipping']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_order_preparation_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(order_preparation),1) AS 'sum_shipping' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(order_preparation),1) AS 'sum_shipping' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$order_preparations = $result->fetchAll();
foreach ($order_preparations as $order_preparation) {
    return $order_preparation['sum_shipping']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_handling_cost_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" HANDLING FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT sum(handling_cost) AS 'sum_handling' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(handling_cost) AS 'sum_handling' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$handlingss = $result->fetchAll();
foreach ($handlingss as $handlings) {
    return $handlings['sum_handling']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_packaging_cost_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" packaging FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(packaging_cost),1) AS 'sum_packaging' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(packaging_cost),1) AS 'sum_packaging' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$packagingss = $result->fetchAll();
foreach ($packagingss as $packagings) {
    return $packagings['sum_packaging']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_google_adwords_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" packaging FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(google_adwords),1) AS 'sum_packaging' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(google_adwords),1) AS 'sum_packaging' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$packagingss = $result->fetchAll();
foreach ($packagingss as $packagings) {
    return $packagings['sum_packaging']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_facebook_branding_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" packaging FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(facebook_branding),1) AS 'sum_packaging' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(facebook_branding),1) AS 'sum_packaging' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$packagingss = $result->fetchAll();
foreach ($packagingss as $packagings) {
    return $packagings['sum_packaging']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_profit_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PROFIT FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT SUM((profit)) AS 'sum_profit' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT SUM((profit)) AS 'sum_profit' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$profits = $result->fetchAll();
foreach ($profits as $profit) {
    return $profit['sum_profit']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_cogs_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$cogs_percs = $result->fetchAll();
foreach ($cogs_percs as $cogs_perc) {
    return $cogs_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_logs_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(total_logistics)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(total_logistics)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$cogs_percs = $result->fetchAll();
foreach ($cogs_percs as $cogs_perc) {
    return $cogs_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_total_cogs_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT total_cogs REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(total_cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(total_cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$total_cogs_percs = $result->fetchAll();
foreach ($total_cogs_percs as $total_cogs_perc) {
    return $total_cogs_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_marketing_cost_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT marketing_cost REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(marketing_cost)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(marketing_cost)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$marketing_cost_percs = $result->fetchAll();
foreach ($marketing_cost_percs as $marketing_cost_perc) {
    return $marketing_cost_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_total_facebook_between_two_dates_from_marketing_cost($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT total_facebook REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(total_facebook)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(total_facebook)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$total_facebook_percs = $result->fetchAll();
foreach ($total_facebook_percs as $total_facebook_perc) {
    return $total_facebook_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_google_adwords_from_marketing_cost($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT google_adwords REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(google_adwords)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((google_adwords/marketing_cost)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$google_adwords_percs = $result->fetchAll();
foreach ($google_adwords_percs as $google_adwords_perc) {
    return $google_adwords_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_google_adwords_between_two_dates_from_marketing_cost($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT google_adwords REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(google_adwords)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(google_adwords)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$google_adwords_percs = $result->fetchAll();
foreach ($google_adwords_percs as $google_adwords_perc) {
    return $google_adwords_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_affiliates_market($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(affiliates_market),1) as 'affiliates_market' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT affiliates_market AS 'affiliates_market' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$affiliates_markets = $result->fetchAll();
foreach ($affiliates_markets as $affiliates_market) {
    return $affiliates_market['affiliates_market']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_affiliates_market_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" packaging FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(affiliates_market),1) AS 'sum_packaging' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(affiliates_market),1) AS 'sum_packaging' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$packagingss = $result->fetchAll();
foreach ($packagingss as $packagings) {
    return $packagings['sum_packaging']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_affiliates_market_from_marketing_cost($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT affiliates_market REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(affiliates_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((affiliates_market/marketing_cost)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$affiliates_market_percs = $result->fetchAll();
foreach ($affiliates_market_percs as $affiliates_market_perc) {
    return $affiliates_market_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_affiliates_market_between_two_dates_from_marketing_cost($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT affiliates_market REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(affiliates_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(affiliates_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$affiliates_market_percs = $result->fetchAll();
foreach ($affiliates_market_percs as $affiliates_market_perc) {
    return $affiliates_market_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_influencers_market($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(influencers_market),1) as 'influencers_market' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT influencers_market AS 'influencers_market' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$influencers_markets = $result->fetchAll();
foreach ($influencers_markets as $influencers_market) {
    return $influencers_market['influencers_market']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_influencers_market_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" packaging FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(influencers_market),1) AS 'sum_packaging' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(influencers_market),1) AS 'sum_packaging' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$packagingss = $result->fetchAll();
foreach ($packagingss as $packagings) {
    return $packagings['sum_packaging']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_influencers_market_from_marketing_cost($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT influencers_market REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(influencers_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((influencers_market/marketing_cost)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$influencers_market_percs = $result->fetchAll();
foreach ($influencers_market_percs as $influencers_market_perc) {
    return $influencers_market_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_influencers_market_between_two_dates_from_marketing_cost($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT influencers_market REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(influencers_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(influencers_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$influencers_market_percs = $result->fetchAll();
foreach ($influencers_market_percs as $influencers_market_perc) {
    return $influencers_market_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_facebook_conversion_between_two_dates_from_total_facebook($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT facebook_conversion REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(facebook_conversion)/SUM(total_facebook))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(facebook_conversion)/SUM(total_facebook))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$facebook_conversion_percs = $result->fetchAll();
foreach ($facebook_conversion_percs as $facebook_conversion_perc) {
    return $facebook_conversion_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_gateways_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT gateways REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(gateways)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(gateways)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$gateways_percs = $result->fetchAll();
foreach ($gateways_percs as $gateways_perc) {
    return $gateways_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}


function get_percentage_discount_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT DISCOUNT REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(discount)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(discount)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$discount_percs = $result->fetchAll();
foreach ($discount_percs as $discount_perc) {
    return $discount_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_refunds($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" refunds FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(refunds),1) as 'refunds' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT ROUND(refunds,1) as 'refunds' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$refundss = $result->fetchAll();
foreach ($refundss as $refunds) {
    return $refunds['refunds']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_refunds_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT refunds REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((sum(refunds)/sum(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((refunds/net_sales)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 

$result = makequery($query);
$refunds_percs = $result->fetchAll();
foreach ($refunds_percs as $refunds_perc) {
    return $refunds_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_refunds_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" refunds FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(sum(refunds),1) as 'sum_refunds' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(refunds),1) as 'sum_refunds' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$refundss = $result->fetchAll();
foreach ($refundss as $refunds) {
    return $refunds['sum_refunds']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_refunds_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT refunds REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(refunds)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(refunds)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$refunds_percs = $result->fetchAll();
foreach ($refunds_percs as $refunds_perc) {
    return $refunds_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_net_sales_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT net_sales REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(net_sales)/SUM(fullpricing))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(net_sales)/SUM(fullpricing))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$net_sales_percs = $result->fetchAll();
foreach ($net_sales_percs as $net_sales_perc) {
    return $net_sales_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_shipping_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT SHIPPING REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(shipping_paid)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(discount)/SUM(net_sales))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$ships_percs = $result->fetchAll();
foreach ($ships_percs as $ship_perc) {
    return $ship_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_profit_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT PROFIT REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND((((SUM(profit))/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND((((SUM(profit))/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$profits_percs = $result->fetchAll();
foreach ($profits_percs as $profit_perc) {
    return $profit_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_refunds_gateways($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" refunds_gateways FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(refunds_gateways),1) as 'refunds_gateways' FROM zzz_online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT ROUND(refunds_gateways,1) as 'refunds_gateways' FROM zzz_online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$refunds_gatewayss = $result->fetchAll();
foreach ($refunds_gatewayss as $refunds_gateways) {
    return $refunds_gateways['refunds_gateways']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_refunds_gateways_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT refunds_gateways REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((sum(refunds_gateways)/sum(gateways))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((refunds_gateways/gateways)*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 

$result = makequery($query);
$refunds_gateways_percs = $result->fetchAll();
foreach ($refunds_gateways_percs as $refunds_gateways_perc) {
    return $refunds_gateways_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_refunds_gateways_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" refunds_gateways FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(sum(refunds_gateways),1) as 'sum_refunds_gateways' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(sum(refunds_gateways),1) as 'sum_refunds_gateways' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$refunds_gatewayss = $result->fetchAll();
foreach ($refunds_gatewayss as $refunds_gateways) {
    return $refunds_gateways['sum_refunds_gateways']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_refunds_gateways_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT refunds_gateways REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(refunds_gateways)/SUM(gateways))*100), 1) AS 'perc' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(refunds_gateways)/SUM(gateways))*100), 1) AS 'perc' FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$refunds_gateways_percs = $result->fetchAll();
foreach ($refunds_gateways_percs as $refunds_gateways_perc) {
    return $refunds_gateways_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_all_datas_between_two_dates($date1, $date2, $countrycode) {

if($countrycode == '') {
$query = "
SELECT date, countrycode, SUM(fullpricing) AS 'fullpricing', SUM(discount) AS 'discount', SUM(cogs) AS 'cogs', SUM(shipping_paid) AS 'shipping_paid' FROM zzz_online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
GROUP BY date";
}
else {
$query = "
SELECT * FROM zzz_online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 



$result = makequery($query);
$finale_result = $result->fetchAll();
return $finale_result;
}


function insert_datas_or_update_to_datawarehouse($date, $countrycode, 
$fullpricing, $discount, $cogs, $shipping_paid, $net_sales, $profit, $gateways,
$shipping_logistics, 
$handling_cost, $order_preparation, $total_logistics, $packaging_cost, $shipping_materals, $total_cogs, 
$exchanges_logistic_cost, $returns_logistic_cost,
$facebook_conversion, $facebook_branding, $total_facebook, $google_adwords, $marketing_cost, 
$refunds, $refunds_gateways,
$refunds_cogs,
$affiliates_market, $influencers_market)
 {


$query_to_do = null;

	// IF IT EXISTS ? CHECK WITH THE DATE and THE COUNTRY CODE
$query_check_exist = "
	SELECT IF( EXISTS(
             SELECT *
             FROM zzz_online_pl
             WHERE date = '".$date."' AND countrycode = '".$countrycode."'), 1, 0);
";	

$result = makequery($query_check_exist);
$exist = $result->fetchAll();
// Be careful, our result is an array ! 

if($exist[0][0] == 0) { // doesn't exist


	$query_to_do = "
	INSERT INTO zzz_online_pl
	(
	date,
	countrycode,
	fullpricing,
	discount,
	cogs,
	shipping_paid,
	net_sales,
	profit,
	gateways,
	shipping_logistics,
	handling_cost,
	order_preparation,
	total_logistics,
	packaging_cost,
	shipping_materals,
	total_cogs,
	exchanges_logistic_cost,
	returns_logistic_cost,
	facebook_conversion,
	facebook_branding,
	total_facebook,
	google_adwords,
	marketing_cost,
	refunds,
	refunds_gateways,
	refunds_cogs,
	affiliates_market, 
	influencers_market 	
	)
	VALUES
	(
	'".$date."',
	'".$countrycode."',
	'".round($fullpricing)."',
	'".round($discount)."',
	'".round($cogs) ."',
	'".round($shipping_paid) ."',
	'".round(($net_sales)). "',
	'".round(($profit)). "',
	'".round($gateways, 1). "',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0'
	);
	
	";
	
} else { // exist


// UPDATE CASE !

$which_things_to_update = "
SELECT * FROM zzz_online_pl WHERE date = '".$date . "' AND countrycode = '".$countrycode . "'
"; 
$results_about_update = makequery($which_things_to_update);
$old_variables = $results_about_update->fetchAll();
foreach ($old_variables as $old_variable) {
		if($fullpricing == null)  $fullpricing = $old_variable['fullpricing']; 
		if($discount == null)  	  $discount = $old_variable['discount']; 
		if($cogs == null)  		$cogs = $old_variable['cogs']; 
		if($shipping_paid == null)  $shipping_paid = $old_variable['shipping_paid']; 
		if($net_sales == null)  $net_sales = $old_variable['net_sales']; 
		if($profit == null)  $profit = $old_variable['profit']; 
		if($gateways == null)  $gateways = $old_variable['gateways']; 
		if($shipping_logistics == null)  $shipping_logistics = $old_variable['shipping_logistics']; 
		if($handling_cost == null)  $handling_cost = $old_variable['handling_cost']; 
		if($order_preparation == null)  $order_preparation = $old_variable['order_preparation']; 
		if($total_logistics == null)  $total_logistics = $old_variable['total_logistics']; 
		if($packaging_cost == null)  $packaging_cost = $old_variable['packaging_cost']; 
		if($shipping_materals == null)  $shipping_materals = $old_variable['shipping_materals'];
		if($total_cogs == null)  $total_cogs = $old_variable['total_cogs'];
		if($exchanges_logistic_cost == null)  $exchanges_logistic_cost = $old_variable['exchanges_logistic_cost'];
		if($returns_logistic_cost == null)  $returns_logistic_cost = $old_variable['returns_logistic_cost'];		
		if($facebook_conversion == null)  $facebook_conversion = $old_variable['facebook_conversion'];
		if($facebook_branding == null)  $facebook_branding = $old_variable['facebook_branding'];
		if($total_facebook == null)  $total_facebook = $old_variable['total_facebook'];
		if($google_adwords == null)  $google_adwords = $old_variable['google_adwords'];		
		if($marketing_cost == null)  $marketing_cost = $old_variable['marketing_cost'];
		if($refunds == null)  $refunds = $old_variable['refunds'];		
		if($refunds_gateways == null)  $refunds_gateways = $old_variable['refunds_gateways'];
		if($refunds_cogs == null)  $refunds_cogs = $old_variable['refunds_cogs'];	
		if($affiliates_market == null)  $affiliates_market = $old_variable['affiliates_market'];	
		if($influencers_market == null)  $influencers_market = $old_variable['influencers_market'];	

		
// Special case to edit profit and logistics cost		
	
}

	$query_to_do = "
UPDATE zzz_online_pl
SET fullpricing = coalesce('".round($fullpricing)."',''),
    discount = coalesce('".round($discount)."',''),
    cogs = coalesce('".round($cogs)."',''),
	shipping_paid = coalesce('".round($shipping_paid)."',''),
	net_sales = coalesce('".round($net_sales)."',''),
	profit = coalesce('".round($profit)."',''),
	gateways = coalesce('".round($gateways,1)."',''),
	shipping_logistics = coalesce('".$shipping_logistics."',''),
	handling_cost = '".round($handling_cost,1)."',
	order_preparation = '".round($order_preparation,1)."',
	total_logistics = '".round($total_logistics,1)."',
	packaging_cost = '".round($packaging_cost,1)."',
	shipping_materals = '".round($shipping_materals,1)."',
	total_cogs = '".round($total_cogs,1)."',
	exchanges_logistic_cost = '0',
	returns_logistic_cost = '".round($returns_logistic_cost,1)."',
	facebook_conversion = '".round($facebook_conversion,1)."',
	facebook_branding = '".round($facebook_branding,1)."',
	total_facebook = '".round($total_facebook,1)."',
	google_adwords	= '".round($google_adwords,1)."',
	marketing_cost	= '".round($marketing_cost,1)."',
	refunds	= '".round($refunds,1)."',
	refunds_gateways	= '".round($refunds_gateways,1)."',
	refunds_cogs	= '".round($refunds_cogs,1)."',
	affiliates_market	= '".round($affiliates_market,1)."',
	influencers_market	= '".round($influencers_market,1)."'
	
	


WHERE date = '".$date ."' AND countrycode = '".$countrycode."'	
	
	
	
	";
	
}

// If result is true -> we update		 
			 
// We have to execute the query

makequery($query_to_do);	 
	

}


function insert_empty_values_for_the_datawarehouse($date) {

	// ***************** SHOWS A SUMUP for our new database warehouse ************* // 
	// ********* BE CAREFUL OF THE DATE FORMAT, FOR EXAMPLE 05-04-17 will be April 5th 2017 **** // 
	// ******* YOU CAN FIND ALL IVA IN THE KEYCHAIN FILE *********** //
	$query = "
insert into
zzz_online_pl( date,
countrycode,
fullpricing, 
discount, 
cogs, 
shipping_paid, 
net_sales, 
profit, 
gateways, 
shipping_logistics,
handling_cost,
order_preparation,
total_logistics,
packaging_cost,
shipping_materals,
total_cogs,
exchanges_logistic_cost,
returns_logistic_cost,
facebook_conversion,
facebook_branding,
total_facebook,
google_adwords,
marketing_cost,
refunds,
refunds_gateways,
refunds_cogs,
affiliates_market,
influencers_market	

)
select '".$date."',countrycode ,0,0,0,0,0,0,0,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0
from zzz_online_pl
where countrycode not in
(
select countrycode from zzz_online_pl where date='".$date."' 
)
group by countrycode

	";
	
return makequery($query);	
}


function update_marketing_cost($date, $country, $name, $value) { 


// $date, $countrycode, 
// $fullpricing, $discount, $cogs, $shipping_paid, $net_sales, $profit, $gateways,
// $shipping_logistics, 
// $handling_cost, $order_preparation, $total_logistics, $packaging_cost, $shipping_materals, $total_cogs, 
// $exchanges_logistic_cost, $returns_logistic_cost,
// $facebook_conversion, $facebook_branding, $total_facebook, $google_adwords, $marketing_cost, 
// $refunds, $refunds_gateways,
// $refunds_cogs,
// $affiliates_market, $influencers_market

			if($name == 'Facebook Conversion') { 
      insert_datas_or_update_to_datawarehouse($date, $country, 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
null, null,
$value, null, null, null, null,
null, null,
null,
null, null); 
			}
			if($name == 'Facebook Branding') {
      insert_datas_or_update_to_datawarehouse($date, $country, 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
null, null,
null, $value, null, null, null,
null, null,
null,
null, null); 

			}
			if($name == 'Google Adwords') {
      insert_datas_or_update_to_datawarehouse($date, $country, 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
null, null,
null, null, null, $value, null,
null, null,
null,
null, null); 

			}

			if($name == 'Affiliates') {
      insert_datas_or_update_to_datawarehouse($date, $country, 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
null, null,
null, null, null, null, null,
null, null,
null,
$value, null); 

			}
			if($name == 'Influencers') {
      insert_datas_or_update_to_datawarehouse($date, $country, 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
null, null,
null, null, null, null, null,
null, null,
null,
null, $value); 

			}			
			
// ********* UPDATING THE REST OF THE COST


			$which_things_to_update = "
				SELECT * FROM zzz_online_pl WHERE date = '".$date . "' AND countrycode = '".$country . "'
			"; 
			$results_about_update = makequery($which_things_to_update);
			$old_variables = $results_about_update->fetchAll();
			foreach ($old_variables as $old_variable) {
				
				// Edit the profit ? 
$profit = $old_variable['net_sales'] - $old_variable['gateways'] - $old_variable['total_logistics'] - $old_variable['total_cogs'] - ($old_variable['facebook_conversion'] + $old_variable['facebook_branding'] + $old_variable['google_adwords']);  
      insert_datas_or_update_to_datawarehouse($date, $country, 
null, null, null, null, null, $profit, null,
null, 
null, null, null, null, null, null, 
null, null,
null, null, ($old_variable['facebook_conversion'] + $old_variable['facebook_branding']), null, 
($old_variable['facebook_conversion'] + $old_variable['facebook_branding'] + $old_variable['google_adwords'] + $old_variable['affiliates_market'] + $old_variable['influencers_market']),
null, null,
null,
null, null);
				
			}


}



//createtables();
//createtables_gateway();
?>