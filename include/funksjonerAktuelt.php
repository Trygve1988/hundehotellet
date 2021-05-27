
<?php

/**
 *  Denne klassen inneholder funksjoner som brukes på aktuelt siden
 *  Det er funksjoner for å vise, lagre og slette innlegg
 *  @author    Trygve Johannessen
 */ 


// Funksjon for å hente ut og vise alle innlegg fra databasen
function visAlleInnlegg($dblink) {
    $sql = "SELECT * FROM innlegg 
    ORDER BY innleggID DESC ;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)) {
        echo $rad['tekst'];
    }
}

// Funksjon for å lagreInnlegg i databasen
function lagreInnlegg($dblink) {
    if (isset($_POST['lagreInnleggKnapp'])) { 
        $dato = new DateTime();
        $dato = $dato->format('Y-m-d');
        $navn = "aktuelt";
        $innleggOverskrift = $_POST['innleggOverskrift'];
        $innleggText = $_POST['innleggText'];
        $tekst = "<div class=\"mellomromMellomInnlegg\">"."<h3>".$innleggOverskrift."</h3>".  
        "<p>".$innleggText."</p>"."<p>".$dato."</p>"."</div>"."<hr>";
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        $sql = "INSERT INTO innlegg(navn,tekst,brukerID) VALUES ('$navn','$tekst','$brukerID') ;";
        mysqli_query($dblink, $sql);
    }
}

// Funksjon for å slette siste lagrede innlegg
function slettInnlegg($dblink) {
    if (isset($_POST['slettInnleggKnapp'])) { 
        $sql = "DELETE FROM innlegg
        ORDER BY innleggID DESC
        LIMIT 1 ;";
        $resultat = mysqli_query($dblink, $sql);
        header("Refresh:0");
    }  
}

?>