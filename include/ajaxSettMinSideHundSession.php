<?php

/**
 *  Denne klassen setter sessionsvariabelen "minSideHund"
 *  Sånn at brukeren kan se informasjon den valgte hunden sin
 *  Klassen kalles med Ajax av script.js. 
 *  @author    Trygve Johannessen
 */ 

include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();

$_SESSION['minSideHund']  = $_GET['q'];
?>



       
    
