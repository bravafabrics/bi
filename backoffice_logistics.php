<?php
require_once("keychain.php"); // contains the passwords we need

function makemultiqueriesforbv($query) {

try{	
$db_conn = mysqli_connect(DBLBV_HOST, DBLBV_USER, DBLBV_PASS, DBLBV_DATABASE);
 
mysqli_query($db_conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

$result = mysqli_multi_query($db_conn, $query) or die( mysql_multi_query( $db_conn ) );
}catch (Exception $e) {
  echo  'Error ' . $e->getMessage();
  exit;
}
return $result;

}

function makequeryforbv($query){

try {
	$db_conn = new PDO('mysql:host='.DBLBV_HOST.';dbname='.DBLBV_DATABASE.';charset=utf8', DBLBV_USER, DBLBV_PASS); 
	

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


function select_zones_and_insertin_temp_zones_for_bv($service) {
	
	// FIRST CREATE IT (IF TEMPORY) 
	
	$the_total_request = "
CREATE TABLE IF NOT EXISTS temp_bv_zones (
country VARCHAR(10),
service VARCHAR(255),
zone VARCHAR(30),
PRIMARY KEY (country, service));
	";
	include_once("queries_database.php");
	$zones = get_all_zones_filtrer_by_service($service);

	foreach($zones as $zone) {
		$the_total_request .= "
	INSERT INTO temp_bv_zones
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

function select_ship_and_insertin_temp_ship_for_bv($service) {
	
	// FIRST CREATE IT (IF TEMPORY) 
	
	$the_total_request = "
CREATE TABLE IF NOT EXISTS temp_bv_shipping (
zone VARCHAR(30),
service VARCHAR(255),
weight FLOAT,
price FLOAT,
PRIMARY KEY (zone, service, weight));
	";
	include_once("queries_database.php");
	$ships = get_all_ship_filtrer_by_service($service);

	foreach($ships as $ship) {
		$the_total_request .= "
	INSERT INTO temp_bv_shipping
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

function select_extra_ship_and_insertin_temp_extra_ship_for_bv($service) {
	
	// FIRST CREATE IT (IF TEMPORY) 
	
	$the_total_request = "
CREATE TABLE IF NOT EXISTS temp_bv_extra_shipping (
service VARCHAR(255),
percentage FLOAT,
fix FLOAT,
PRIMARY KEY (service));
	";
	include_once("queries_database.php");
	$ships = get_most_recent_extra_ship_filtrer_by_service($service);

	foreach($ships as $ship) {
		$the_total_request .= "
	INSERT INTO temp_bv_extra_shipping
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


function drop_all_temp_bv_ship_table() {
	$query = "DROP TABLE temp_bv_zones;
DROP TABLE temp_bv_shipping;
DROP TABLE temp_bv_extra_shipping;
DROP TABLE temp_bv_handling;";
	return makemultiqueriesforbv($query);
}

function report_refunds_from_bv_returns_by_date($date) {
	
	makemultiqueriesforbv(select_zones_and_insertin_temp_zones_for_bv(Refund_Returns)); // ZONES	
	makemultiqueriesforbv(select_ship_and_insertin_temp_ship_for_bv(Refund_Returns)); // SHIP
	makemultiqueriesforbv(select_extra_ship_and_insertin_temp_extra_ship_for_bv(Refund_Returns)); // SHIP EXTRA FEES
		
	
	$query = "
			SELECT temp_select.country AS 'countrycode', 
temp_select.number_refunds*(ts.price + tes.fix)*(1+tes.percentage/100) AS 'refunds_log'
 FROM 

				( SELECT COUNT(*) AS 'number_refunds', country FROM envios where type = 'Devolucion'
				AND DATE_FORMAT(created_at,'%Y-%m-%d') = '".$date."' 
				GROUP BY country) AS temp_select
	inner join temp_bv_zones tz on temp_select.country = tz.country and tz.service = '".Refund_Returns."'
	inner join temp_bv_shipping ts on ts.service = 'UPS Refund Returns' AND (ts.weight = '1') AND ts.zone = temp_select.country  
	inner join temp_bv_extra_shipping AS tes on tes.service = 'UPS Refund Returns'	
	";
return makequeryforbv($query);
	
}

function select_gateways_and_insertin_temp_gateways_for_bv() {
	
	// FIRST CREATE IT (IF TEMPORY) 
	
	$the_total_request = "
CREATE TABLE IF NOT EXISTS temp_bv_gateway (
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
	INSERT INTO temp_bv_gateway
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
		
return $the_total_request;
}


function report_returns_from_bv_returns_by_date($date) {
	
	// TEMPORARY TABLE
	makemultiqueriesforbv(select_handling_and_insertin_temp_handling_for_bv()); // HANDLING 
	
	makemultiqueriesforbv(select_zones_and_insertin_temp_zones_for_bv(Returns_go_es)); // ZONES	
	makemultiqueriesforbv(select_zones_and_insertin_temp_zones_for_bv(Returns_back_es)); // ZONES	
	makemultiqueriesforbv(select_zones_and_insertin_temp_zones_for_bv(Returns_go_other)); // ZONES		
	makemultiqueriesforbv(select_zones_and_insertin_temp_zones_for_bv(Returns_back_other)); // ZONES		
	makemultiqueriesforbv(select_ship_and_insertin_temp_ship_for_bv(Returns_go_es)); // SHIP
	makemultiqueriesforbv(select_ship_and_insertin_temp_ship_for_bv(Returns_back_es)); // SHIP
	makemultiqueriesforbv(select_ship_and_insertin_temp_ship_for_bv(Returns_go_other)); // SHIP
	makemultiqueriesforbv(select_ship_and_insertin_temp_ship_for_bv(Returns_back_other)); // SHIP
	makemultiqueriesforbv(select_extra_ship_and_insertin_temp_extra_ship_for_bv(Returns_go_es)); // SHIP EXTRA FEES
	makemultiqueriesforbv(select_extra_ship_and_insertin_temp_extra_ship_for_bv(Returns_back_es)); // SHIP EXTRA FEES
	makemultiqueriesforbv(select_extra_ship_and_insertin_temp_extra_ship_for_bv(Returns_go_other)); // SHIP EXTRA FEES
	makemultiqueriesforbv(select_extra_ship_and_insertin_temp_extra_ship_for_bv(Returns_back_other)); // SHIP EXTRA FEES
	
		$multi_queries_temp = "
CREATE TABLE IF NOT EXISTS temp_cambio_go (
    countrycode VARCHAR(2),
    count INT,
    service_to_bv VARCHAR(255),
    PRIMARY KEY (countrycode)
);
CREATE TABLE IF NOT EXISTS temp_cambio_return (
    countrycode VARCHAR(2),
    count INT,
    service_to_cust VARCHAR(255),
    PRIMARY KEY (countrycode)
);
CREATE TABLE IF NOT EXISTS temp_values (
    countrycode VARCHAR(2),
	value_to_bv FLOAT,
    PRIMARY KEY (countrycode)
);




		INSERT INTO temp_cambio_go (countrycode, count, service_to_bv)
				(SELECT country, COUNT(*),
				(
				CASE
				when country='ES' OR country='PT' THEN
				'".Returns_go_es."'
				else
				'".Returns_go_other."'
				END
				)

				 FROM envios 
				where type='Cambio' and DATE_FORMAT(created_at,'%Y-%m-%d') = '".$date."' 
				GROUP BY country);


		INSERT INTO temp_cambio_return (countrycode, count, service_to_cust)
				(SELECT country, COUNT(*),
				(
				CASE
				when country='ES' OR country='PT' THEN
				'".Returns_back_es."'
				else
				'".Returns_back_other."'
				END
				)

				 FROM envios 
				where type='Cambio' and DATE_FORMAT(created_at,'%Y-%m-%d') = '".$date."' 
				GROUP BY country);


INSERT INTO temp_values (countrycode, value_to_bv)
    (SELECT 
        countrycode AS 'countrycode',
            tc.count * (ts.price + tes.fix) * (1 + tes.percentage / 100) AS 'exchanges_log_1'
    FROM
        temp_cambio_go tc
    inner join temp_bv_shipping ts ON tc.service_to_bv = ts.service
        AND (ts.weight = '1')
        AND ts.zone = 'ES'
    inner join temp_bv_extra_shipping AS tes ON tc.service_to_bv = tes.service); 	
		";
		
		makemultiqueriesforbv($multi_queries_temp);
	
	$query_select = "

(SELECT 
    tr.countrycode AS 'countrycode', (tv.value_to_bv + (tr.count * (th.handling + th.preparation + (ts.price + tes.fix) * (1 + tes.percentage / 100)))) AS 'total_returns'
FROM
    temp_cambio_return tr
        inner join
    temp_bv_zones tz ON tr.countrycode = tz.country
        and tz.service = tr.service_to_cust
        inner join
    temp_bv_shipping ts ON (ts.weight = '1')
        AND tr.service_to_cust = ts.service
        AND tz.zone = ts.zone
        inner join
    temp_bv_extra_shipping AS tes ON tes.service = tz.service
		inner join temp_values AS tv ON tv.countrycode = tr.countrycode

inner join (SELECT packaging, handling, preparation, shipping_materals FROM temp_bv_handling ORDER BY date DESC LIMIT 1) th);


	
	";
	$finale_result = makequeryforbv($query_select);
	
	$query_drop_temp = "
DROP TABLE temp_cambio_go;
DROP TABLE temp_cambio_return;
DROP TABLE temp_values;
	";
	makemultiqueriesforbv($query_drop_temp);
	drop_all_temp_bv_ship_table();

	
return $finale_result;

	
}

function select_handling_and_insertin_temp_handling_for_bv() {
	
	// FIRST CREATE IT (IF TEMPORY) 
	
	$the_total_request = "
CREATE TABLE IF NOT EXISTS temp_bv_handling (
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
	INSERT INTO temp_bv_handling
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

function report_refunds_from_net_sales_from_bv_returns_by_date($date) {
			
	$query = "
SELECT country AS 'countrycode', sum(refunded_novat) AS 'refunds' FROM devoluciones WHERE return_date = '".$date."' GROUP BY country 
	";
return makequeryforbv($query);
	
}

function report_refunds_gateways_from_net_sales_from_bv_returns_by_date($date) {
			makemultiqueriesforbv(select_gateways_and_insertin_temp_gateways_for_bv());
	$query = "
(
SELECT o.country AS 'countrycode', 

sum(
CASE
when o.pay_method='Pago contra reembolso' THEN
GREATEST(o.refunded*g.percentage/100, g.fix)
else
o.refunded*g.percentage/100 + g.fix 
END
) as 'refunds_gateways'

FROM devoluciones o
inner join (

SELECT g2.payment_method,g2.percentage,g2.fix
FROM temp_bv_gateway g2
INNER JOIN(
  SELECT tg.payment_method, MAX(tg.date) AS date
  FROM temp_bv_gateway tg
  GROUP BY tg.payment_method
) AS g1 on g1.payment_method=g2.payment_method and g1.date=g2.date
) g
on g.payment_method=o.pay_method

WHERE return_date = '".$date."' group by o.country
)
	";
	$result = makequeryforbv($query);
	
	$drop_table = "DROP TABLE temp_bv_gateway";
	
	makequeryforbv($drop_table);
	
return $result;
	
}


?>