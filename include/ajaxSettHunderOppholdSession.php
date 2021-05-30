<?php

/**
 *  Denne klassen setter valgte hunder som skal ha opphold
 *  Klassen kalles med Ajax av scriptBestillOpphiold.js. 
 *  @author    Trygve Johannessen
 */ 

include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();

$valgteHunder = $_GET['q'];
$valgteHunderTab = explode (",", $valgteHunder);
$_SESSION['valgteHunder'] = $valgteHunderTab;
$_SESSION['valgteHunderPos'] = 0;
?>