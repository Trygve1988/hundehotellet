<?php

/**
 *  Denne klassen setter sessionsvariabelen "inspiserHund"
 *  Sånn at ansatt-brukeren kan se informasjon om en hund på opphold
 *  Klassen kalles med Ajax av script.js. 
 *  @author    Trygve Johannessen
 */ 

include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();

$_SESSION['inspiserHund']  = $_GET['q'];
?>



       
    
