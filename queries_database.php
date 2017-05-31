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


function createtables()
{
	
	// ***** THIS FONCTION JUST CREATES THE ONLINE_PL table ***** //
	
	
	
$query=
"
CREATE TABLE online_pl(
date DATE,
countrycode VARCHAR(2),
fullpricing FLOAT,
discount FLOAT,
cogs FLOAT, 
shipping_paid FLOAT,
net_sales FLOAT,
PRIMARY KEY (date, countrycode)

);

";	

makequery($query);

echo "The table has correctly been created";
}

function get_countries_top_five($date) {
// ************** THIS FONCTION RETURNS THE TOP FIVE (HIGHEST FULLPRICING) OF COUNTRIES *******************//
// *****************   ************//
$query = "
SELECT countrycode FROM online_pl WHERE date = '".$date."' ORDER BY (fullpricing-discount) DESC LIMIT 5
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
SELECT SUM(fullpricing) as 'fullpricing' FROM online_pl WHERE date = '".$date."' 
";		
}
else {
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
SELECT SUM(cogs) as 'cogs' FROM online_pl WHERE date = '".$date."' 
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

echo "There is no result";
return null;
}


function get_discount($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT SUM(discount) as 'discount' FROM online_pl WHERE date = '".$date."' 
";		
}
else {
	$query = "
SELECT discount FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";
} 

$result = makequery($query);
$discounts = $result->fetchAll();
foreach ($discounts as $discount) {
    return $discount['discount']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}

function get_net_sales($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" net_sales FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT SUM(net_sales) as 'net_sales' FROM online_pl WHERE date = '".$date."' 
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

echo "There is no result";
return null;
}

function get_shipping_paid($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT SUM(shipping_paid) as 'shipping_paid' FROM online_pl WHERE date = '".$date."' 
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

echo "There is no result";
return null;
}

function get_profit($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PROFIT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//
if($countrycode == '') {
$query = "
SELECT SUM((fullpricing - cogs - discount - shipping_paid)) AS 'diff' FROM online_pl WHERE date = '".$date."'
";		
}
else {
$query = "
SELECT (fullpricing - cogs - discount - shipping_paid) AS 'diff' FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
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

function get_percentage_cogs_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(cogs)/SUM(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((cogs/fullpricing)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$cogs_percs = $result->fetchAll();
foreach ($cogs_percs as $cogs_perc) {
    return $cogs_perc['perc']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}


function get_percentage_discount_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT DISCOUNT REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((sum(discount)/sum(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((discount/fullpricing)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 

$result = makequery($query);
$discount_percs = $result->fetchAll();
foreach ($discount_percs as $discount_perc) {
    return $discount_perc['perc']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}

function get_percentage_net_sales_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT net_sales REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((sum(net_sales)/sum(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
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

echo "There is no result";
return null;
}

function get_percentage_shipping_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT SHIPPING REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((sum(shipping_paid)/sum(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND(((shipping_paid/fullpricing)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 



$result = makequery($query);
$ships_percs = $result->fetchAll();
foreach ($ships_percs as $ship_perc) {
    return $ship_perc['perc']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}

function get_percentage_profit_from_total($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT PROFIT REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND((((SUM(fullpricing - cogs - discount - shipping_paid))/SUM(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE date='".$date."'
";
}
else {
$query = "
SELECT ROUND((((fullpricing - cogs - discount - shipping_paid)/fullpricing)*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date='".$date."'
";
} 

$result = makequery($query);
$profits_percs = $result->fetchAll();
foreach ($profits_percs as $profit_perc) {
    return $profit_perc['perc']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}


function get_fullpricing_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" FULLPRICING FROM AN INTERVALL BETWEEN TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT sum(fullpricing) AS 'fullpricing' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(fullpricing) AS 'fullpricing' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$fullps = $result->fetchAll();
foreach ($fullps as $fullp) {
    return $fullp['fullpricing']; // It will return the first object
}

$result->closeCursor();

echo "There is no result";
return null;

}


function get_cogs_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" COGS FROM A PARTICULAR INTERVALL BETWEEN DATE AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT SUM(cogs) as 'total_cogs' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(fullpricing) AS 'total_cogs' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$cogs = $result->fetchAll();
foreach ($cogs as $cog) {
    return $cog['total_cogs']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}


function get_discount_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT sum(discount) as 'sum_discount' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(discount) as 'sum_discount' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$discounts = $result->fetchAll();
foreach ($discounts as $discount) {
    return $discount['sum_discount']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}

function get_net_sales_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" net_sales FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT sum(net_sales) as 'sum_net_sales' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(net_sales) as 'sum_net_sales' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$net_saless = $result->fetchAll();
foreach ($net_saless as $net_sales) {
    return $net_sales['sum_net_sales']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}

function get_shipping_paid_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//



if($countrycode == '') {
$query = "
SELECT sum(shipping_paid) AS 'sum_shipping' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT sum(shipping_paid) AS 'sum_shipping' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$shipping_paids = $result->fetchAll();
foreach ($shipping_paids as $shipping_paid) {
    return $shipping_paid['sum_shipping']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}

function get_profit_between_two_dates($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PROFIT FROM A PARTICULAR INTERVAL OF TWO DATES AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT SUM((fullpricing - cogs - discount - shipping_paid)) AS 'sum_profit' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT SUM((fullpricing - cogs - discount - shipping_paid)) AS 'sum_profit' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 

$result = makequery($query);
$profits = $result->fetchAll();
foreach ($profits as $profit) {
    return $profit['sum_profit']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}

function get_percentage_cogs_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT COGS REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//


if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(cogs)/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
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

echo "There is no result";
return null;
}


function get_percentage_discount_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT DISCOUNT REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(discount)/SUM(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND(((SUM(discount)/SUM(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$discount_percs = $result->fetchAll();
foreach ($discount_percs as $discount_perc) {
    return $discount_perc['perc']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}

function get_percentage_net_sales_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT net_sales REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(net_sales)/SUM(fullpricing))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
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

echo "There is no result";
return null;
}

function get_percentage_shipping_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT SHIPPING REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND(((SUM(shipping_paid)/SUM(net_sales))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
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

echo "There is no result";
return null;
}

function get_percentage_profit_between_two_dates_from_total($date1, $date2, $countrycode) {
// ************** THIS FONCTION RETURNS THE PERCENTAGE OF THE SALES THAT PROFIT REPRESENTS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

if($countrycode == '') {
$query = "
SELECT ROUND((((SUM(fullpricing - cogs - discount - shipping_paid))/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE date BETWEEN '".$date1."' and '".$date2."'
";
}
else {
$query = "
SELECT ROUND((((SUM(fullpricing - cogs - discount - shipping_paid))/SUM(fullpricing-discount))*100), 1) AS 'perc' FROM online_pl WHERE countrycode = '".$countrycode."' AND date BETWEEN '".$date1."' and '".$date2."'
";
} 


$result = makequery($query);
$profits_percs = $result->fetchAll();
foreach ($profits_percs as $profit_perc) {
    return $profit_perc['perc']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
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


function insert_datas_or_update_to_datawarehouse($date, $countrycode, $fullpricing, $discount, $cogs, $shipping_paid, $net_sales) {


	// ******* THIS FUNCTION MAKES THE POINT TO INSERT AND UPDATE VALUES IN THE ONLINE_PL TABLE
	// *************** HOW IT WORKS ??? **********//
	// ***** WE CALL IT WITH insert_datas_or_update('2017-01-01', 'ES', '300, '200', '500') **** /
	// ***** IF YOU WANT TO PUT SOME NULL STRING VALUES, YOU CAN CALL WITH insert_datas_or_update('2017-01-01', 'ES', '300, '200', null);
	// ***** THE ALGORITHM WILL CHECK IF THE DATAS EXISTS ***//
	// ** TWO CASES : - IF IT EXISTS, IT UPDATES AND CHECKS IF CERTAINS VALUS HAVE BEEN MODIFIES
	// ****           - IF IT DOESNT EXIST, IT CREATES IT

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
	net_sales
	)
	VALUES
	(
	'".$date."',
	'".$countrycode."',
	'".round($fullpricing)."',
	'".round($discount)."',
	'".round($cogs) ."',
	'".round($shipping_paid) ."',
	'".round(($fullpricing-$discount)). "'
	);
	
	";
	
} else { // exist


// If the user just wants to update a certain value, lets pick up the old ones
$which_things_to_update = "
SELECT fullpricing, discount, cogs FROM online_pl WHERE date = '".$date . "' AND countrycode = '".$countrycode . "'
"; 

$results_about_update = makequery($which_things_to_update);
$old_variables = $results_about_update->fetchAll();
$old_variable_fullprice = null;
$old_variable_discount = null;
$old_variable_cogs = null;
$old_variable_shipping_paid = null;
foreach ($old_variables as $old_variable) {
    $old_variable_fullprice = $old_variable['fullpricing'];
	$old_variable_cogs = $old_variable['cogs'];
	$old_variable_discount = $old_variable['discount'];
	$old_variable_shipping_paid = $old_variable['shipping_paid'];
}

// ** with that conditions, we are sure that we will only update certains values
if($fullpricing == null) $fullpricing = $old_variable_fullprice;
if($discount == null) $discount = $old_variable_discount;
if($cogs == null) $cogs = $old_variable_cogs;
if($shipping_paid == null) $shipping_paid = $old_variable_shipping_paid;
if($net_sales == null) $net_sales = ($fullpricing - $discount);
	
	$query_to_do = "
UPDATE online_pl
SET fullpricing = coalesce('".round($fullpricing)."',''),
    discount = coalesce('".round($discount)."',''),
    cogs = coalesce('".round($cogs)."',''),
	shipping_paid = coalesce('".round($shipping_paid)."',''),
	net_sales = coalesce('".round(($fullpricing-$discount))."',''


WHERE date = '".$date ."' AND countrycode = '".$countrycode."';	
	
	
	
	";
}

// If result is true -> we update		 
			 
// We have to execute the query

makequery($query_to_do);	 
	

}


//createtables();

?>