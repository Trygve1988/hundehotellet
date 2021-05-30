<?php

/**
 *  Denne klassen henter ut alle godkjente anmeldelser fra databsen.
 *  Klassen kalles med Ajax av script.js. 
 *  @author    Trygve Johannessen
 */ 

include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();

$anmeldelseStr = ""; 
$sql = "SELECT * FROM anmeldelse WHERE godkjent = 1;"; 
$resultat = mysqli_query($dblink,$sql);
while($rad = mysqli_fetch_assoc($resultat)) {
    $anmeldelseStr =  $anmeldelseStr.$rad['tekst'] . ",¤&%#";
}

echo $anmeldelseStr;

?>