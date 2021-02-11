<!-- Trygve -->
<?php
include_once "include/funksjoner.php";
session_start();
$dblink = kobleOpp();

session_destroy();
header('Location: loggInn.php');
?> 
 