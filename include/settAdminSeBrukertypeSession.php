<?php
include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();

$_SESSION['adminSeBrukertype']  = $_GET['q'];
?>



       
    
