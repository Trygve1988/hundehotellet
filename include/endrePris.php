<?php
include_once "funksjoner.php";
session_start();
$dblink = mysqli_connect("itfag.usn.no", "h20APP2000gr5", "pw5", "h20APP2000grdb5");

$nyDagpris = $_GET['q'];
$beskrivelse = "dagPris";

// finner gammel pris og prisID
$sql = "SELECT * FROM pris WHERE beskrivelse = '$beskrivelse' ;";
$resultat = mysqli_query($dblink,$sql);
$rad = mysqli_fetch_assoc($resultat);
$gammelPris = $rad['beløp']; 
$prisID = $rad['prisID']; 

// endrer pris
$sql = "UPDATE pris SET beløp = '$nyDagpris' WHERE beskrivelse = '$beskrivelse';";  // 
$resultat = mysqli_query($dblink,$sql);

// finner ny pris
$sql = "SELECT * FROM pris WHERE beskrivelse = '$beskrivelse' ;";
$resultat = mysqli_query($dblink,$sql);
$rad = mysqli_fetch_assoc($resultat);
$nyPris = $rad['beløp']; 

// nullstiller prishistorikk
//$sql = "DELETE FROM prisHistorikk;";
//$resultat = mysqli_query($dblink, $sql); 

// lagrer prishistorikk
$idag = new DateTime();         //Date obj
$idag = $idag->format('Y-m-d'); //til string 

$brukerID = $_SESSION['brukerID'];
$sql = "INSERT INTO prisHistorikk (endretDato,nyttbeløp,gammeltbeløp,brukerID,prisID)
VALUES ('$idag','$nyPris','$gammelPris','$brukerID','$prisID');";
$resultat = mysqli_query($dblink, $sql); 

?>

