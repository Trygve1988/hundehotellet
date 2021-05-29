<?php
ob_start();

/**
 *  Denne klassen inneholder funksjoner til admin.php siden og undersidene som hører til den
 *  Det er funksjoner som lar admin-brukeren få en se,endre og slette brukerkontoer
 *  @author    Trygve Johannessen
 */ 


/** 
 *  Funksjon for å vise alle brukere som valgt brukerType
 *  Når brukeren velger brukertype i select boksen på admin siden blir kjøres et
 *  ajax kall til databasen som setter sessionsvariabelen "adminSeBrukertype"n
 **/ 
function visAlleBrukere($dblink)  {     
    $brukertype = $_SESSION['adminSeBrukertype'];
    $sql = "SELECT * FROM bruker WHERE brukertype = '$brukertype' ;";
    $resultat = mysqli_query($dblink, $sql); 
    
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>ID</th>";
    echo    "<th>Epost</th>";
    echo    "<th>BrukerType</th>";
    echo    "<th>Fornavn</th>";
    echo    "<th>Etternavn</th>";
    echo    "<th>Tlf</th>";
    echo    "<th>Adresse</th>";
    echo    "<th>PostNr</th>";
    echo "</tr>";

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>"; 
        echo "<td>" . $rad['brukerID'] . "</td>"; 
        echo "<td>" . $rad['epost'] . "</td>"; 
        echo "<td>" . $rad['brukerType'] . "</td>"; 
        echo "<td>" . $rad['fornavn'] . "</td>"; 
        echo "<td>" . $rad['etternavn'] . "</td>"; 
        echo "<td>" . $rad['tlf'] . "</td>"; 
        echo "<td>" . $rad['adresse'] . "</td>"; 
        echo "<td>" . $rad['postnummer'] . "</td>"; 
        echo "</tr>";
    }
    echo "</table>" . "<br>";
} 



// ************************** 2) adminNyBruker **************************
// Denne siden lar admin-brukeren opprette en ny brukerkonto

//Funksjon for å registrer en ny bruker
function registrerNyBruker($dblink) {
    if (isset($_POST['registrerNyBrukerKnapp'])) {   
        $epost = $_POST['epost'];
        $passord = $_POST['passord'];
        $passord = password_hash($passord, PASSWORD_DEFAULT);
        $brukerType = $_POST['brukertype'];
        $fornavn = $_POST['fornavn'];
        $etternavn = $_POST['etternavn'];
        $tlf = $_POST['tlf'];
        $adresse = $_POST['adresse'];

        //sjekker at epost ikke finnes fra før
        $sql = "SELECT * FROM bruker WHERE epost = '$epost'";
        $resultat = mysqli_query($dblink, $sql);
        $antall = mysqli_num_rows($resultat);
        if ($antall > 0) { // epost finnes fra før!
            echo "<br>".'<i style="color:red; position:absolute";"> epost er allerede registrert! </i>'; 
        }

        //registrerer ny bruker
        else {
            $sql = "INSERT INTO bruker(epost,passord,brukerType,fornavn,etternavn,tlf,adresse) 
                    VALUES ('$epost','$passord','$brukerType','$fornavn','$etternavn','$tlf','$adresse');";
            $resultat = mysqli_query($dblink, $sql);
            echo "<br>".'<i style="color:green; position:absolute";"> Ny Bruker Registrert </i>'; 
            header('Location: admin.php');
        }
    }
}



// ************************** 3) adminendreBruker **************************
// Denne siden lar admin-brukeren endre en brukerkonto

/** 
 *  Funksjon for å lage en tabell med brukere som String objekter
 *  Brukes får lage valg som admin-brukeren kan trykke på i select bokser for å velge en bruker
 *  @return $brukereTab;
 **/ 
function lagBrukereTab($dblink) {
    $brukereTab = array();
    $pos = 0;

    $brukertype = $_SESSION['adminSeBrukertype'];
    $sql = "SELECT * FROM bruker WHERE brukertype = '$brukertype' ;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        $brukereTab[$pos++] = $rad['brukerID']." ".$rad['epost']." - ".$rad['fornavn']." ".$rad['etternavn']; 
    }
    return $brukereTab;
}

/** 
 *  Funksjon for velge en bruker i en select boks
 *  Den valgte brukeren lagres som et bruker-objekt i sessionsvariabelen "endreBruker"
 **/ 
function velgEndreBruker($dblink) {
    if (isset($_POST['velgEndreBrukerKnapp'])) { 
        $brukerID = $_POST['velgEndreBrukerSelect'];
        $sql = "SELECT * FROM bruker WHERE brukerID = '$brukerID' ;";
        $resultat = mysqli_query($dblink, $sql);
        while($rad = mysqli_fetch_assoc($resultat)) {
            $brukerID       = $rad['brukerID'];
            $epost          = $rad['epost'];
            $brukerType     = $rad['brukerType'];
            $fornavn        = $rad['fornavn'];
            $etternavn      = $rad['etternavn'];
            $tlf            = $rad['tlf'];
            $adresse        = $rad['adresse'];
            $fødselsNr      = $rad['fødselsNr'];
            $stilling       = $rad['stilling'];
            $postNr         = $rad['postNr'];
        }
        $b = new Bruker($brukerID,$epost,$brukerType,$fornavn,$etternavn,$tlf, $adresse, $fødselsNr, $stilling, $postNr);
        $_SESSION['endreBruker'] = $b;
        header('Location: adminEndreBruker2.php');
    } 
}

// Funksjon for å endre en bruker i databasen
function adminEndreBrukerInfo($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bruker = $_SESSION['endreBruker'];
        $brukerID = $bruker->getBrukerID();
        $epost = $_POST['epost'];
        $brukerType = $bruker->getBrukerType();
        $fornavn = $_POST['fornavn'];
        $etternavn = $_POST['etternavn'];
        $tlf = $_POST['tlf'];
        $adresse = $_POST['adresse'];

        $sql = "UPDATE bruker SET epost = '$epost',fornavn = '$fornavn', etternavn = '$etternavn',
        tlf = '$tlf', adresse = '$adresse' WHERE brukerID = '$brukerID' ;";
        $resultat = mysqli_query($dblink, $sql);

        $b = new Bruker($brukerID,$epost,$brukerType,$fornavn,$etternavn,$tlf, $adresse, $fødselsNr, $stilling, $postNr);
        $_SESSION['endreBruker'] = $b;
        header('Location: admin.php');
    }
}



// ************************** 4) adminSlettBruker **************************
// Denne siden lar admin-brukeren slette en brukerkonto

// Funksjon for å slette en bruker fra databasen  
function slettBruker($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $brukerID = $_POST['velgSlettBrukerSelect'];
        $sql = "DELETE FROM bruker WHERE brukerID = '$brukerID' ;";
        $resultat = mysqli_query($dblink, $sql);

        //ble brukeren slettet?
        $sql = "SELECT * FROM bruker WHERE brukerID = '$brukerID' ;";
        $resultat = mysqli_query($dblink, $sql);
        $antall = mysqli_num_rows($resultat);
        if ($antall !== 0) {  
            echo "<br>".'<i style="color:red; position:absolute";"> Kunne ikke slette bruker! </i>'; 
        }
        else {
            header("Refresh:0");
            echo "<br>".'<i style="color:green; position:absolute";"> Bruker slettet </i>'; 
        }
    }
}



// ************************** 5) adminGjennoprettBruker **************************
// Brukere kan slette kontoen sin. Viss brukeren angrer innen 30 dager kan han be 
// hundehotellet om å gjenopprette kontoen.
// Denne siden lar admin-brukeren gjennoprette en konto.

/** 
 * Funksjon for å lage en tabell med slettede brukere som string objekter  
 * @return String Array $brukereTab;
**/
function lagSlettedeBrukereTab($dblink) {
    $brukereTab = array();
    $pos = 0;
    $brukertype = $_SESSION['adminSeBrukertype'];
    $sql = "SELECT * FROM bruker WHERE brukertype = '$brukertype' AND slettetDato IS NOT NULL ;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        $brukereTab[$pos++] = $rad['brukerID']." ".$rad['epost']." - ".$rad['fornavn']." ".$rad['etternavn']; 
    }
    return $brukereTab;
}


/** 
 * Funksjon for å gjennoprett en bruker i databasen
 * Setter kolonen slettetDato i brukeren til null
**/
function gjennoprettBruker($dblink) {
    if (isset($_POST['velgGjennoprettBrukerKnapp'])) { 
        $brukerID = $_POST['velgGjennoprettBrukerSelect'];
        $sql = "UPDATE bruker SET slettetDato = null WHERE brukerID = '$brukerID' ;";
        $resultat = mysqli_query($dblink, $sql);
        echo "kontoen er gjennoprettet ";
        header("Refresh:0");
    }
}

ob_end_flush();