<?php
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=test_datawarehouse;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Error : '.$e->getMessage());
}


// This is working, pretty well
 
 
$getUsers = $bdd->prepare('SELECT * FROM online_pl WHERE date = "2017-01-01"');
$getUsers->execute();
$users = $getUsers->fetchAll();
foreach ($users as $user) {
    echo $user['countrycode'];
}

$getUsers->closeCursor();
 
?>