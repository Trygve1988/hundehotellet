<?php
include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();


$opptattTab=array();
$opptattTab = getFullbookedeDatoer($dblink);
echo json_encode($opptattTab);


function getFullbookedeDatoer($dblink) { 
    //finner datoer som er vi er forbi eller er foolbooket
    $sql = "SELECT * FROM ledigeBurPrDag WHERE antallLedigeBur < 1 ;"; 
    $resultat = mysqli_query($dblink, $sql); 
    $opptattTab=array();
    while($rad = mysqli_fetch_assoc($resultat)) {
        $dato = $rad['dato']; 
        array_push($opptattTab,$dato); 
    }
    return $opptattTab;
}

?>