<?php

/**
 *  Denne klassen inneholder funksjoner til loggInn siden.
 *  Det er funksjoner som lar brukere logge på og lagrer brukerinfo i en sessionsvariabel
 *  @author    Trygve Johannessen
 */ 


// Funksjon for å logge inn på nettsiden
function loggInn($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $epost = $_POST['epost'];
        $passord = $_POST['passord'];
        //sjekker at bruker ikke er slettet
        $sql = "SELECT * FROM bruker WHERE epost = '$epost' AND slettetDato IS NOT NULL; ";   
        $resultat = mysqli_query($dblink, $sql); 
        $antall = mysqli_num_rows($resultat);
        if ($antall > 0) {  
            echo "<br>".'<i position:absolute";"> Vi har mottat din forespørsel 
            om å slette denne kontoen. Du kan kontakte oss på bohundehotell@outlook.com 
            viss du vil at vi skal gjennopprette kontoen din! </i>'; 
        }
        else {
            //bruker er ikke slettet
            $innloggingOk = false;
            $stmt = $dblink->prepare("SELECT brukerID,epost,passord,brukerType,fornavn,etternavn,tlf,adresse 
            FROM bruker WHERE (epost) = (?)");
            $stmt->bind_param("s", $_POST['epost']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($brukerID, $epost, $hashPw, $brukerType, $fornavn, $etternavn, $tlf, $adresse);

            if ($stmt->num_rows == 1) {
                $stmt->fetch();
                if (password_verify($passord, $hashPw))   {
                    $fødselsNr = "";
                    $stilling = "";
                    $postNr = 0;
                    opprettBrukerSession($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
                    $tlf, $adresse, $fødselsNr, $stilling, $postNr);

                    header('Location: minSide.php');
                    $innloggingOk = true;
                }
            }
            if($innloggingOk == false) {
                echo "<br>".'<i style="color:red; position:absolute";"> Du har skrivd inn feil epost og/eller passord! </i>'; 
            }
            $_SESSION['adminSeBrukertype'] = "kunde";
        }        
    }     
}

/**
 *  Når en bruker logger inn blir det laget et brukerObjekt som inneholder brukerens info
 *  @param int $hundID
 *  @param int $epost
 *  @param int $brukerType
 *  @param int $fornavn
 *  @param int $etternavn
 *  @param int $tlf
 *  @param int $adresse
 *  @param int $fødselsNr
 *  @param int $stilling
 *  @param int $postNr
**/
function opprettBrukerSession($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
$tlf, $adresse, $fødselsNr, $stilling, $postNr) {
    $bruker = new Bruker($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
    $tlf, $adresse, $fødselsNr, $stilling, $postNr);
    $_SESSION['bruker'] = $bruker;
}

?>