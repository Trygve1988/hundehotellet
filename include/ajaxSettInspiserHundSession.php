<?php
include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();

$_SESSION['inspiserHund']  = $_GET['q'];
?>



       
    
