<?php

/**
 *  Denne klassen inneholder funksjoner til PriserOgInfo
 *  @author Trygve Johannessen
 */ 


/** 
 *  Funksjon for å lage en tabell med alle prisene til å vise på "Priser og Info" siden
 *  @return String Array $prisTab  
 **/ 
function lagPrisTab($dblink) {
    $prisTab;
    $pos = 0;
    $sql = "SELECT * FROM pris;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        $prisTab[$pos++] = $rad['beløp'] . "kr";
    }
    return $prisTab;
}

?>