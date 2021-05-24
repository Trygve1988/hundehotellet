<?php
ob_start();
// ************************** 1) visInnloggetInfo **************************
function visInnloggetInfo($dblink) {
    if (isset($_SESSION['bruker'])) {
        echo "<h2> Min profil </h2>";
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        $sql = "SELECT * FROM bruker WHERE brukerID = '$brukerID';";
        $resultat = mysqli_query($dblink, $sql); 

        echo "<table>";
        echo "<tr>";
        echo    "<th>brukerID</th>";
        echo    "<th>epost</th>";
        echo    "<th>brukerType</th>";
        echo    "<th>fornavn</th>";
        echo    "<th>etternavn</th>";
        echo    "<th>tlf</th>";
        echo    "<th>adresse</th>";
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
            echo "</tr>";
        }
        echo "</table>" . "<br>";
    } 
}

// ************************** 2) visMineHunder **************************
function visMineHunder($dblink) {
    echo "<h2> Mine registrerte hunder </h2>";
    $bruker = $_SESSION['bruker'];
    $brukerID = $bruker->getBrukerID();
    $sql = "SELECT * FROM hund WHERE brukerID = '$brukerID';";
    $resultat = mysqli_query($dblink, $sql); 
    echo "<table>";
    echo "<tr>";
    echo    "<th>hundID</th>";
    echo    "<th>navn</th>";
    echo    "<th>rase</th>";
    echo    "<th>fdato</th>";
    echo    "<th>kjønn</th>";
    echo    "<th>sterilisert</th>";
    echo    "<th>løpeMAndre</th>";
    echo    "<th>info</th>";
    echo    "<th>brukerID</th>";
    echo    "<th>forID</th>";
    echo "</tr>";
    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['hundID'] . "</td>"; 
        echo "<td>" . $rad['navn'] . "</td>"; 
        echo "<td>" . $rad['rase'] . "</td>";
        echo "<td>" . $rad['fdato'] . "</td>";  
        echo "<td>" . $rad['kjønn'] . "</td>";
        echo "<td>" . $rad['sterilisert'] . "</td>";
        echo "<td>" . $rad['løpeMedAndre'] . "</td>";
        echo "<td>" . $rad['info'] . "</td>";
        echo "<td>" . $rad['brukerID'] . "</td>";
        echo "<td>" . $rad['forID'] . "</td>";
        echo "</tr>";
    }
    echo "</table>" . "<br>";;
}

// ************************** 3) visMineOpphold **************************
function visMineOpphold($dblink) {
    if (harOpphold($dblink)) {

        //1) lagOppholdOverskrifter($dblink)
        lagOppholdOverskrifter();

        //2) lagOppholdTab($dblink)
        $bestillingTab = lagOppholdTab($dblink);

        //3) visOppholdTab($dblink)
        visOppholdTab($bestillingTab);
    }
}

function lagOppholdTab($dblink) {
    // variabler
    $forigeBestillingID = "";
    $bestillingTab = null;
    $bestillingTabPos = 0;

    // sql
    $bruker = $_SESSION['bruker'];
    $brukerID = $bruker->getBrukerID();
    $sql = "SELECT B.*, O.*, H.* FROM bestilling AS B, opphold AS O, hund AS H
    WHERE H.brukerID = '$brukerID' 
    AND B.bestillingID = O.bestillingID 
    AND O.hundID = H.hundID 
    ORDER BY B.bestillingID ; ";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){

        // bestillingID
        $bestillingID = $rad['bestillingID'];
        // er dette en ny bestilling?
        if ($forigeBestillingID !== $bestillingID) {
            //ny bestilling: lager et FerdigBestilling objekt
            $b1 = new FerdigBestilling($bestillingID);
            $bestillingTab[$bestillingTabPos++] = $b1;
        }
        // resten
        $b1->setStartDato($rad['startDato']);
        $b1->setSluttDato($rad['sluttDato']);
        $b1->setBestiltDato($rad['bestiltDato']);
        $b1->setTotalPris($rad['totalPris']);
        $b1->setBurID($rad['burID']);
        $b1->addHund($rad['navn']);
        $forigeBestillingID = $bestillingID;
    }

    return $bestillingTab;
}

function lagOppholdOverskrifter() {
    echo "<h2> Mine Opphold </h2>";
    //overskrifter
    echo "<table>";
    echo "<tr>";
    echo    "<th>bestillingID</th>";    // bestilling
    echo    "<th>start</th>";           // bestilling
    echo    "<th>slutt</th>";           // bestilling
    echo    "<th>bestilt</th>";         // bestilling
    echo    "<th>totalPris</th>";       // bestilling
    echo    "<th>burID</th>";           // opphold
    echo    "<th>hunder</th>";            // hund
    echo "</tr>";
}

function visOppholdTab($bestillingTab) {
    if ($bestillingTab!==null) {
        //kjører gjennom $bestillingTab
        for ($i=0; $i<count($bestillingTab); $i++) {
            $b = $bestillingTab[$i];
            echo "<tr>";
            echo "<td>" . $b->getBestillingID() . "</td>";         
            echo "<td>" . $b->getStartDato() . "</td>";  
            echo "<td>" . $b->getSluttDato() . "</td>"; 
            echo "<td>" . $b->getBestiltDato() . "</td>"; 
            echo "<td>" . $b->getTotalPris() . "</td>"; 
            echo "<td>" . $b->getBurID() . "</td>"; 
            echo "<td>" . implode(", ",$b->getHundTab()) . "</td>"; 
            echo "</tr>";
        } 
        echo "</table>";
    } 
} 

function harHund($dblink) {
    $harHund = false;
    $bruker = $_SESSION['bruker'];
    $brukerID = $bruker->getBrukerID();
    $sql = "SELECT * FROM hund WHERE brukerID = '$brukerID'; ";
    $resultat = mysqli_query($dblink, $sql); 
    $antall = mysqli_num_rows($resultat);
    if ($antall > 0) {  
        $harHund = true;
    }
    return $harHund; 
}

function harOpphold($dblink) {
    $harOpphold = false;
    $bruker = $_SESSION['bruker'];
    $brukerID = $bruker->getBrukerID();
    $sql = "SELECT * FROM bruker AS B, hund AS H, opphold AS O WHERE B.brukerID = H.brukerID  
    AND H.hundID = O.hundID AND B.brukerID = '$brukerID';";  // 

    $resultat = mysqli_query($dblink, $sql); 
    $antall = mysqli_num_rows($resultat);
    if ($antall > 0) {  
        $harOpphold = true;
    }
    return $harOpphold; 
}

// ************************** 4) endreBrukerInfo **************************
function endreBrukerInfo($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bruker = $_SESSION['bruker'];
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

        opprettBrukerSession($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
        $tlf, $adresse, $fødselsNr, $stilling, $postNr);
        header("Refresh:0");
    }
}

// ************************** 5) endrePassord **************************
function endrePassord($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        $gammeltPassord = $_POST['gammeltPassord'];
        $nyttPassord = $_POST['nyttPassord'];
        $bekreftNyttPassord = $_POST['bekreftNyttPassord'];

        if ($nyttPassord == $bekreftNyttPassord) {

            //hasher nyttPassord
            $nyttPassord = password_hash($nyttPassord, PASSWORD_DEFAULT);

            //matcher gammeltPassord?
            $stmt = $dblink->prepare("SELECT passord FROM bruker WHERE (brukerID) = (?)");
            $bruker = $_SESSION['bruker'];
            $brukerID = $bruker->getBrukerID();
            $stmt->bind_param("s", $brukerID);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($hashPw);

            if ($stmt->num_rows == 1) {    
                $stmt->fetch();
                if (password_verify($gammeltPassord, $hashPw)) {
                    $sql = "UPDATE bruker SET passord = '$nyttPassord' WHERE brukerID = '$brukerID' ;" ;
                    $resultat = mysqli_query($dblink, $sql);
                    echo "endret passord" . "<br>";
                }
                else {
                    echo "gammeltPassord matcher ikke!" . "<br>";
                }
            }  
        }
        else {
            echo "de nye passordene matcher ikke!" . "<br>";
        }

    }
}

// ************************** 6) slettKonto **************************
function slettMinBruker($dblink) {
    if (isset($_POST['slettBrukerKnapp'])) {
        //sjekker at denne brukeren ikke har noen fremtidige eller aktive opphold
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        $sql = "SELECT B.* 
        FROM hund AS H, opphold AS O, bestilling AS B 
        WHERE H.hundID = O.hundID 
        AND O.bestillingID = B.bestillingID        
        AND B.sjekketUt IS NULL 
        AND H.brukerID = '$brukerID'; ";   
        $resultat = mysqli_query($dblink, $sql); 
        $antall = mysqli_num_rows($resultat);
        if ($antall > 0) {  
            echo "<br>"."<br>".'<i style="color:red; position:absolute";"> 
            Kan ikke slette Bruker! Du har fremtidige/aktive opphold! </i>'; 
        }
        else {
            //sletter bruker 
            $sql = "UPDATE bruker SET slettetDato = CURRENT_TIMESTAMP WHERE brukerID = '$brukerID' ;";
            $resultat = mysqli_query($dblink, $sql);
            header('Location: loggUt.php');
            echo "kontoen din er slettet ";
        }
    }
}

// ************************** registrerHund **************************
//denne funskjonen er allerede laget under bestill opphold

// ************************** 7) endre hund1  **************************
function laghunderTab($dblink) {
    //lager tabell med brukeren sine hundIDer
    $bruker = $_SESSION['bruker'];
    $brukerID = $bruker->getBrukerID();
    $sql = "SELECT * FROM hund WHERE brukerID = '$brukerID';";
    $resultat = mysqli_query($dblink, $sql); 

    $hundIDTab = array();
    $pos = 0;
    while($rad = mysqli_fetch_assoc($resultat)){
        $hundIDTab[$pos++] = $rad['navn']; 
    }
    return $hundIDTab;
}

function velgHundSomSkalEndres($dblink) {
    if (isset($_POST['velgHund'])) { 
        $navn = $_POST['hund']; 
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        $sql = "SELECT * FROM hund WHERE navn = '$navn' AND brukerID = '$brukerID' ;"; 
        $resultat = mysqli_query($dblink, $sql); 
        $rad = mysqli_fetch_assoc($resultat);
        $hundID = $rad['hundID'];
        setAktivHund($dblink,$hundID);
        header('Location: minSideTestEndreHund2.php');
    }
}

// ************************** 8) endre hund2 **************************
function endreHund($dblink) {
    if (isset($_POST['bekreftHundInfo'])) {  
        $hund = $_SESSION['aktivHund'];
        $hundID = $hund->getHundID();
        $navn = $_POST['navn'];
        $rase = $_POST['rase'];
        $fdato = $_POST['fdato'];
        $kjønn = $_POST['kjønn'];

        $sterilisert = $_POST['sterilisert'];
        $løpeMedAndre = $_POST['løpeMedAndre'];
        $info = $_POST['info'];
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        $forID = $_POST['forID'];

        $sql = "UPDATE hund SET navn = '$navn', rase = '$rase', 
        fdato = '$fdato', kjønn = '$kjønn', 
        sterilisert = '$sterilisert', løpeMedAndre = '$løpeMedAndre', info = '$info', 
        brukerID = '$brukerID', forID = '$forID' 
        WHERE hundID = $hundID;";
        $resultat = mysqli_query($dblink, $sql);
        echo "hund " . $hundID . " - ". $navn . " oppdatert" . "<br>";
        setAktivHund($dblink,$hundID);
        header("Refresh:0");
    }
}

// ************************** 9) slett hund **************************  
function slettHund($dblink) {
    if (isset($_POST['slettHund'])) {  
        $brukerID = $_SESSION['bruker']->getBrukerID();
        $hund = $_POST['hund'];

        echo "brukerID: " . $brukerID;
        echo "hund:     " . $hund;

        $sql = "DELETE FROM hund WHERE brukerID = '$brukerID' AND navn = $hund ;";
        $resultat = mysqli_query($dblink, $sql);
        //header("Refresh:0");
    }
}

// ************************** 10)  avbestill bestilling ************************** 
function lagIkkeBegyntBestillingTab($dblink) {
    $bruker = $_SESSION['bruker'];
    $brukerID = $bruker->getBrukerID();
    $bestillinger = array();
    $pos = 0;
    $sql = "SELECT DISTINCT B.* FROM bestilling AS B, opphold AS O, hund AS H
    WHERE B.bestillingID = O.bestillingID
    AND O.hundID = H.hundID
    AND H.brukerID = $brukerID ;" ;
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)) {
        $bestillingID = $rad['bestillingID'];
        $startDato = $rad['startDato'];
        $sluttDato = $rad['sluttDato'];
        $bestillinger[$pos++] = $bestillingID . ", fra " . $startDato . " til " . $sluttDato;
    }
    return $bestillinger;
}

function lagHundIDTab($dblink) {
    $bruker = $_SESSION['bruker'];
    $brukerID = $bruker->getBrukerID();
    $sql = "SELECT hundID FROM hund WHERE brukerID = '$brukerID' ;";
    $resultat = mysqli_query($dblink, $sql); 
    $hundIDTab = array();
    $pos = 0;
    while($rad = mysqli_fetch_assoc($resultat)) {
        $hundIDTab[$pos++] = $rad['hundID'];
    }
    return $hundIDTab;
}

function lagBestillingOption($bestilling) {
    ?> <option value= <?php echo $bestilling?> > <?php echo $bestilling?> </option><?php
}

function avbestill($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
        $bestillingID = $_POST['bestillinger'];

        //henter ut bestilling info
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        $startDato;
        $sluttDato;
        $bestiltDato;
        $totalPris;
        $sql = "SELECT * FROM bestilling WHERE bestillingID = '$bestillingID' ;";
        $resultat = mysqli_query($dblink, $sql); 
        while($rad = mysqli_fetch_assoc($resultat)) {
            $startDato = $rad['startDato'];
            $sluttDato = $rad['sluttDato'];
            $bestiltDato = $rad['bestiltDato'];
            $totalPris  = $rad['totalPris'];
        }

        //slett opphold
        $sql = "DELETE FROM opphold WHERE bestillingID = '$bestillingID' ;";
        $resultat = mysqli_query($dblink, $sql); 

        //slett bestilling
        $sql = "DELETE FROM bestilling WHERE bestillingID = '$bestillingID' ;";
        $resultat = mysqli_query($dblink, $sql); 

        echo "bestillingID " . $bestillingID . " avbestil. <br>";

        //setter inn en rad i slettetBestilling
        $sql = "INSERT INTO slettetBestilling (startDato, sluttDato, bestiltDato, totalPris, brukerID)
        VALUES ('$startDato','$sluttDato','$bestiltDato','$totalPris','$brukerID') ;";
        $resultat = mysqli_query($dblink, $sql); 
        header("Refresh:0");
    }
}

// ************************** 11) Skriv anmeldelse **************************
function lagreAnmeldelse($dblink) {
    if (isset($_POST['sendAnmeldelseKnapp'])) { 

        // brukerNavn
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();

        // brukerNavn
        $brukerFornavn = $bruker->getFornavn();
        $brukerEtternavn = $bruker->getEtternavn();
        $brukerNavn = $brukerFornavn . " " . $brukerEtternavn;

        // text (anmeldelse)
        $tekst = $_POST['anmeldelseKundeText']; 
        $tekst = "<p>".$tekst."</p>"."<p>"."- ".$brukerNavn."</p>";

        //lagre i db
        $sql = "INSERT INTO anmeldelse (tekst,dato,brukerID,godkjent) 
        VALUES ('$tekst',CURRENT_TIMESTAMP,'$brukerID',0);" ;
        mysqli_query($dblink,$sql);

        //melding
        echo "<br>".'<i style="color:green; position:absolute";"> Takk for din tilbakemelding </i>'; 
    }
}


ob_end_flush();