<?php 

// ****************************************** 
// ****************************************** 
// *******************************
// ********************** THAT FILE CREATES TABLE AND CONTAINS EVERY QUERIES TO DEAL WITH DATAS FOR DATABASEWHEREHOUSE  ******** //
// *********
// ***



function makequery($query){


include("keychain.php"); // contains the passwords we need

try {
$db_conn = new PDO('mysql:host='.$host.';dbname='.$dbname['datawarehouse'] . ';charset=utf8', $db_user, $db_pass);
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
CREATE TABLE ONLINE_PL(
date DATE,
countrycode VARCHAR(2),
fullpricing FLOAT,
discount FLOAT,
cogs FLOAT, 
shipping_paid FLOAT,
PRIMARY KEY (date, countrycode)

);

";	

makequery($query);

echo "The table has correctly been created";
}

function get_fullpricing($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" FULLPRICING FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//
$query = "
SELECT fullpricing FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";

$result = makequery($query);
$fullps = $result->fetchAll();
foreach ($fullps as $fullp) {
    return $fullp['fullpricing']; // It will return the first object
}

$result->closeCursor();

echo "There is no result";
return null;

}

function get_cogs($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" COGS FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

$query = "
SELECT cogs FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";

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

$query = "
SELECT discount FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";

$result = makequery($query);
$discounts = $result->fetchAll();
foreach ($discounts as $discount) {
    return $discount['discount']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}

function get_shipping_paid($date, $countrycode) {
// ************** THIS FONCTION RETURNS THE "FIRST" DISCOUNT FROM A PARTICULAR DATE AND COUNTRYCODE *******************//
// *****************   ************//

$query = "
SELECT shipping_paid FROM online_pl WHERE date = '".$date."' AND countrycode = '".$countrycode."'
";

$result = makequery($query);
$shipping_paids = $result->fetchAll();
foreach ($shipping_paids as $shipping_paid) {
    return $shipping_paid['shipping_paid']; // It will return the first object
}


$result->closeCursor();

echo "There is no result";
return null;
}


function insert_datas_or_update($date, $countrycode, $fullpricing, $discount, $cogs, $shipping_paid) {


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
	shipping_paid
	)
	VALUES
	(
	'".$date."',
	'".$countrycode."',
	'".$fullpricing."',
	'".$discount."',
	'".$cogs ."',
	'".$shipping_paid ."'
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
	
	$query_to_do = "
UPDATE online_pl
SET fullpricing = coalesce('".$fullpricing."',''),
    discount = coalesce('".$discount."',''),
    cogs = coalesce('".$cogs."',''),
	shipping_paid = coalesce('".$shipping_paid."','')


WHERE date = '".$date ."' AND countrycode = '".$countrycode."';	
	
	
	
	";
}

// If result is true -> we update		 
			 
// We have to execute the query

makequery($query_to_do);	 
	

}


?>