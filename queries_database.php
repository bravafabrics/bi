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
	

$db_conn = new PDO('mysql:host='.DBDW_HOST.';dbname='.DBDW_DATABASE.';charset=utf8', DBDW_USER, DBDW_PASS);
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
$db_conn = mysqli_connect(DBDW_HOST, DBDW_USER, DBDW_PASS, DBDW_DATABASE);
 
mysqli_query($db_conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

$result = mysqli_multi_query($db_conn, $query) or die( mysql_multi_query( $db_conn ) );
}catch (Exception $e) {
  echo  'Error ' . $e->getMessage();
  exit;
}
return $result;

}


function createtables_ecommerce_orders()
{
	
	// ***** THIS FONCTION JUST CREATES THE online_pl table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS ecommerce_orders(
id_order INT(10),
date DATE,
countrycode VARCHAR(2),
total_paid_ps FLOAT,
fullpricing FLOAT,
discount FLOAT,
cogs FLOAT, 
shipping_paid FLOAT,
payment_method VARCHAR(255),
carrier VARCHAR(255),
product_quantity INT(10), 
new_customer tinyint (1),
PRIMARY KEY (id_order)

);

";	

makequery($query);

}


function createtables_refunds()
{
	
	// ***** THIS FONCTION JUST CREATES THE exchanges_and_refunds table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS refunds(
id_refund INT(10),
id_order INT(10),
date DATE,
countrycode VARCHAR(2),
amount_refunds_without_iva FLOAT,
refunds_pay_method VARCHAR(255),
logistic_consideration tinyint (1),
PRIMARY KEY (id_refund)

);

";	

makequery($query);

}


function createtables_exchanges()
{
	
	// ***** THIS FONCTION JUST CREATES THE exchanges_and_refunds table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS exchanges(
date DATE,
countrycode VARCHAR(2),
number_returns INT(10),
service_go_brava VARCHAR(255),
service_go_cust VARCHAR(255),
PRIMARY KEY (date, countrycode)

);

";	

makequery($query);

}

function createtables_online_pl()
{
	
	// ***** THIS FONCTION JUST CREATES THE online_pl table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS online_pl(
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
recurrency FLOAT,
taboola_marketing FLOAT,
belboon_marketing FLOAT,
other_marketing FLOAT,

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

function createtables_cac()
{
	
	// ***** THIS FONCTION JUST CREATES THE cac table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS online_cac(
date DATE,
countrycode VARCHAR(2),
number_new_customers INT,
average_order_value FLOAT,
marketing_spend FLOAT,
cac FLOAT,
cltv FLOAT,
ratio FLOAT,
total_paid_for_avg FLOAT, 
number_orders INT,
total_for_cltv FLOAT,
PRIMARY KEY (date, countrycode)

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


function createtables_recurrency()
{
	
	// ***** THIS FONCTION JUST CREATES THE zones table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS zzz_recurrency(
date DATE,
recurrency FLOAT,
PRIMARY KEY (date)

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


function createtables_product_sales()
{
	
	// ***** THIS FONCTION JUST CREATES THE online_pl table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS product_sales(
id int NOT NULL AUTO_INCREMENT,
date DATE,
countrycode VARCHAR(2),
id_product INT(10),
short_name_1 VARCHAR(255),
short_name_2 VARCHAR(255),
unit_sold INT,
fp_disc VARCHAR (150),
gentle VARCHAR (150),
category_name VARCHAR (255),
id_category INT(10),
size VARCHAR(255),
sales_value FLOAT,
cogs FLOAT,

PRIMARY KEY (id)

);

";	

makequery($query);

}

function createtables_category_couple()
{
	
	// ***** THIS FONCTION JUST CREATES THE cac table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS category_couple(
id int NOT NULL AUTO_INCREMENT,
date DATE,
countrycode VARCHAR(2),
id_order INT(10),
cat_combi_id VARCHAR(255),
cat_combi_name VARCHAR(255),
PRIMARY KEY (id)

);

";	

makequery($query);

}

function createtables_daily_stock()
{
	
	// ***** THIS FONCTION JUST CREATES THE online_pl table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS daily_stock(
id_category INT(10),
date DATE,
category_name VARCHAR(255),
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

";	

makequery($query);

}

function createtables_adset_header()
{
	
	// ***** THIS FONCTION JUST CREATES THE online_pl table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS adset_header(
id_adset VARCHAR(255),
date DATE,
id_campaign VARCHAR(255),
adset_name VARCHAR(255),
campaign_name VARCHAR(255),
composed_name VARCHAR(255),
adset_bid FLOAT,
relevance_score INT(10), 
daily_budget FLOAT,
campaign_type VARCHAR(100),
campaign_objective VARCHAR(255),
event_type VARCHAR(255),
bid_method VARCHAR(100),
optimization VARCHAR(255),

PRIMARY KEY (id_adset, date)

);

";	

makequery($query);

}

function createtables_google_adgroup_header()
{
	
	// ***** THIS FONCTION JUST CREATES THE online_pl table ***** //
	
	
	
$query=
"
CREATE TABLE IF NOT EXISTS google_adgroup_header(
id_adgroup VARCHAR(255),
date DATE,
id_campaign VARCHAR(255),
adgroup_name VARCHAR(255),
campaign_name VARCHAR(255),
composed_name VARCHAR(255),
campaign_type VARCHAR(100),
bid FLOAT,
bid_type VARCHAR(255),
impressions FLOAT,
clicks INT(10),
purchases_post_click FLOAT,
purchases_post_view FLOAT,
cpclick FLOAT,
cpurchase_post_click FLOAT,
cpurchase_post_view FLOAT,
amount_spend FLOAT,
delivery FLOAT,
underdelivery FLOAT,
budget FLOAT,
cpm FLOAT,

PRIMARY KEY (id_adgroup, date)

);

";	

makequery($query);

}


function createtables_adset_data_yesterday()
{
		
	
	
$query=
"
CREATE TABLE IF NOT EXISTS adset_data_yesterday(
id_adset VARCHAR(255),
date DATE,
amount_spend FLOAT,
link_clicks FLOAT,
impressions FLOAT, 
cpc FLOAT, 
cost_per_unique_click FLOAT,
cpm FLOAT, 
reach FLOAT,
cost_per_thousand FLOAT,
pixel_add_to_cart_count INT(10),
pixel_pucharse_count INT(10),
pixel_pucharse_value FLOAT,
pixel_checkout_count INT(10),
pixel_cost_per_purchase FLOAT,
pixel_cost_per_add_to_cart FLOAT,
pixel_cost_per_product_view FLOAT,
delivery FLOAT,
underdelivery FLOAT,
frequency FLOAT,
PRIMARY KEY (id_adset, date)

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
SELECT sum(cogs)/sum(fullpricing - discount) AS 'ratio' FROM online_pl WHERE date BETWEEN DATE_FORMAT(DATE_ADD(now(), INTERVAL -8 DAY),'%Y-%m-%d')
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

function ajax_insert_recurrency($date, $recurrency) {

$query = "

	INSERT INTO zzz_recurrency
	(
	date,
	recurrency
	)
	VALUES
	(
	'".$date . "',
	'".$recurrency . "'
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
	
$query_to_do = null;

	// IF IT EXISTS ? CHECK WITH THE DATE and THE COUNTRY CODE
$query_check_exist = "
	SELECT IF( EXISTS(
             SELECT *
             FROM zzz_marketing
             WHERE date = '".$date."' AND country = '".$countrycode."' AND name = '".$name."'), 1, 0);
";	

$result = makequery($query_check_exist);
$exist = $result->fetchAll();
// Be careful, our result is an array ! 

if($exist[0][0] == 0) { // doesn't exist, lets create it


	$query_to_do = "
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
	
} else { // exist


// UPDATE CASE !

$which_things_to_update = "
SELECT * FROM zzz_marketing WHERE date = '".$date . "' AND country = '".$countrycode . "' AND name = '".$name."'
"; 
$results_about_update = makequery($which_things_to_update);
$old_variables = $results_about_update->fetchAll();
foreach ($old_variables as $old_variable) {
	
		$value = $value + $old_variable['value'];
	
}

	$query_to_do = "
UPDATE zzz_marketing
SET value = '".$value."'
	
	


WHERE date = '".$date ."' AND country = '".$countrycode."' AND name = '".$name."'	
	
	
	
	";
	
}


makequery($query_to_do);		


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

function ajax_get_recurrency() {
$query = "

SELECT * FROM zzz_recurrency;
";
$result = makequery($query);
$recurrencies = $result->fetchAll();

$result->closeCursor();

return $recurrencies;


}

function get_recent_recurrency() {
$query = "

SELECT recurrency FROM zzz_recurrency ORDER BY date DESC LIMIT 1;
";


$result = makequery($query);
$temp_variables = $result->fetchAll();
foreach ($temp_variables as $temp) {
    return $temp['recurrency']; // It will return the first object
}


$result->closeCursor();

 
return null;


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

function update_all_recurrency($recurrency) {

$query = "

UPDATE online_pl
SET recurrency = '".$recurrency."'
	
";
makequery($query);


}

function ajax_update_recurrency($date, $recurrency) {

$query = "

UPDATE zzz_recurrency
SET recurrency = '".$recurrency."'

WHERE date = '".$date."'
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
SELECT countrycode FROM online_pl WHERE date = '".$date."' ORDER BY net_sales DESC, marketing_cost DESC LIMIT 5
";

$result = makequery($query);
$countries = $result->fetchAll();

$result->closeCursor();

return $countries;

}

function get_countries_top_five_for_cac($date) {
// ************** THIS FONCTION RETURNS THE TOP FIVE (HIGHEST FULLPRICING) OF COUNTRIES *******************//
// *****************   ************//
$query = "
SELECT countrycode FROM online_cac WHERE date = '".$date."' ORDER BY marketing_spend DESC LIMIT 5
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
SELECT ROUND(SUM(fullpricing),1) as 'fullpricing' FROM online_pl WHERE date = '".$date."' 
";		
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(fullpricing),1) as 'fullpricing' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

} else {
	$query = "
SELECT fullpricing FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(cogs),1) as 'cogs' FROM online_pl WHERE date = '".$date."' 
";		
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(cogs),1) as 'cogs' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT cogs FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(gateways),1) as 'gateways' FROM online_pl WHERE date = '".$date."' 
";		
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(gateways),1) as 'gateways' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT gateways FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(discount),1) as 'discount' FROM online_pl WHERE date = '".$date."' 
";		
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(discount),1) as 'discount' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND(discount,1) AS 'discount' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(returns_logistic_cost),1) as 'returns_logistic_cost' FROM online_pl WHERE date = '".$date."' 
";		
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(returns_logistic_cost),1) as 'returns_logistic_cost' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND((returns_logistic_cost),1) as 'returns_logistic_cost' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(net_sales),1) as 'net_sales' FROM online_pl WHERE date = '".$date."' 
";		
}  
else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(net_sales),1) as 'net_sales' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT net_sales FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(total_logistics),1) as 'total_logistics' FROM online_pl WHERE date = '".$date."' 
";		
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(total_logistics),1) as 'total_logistics' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND(total_logistics,1) as 'total_logistics' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(total_cogs),1) as 'total_cogs' FROM online_pl WHERE date = '".$date."' 
";		
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(total_cogs),1) as 'total_cogs' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND(total_cogs,1) as 'total_cogs' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(marketing_cost),1) as 'marketing_cost' FROM online_pl WHERE date = '".$date."' 
";		
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(marketing_cost),1) as 'marketing_cost' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND(marketing_cost,1) as 'marketing_cost' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(total_facebook),1) as 'total_facebook' FROM online_pl WHERE date = '".$date."' 
";		
}  else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(total_facebook),1) as 'total_facebook' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND(total_facebook,1) as 'total_facebook' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(shipping_paid),1) as 'shipping_paid' FROM online_pl WHERE date = '".$date."' 
";		
}  else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(shipping_paid),1) as 'shipping_paid' FROM online_pl WHERE date = '".$date."'   AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT shipping_paid FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(shipping_logistics),1) as 'shipping_logistics' FROM online_pl WHERE date = '".$date."' 
";		
}   else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(shipping_logistics),1) as 'shipping_logistics' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND(shipping_logistics,1) AS 'shipping_logistics' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(shipping_materals),1) as 'shipping_materals' FROM online_pl WHERE date = '".$date."' 
";		
}   else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(shipping_materals),1) as 'shipping_materals' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT shipping_materals AS 'shipping_materals' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(order_preparation),1) as 'order_preparation' FROM online_pl WHERE date = '".$date."' 
";		
}   else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(order_preparation),1) as 'order_preparation' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND(order_preparation,1) AS 'order_preparation' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT SUM(handling_cost) as 'handling_cost' FROM online_pl WHERE date = '".$date."' 
";		
}    else if($countrycode == 'noes') { 

$query = "
SELECT SUM(handling_cost) as 'handling_cost' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT handling_cost AS 'handling_cost' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(packaging_cost),1) as 'packaging_cost' FROM online_pl WHERE date = '".$date."' 
";		
}    else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(packaging_cost),1) as 'packaging_cost' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT packaging_cost AS 'packaging_cost' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(google_adwords),1) as 'google_adwords' FROM online_pl WHERE date = '".$date."' 
";		
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(google_adwords),1) as 'google_adwords' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT google_adwords AS 'google_adwords' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM(facebook_branding),1) as 'facebook_branding' FROM online_pl WHERE date = '".$date."' 
";		
}    else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(facebook_branding),1) as 'facebook_branding' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT facebook_branding AS 'facebook_branding' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(sum(facebook_conversion),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(facebook_conversion),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(facebook_conversion),1) AS 'sum_packaging' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(SUM(facebook_conversion),1) as 'facebook_conversion' FROM online_pl WHERE date = '".$date."' 
";		
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(facebook_conversion),1) as 'facebook_conversion' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT facebook_conversion AS 'facebook_conversion' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(SUM((profit)),1) AS 'diff' FROM online_pl WHERE date = '".$date."'
";		
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM((profit)),1) AS 'diff' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND((profit),1) AS 'diff' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT SUM((marketing_cost)) AS 'diff' FROM online_pl WHERE date = '".$date."'
";		
}     else if($countrycode == 'noes') { 

$query = "
SELECT SUM((marketing_cost)) AS 'diff' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT (marketing_cost) AS 'diff' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(((SUM(cogs)/SUM(total_cogs))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(cogs)/SUM(total_cogs))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((cogs/total_cogs)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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

function get_percentage_simple_gateways_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(refunds_gateways+gateways)/SUM(gateways))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(refunds_gateways+gateways)/SUM(gateways))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND((((refunds_gateways+gateways)/gateways)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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


function get_percentage_simple_gateways_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT refunds_cogs REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM((refunds_gateways+gateways))/SUM(gateways))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}       else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM((refunds_gateways+gateways))/SUM(gateways))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM((refunds_gateways+gateways))/SUM(gateways))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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


function get_percentage_refunds_gateways_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(refunds_gateways)/SUM(gateways))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(refunds_gateways)/SUM(gateways))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND((((refunds_gateways)/gateways)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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



function get_percentage_shipping_paid_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT shipping_paid REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(shipping_paid)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}           else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(shipping_paid)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(shipping_paid)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$shipping_paid_percs = $result->fetchAll();
foreach ($shipping_paid_percs as $shipping_paid_perc) {
    return $shipping_paid_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_shipping_paid_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(shipping_paid)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(shipping_paid)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND((((shipping_paid)/total_logistics)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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

function get_percentage_shipping_logistics_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT shipping_logistics REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(shipping_logistics)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}           else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(shipping_logistics)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(shipping_logistics)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$shipping_logistics_percs = $result->fetchAll();
foreach ($shipping_logistics_percs as $shipping_logistics_perc) {
    return $shipping_logistics_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_shipping_logistics_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(shipping_logistics)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(shipping_logistics)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND((((shipping_logistics)/total_logistics)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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

function get_percentage_handling_cost_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT handling_cost REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(handling_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}           else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(handling_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(handling_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$handling_cost_percs = $result->fetchAll();
foreach ($handling_cost_percs as $handling_cost_perc) {
    return $handling_cost_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_handling_cost_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(handling_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(handling_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND((((handling_cost)/total_logistics)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
function get_percentage_order_preparation_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT order_preparation REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(order_preparation)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}           else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(order_preparation)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(order_preparation)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$order_preparation_percs = $result->fetchAll();
foreach ($order_preparation_percs as $order_preparation_perc) {
    return $order_preparation_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_order_preparation_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(order_preparation)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(order_preparation)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND((((order_preparation)/total_logistics)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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

function get_percentage_exchanges_logistic_cost_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT exchanges_logistic_cost REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(exchanges_logistic_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}           else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(exchanges_logistic_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(exchanges_logistic_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$exchanges_logistic_cost_percs = $result->fetchAll();
foreach ($exchanges_logistic_cost_percs as $exchanges_logistic_cost_perc) {
    return $exchanges_logistic_cost_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_exchanges_logistic_cost_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(exchanges_logistic_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(exchanges_logistic_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND((((exchanges_logistic_cost)/total_logistics)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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


function get_percentage_returns_logistic_cost_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT returns_logistic_cost REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(returns_logistic_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}           else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(returns_logistic_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(returns_logistic_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$returns_logistic_cost_percs = $result->fetchAll();
foreach ($returns_logistic_cost_percs as $returns_logistic_cost_perc) {
    return $returns_logistic_cost_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_returns_logistic_cost_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(returns_logistic_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(returns_logistic_cost)/SUM(total_logistics))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND((((returns_logistic_cost)/total_logistics)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(SUM(refunds_cogs),2) as 'refunds_cogs' FROM online_pl WHERE date = '".$date."' 
";		
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(refunds_cogs),2) as 'refunds_cogs' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT refunds_cogs FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(((SUM(refunds_cogs)/SUM(total_cogs))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}      else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(refunds_cogs)/SUM(total_cogs))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((refunds_cogs/total_cogs)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(SUM(refunds_cogs),2) as 'total_refunds_cogs' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}      else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(refunds_cogs),2) as 'total_refunds_cogs' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(fullpricing),2) AS 'total_refunds_cogs' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(refunds_cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}       else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(refunds_cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(refunds_cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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


function get_percentage_packaging_cost_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT packaging_cost REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(packaging_cost)/SUM(total_cogs))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}      else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(packaging_cost)/SUM(total_cogs))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((packaging_cost/total_cogs)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$packaging_cost_percs = $result->fetchAll();
foreach ($packaging_cost_percs as $packaging_cost_perc) {
    return $packaging_cost_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_packaging_cost_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT packaging_cost REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(packaging_cost)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}       else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(packaging_cost)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(packaging_cost)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$packaging_cost_percs = $result->fetchAll();
foreach ($packaging_cost_percs as $packaging_cost_perc) {
    return $packaging_cost_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_shipping_materals_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT shipping_materals REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(shipping_materals)/SUM(total_cogs))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}      else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(shipping_materals)/SUM(total_cogs))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((shipping_materals/total_cogs)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$shipping_materals_percs = $result->fetchAll();
foreach ($shipping_materals_percs as $shipping_materals_perc) {
    return $shipping_materals_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_shipping_materals_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT shipping_materals REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(shipping_materals)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}       else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(shipping_materals)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(shipping_materals)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$shipping_materals_percs = $result->fetchAll();
foreach ($shipping_materals_percs as $shipping_materals_perc) {
    return $shipping_materals_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_logs_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(total_logistics)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}        else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(total_logistics)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((total_logistics/net_sales)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((SUM(total_cogs)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}         else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(total_cogs)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((total_cogs/net_sales)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((SUM(marketing_cost)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}          else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(marketing_cost)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((marketing_cost/net_sales)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((SUM(total_facebook)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}           else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(total_facebook)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((total_facebook/marketing_cost)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((SUM(facebook_conversion)/SUM(total_facebook))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}            else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(facebook_conversion)/SUM(total_facebook))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((facebook_conversion/total_facebook)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((SUM(facebook_branding)/SUM(total_facebook))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}             else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(facebook_branding)/SUM(total_facebook))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(facebook_branding)/SUM(total_facebook))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(facebook_branding)/SUM(total_facebook))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}              else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(facebook_branding)/SUM(total_facebook))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((facebook_branding/total_facebook)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((SUM(gateways)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}               else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(gateways)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((gateways/net_sales)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((sum(discount)/sum(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}                else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((sum(discount)/sum(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((discount/net_sales)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((sum(net_sales)/sum(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}                 else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((sum(net_sales)/sum(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((net_sales/fullpricing)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((sum(shipping_paid)/sum(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}                  else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((sum(shipping_paid)/sum(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((shipping_paid/net_sales)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND((((SUM(profit))/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}                   else if($countrycode == 'noes') { 

$query = "
SELECT ROUND((((SUM(profit))/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND((((profit)/net_sales)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(sum(fullpricing),1) AS 'fullpricing' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}                    else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(fullpricing),1) AS 'fullpricing' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(fullpricing),1) AS 'fullpricing' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(SUM(cogs),1) as 'total_cogs' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}                     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(cogs),1) as 'total_cogs' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(cogs),1) AS 'total_cogs' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(SUM(gateways),1) as 'total_gateways' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}  else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(gateways),1) as 'total_gateways' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(gateways),1) AS 'total_gateways' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(SUM(returns_logistic_cost),1) as 'total_returns_logistic_cost' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}  else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(returns_logistic_cost),1) as 'total_returns_logistic_cost' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(returns_logistic_cost),1) AS 'total_returns_logistic_cost' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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

function get_exchange_log($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" exchanges_logistic_cost FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(exchanges_logistic_cost),1) as 'exchanges_logistic_cost' FROM online_pl WHERE date = '".$date."' 
";		
}  else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(exchanges_logistic_cost),1) as 'exchanges_logistic_cost' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND((exchanges_logistic_cost),1) as 'exchanges_logistic_cost' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$exchanges_logistic_costs = $result->fetchAll();
foreach ($exchanges_logistic_costs as $exchanges_logistic_cost) {
    return $exchanges_logistic_cost['exchanges_logistic_cost']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_exchange_log_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" exchanges_logistic_cost FROM A PARTICULAR INTERVALL BETWEEN DATE AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(SUM(exchanges_logistic_cost),1) as 'total_exchanges_logistic_cost' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(exchanges_logistic_cost),1) as 'total_exchanges_logistic_cost' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(exchanges_logistic_cost),1) AS 'total_exchanges_logistic_cost' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$exchanges_logistic_cost = $result->fetchAll();
foreach ($exchanges_logistic_cost as $cog) {
    return $cog['total_exchanges_logistic_cost']; // It will return the first object
}


$result->closeCursor();

 
return null;
}


function get_discount_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(sum(discount),1) as 'sum_discount' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(discount),1) as 'sum_discount' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(discount),1) as 'sum_discount' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(net_sales),1) as 'sum_net_sales' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(net_sales),1) as 'sum_net_sales' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(net_sales),1) as 'sum_net_sales' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(total_logistics),1) as 'sum_total_logistics' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(total_logistics),1) as 'sum_total_logistics' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(total_logistics),1) as 'sum_total_logistics' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(total_cogs),1) as 'sum_total_cogs' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(total_cogs),1) as 'sum_total_cogs' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(total_cogs),1) as 'sum_total_cogs' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(marketing_cost),1) as 'sum_marketing_cost' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(marketing_cost),1) as 'sum_marketing_cost' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(marketing_cost),1) as 'sum_marketing_cost' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(total_facebook),1) as 'sum_total_facebook' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(total_facebook),1) as 'sum_total_facebook' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(total_facebook),1) as 'sum_total_facebook' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(shipping_paid),1) AS 'sum_shipping' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(shipping_paid),1) AS 'sum_shipping' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(shipping_paid),1) AS 'sum_shipping' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(shipping_logistics),1) AS 'sum_shipping' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(shipping_logistics),1) AS 'sum_shipping' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(shipping_logistics),1) AS 'sum_shipping' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(shipping_materals),1) AS 'sum_shipping' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
} else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(shipping_materals),1) AS 'sum_shipping' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(shipping_materals),1) AS 'sum_shipping' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(order_preparation),1) AS 'sum_shipping' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(order_preparation),1) AS 'sum_shipping' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(order_preparation),1) AS 'sum_shipping' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT sum(handling_cost) AS 'sum_handling' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
} else if($countrycode == 'noes') { 

$query = "
SELECT sum(handling_cost) AS 'sum_handling' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT sum(handling_cost) AS 'sum_handling' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(packaging_cost),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}  else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(packaging_cost),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(packaging_cost),1) AS 'sum_packaging' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(google_adwords),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}   else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(google_adwords),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(google_adwords),1) AS 'sum_packaging' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(sum(facebook_branding),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}   else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(facebook_branding),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(facebook_branding),1) AS 'sum_packaging' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(SUM((profit)),1) AS 'sum_profit' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}    else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM((profit)),1) AS 'sum_profit' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(SUM((profit)),1) AS 'sum_profit' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}    else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(total_logistics)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(total_logistics)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(total_logistics)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(total_cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}      else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(total_cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(total_cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(marketing_cost)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}       else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(marketing_cost)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(marketing_cost)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(total_facebook)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}        else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(total_facebook)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(total_facebook)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(google_adwords)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}         else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(google_adwords)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((google_adwords/marketing_cost)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((SUM(google_adwords)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}          else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(google_adwords)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(google_adwords)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(SUM(affiliates_market),1) as 'affiliates_market' FROM online_pl WHERE date = '".$date."' 
";		
}           else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(affiliates_market),1) as 'affiliates_market' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT affiliates_market AS 'affiliates_market' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(sum(affiliates_market),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}            else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(affiliates_market),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(affiliates_market),1) AS 'sum_packaging' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(affiliates_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}            else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(affiliates_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((affiliates_market/marketing_cost)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((SUM(affiliates_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}            else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(affiliates_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(affiliates_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(SUM(influencers_market),1) as 'influencers_market' FROM online_pl WHERE date = '".$date."' 
";		
}            else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(influencers_market),1) as 'influencers_market' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT influencers_market AS 'influencers_market' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(sum(influencers_market),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}            else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(influencers_market),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'  AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(influencers_market),1) AS 'sum_packaging' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(influencers_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}            else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(influencers_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((influencers_market/marketing_cost)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT ROUND(((SUM(influencers_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}             else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(influencers_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(influencers_market)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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


function get_taboola_marketing($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(taboola_marketing),1) as 'taboola_marketing' FROM online_pl WHERE date = '".$date."' 
";		
}              else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(taboola_marketing),1) as 'taboola_marketing' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT taboola_marketing AS 'taboola_marketing' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$taboola_marketings = $result->fetchAll();
foreach ($taboola_marketings as $taboola_marketing) {
    return $taboola_marketing['taboola_marketing']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_taboola_marketing_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" packaging FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(taboola_marketing),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}              else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(taboola_marketing),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(taboola_marketing),1) AS 'sum_packaging' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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

function get_percentage_taboola_marketing_from_marketing_cost($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT taboola_marketing REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(taboola_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}               else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(taboola_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((taboola_marketing/marketing_cost)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$taboola_marketing_percs = $result->fetchAll();
foreach ($taboola_marketing_percs as $taboola_marketing_perc) {
    return $taboola_marketing_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_taboola_marketing_between_two_dates_from_marketing_cost($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT taboola_marketing REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(taboola_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}                else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(taboola_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(taboola_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$taboola_marketing_percs = $result->fetchAll();
foreach ($taboola_marketing_percs as $taboola_marketing_perc) {
    return $taboola_marketing_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_belboon_marketing($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(belboon_marketing),1) as 'belboon_marketing' FROM online_pl WHERE date = '".$date."' 
";		
}                else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(belboon_marketing),1) as 'belboon_marketing' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT belboon_marketing AS 'belboon_marketing' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$belboon_marketings = $result->fetchAll();
foreach ($belboon_marketings as $belboon_marketing) {
    return $belboon_marketing['belboon_marketing']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_belboon_marketing_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" packaging FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(belboon_marketing),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}                 else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(belboon_marketing),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(belboon_marketing),1) AS 'sum_packaging' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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

function get_percentage_belboon_marketing_from_marketing_cost($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT belboon_marketing REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(belboon_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}                  else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(belboon_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((belboon_marketing/marketing_cost)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$belboon_marketing_percs = $result->fetchAll();
foreach ($belboon_marketing_percs as $belboon_marketing_perc) {
    return $belboon_marketing_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_belboon_marketing_between_two_dates_from_marketing_cost($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT belboon_marketing REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(belboon_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}                   else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(belboon_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(belboon_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$belboon_marketing_percs = $result->fetchAll();
foreach ($belboon_marketing_percs as $belboon_marketing_perc) {
    return $belboon_marketing_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_other_marketing($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(other_marketing),1) as 'other_marketing' FROM online_pl WHERE date = '".$date."' 
";		
}                    else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(other_marketing),1) as 'other_marketing' FROM online_pl WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT other_marketing AS 'other_marketing' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$other_marketings = $result->fetchAll();
foreach ($other_marketings as $other_marketing) {
    return $other_marketing['other_marketing']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_other_marketing_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" packaging FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT ROUND(sum(other_marketing),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}                     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(other_marketing),1) AS 'sum_packaging' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(other_marketing),1) AS 'sum_packaging' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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

function get_percentage_other_marketing_from_marketing_cost($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT other_marketing REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(other_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}  else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(other_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((other_marketing/marketing_cost)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$other_marketing_percs = $result->fetchAll();
foreach ($other_marketing_percs as $other_marketing_perc) {
    return $other_marketing_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_other_marketing_between_two_dates_from_marketing_cost($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT other_marketing REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(other_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}   else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(other_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(other_marketing)/SUM(marketing_cost))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$other_marketing_percs = $result->fetchAll();
foreach ($other_marketing_percs as $other_marketing_perc) {
    return $other_marketing_perc['perc']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_percentage_facebook_conversion_between_two_dates_from_total_facebook($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT facebook_conversion REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(facebook_conversion)/SUM(total_facebook))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}   else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(facebook_conversion)/SUM(total_facebook))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(facebook_conversion)/SUM(total_facebook))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(gateways)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}    else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(gateways)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(gateways)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(discount)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}    else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(discount)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(discount)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(SUM(refunds),1) as 'refunds' FROM online_pl WHERE date = '".$date."' 
";		
}    else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(refunds),1) as 'refunds' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND(refunds,1) as 'refunds' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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
SELECT ROUND(((sum(refunds)/sum(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}     else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((sum(refunds)/sum(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((refunds/net_sales)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
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
SELECT round(sum(refunds),1) as 'sum_refunds' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}      else if($countrycode == 'noes') { 

$query = "
SELECT round(sum(refunds),1) as 'sum_refunds' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT round(sum(refunds),1) as 'sum_refunds' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(refunds)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}      else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(refunds)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(refunds)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(net_sales)/SUM(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}       else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(net_sales)/SUM(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(net_sales)/SUM(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(shipping_paid)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}       else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(shipping_paid)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(discount)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND((((SUM(profit))/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}       else if($countrycode == 'noes') { 

$query = "
SELECT ROUND((((SUM(profit))/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND((((SUM(profit))/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(SUM(refunds_gateways),1) as 'refunds_gateways' FROM online_pl WHERE date = '".$date."' 
";		
}        else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(refunds_gateways),1) as 'refunds_gateways' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND(refunds_gateways,1) as 'refunds_gateways' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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


function get_refunds_gateways_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" refunds_gateways FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(sum(refunds_gateways),1) as 'sum_refunds_gateways' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}          else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(refunds_gateways),1) as 'sum_refunds_gateways' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(refunds_gateways),1) as 'sum_refunds_gateways' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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
SELECT ROUND(((SUM(refunds_gateways)/SUM(gateways))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}           else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(((SUM(refunds_gateways)/SUM(gateways))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(((SUM(refunds_gateways)/SUM(gateways))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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

function get_simple_gateways($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" refunds_gateways FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(SUM(refunds_gateways+gateways),1) as 'refunds_gateways' FROM online_pl WHERE date = '".$date."' 
";		
}           else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(SUM(refunds_gateways+gateways),1) as 'refunds_gateways' FROM online_pl WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT ROUND(refunds_gateways+gateways,1) as 'refunds_gateways' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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

function get_simple_gateways_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" refunds_gateways FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(sum(refunds_gateways+gateways),1) as 'sum_refunds_gateways' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}            else if($countrycode == 'noes') { 

$query = "
SELECT ROUND(sum(refunds_gateways+gateways),1) as 'sum_refunds_gateways' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT ROUND(sum(refunds_gateways+gateways),1) as 'sum_refunds_gateways' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
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


function get_all_datas_between_two_dates($date1, $date2, $countrycode) {

if($countrycode == '') {
$query = "
SELECT date, countrycode, SUM(fullpricing) AS 'fullpricing', SUM(discount) AS 'discount', SUM(cogs) AS 'cogs', SUM(shipping_paid) AS 'shipping_paid' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
GROUP BY date";
} 
else {
$query = "
SELECT * FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 



$result = makequery($query);
$finale_result = $result->fetchAll();
return $finale_result;
}

function report_from_ecommerce_orders_net_sales_gateways_cogs_group_by_country($date) { 

$query = "

SELECT eo.countrycode AS 'countrycode', 
sum(eo.fullpricing) AS 'fullpricing',
sum(eo.discount) AS 'discount', 
sum(eo.cogs) AS 'cogs', 
sum(eo.shipping_paid) AS 'shipping_paid',
sum(
CASE
when eo.payment_method='Pago contra reembolso' THEN
GREATEST((eo.total_paid_ps*1.21)*g.percentage/100, g.fix)
else
(eo.total_paid_ps*1.21)*g.percentage/100 + g.fix 
END)
 as 'gateways'
FROM ecommerce_orders eo
inner join (

SELECT g2.payment_method,g2.percentage,g2.fix
FROM zzz_gateway g2
INNER JOIN(
  SELECT tg.payment_method, MAX(tg.date) AS date
  FROM zzz_gateway tg
  GROUP BY tg.payment_method
) AS g1 on g1.payment_method=g2.payment_method and g1.date=g2.date
) g
on g.payment_method=eo.payment_method
WHERE date = '".$date."'
GROUP BY eo.countrycode
";

return makequery($query);

}

function report_from_ecommerce_orders_shipping_logistics_group_by_country($date) { 

$query = "

select subquery.iso_code AS 'countrycode', sum(subquery.majoreted) AS 'shipping_logistics'
from
(
			SELECT temp_select.number_items, 
			temp_select.name_carrier, 
			temp_select.iso_code, 
			temp_select.date AS 'date_finale_temp',
			ts.weight AS 'weight temp', 
			temp_select.weight AS 'real weight',
			ts.price AS 'price', 
			(ts.price + tes.fix)*(1+tes.percentage/100) AS 'majoreted'


			 FROM (
								SELECT eo.countrycode AS 'iso_code', 
								eo.id_order AS 'id_order', 
								sum(eo.product_quantity) AS 'number_items', 
								eo.carrier AS 'name_carrier',
								eo.date AS 'date',
								CASE
								when sum(eo.product_quantity) >= 1 AND sum(eo.product_quantity) <= 4  THEN
								1
								else
								2
								END
								as 'weight'
								FROM ecommerce_orders eo 

								where eo.date = '".$date."'  
								GROUP BY eo.id_order 

			) AS temp_select

			inner join zzz_zones tz on temp_select.iso_code = tz.country and tz.service = temp_select.name_carrier
			inner join zzz_shipping ts on (temp_select.weight = ts.weight) AND tz.zone = ts.zone AND temp_select.name_carrier = ts.service
			inner join zzz_extra_ship AS tes on tes.service = tz.service

			WHERE temp_select.date = '".$date."' 
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
			temp_select.date AS 'date_finale_temp',
			ts.weight AS 'weight temp', 
			temp_select.weight AS 'real weight',
			ts.price AS 'price', 
			(ts.price + tes.fix)*(1+tes.percentage/100) AS 'majoreted'


			 FROM (
								SELECT eo.countrycode AS 'iso_code', 
								eo.id_order AS 'id_order', 
								sum(eo.product_quantity) AS 'number_items', 
								eo.carrier AS 'name_carrier',
								eo.date,
								CASE
								when sum(eo.product_quantity) >= 1 AND sum(eo.product_quantity) <= 4  THEN
								1
								else
								2
								END
								as 'weight'
								FROM (
											SELECT eo1.* FROM ecommerce_orders eo1
											WHERE eo1.countrycode NOT IN (
											SELECT country FROM zzz_zones z WHERE z.country <> 'ZZ' and z.service=eo1.carrier
											)
									) 
								AS eo

								where eo.date = '".$date."' 
								GROUP BY eo.id_order 

			) AS temp_select

			inner join zzz_zones tz on temp_select.iso_code = tz.country and tz.service = temp_select.name_carrier
			inner join zzz_shipping ts on (temp_select.weight = ts.weight) AND ts.zone = 'Default' AND temp_select.name_carrier = ts.service
			inner join zzz_extra_ship AS tes on tes.service = tz.service

			WHERE temp_select.date = '".$date."' 
) as subquery
group by iso_code

)



";

return makequery($query);

}


function report_from_ecommerce_orders_handling_cost_group_by_country($date) { 

$query = "

(SELECT 
sum((th.packaging*finale_select.number_items)) AS 'packaging_cost',
sum((th.handling*finale_select.number_items)) AS 'handling_cost',
sum((th.preparation)) AS 'preparation_cost',
sum((th.shipping_materals)) AS 'materals_cost',
finale_select.iso_code AS 'countrycode' FROM 
(SELECT temp_select.id_order, temp_select.number_items, temp_select.iso_code, 
temp_select.date AS 'date'
 FROM (
SELECT eo.countrycode AS 'iso_code', 
eo.id_order AS 'id_order', 
sum(eo.product_quantity) AS 'number_items', 
eo.date AS 'date'  

FROM ecommerce_orders eo
GROUP BY eo.id_order
) AS temp_select 

) 

AS finale_select 
inner join (SELECT packaging, handling, preparation, shipping_materals FROM zzz_edit_handling_costs ORDER BY date DESC LIMIT 1) th
WHERE date = '".$date."' GROUP BY finale_select.iso_code)


";

return makequery($query);

}


function insert_datas_or_update_to_datawarehouse($date, $countrycode, 
$fullpricing, $discount, $cogs, $shipping_paid, $net_sales, $profit, $gateways,
$shipping_logistics, 
$handling_cost, $order_preparation, $total_logistics, $packaging_cost, $shipping_materals, $total_cogs, 
$exchanges_logistic_cost, $returns_logistic_cost,
$facebook_conversion, $facebook_branding, $total_facebook, $google_adwords, $marketing_cost, 
$refunds, $refunds_gateways,
$refunds_cogs,
$affiliates_market, $influencers_market,
$recurrency,
$taboola_marketing, $belboon_marketing, $other_marketing)
 {


$query_to_do = null;

	// IF IT EXISTS ? CHECK WITH THE DATE and THE COUNTRY CODE
$query_check_exist = "
	SELECT IF( EXISTS(
             SELECT *
             FROM online_pl
             WHERE date = '".$date."' AND countrycode = '".$countrycode."'), 1, 0);
";	

$result = makequery($query_check_exist);
$exist = $result->fetchAll();
// Be careful, our result is an array ! 

if($exist[0][0] == 0) { // doesn't exist


	$query_to_do = "
	INSERT INTO online_pl
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
	influencers_market,
	recurrency,
	taboola_marketing,
	belboon_marketing,
	other_marketing
	)
	VALUES
	(
	'".$date."',
	'".$countrycode."',
	'".round($fullpricing, 1)."',
	'".round($discount, 1)."',
	'".round($cogs, 1) ."',
	'".round($shipping_paid, 1) ."',
	'".round(($net_sales), 1). "',
	'".round(($profit), 1). "',
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
	'".$facebook_conversion."',
	'".$facebook_branding."',
	'".$total_facebook."',
	'".$google_adwords."',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'0',
	'".$taboola_marketing."',
	'".$belboon_marketing."',
	'".$other_marketing."'
	);
	
	";
	
} else { // exist


// UPDATE CASE !

$which_things_to_update = "
SELECT * FROM online_pl WHERE date = '".$date . "' AND countrycode = '".$countrycode . "'
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
		if($recurrency == null)  $recurrency = $old_variable['recurrency'];	
		if($taboola_marketing == null)  $taboola_marketing = $old_variable['taboola_marketing'];	
		if($belboon_marketing == null)  $belboon_marketing = $old_variable['belboon_marketing'];
		if($other_marketing == null)  $other_marketing = $old_variable['other_marketing'];
		
// Special case to edit profit and logistics cost		
	
}

	$query_to_do = "
UPDATE online_pl
SET fullpricing = coalesce('".round($fullpricing,1)."',''),
    discount = coalesce('".round($discount,1)."',''),
    cogs = coalesce('".round($cogs,1)."',''),
	shipping_paid = coalesce('".round($shipping_paid,1)."',''),
	net_sales = coalesce('".round($net_sales,1)."',''),
	profit = coalesce('".round($profit,1)."',''),
	gateways = coalesce('".round($gateways,1)."',''),
	shipping_logistics = coalesce('".$shipping_logistics."',''),
	handling_cost = '".round($handling_cost,1)."',
	order_preparation = '".round($order_preparation,1)."',
	total_logistics = '".round($total_logistics,1)."',
	packaging_cost = '".round($packaging_cost,1)."',
	shipping_materals = '".round($shipping_materals,1)."',
	total_cogs = '".round($total_cogs,1)."',
	exchanges_logistic_cost = '".round($exchanges_logistic_cost,1)."',
	returns_logistic_cost = '".round($returns_logistic_cost,1)."',
	facebook_conversion = '".$facebook_conversion."',
	facebook_branding = '".$facebook_branding."',
	total_facebook = '".round($total_facebook,2)."',
	google_adwords	= '".round($google_adwords,1)."',
	marketing_cost	= '".round($marketing_cost,1)."',
	refunds	= '".round($refunds,2)."',
	refunds_gateways	= '".round($refunds_gateways,1)."',
	refunds_cogs	= '".round($refunds_cogs,1)."',
	affiliates_market	= '".round($affiliates_market,1)."',
	influencers_market	= '".round($influencers_market,1)."',
	recurrency	= '".round($recurrency,1)."',
	taboola_marketing = '".round($taboola_marketing,1)."',
	belboon_marketing = '".round($belboon_marketing,1)."',
	other_marketing = '".round($other_marketing,1)."'
	
	


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
online_pl( date,
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
influencers_market,
recurrency,
taboola_marketing,
belboon_marketing,
other_marketing	

)
select '".$date."',countrycode ,0,0,0,0,0,0,0,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0
from online_pl
where countrycode not in
(
select countrycode from online_pl where date='".$date."' 
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
null, null,
null,
null, null, null); 
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
null, null,
null,
null, null, null); 

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
null, null,
null,
null, null, null); 

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
$value, null,
null,
null, null, null); 

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
null, $value,
null,
null, null, null); 

			}	
			if($name == 'Taboola') {
      insert_datas_or_update_to_datawarehouse($date, $country, 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
null, null,
null, null, null, null, null,
null, null,
null,
null, null,
null,
$value, null, null); 

			}	
			if($name == 'Belboon') {
      insert_datas_or_update_to_datawarehouse($date, $country, 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
null, null,
null, null, null, null, null,
null, null,
null,
null, null,
null,
null, $value, null); 

			}
			if($name == 'Other') {
      insert_datas_or_update_to_datawarehouse($date, $country, 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
null, null,
null, null, null, null, null,
null, null,
null,
null, null,
null,
null, null, $value); 

			}			
			
// ********* UPDATING THE REST OF THE COST


			$which_things_to_update = "
				SELECT * FROM online_pl WHERE date = '".$date . "' AND countrycode = '".$country . "'
			"; 
			$results_about_update = makequery($which_things_to_update);
			$old_variables = $results_about_update->fetchAll();
			foreach ($old_variables as $old_variable) {

				// Edit the profit ? 
      insert_datas_or_update_to_datawarehouse($date, $country, 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
null, null,
null, null, ($old_variable['facebook_conversion'] + $old_variable['facebook_branding']), null, 
null,
null, null,
null,
null, null,
null,
null, null, null);


// $date, $countrycode, 
// $fullpricing, $discount, $cogs, $shipping_paid, $net_sales, $profit, $gateways,
// $shipping_logistics, 
// $handling_cost, $order_preparation, $total_logistics, $packaging_cost, $shipping_materals, $total_cogs, 
// $exchanges_logistic_cost, $returns_logistic_cost,
// $facebook_conversion, $facebook_branding, $total_facebook, $google_adwords, $marketing_cost, 
// $refunds, $refunds_gateways,
// $refunds_cogs,
// $affiliates_market, $influencers_market,
// $recurrency,
// $taboola_marketing, $belboon_marketing, $other_marketing
// Update the online_cac
				
			}


}


function recompute_all_the_total($date, $countrycode) { 

			$query_old_result = "SELECT * FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."' ";
			$result_old = makequery($query_old_result);
			$datas_old = $result_old->fetchAll();
			foreach($datas_old as $data_old) {  

		// TO UPDATE : net sales, gateways, total logistics, total cogs, marketing cost, profit
		
			$net_sales = $data_old['fullpricing'] - $data_old['discount'] - $data_old['refunds'];
			$gateways = $data_old['gateways'] - $data_old['refunds_gateways'];
			$total_logistics = $data_old['shipping_logistics'] + $data_old['handling_cost'] + $data_old['order_preparation'] + $data_old['exchanges_logistic_cost'] + $data_old['returns_logistic_cost'] - $data_old['shipping_paid'];
			$total_cogs = $data_old['cogs'] + $data_old['packaging_cost'] + $data_old['shipping_materals'] - $data_old['refunds_cogs'];
			$marketing_cost = $data_old['total_facebook'] + $data_old['google_adwords'] + $data_old['affiliates_market'] + $data_old['influencers_market'] + $data_old['taboola_marketing'] + $data_old['belboon_marketing'] + $data_old['other_marketing']; 
			$profit = $net_sales - $gateways - $total_logistics - $total_cogs - $marketing_cost;
			
insert_datas_or_update_to_datawarehouse($date, $countrycode, 
null, null, null, null, $net_sales, $profit, $gateways,
null, 
null, null, $total_logistics, null, null, $total_cogs, 
null, null,
null, null, null, null, $marketing_cost, 
null, null,
null,
null, null,
null,
null, null, null);	

// UPDATE THE MARKETIN COST IN THE ONLINE_CAC


				$update_query = "
UPDATE online_cac
SET marketing_spend = coalesce('".$marketing_cost."','')
WHERE date = '".$date."' AND countrycode = '".$countrycode."'
				
				";
				makequery($update_query);
			
			}

}


function get_datas_from_ps_and_insert_into_temporary_table($date) { 


	// FIRST CREATE IT (IF TEMPORY) 
	
	$the_total_request = "
CREATE TABLE IF NOT EXISTS temp_ps_cac (
countrycode VARCHAR(2),
number_orders INT,
number_new_cust INT,
avg_order_value FLOAT,
total_paid_for_avg FLOAT,
PRIMARY KEY (countrycode)
);
	";
	include_once("prestashop.php");
	$datas = get_datas_for_cac_from_prestashop($date);

	foreach($datas as $data) {
		$the_total_request .= "
	INSERT INTO temp_ps_cac
	(
countrycode,
number_orders,
number_new_cust,
avg_order_value,
total_paid_for_avg
	)
	VALUES
	(
	'".$data['countrycode']."',
	'".$data['number_orders']."',
	'".$data['number_new_cust']."',
	'".$data['avg_order_value']."',
	'".$data['total_paid_for_avg']."'
	);		
		";
	}
	//echo $the_total_request;	
return $the_total_request;

}


function fullfil_the_online_cac_table($date) { 



	
	$query_fulfill = "
	
INSERT INTO online_cac (date, countrycode, number_new_customers, average_order_value, marketing_spend, cac, cltv, ratio, total_paid_for_avg, number_orders, total_for_cltv)
SELECT eo.date, eo.countrycode, SUM(eo.new_customer) AS 'number_new_customers',
sum(eo.fullpricing-eo.discount+eo.shipping_paid)/count(*) AS 'average_order_value',
zop.marketing_cost AS 'marketing_spend',
CASE when SUM(eo.new_customer) = 0 THEN 0 else (zop.marketing_cost/SUM(eo.new_customer)) END
AS 'cac',
CASE when count(*) = 0 THEN 0 else zop.recurrency*(zop.profit + zop.marketing_cost)/count(*) end
 AS 'cltv',
CASE when count(*) = 0 OR zop.marketing_cost = 0 THEN 0 
else (zop.recurrency*(zop.profit + zop.marketing_cost)*SUM(eo.new_customer))/(count(*)*zop.marketing_cost) END 
AS 'ratio',
sum(eo.fullpricing-eo.discount+eo.shipping_paid) AS 'total_paid_for_avg', 
COUNT(*) as 'number_orders',
(zop.recurrency*(zop.profit + zop.marketing_cost)) AS 'total_for_cltv' 

 FROM ecommerce_orders eo 

inner join online_pl zop on zop.countrycode = eo.countrycode AND zop.date = eo.date
WHERE eo.date = '".$date."' GROUP BY countrycode;

	
	";
	
	
	makequery($query_fulfill);

}

function fulfill_product_sales($id_category, $date, $countrycode, $id_product, $short_name_1, $short_name_2, $unit_sold, $fp_disc, $gentle, $category_name, $size,
$sales_value, $cogs) { 


	$query_insert = "
	INSERT INTO product_sales
	(
	date,
	countrycode,
	id_product,
	short_name_1,
	short_name_2,
	unit_sold,
	fp_disc,
	gentle,
	category_name,
	id_category,
	size,
	sales_value,
	cogs
	)
	VALUES
	(
	'".$date."',
	'".$countrycode."',
	'".$id_product."',
	'".$short_name_1."',
	'".$short_name_2."',
	'".$unit_sold."',
	'".$fp_disc."',
	'".$gentle."',
	'".$category_name."',
	'".$id_category."',
	'".$size."',
	'".$sales_value."',
	'".$cogs."'
	);
		
		";
	
makequery($query_insert);


}

function fulfill_category_couple($date, $countrycode, $id_order, $cat_combi_id, $cat_combi_name) { 


	$query_insert = "
	INSERT INTO category_couple
	(
	date,
	countrycode,
	id_order,
	cat_combi_id,
	cat_combi_name
	)
	VALUES
	(
	'".$date."',
	'".$countrycode."',
	'".$id_order."',
	'".$cat_combi_id."',
	'".$cat_combi_name."'
	);
		
		";
	
makequery($query_insert);


}


function get_number_new_customers($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" number_new_customers FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT SUM(number_new_customers) as 'number_new_customers' FROM online_cac WHERE date = '".$date."' 
";		
}            else if($countrycode == 'noes') { 

$query = "
SELECT SUM(number_new_customers) as 'number_new_customers' FROM online_cac WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT number_new_customers FROM online_cac WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$number_new_customerss = $result->fetchAll();
foreach ($number_new_customerss as $number_new_customers) {
    return $number_new_customers['number_new_customers']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_number_new_customers_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" number_new_customers FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT sum(number_new_customers) as 'sum_number_new_customers' FROM online_cac WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}             else if($countrycode == 'noes') { 

$query = "
SELECT sum(number_new_customers) as 'sum_number_new_customers' FROM online_cac WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT sum(number_new_customers) as 'sum_number_new_customers' FROM online_cac WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$number_new_customerss = $result->fetchAll();
foreach ($number_new_customerss as $number_new_customers) {
    return $number_new_customers['sum_number_new_customers']; // It will return the first object
}


$result->closeCursor();

 
return null;
}


function get_average_order_value($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" average_order_value FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT round(SUM(total_paid_for_avg)/SUM(number_orders),1) as 'average_order_value' FROM online_cac WHERE date = '".$date."' 
";		
}             else if($countrycode == 'noes') { 

$query = "
SELECT round(SUM(total_paid_for_avg)/SUM(number_orders),1) as 'average_order_value' FROM online_cac WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT round(average_order_value,1) as 'average_order_value' FROM online_cac WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$average_order_values = $result->fetchAll();
foreach ($average_order_values as $average_order_value) {
    return $average_order_value['average_order_value']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_average_order_value_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" average_order_value FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT round(SUM(total_paid_for_avg)/SUM(number_orders),1) as 'sum_average_order_value' FROM online_cac WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}              else if($countrycode == 'noes') { 

$query = "
SELECT round(SUM(total_paid_for_avg)/SUM(number_orders),1) as 'sum_average_order_value' FROM online_cac WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT round(SUM(total_paid_for_avg)/SUM(number_orders),1) as 'sum_average_order_value' FROM online_cac WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$average_order_values = $result->fetchAll();
foreach ($average_order_values as $average_order_value) {
    return $average_order_value['sum_average_order_value']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_marketing_spend($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" marketing_spend FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT round(SUM(marketing_spend),1) as 'marketing_spend' FROM online_cac WHERE date = '".$date."' 
";		
}               else if($countrycode == 'noes') { 

$query = "
SELECT round(SUM(marketing_spend),1) as 'marketing_spend' FROM online_cac WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT round(marketing_spend,1) as 'marketing_spend' FROM online_cac WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$marketing_spends = $result->fetchAll();
foreach ($marketing_spends as $marketing_spend) {
    return $marketing_spend['marketing_spend']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_marketing_spend_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" marketing_spend FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT round(sum(marketing_spend),1) as 'sum_marketing_spend' FROM online_cac WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}                else if($countrycode == 'noes') { 

$query = "
SELECT round(sum(marketing_spend),1) as 'sum_marketing_spend' FROM online_cac WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT round(sum(marketing_spend),1) as 'sum_marketing_spend' FROM online_cac WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$marketing_spends = $result->fetchAll();
foreach ($marketing_spends as $marketing_spend) {
    return $marketing_spend['sum_marketing_spend']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_cac($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" cac FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT CASE when SUM(number_new_customers) = 0 THEN 0 else ROUND((SUM(marketing_spend)/SUM(number_new_customers)),1) END
AS 'cac' FROM online_cac WHERE date = '".$date."' 
";		
}                else if($countrycode == 'noes') { 

$query = "
SELECT CASE when SUM(number_new_customers) = 0 THEN 0 else ROUND((SUM(marketing_spend)/SUM(number_new_customers)),1) END
AS 'cac' FROM online_cac WHERE date = '".$date."'  AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT CASE when number_new_customers = 0 THEN 0 else ROUND((marketing_spend/number_new_customers),1) END as 'cac' FROM online_cac WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$cacs = $result->fetchAll();
foreach ($cacs as $cac) {
    return $cac['cac']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_cac_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" cac FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT CASE when SUM(number_new_customers) = 0 THEN 0 else ROUND((SUM(marketing_spend)/SUM(number_new_customers)),1) END as 'sum_cac' FROM online_cac WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}                 else if($countrycode == 'noes') { 

$query = "
SELECT CASE when SUM(number_new_customers) = 0 THEN 0 else ROUND((SUM(marketing_spend)/SUM(number_new_customers)),1) END as 'sum_cac' FROM online_cac 
WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT CASE when SUM(number_new_customers) = 0 THEN 0 else ROUND((SUM(marketing_spend)/SUM(number_new_customers)),1) END as 'sum_cac' FROM online_cac WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$cacs = $result->fetchAll();
foreach ($cacs as $cac) {
    return $cac['sum_cac']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_cltv($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" cltv FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT CASE when SUM(number_orders) = 0 THEN 0 else ROUND(SUM(total_for_cltv)/SUM(number_orders),1) end
 as 'cltv' FROM online_cac WHERE date = '".$date."' 
";		
}                  else if($countrycode == 'noes') { 

$query = "
SELECT CASE when SUM(number_orders) = 0 THEN 0 else ROUND(SUM(total_for_cltv)/SUM(number_orders),1) end
 as 'cltv' FROM online_cac WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT round(cltv,1) as 'cltv' FROM online_cac WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$cltvs = $result->fetchAll();
foreach ($cltvs as $cltv) {
    return $cltv['cltv']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_cltv_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" cltv FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT CASE when SUM(number_orders) = 0 THEN 0 else ROUND(SUM(total_for_cltv)/SUM(number_orders),1) end as 'sum_cltv' FROM online_cac WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}                   else if($countrycode == 'noes') { 

$query = "
SELECT CASE when SUM(number_orders) = 0 THEN 0 else ROUND(SUM(total_for_cltv)/SUM(number_orders),1) end as 'sum_cltv' FROM online_cac 
WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT CASE when SUM(number_orders) = 0 THEN 0 else ROUND(SUM(total_for_cltv)/SUM(number_orders),1) end as 'sum_cltv' FROM online_cac WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$cltvs = $result->fetchAll();
foreach ($cltvs as $cltv) {
    return $cltv['sum_cltv']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_ratio($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" ratio FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT CASE when SUM(number_orders) = 0 OR SUM(marketing_spend) = 0 THEN 0 
else ROUND((SUM(total_for_cltv)*SUM(number_new_customers))/(SUM(number_orders)*SUM(marketing_spend)),1) END as 'ratio' FROM online_cac WHERE date = '".$date."' 
";		
}                   else if($countrycode == 'noes') { 

$query = "
SELECT CASE when SUM(number_orders) = 0 OR SUM(marketing_spend) = 0 THEN 0 
else ROUND((SUM(total_for_cltv)*SUM(number_new_customers))/(SUM(number_orders)*SUM(marketing_spend)),1) END as 'ratio' FROM online_cac WHERE date = '".$date."' AND countrycode != 'ES'
";

}
else {
	$query = "
SELECT round(ratio,1) as 'ratio' FROM online_cac WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$ratios = $result->fetchAll();
foreach ($ratios as $ratio) {
    return $ratio['ratio']; // It will return the first object
}


$result->closeCursor();

 
return null;
}

function get_ratio_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" ratio FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT CASE when SUM(number_orders) = 0 OR SUM(marketing_spend) = 0 THEN 0 
else ROUND((SUM(total_for_cltv)*SUM(number_new_customers))/(SUM(number_orders)*SUM(marketing_spend)),1) END as 'sum_ratio' FROM online_cac WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}                   else if($countrycode == 'noes') { 

$query = "
SELECT CASE when SUM(number_orders) = 0 OR SUM(marketing_spend) = 0 THEN 0 
else ROUND((SUM(total_for_cltv)*SUM(number_new_customers))/(SUM(number_orders)*SUM(marketing_spend)),1) END as 'sum_ratio' FROM online_cac WHERE date BETWEEN '".$date1."' and '".$date2."' AND countrycode != 'ES'
";

}
else {
$query = "
SELECT CASE when SUM(number_orders) = 0 OR SUM(marketing_spend) = 0 THEN 0 
else ROUND((SUM(total_for_cltv)*SUM(number_new_customers))/(SUM(number_orders)*SUM(marketing_spend)),1) END as 'sum_ratio' FROM online_cac WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$ratios = $result->fetchAll();
foreach ($ratios as $ratio) {
    return $ratio['sum_ratio']; // It will return the first object
}


$result->closeCursor();

 
return null;
}


function insert_empty_values_for_the_online_cac($date) {

	// ***************** SHOWS A SUMUP for our new database warehouse ************* // 
	// ********* BE CAREFUL OF THE DATE FORMAT, FOR EXAMPLE 05-04-17 will be April 5th 2017 **** // 
	// ******* YOU CAN FIND ALL IVA IN THE KEYCHAIN FILE *********** //
	$query = "
insert into
online_cac
( date,
countrycode,
number_new_customers,
average_order_value,
marketing_spend,
cac,
cltv,
ratio,
total_paid_for_avg,
number_orders,
total_for_cltv

)
select '".$date."',countrycode, 0, 0, marketing_cost, 0, 0, 0, 0, 0, 0
from online_pl
where countrycode not in
(
select countrycode from online_cac where date='".$date."' 
)
AND date = '".$date."' group by countrycode

	";
	
return makequery($query);	
}


function update_marketing_spend_cac($date, $country, $value) {  

			$which_things_to_update = "
				SELECT * FROM online_cac WHERE date = '".$date . "' AND countrycode = '".$country . "'
			"; 
			$results_about_update = makequery($which_things_to_update);
			$old_variables = $results_about_update->fetchAll();
			foreach ($old_variables as $old_variable) { 


				$marketing_spend = $old_variable['marketing_spend'] + $value;
				$update_query = "
UPDATE online_cac
SET marketing_spend = coalesce('".$marketing_spend."','')
WHERE date = '".$date."' AND countrycode = '".$country."'
				
				";
				makequery($update_query);
				
			}


}

function insert_all_datas_in_ecommerce_orders($id_order, $date, $countrycode, $total_paid_ps, $fullpricing,
$discount, $cogs, $shipping_paid, $payment_method, $carrier, $product_quantity, $new_customer) {


		$query = "
		
	INSERT INTO ecommerce_orders
	(
	id_order,
	date,
	countrycode,
	total_paid_ps,
	fullpricing,
	discount,
	cogs, 
	shipping_paid,
	payment_method,
	carrier,
	product_quantity, 
	new_customer
	)
	VALUES
	(
	'".$id_order."',
	'".$date."',
	'".$countrycode."',
	'".$total_paid_ps."',
	'".$fullpricing."',
	'".$discount."',
	'".$cogs."',
	'".$shipping_paid."',
	'".$payment_method."',
	'".$carrier."',
	'".$product_quantity."',
	'".$new_customer."'
	);
		
		";
		
		makequery($query);

}



function insert_all_datas_in_refunds($id_refund, $id_order, $date, $countrycode, $amount_refunds_without_iva, $refunds_pay_method, $logistic_consideration) {


		$query = "
		
	INSERT INTO refunds
	(
	id_refund,
	id_order,
	date,
	countrycode,
	amount_refunds_without_iva,
	refunds_pay_method,
	logistic_consideration
	)
	VALUES
	(
	'".$id_refund."',
	'".$id_order."',
	'".$date."',
	'".$countrycode."',
	'".$amount_refunds_without_iva."',
	'".$refunds_pay_method."',
	'".$logistic_consideration."'
	);
		
		";
		
		makequery($query);

}


function insert_all_datas_in_exchanges($date, $countrycode, $number_returns, $service_go_brava, $service_go_cust) {


		$query = "
		
	INSERT INTO exchanges
	(
	date,
	countrycode,
	number_returns,
	service_go_brava,
	service_go_cust
	)
	VALUES
	(
	'".$date."',
	'".$countrycode."',
	'".$number_returns."',
	'".$service_go_brava."',
	'".$service_go_cust."'
	);
		
		";
		
		makequery($query);

}

function report_from_refunds_all_refunds_cost_group_by_country($date) { 


	$query =  "
SELECT r.date, countrycode, sum(amount_refunds_without_iva) AS 'refunds',

sum(CASE
when r.refunds_pay_method='Pago contra reembolso' THEN
GREATEST((r.amount_refunds_without_iva*1.21)*g.percentage/100, g.fix)
else
(r.amount_refunds_without_iva*1.21)*g.percentage/100 + g.fix 
END)
 as 'refund_gateways', 
sum(logistic_consideration)*(ts.price + tes.fix)*(1+tes.percentage/100) AS 'refunds_logistic'

 FROM refunds r 

inner join (

SELECT g2.payment_method,g2.percentage,g2.fix
FROM zzz_gateway g2
INNER JOIN(
  SELECT tg.payment_method, MAX(tg.date) AS date
  FROM zzz_gateway tg
  GROUP BY tg.payment_method
) AS g1 on g1.payment_method=g2.payment_method and g1.date=g2.date
) g
on g.payment_method=r.refunds_pay_method

	inner join zzz_zones tz on r.countrycode = tz.country and tz.service = '".Refund_Returns."'
	inner join zzz_shipping ts on ts.service = '".Refund_Returns."' AND (ts.weight = '1') AND ts.zone = tz.zone
	inner join zzz_extra_ship AS tes on tes.service = '".Refund_Returns."'	

WHERE r.date = '".$date."' GROUP BY countrycode

UNION (

SELECT r.date, countrycode, sum(amount_refunds_without_iva) AS 'refunds',

sum(CASE
when r.refunds_pay_method='Pago contra reembolso' THEN
GREATEST((r.amount_refunds_without_iva*1.21)*g.percentage/100, g.fix)
else
(r.amount_refunds_without_iva*1.21)*g.percentage/100 + g.fix 
END)
 as 'refund_gateways', 
sum(logistic_consideration)*(ts.price + tes.fix)*(1+tes.percentage/100) AS 'refunds_logistic'

 FROM (											SELECT eo1.* FROM refunds eo1
											WHERE eo1.countrycode NOT IN (
											SELECT country FROM zzz_zones z WHERE z.country <> 'ZZ' and z.service='".Refund_Returns."'
											)
) AS r

inner join (

SELECT g2.payment_method,g2.percentage,g2.fix
FROM zzz_gateway g2
INNER JOIN(
  SELECT tg.payment_method, MAX(tg.date) AS date
  FROM zzz_gateway tg
  GROUP BY tg.payment_method
) AS g1 on g1.payment_method=g2.payment_method and g1.date=g2.date
) g
on g.payment_method=r.refunds_pay_method

	inner join zzz_zones tz on r.countrycode = tz.country and tz.service = '".Refund_Returns."'
	inner join zzz_shipping ts on ts.service = '".Refund_Returns."' AND (ts.weight = '1') AND ts.zone = 'Default'
	inner join zzz_extra_ship AS tes on tes.service = '".Refund_Returns."'	

WHERE r.date = '".$date."' GROUP BY countrycode

)	
	";
	
return makequery($query);	


}


function report_from_exchanges_all_logistic_cost_group_by_country($date) { 


	$query =  "
SELECT e1.date, e1.countrycode AS 'countrycode', 
e1.log_go_cust + e1.number_returns*(ts1.price + tes1.fix)*(1 + tes1.percentage / 100)
AS 'exchanges_logistic_cost'
 FROM 
(SELECT e.date, e.countrycode, e.number_returns, e.service_go_cust, e.service_go_brava,
e.number_returns*(th.handling + th.preparation+(ts.price + tes.fix)*(1 + tes.percentage / 100)) AS 'log_go_cust'
 FROM exchanges e
	inner join zzz_zones tz ON tz.country = e.countrycode AND tz.service = e.service_go_cust
    inner join zzz_shipping ts ON e.service_go_cust = ts.service
        AND (ts.weight = '1')
        AND ts.zone = tz.zone
    inner join zzz_extra_ship AS tes ON e.service_go_cust = tes.service
	inner join (SELECT packaging, handling, preparation, shipping_materals FROM zzz_edit_handling_costs ORDER BY date DESC LIMIT 1) th
WHERE e.date = '".$date."') AS e1

	inner join zzz_zones tz1 ON tz1.country = e1.countrycode AND tz1.service = e1.service_go_brava
    inner join zzz_shipping ts1 ON e1.service_go_brava = ts1.service
        AND (ts1.weight = '1')
        AND ts1.zone = tz1.zone
    inner join zzz_extra_ship AS tes1 ON e1.service_go_brava = tes1.service
	
	";
	
return makequery($query);	


}


function fulfill_google_adgroup_header($id_adgroup, $date, $id_campaign, $adgroup_name, $campaign_name,
$composed_name, $campaign_type, $bid, $bid_type, $impressions, $clicks, $purchases_post_click, $purchases_post_view, $cpclick,
$cpurchase_post_click, $cpurchase_post_view, $amount_spend, $delivery, $underdelivery, $budget, $cpm) {  

$query = "

	INSERT INTO google_adgroup_header
	(
	id_adgroup,
	date,
	id_campaign,
	adgroup_name,
	campaign_name,
	composed_name,
	campaign_type,
	bid,
	bid_type,
	impressions,
	clicks,
	purchases_post_click,
	purchases_post_view,
	cpclick,
	cpurchase_post_click,
	cpurchase_post_view,
	amount_spend,
	delivery,
	underdelivery,
	budget,
	cpm
	)
	VALUES
	(
	'".$id_adgroup."',
	'".$date."',
	'".$id_campaign."',
	'".$adgroup_name."',
	'".$campaign_name."',
	'".$composed_name."',
	'".$campaign_type."',
	'".$bid."',
	'".$bid_type."',
	'".$impressions."',
	'".$clicks."',
	'".$purchases_post_click."',
	'".$purchases_post_view."',
	'".$cpclick."',
	'".$cpurchase_post_click."',
	'".$cpurchase_post_view."',
	'".$amount_spend."',
	'".$delivery."',
	'".$underdelivery."',
	'".$budget."',
	'".$cpm."'
	);
";
makequery($query);

}

function fulfill_adset_header_fb($id_adset, $date, $id_campaign, $adset_name, $campaign_name,
$composed_name, $adset_bid, $relevance_score, $daily_budget, $campaign_type, $campaign_objective,
$event_type, $bid_method, $optimization) {  

$query = "

	INSERT INTO adset_header
	(
	id_adset,
	date,
	id_campaign,
	adset_name,
	campaign_name,
	composed_name,
	adset_bid,
	relevance_score, 
	daily_budget,
	campaign_type,
	campaign_objective,
	event_type,
	bid_method,
	optimization	
	)
	VALUES
	(
	'".$id_adset."',
	'".$date."',
	'".$id_campaign."',
	'".$adset_name."',
	'".$campaign_name."',
	'".$composed_name."',
	'".$adset_bid."',
	'".$relevance_score."', 
	'".$daily_budget."',
	'".$campaign_type."',
	'".$campaign_objective."',
	'".$event_type."',
	'".$bid_method."',
	'".$optimization."'
	);
";
makequery($query);

}

function fulfill_adset_data_yesterday($id_adset, $date, $amount_spend, $link_clicks, $impressions, 
$cpc, $cost_per_unique_click, $cpm, $reach, $cost_per_thousand, $pixel_add_to_cart_count, $pixel_pucharse_count,
$pixel_pucharse_value, $pixel_checkout_count, $pixel_cost_per_purchase, $pixel_cost_per_add_to_cart, 
$pixel_cost_per_product_view, $delivery, $underdelivery, $frequency) {  

$query = "

	INSERT INTO adset_data_yesterday
	(
	id_adset,
	date,
	amount_spend,
	link_clicks,
	impressions, 
	cpc, 
	cost_per_unique_click,
	cpm, 
	reach,
	cost_per_thousand,
	pixel_add_to_cart_count,
	pixel_pucharse_count,
	pixel_pucharse_value,
	pixel_checkout_count,
	pixel_cost_per_purchase,
	pixel_cost_per_add_to_cart,
	pixel_cost_per_product_view,	
	delivery,
	underdelivery,
	frequency
	)
	VALUES
	(
	'".$id_adset."',
	'".$date."',
	'".$amount_spend."',
	'".$link_clicks."',
	'".$impressions."', 
	'".$cpc."', 
	'".$cost_per_unique_click."',
	'".$cpm."', 
	'".$reach."',
	ifnull('".$cost_per_thousand."','-1'),
	'".$pixel_add_to_cart_count."',
	'".$pixel_pucharse_count."',
	'".$pixel_pucharse_value."',
	'".$pixel_checkout_count."',
	ifnull('".$pixel_cost_per_purchase."','-1'),
	ifnull('".$pixel_cost_per_add_to_cart."','-1'),
	ifnull('".$pixel_cost_per_product_view."','-1'),
	'".$delivery."',
	'".$underdelivery."',
	'".$frequency."'
	);
";
makequery($query);

}

function createtables_adset_data_lifetime()
{
		
	
	
$query=
"
CREATE TABLE IF NOT EXISTS adset_data_lifetime(
id_adset VARCHAR(255),
date DATE,
amount_spend FLOAT,
link_clicks FLOAT,
impressions FLOAT, 
cpc FLOAT, 
cost_per_unique_click FLOAT,
cpm FLOAT, 
reach FLOAT,
cost_per_thousand FLOAT,
pixel_add_to_cart_count INT(10),
pixel_pucharse_count INT(10),
pixel_pucharse_value FLOAT,
pixel_checkout_count INT(10),
pixel_cost_per_purchase FLOAT,
pixel_cost_per_add_to_cart FLOAT,
pixel_cost_per_product_view FLOAT,
delivery FLOAT,
underdelivery FLOAT,
frequency FLOAT,
PRIMARY KEY (id_adset, date)

);

";	

makequery($query);

}


function fulfill_adset_data_lifetime($id_adset, $date, $amount_spend, $link_clicks, $impressions, 
$cpc, $cost_per_unique_click, $cpm, $reach, $cost_per_thousand, $pixel_add_to_cart_count, $pixel_pucharse_count,
$pixel_pucharse_value, $pixel_checkout_count, $pixel_cost_per_purchase, $pixel_cost_per_add_to_cart, 
$pixel_cost_per_product_view, $delivery, $underdelivery, $frequency) {  

$query = "

	INSERT INTO adset_data_lifetime
	(
	id_adset,
	date,
	amount_spend,
	link_clicks,
	impressions, 
	cpc, 
	cost_per_unique_click,
	cpm, 
	reach,
	cost_per_thousand,
	pixel_add_to_cart_count,
	pixel_pucharse_count,
	pixel_pucharse_value,
	pixel_checkout_count,
	pixel_cost_per_purchase,
	pixel_cost_per_add_to_cart,
	pixel_cost_per_product_view,	
	delivery,
	underdelivery,
	frequency
	)
	VALUES
	(
	'".$id_adset."',
	'".$date."',
	'".$amount_spend."',
	'".$link_clicks."',
	'".$impressions."', 
	'".$cpc."', 
	'".$cost_per_unique_click."',
	'".$cpm."', 
	'".$reach."',
	ifnull('".$cost_per_thousand."','-1'),
	'".$pixel_add_to_cart_count."',
	'".$pixel_pucharse_count."',
	'".$pixel_pucharse_value."',
	'".$pixel_checkout_count."',
	ifnull('".$pixel_cost_per_purchase."','-1'),
	ifnull('".$pixel_cost_per_add_to_cart."','-1'),
	ifnull('".$pixel_cost_per_product_view."','-1'),
	'".$delivery."',
	'".$underdelivery."',
	'".$frequency."'
	);
";
makequery($query);

}

function createtables_adset_data_last_three_days()
{
		
	
	
$query=
"
CREATE TABLE IF NOT EXISTS adset_data_last_three_days(
id_adset VARCHAR(255),
date DATE,
amount_spend FLOAT,
link_clicks FLOAT,
impressions FLOAT, 
cpc FLOAT, 
cost_per_unique_click FLOAT,
cpm FLOAT, 
reach FLOAT,
cost_per_thousand FLOAT,
pixel_add_to_cart_count INT(10),
pixel_pucharse_count INT(10),
pixel_pucharse_value FLOAT,
pixel_checkout_count INT(10),
pixel_cost_per_purchase FLOAT,
pixel_cost_per_add_to_cart FLOAT,
pixel_cost_per_product_view FLOAT,
delivery FLOAT,
underdelivery FLOAT,
frequency FLOAT,
PRIMARY KEY (id_adset, date)

);

";	

makequery($query);

}


function fulfill_adset_data_last_three_days($id_adset, $date, $amount_spend, $link_clicks, $impressions, 
$cpc, $cost_per_unique_click, $cpm, $reach, $cost_per_thousand, $pixel_add_to_cart_count, $pixel_pucharse_count,
$pixel_pucharse_value, $pixel_checkout_count, $pixel_cost_per_purchase, $pixel_cost_per_add_to_cart, 
$pixel_cost_per_product_view, $delivery, $underdelivery, $frequency) {  

$query = "

	INSERT INTO adset_data_last_three_days
	(
	id_adset,
	date,
	amount_spend,
	link_clicks,
	impressions, 
	cpc, 
	cost_per_unique_click,
	cpm, 
	reach,
	cost_per_thousand,
	pixel_add_to_cart_count,
	pixel_pucharse_count,
	pixel_pucharse_value,
	pixel_checkout_count,
	pixel_cost_per_purchase,
	pixel_cost_per_add_to_cart,
	pixel_cost_per_product_view,	
	delivery,
	underdelivery,
	frequency
	)
	VALUES
	(
	'".$id_adset."',
	'".$date."',
	'".$amount_spend."',
	'".$link_clicks."',
	'".$impressions."', 
	'".$cpc."', 
	'".$cost_per_unique_click."',
	'".$cpm."', 
	'".$reach."',
	ifnull('".$cost_per_thousand."','-1'),
	'".$pixel_add_to_cart_count."',
	'".$pixel_pucharse_count."',
	'".$pixel_pucharse_value."',
	'".$pixel_checkout_count."',
	ifnull('".$pixel_cost_per_purchase."','-1'),
	ifnull('".$pixel_cost_per_add_to_cart."','-1'),
	ifnull('".$pixel_cost_per_product_view."','-1'),
	'".$delivery."',
	'".$underdelivery."',
	'".$frequency."'
	);
";
makequery($query);

}

function createtables_adset_data_last_seven_days()
{
		
	
	
$query=
"
CREATE TABLE IF NOT EXISTS adset_data_last_seven_days(
id_adset VARCHAR(255),
date DATE,
amount_spend FLOAT,
link_clicks FLOAT,
impressions FLOAT, 
cpc FLOAT, 
cost_per_unique_click FLOAT,
cpm FLOAT, 
reach FLOAT,
cost_per_thousand FLOAT,
pixel_add_to_cart_count INT(10),
pixel_pucharse_count INT(10),
pixel_pucharse_value FLOAT,
pixel_checkout_count INT(10),
pixel_cost_per_purchase FLOAT,
pixel_cost_per_add_to_cart FLOAT,
pixel_cost_per_product_view FLOAT,
delivery FLOAT,
underdelivery FLOAT,
frequency FLOAT,
PRIMARY KEY (id_adset, date)

);

";	

makequery($query);

}


function fulfill_adset_data_last_seven_days($id_adset, $date, $amount_spend, $link_clicks, $impressions, 
$cpc, $cost_per_unique_click, $cpm, $reach, $cost_per_thousand, $pixel_add_to_cart_count, $pixel_pucharse_count,
$pixel_pucharse_value, $pixel_checkout_count, $pixel_cost_per_purchase, $pixel_cost_per_add_to_cart, 
$pixel_cost_per_product_view, $delivery, $underdelivery, $frequency) {  

$query = "

	INSERT INTO adset_data_last_seven_days
	(
	id_adset,
	date,
	amount_spend,
	link_clicks,
	impressions, 
	cpc, 
	cost_per_unique_click,
	cpm, 
	reach,
	cost_per_thousand,
	pixel_add_to_cart_count,
	pixel_pucharse_count,
	pixel_pucharse_value,
	pixel_checkout_count,
	pixel_cost_per_purchase,
	pixel_cost_per_add_to_cart,
	pixel_cost_per_product_view,	
	delivery,
	underdelivery,
	frequency
	)
	VALUES
	(
	'".$id_adset."',
	'".$date."',
	'".$amount_spend."',
	'".$link_clicks."',
	'".$impressions."', 
	'".$cpc."', 
	'".$cost_per_unique_click."',
	'".$cpm."', 
	'".$reach."',
	ifnull('".$cost_per_thousand."','-1'),
	'".$pixel_add_to_cart_count."',
	'".$pixel_pucharse_count."',
	'".$pixel_pucharse_value."',
	'".$pixel_checkout_count."',
	ifnull('".$pixel_cost_per_purchase."','-1'),
	ifnull('".$pixel_cost_per_add_to_cart."','-1'),
	ifnull('".$pixel_cost_per_product_view."','-1'),
	'".$delivery."',
	'".$underdelivery."',
	'".$frequency."'
	);
";
makequery($query);

}

function createtables_adset_data_last_twenty_eight_days()
{
		
	
	
$query=
"
CREATE TABLE IF NOT EXISTS adset_data_last_twenty_eight_days(
id_adset VARCHAR(255),
date DATE,
amount_spend FLOAT,
link_clicks FLOAT,
impressions FLOAT, 
cpc FLOAT, 
cost_per_unique_click FLOAT,
cpm FLOAT, 
reach FLOAT,
cost_per_thousand FLOAT,
pixel_add_to_cart_count INT(10),
pixel_pucharse_count INT(10),
pixel_pucharse_value FLOAT,
pixel_checkout_count INT(10),
pixel_cost_per_purchase FLOAT,
pixel_cost_per_add_to_cart FLOAT,
pixel_cost_per_product_view FLOAT,
delivery FLOAT,
underdelivery FLOAT,
frequency FLOAT,
PRIMARY KEY (id_adset, date)

);

";	

makequery($query);

}


function fulfill_adset_data_last_twenty_eight_days($id_adset, $date, $amount_spend, $link_clicks, $impressions, 
$cpc, $cost_per_unique_click, $cpm, $reach, $cost_per_thousand, $pixel_add_to_cart_count, $pixel_pucharse_count,
$pixel_pucharse_value, $pixel_checkout_count, $pixel_cost_per_purchase, $pixel_cost_per_add_to_cart, 
$pixel_cost_per_product_view, $delivery, $underdelivery, $frequency) {  

$query = "

	INSERT INTO adset_data_last_twenty_eight_days
	(
	id_adset,
	date,
	amount_spend,
	link_clicks,
	impressions, 
	cpc, 
	cost_per_unique_click,
	cpm, 
	reach,
	cost_per_thousand,
	pixel_add_to_cart_count,
	pixel_pucharse_count,
	pixel_pucharse_value,
	pixel_checkout_count,
	pixel_cost_per_purchase,
	pixel_cost_per_add_to_cart,
	pixel_cost_per_product_view,	
	delivery,
	underdelivery,
	frequency
	)
	VALUES
	(
	'".$id_adset."',
	'".$date."',
	'".$amount_spend."',
	'".$link_clicks."',
	'".$impressions."', 
	'".$cpc."', 
	'".$cost_per_unique_click."',
	'".$cpm."', 
	'".$reach."',
	ifnull('".$cost_per_thousand."','-1'),
	'".$pixel_add_to_cart_count."',
	'".$pixel_pucharse_count."',
	'".$pixel_pucharse_value."',
	'".$pixel_checkout_count."',
	ifnull('".$pixel_cost_per_purchase."','-1'),
	ifnull('".$pixel_cost_per_add_to_cart."','-1'),
	ifnull('".$pixel_cost_per_product_view."','-1'),
	'".$delivery."',
	'".$underdelivery."',
	'".$frequency."'
	);
";
makequery($query);

}


function fulfill_daily_stocks($id_category, $date, $category_name, $id_product, $short_name_1,
$short_name_2, $current_stock, $euro_stock, $percentage_size, $units_sold, $days_stock) {  
$query = "

	INSERT INTO daily_stock
	(
	id_category,
	date,
	category_name,
	id_product,
	short_name_1,
	short_name_2,
	current_stock,
	euro_stock,
	percentage_size,
	units_sold,
	days_stock
	)
	VALUES
	(
	'".$id_category."',
	'".$date."',
	'".$category_name."',
	'".$id_product."',
	'".$short_name_1."', 
	'".$short_name_2."', 
	'".$current_stock."',
	'".$euro_stock."', 
	'".$percentage_size."',
	'".$units_sold."',
	'".$days_stock."'
	);
";
makequery($query);

}


//createtables();
//createtables_gateway();
?>