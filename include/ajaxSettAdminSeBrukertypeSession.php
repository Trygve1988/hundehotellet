<?php

/**
 *  Denne klassen setter valgt brukerType
 *  Sånn at admin-brukeren kan kan velge hvilken brukerGruppe han vil administrere
 *  Klassen kalles med Ajax av scriptAdmin.js. 
 *  @author    Trygve Johannessen
 */ 

include_once "funksjoner.php";
session_start();
$dblink = kobleOpp();

$_SESSION['adminSeBrukertype']  = $_GET['q'];
?>



       
    
