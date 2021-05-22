<?php
include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();

$valgteHunder = $_GET['q'];
$valgteHunderTab = explode (",", $valgteHunder);
$_SESSION['valgteHunder'] = $valgteHunderTab;
$_SESSION['valgteHunderPos'] = 0;
?>