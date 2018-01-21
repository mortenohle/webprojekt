<?php
include_once("db/connect.php"); 

$req1="select * from Bestellungen";

$req3 =mysql_query($req1);
while ($req2= mysq_fetch_array($req3)) {
	
	echo 'bestellnummer :'  .$req2 ['bestellnummer']. '<br>';
	echo 'produkt :'  .$req2 ['produkt']. '<br>';
	echo 'date :'  .$req2 ['date']. '<br>';
}
?>

