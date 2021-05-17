<?php
include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();

$anmeldelseStr = ""; 
$sql = "SELECT * FROM anmeldelse WHERE godkjent = 1;"; 
$resultat = mysqli_query($dblink,$sql);
while($rad = mysqli_fetch_assoc($resultat)) {
    $anmeldelseStr =  $anmeldelseStr.$rad['tekst'] . ",";
}

echo $anmeldelseStr;

?>






<?php/*
include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();

$anmeldelseTab = array();
$pos = 0;

$sql = "SELECT * FROM anmeldelse;"; 
$resultat = mysqli_query($dblink,$sql);
while($rad = mysqli_fetch_assoc($resultat)) {
    $anmeldelseTab[$pos] = $rad['tekst'];
    $pos++;
}

echo json_encode($anmeldelseTab);
*/
?>