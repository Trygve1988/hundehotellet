
<?php

/**
 *  Denne klassen inneholder funksjoner til registrerDeg siden
 *  @author Trygve Johannessen
 */ 

// ************************** 4) Registrer deg **************************
// Funksjon for registrere seg på nettsiden
function registrerDeg($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $epost = $_POST['epost'];
        $passord = $_POST['passord'];
        $passord = password_hash($passord, PASSWORD_DEFAULT);

        // velg brukertype (bare for testing) 
        $brukerType = "kunde";
        $fornavn = $_POST['fornavn'];
        $etternavn = $_POST['etternavn'];
        $tlf = $_POST['tlf'];
        $adresse = $_POST['adresse'];
        $postnummer = $_POST['postnummer'];
        $poststed = $_POST['poststed'];

        //sjekker at epost ikke finnes fra før
        $sql = "SELECT * FROM bruker WHERE epost = '$epost'";
        $resultat = mysqli_query($dblink, $sql);
        $antall = mysqli_num_rows($resultat);
        if ($antall > 0) { // epost finnes fra før!
            echo "<br>".'<i style="color:red; position:absolute";"> epost er allerede registrert! </i>'; 
        }

        //registrerer ny bruker
        else {
            $sql = "INSERT INTO bruker(epost,passord,brukerType,fornavn,etternavn,tlf,adresse,postnummer,poststed) 
            VALUES ('$epost','$passord','$brukerType','$fornavn','$etternavn','$tlf','$adresse','$postnummer','$poststed');";
            $resultat = mysqli_query($dblink, $sql);
            
            loggInn($dblink);
            echo "<br>".'<i style="color:green; position:absolute";"> Du er nå registrert! </i>'; 
        }
    }
}

?>