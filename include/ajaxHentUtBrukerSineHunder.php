<?php

/**
 *  Denne klassen henter ut alle hunder som tilhører den aktuelle brukeren.
 *  Klassen kalles med Ajax av scriptBestillOpphold.js. 
 *  @author    Trygve Johannessen
 */ 

include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();

$hundTab = array();
$pos = 0;
$bruker = $_SESSION['bruker']; 
$brukerID = $bruker->getBrukerID();

$sql = "SELECT * FROM hund WHERE brukerID = '$brukerID';"; 
$resultat = mysqli_query($dblink, $sql); 
while($rad = mysqli_fetch_assoc($resultat)) {
    $hundID = $rad['hundID'];
    $navn = $rad['navn'];
    $hundTab[$pos] = $hundID . " " . $navn;
    $pos++;
}
echo json_encode($hundTab);
?>