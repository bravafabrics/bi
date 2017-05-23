<?php 



/* --- CONNECTION ON THE MYSQL DATABASE */
$nameDB = array(
    "prestashop" => "test_prestashop",
    "datawarehouse" => "test_datawarehouse",
);

// Lets pick one of them

try {
$db = new PDO('mysql:host=localhost;dbname='.$nameDB['datawarehouse']. ';charset=utf8', 'root', 'root');
}

catch(Exception $e) {
	die('Special error :' . $e->getMessage());
} // and show if there is a particular problem.




$first_query = $db->query('SELECT * FROM cogs_ecommerce');

// Lets show the datas
$amount = 0;

while ($datas = $first_query->fetch())
{
	$amount+= $datas['cogs'];
}

echo "The total amount of the cogs are : " .$amount . " euros ";


?>