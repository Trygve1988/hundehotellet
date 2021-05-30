<?php
ob_start();

/**
 *  Denne klassen inneholder funksjoner til Minside og undersidene som hører til minSide
 *  Det er funksjoner som lar brukeren få en se,endre og slette brukerinfo, hunder og opphold 
 *  @author Trygve Johannessen og Gunn Inger Bleikalia
 */ 


/** 
 *  Funksjon for å vise brukerens brukerInfo til brukeren (Gunni)
 *  @author Gunn Inger Bleikalia
 **/ 
function minProfilTab($dblink) {
    // $brukerID
    $bruker = $_SESSION['bruker'];
    $brukerID = $bruker->getBrukerID();

    // SQL-spørring
    $sql = "SELECT * FROM bruker WHERE brukerID = '$brukerID' ;";

    //SQL-resultat -> Tabellrader
    $resultat = mysqli_query($dblink, $sql);
    
    while($rad = mysqli_fetch_assoc($resultat)) {
        echo "<table class=\"toKolTab  minSideToKolTab\">";	
            echo "<tr>";
                echo "<th class=\"thKolonne\">BrukerID</th>";
                echo "<td>". $rad['brukerID']. "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th class=\"thKolonne\">Navn</th>";
                echo "<td>". $rad['fornavn'] ." ". $rad['etternavn']. "</td>";
                echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Epost</th>";
                echo "<td>". $rad['epost'] . "</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Tlf</th>";
                echo "<td>". $rad['tlf'] . "</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Adresse</th>";
                echo "<td>". $rad['adresse'] . "</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Postnummer</th>";
                echo "<td>". $rad['postnummer'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th class=\"thKolonne\">Poststed</th>";
            echo "<td>". $rad['poststed'] . "</td>";
        echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">BrukerType</th>";
                echo "<td>". $rad['brukerType'] . "</td>";
            echo "</tr>";
        echo "</table>";
    } 
}

/** 
 *  Funksjon for å vise brukerens hunder til brukeren
 *  Oversetter fra database verdier som eks: 0,1 til JA/NEI
 *  @author Trygve Johannessen
 **/ 
function visMineHunder($dblink) {
    $bruker = $_SESSION['bruker'];
    $brukerID = $bruker->getBrukerID();
    $sql = "SELECT * FROM hund WHERE brukerID = '$brukerID';";
    $resultat = mysqli_query($dblink, $sql); 
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>HundID</th>";
    echo    "<th>Navn</th>";
    echo    "<th>Rase</th>";
    echo    "<th>Fdato</th>";
    echo    "<th>Kjønn</th>";
    echo    "<th>Steril</th>";
    echo    "<th>LøpeM<br>Andre</th>";
    echo    "<th>Info</th>";
    echo    "<th>For</th>";
    echo "</tr>";
    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['hundID'] . "</td>"; 
        echo "<td>" . $rad['navn'] . "</td>"; 
        echo "<td>" . $rad['rase'] . "</td>";
        echo "<td>" . $rad['fdato'] . "</td>";  

        //kjønn
        $kjønn;
        if ($rad['kjønn'] == "gutt") {
            $kjønn = "Hann"; 
        }
        else {
            $kjønn = "Tispe"; 
        }
        echo "<td>". $kjønn . "</td>";

        //sterilisert
        $sterilisert;
        if ($rad['sterilisert'] == 1) {
            $sterilisert = "Ja"; 
        }
        else {
            $sterilisert = "Nei"; 
        }
        echo "<td>". $sterilisert . "</td>";

        //løpeMedAndre
        $løpeMedAndre;
        if ($rad['løpeMedAndre'] == 1) {
            $løpeMedAndre = "Ja"; 
        }
        else {
            $løpeMedAndre = "Nei"; 
        }
        echo "<td>". $løpeMedAndre . "</td>";

        echo "<td>" . $rad['info'] . "</td>";

        //forID
        $forID;
        if ($rad['forID'] == 1) {
            $forID = "Vanlig"; 
        }
        else {
            $forID = "Allergi"; 
        }
        echo "<td>". $forID . "</td>";    
        echo "</tr>";
    }
    echo "</table>";
}

/** 
 *  Funksjon for å vise brukerens opphold til brukeren
 *  Kaller funksjonenene "harOpphold" for å sjekke om brukeren har opphold
 *  Så kalles "lagOppholdOverskrifter", "lagOppholdTab" og "visOppholdTab" for å vise oppholdene
 *  @author Trygve Johannessen
 **/ 
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

/**
 *  Funksjon for å lage Opphold-Overskrifter
 *  @author Trygve Johannessen
 */
function lagOppholdOverskrifter() {
    //overskrifter
    echo "<table class=\"blaaTab\">";
    echo "<tr>";
    echo    "<th>BestillingID</th>";    // bestilling
    echo    "<th>Start</th>";           // bestilling
    echo    "<th>Slutt</th>";           // bestilling
    echo    "<th>Bestilt</th>";         // bestilling
    echo    "<th>TotalPris</th>";       // bestilling
    echo    "<th>BurID</th>";           // opphold
    echo    "<th>Hunder</th>";          // hund
    echo "</tr>";
}

/** 
 *  Funksjon for å lage en tabell med "FerdigBestilling"-objekter
 *  Kaller funksjonenene "harOpphold" for å sjekke om brukeren har opphold
 *  @return String Array $bestillingTab
 *  @author Trygve Johannessen
 **/ 
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

/** 
 *  Funksjon for å vise alle brukeren sine opphold.
 *  @param String Array $bestillingTab
 *  @author Trygve Johannessen
 **/ 
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

/** 
 *  Funksjon for å sjekke om brukeren har minst 1 hund
 *  Kalles på minSide.php for å sjekke om hunder skal vises
 *  @return boolean $harHund
 *  @author Trygve Johannessen
 **/
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

// ************************** 2) minSideEndreBrukerInfo **************************
// Denne siden lar brukeren få en endre brukerinfo

/** 
 *  Funksjon for å endre brukerens info
 *  @author Trygve Johannessen
 **/
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

        oppdaterBrukerSession($brukerID, $epost, $brukerType, $fornavn, $etternavn, $tlf, $adresse);
        header("Refresh:0");
    }
}

/**
 *  oppdaterer brukerSession som tar vare på burkerens info
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
function oppdaterBrukerSession($brukerID, $epost, $brukerType, $fornavn, $etternavn, $tlf, $adresse) {
    $bruker = new Bruker($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
    $tlf, $adresse,null,null,null);
    $_SESSION['bruker'] = $bruker;
}

ob_end_flush();

// ************************** 3) minSideEndrePassord **************************
// Denne siden lar brukeren få en endre passord

/** 
 *  Funksjon for å endre brukerens passord
 *  @author Trygve Johannessen
 **/
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
                    echo "Gammelt passord matcher ikke!" . "<br>";
                }
            }  
        }
        else {
            echo "De nye passordene matcher ikke!" . "<br>";
        }

    }
}



// ************************** 4) minSideslettKonto **************************
// Denne siden lar brukeren slette kontoen sin

/** 
 *  Funksjon for å slette konto
 *  @author Trygve Johannessen
 **/
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



// ************************** 5) minSideRegistrerHund **************************
// Denne siden lar brukeren registrere en ny hund

/** 
 *  Funksjon for å registrere hund
 *  @author Trygve Johannessen
 **/
function minSideRegistrerHund($dblink) {
    if (isset($_POST['registrer'])) { 
        $navn = $_POST['navn'];
        $rase = $_POST['rase'];
        $fdato = $_POST['fdato'];
        if ( empty($fdato )) {
            $fdato = "2000-01-01";
        }
        $kjønn = $_POST['kjønn'];
        $sterilisert = $_POST['sterilisert'];
        $løpeMedAndre = $_POST['løpeMedAndre'];
        $info = $_POST['info'];
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        $forID = $_POST['forID'];

        $sql = "INSERT INTO hund(navn,rase,fdato,kjønn, sterilisert,løpeMedAndre,info,brukerID,forID)
        VALUES ('$navn','$rase','$fdato','$kjønn','$sterilisert','$løpeMedAndre','$info','$brukerID','$forID');";
        $resultat = mysqli_query($dblink, $sql);

        //får tak i hundID
        $hundID; 
        $sql = "SELECT MAX(hundID) FROM hund;"; 
        $resultat = mysqli_query($dblink, $sql); 
        while($rad = mysqli_fetch_assoc($resultat)) {
            $hundID = implode($rad);
        }

        echo "<br>".'<i style="color:green";> Hund registrert! </i>'; 
        header('Location: minSide.php');
    }
}


//Mine hunder tabell
function minHundTab($dblink) {
    //if (isset($_POST['minSideHund'])) {     
        // $brukerID
        $hundID = $_SESSION['minSideHund'];

        // SQL-spørring
        $sql = "SELECT * FROM hund WHERE hundID = '$hundID' ;"; 

        //SQL-resultat -> Tabellrader
        $resultat = mysqli_query($dblink, $sql);
        
        while($rad = mysqli_fetch_assoc($resultat)) {
            echo "<table class=\"toKolTab  minSideToKolTab\">";	
                echo "<tr>";
                echo "<th class=\"thKolonne\">Navn</th>";
                    echo "<td>". $rad['navn'] ."</td>";
                    echo "</tr>";
                echo "<tr>";
                    echo "<th class=\"thKolonne\">Rase</th>";
                    echo "<td>". $rad['rase'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<th class=\"thKolonne\">Fødselsdato</th>";
                    echo "<td>". $rad['fdato'] . "</td>";
                echo "</tr>";

               //kjønn
               $kjønn;
               if ($rad['kjønn'] == "gutt") {
                   $kjønn = "Hann"; 
               }
               else {
                   $kjønn = "Tispe"; 
               }
                echo "<tr>";
                    echo "<th class=\"thKolonne\">Kjønn</th>";
                    echo "<td>". $kjønn . "</td>";
                echo "</tr>";

                //sterilisert
                $sterilisert;
                if ($rad['sterilisert'] == 1) {
                    $sterilisert = "Ja"; 
                }
                else {
                    $sterilisert = "Nei"; 
                }
                echo "<tr>";
                    echo "<th class=\"thKolonne\">Sterilisert</th>";
                    echo "<td>". $sterilisert . "</td>";
                echo "</tr>";

                //løpeMedAndre
                $løpeMedAndre;
                if ($rad['løpeMedAndre'] == 1) {
                    $løpeMedAndre = "Ja"; 
                }
                else {
                    $løpeMedAndre = "Nei"; 
                }
                echo "<tr>";
                    echo "<th class=\"thKolonne\">Kan omgås andre hunder</th>";
                    echo "<td>". $løpeMedAndre . "</td>";
                echo "</tr>";

                //løpeMedAndre
                $forID;
                if ($rad['forID'] == 1) {
                    $forID = "Vanlig"; 
                }
                else {
                    $forID = "Allergi"; 
                }
                echo "<tr>";
                    echo "<th class=\"thKolonne\">Fòrtype</th>";
                    echo "<td>". $forID . "</td>";    
                echo "</tr>";

                echo "<tr>";
                    echo "<th class=\"thKolonne\">Ekstra informasjon</th>";
                    echo "<td>". $rad['info'] . "</td>";
                echo "</tr>";
            echo "</table>";
        } 
    //}
}

/** 
 *  Funksjon for å lage en option verdi til min side select boksen der brukeren kan velge en hund
 *  @author Trygve Johannessen
 **/
function lagMinSideOption($hund,$hundID) {
    if ($hundID == substr($hund,0,2)) {  
        ?> <option value= <?php echo $hund?> selected > <?php echo $hund ?> </option><?php
    }
    else {
        ?> <option value= <?php echo $hund?> > <?php echo $hund ?> </option><?php
    }
}

// ************************** 6) minSideEndreHund **************************
// Denne siden lar brukeren endre en hund

/** 
 *  Funksjon for å lag en tabell med brukerens hunder
 *  Brukes for å lage options i select bokser
 *  @return int Array $hundTab
 *  @author Trygve Johannessen
 */ 
function laghunderTab($dblink) {
    //lager tabell med brukeren sine hundIDer
    $bruker = $_SESSION['bruker'];
    $brukerID = $bruker->getBrukerID();
    $sql = "SELECT * FROM hund WHERE brukerID = '$brukerID';";
    $resultat = mysqli_query($dblink, $sql); 

    $hundTab = array();
    $pos = 0;
    while($rad = mysqli_fetch_assoc($resultat)){
        $hundTab[$pos++] = $rad['hundID']." ".$rad['navn']; 
    }
    return $hundTab;
}

/** 
 *  Funksjon for å velge en hund som skal endres
 *  @author Trygve Johannessen
 */ 
function velgHundSomSkalEndres($dblink) {
    if (isset($_POST['velgHund'])) { 
        $hundID = $_POST['hund']; 
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        setAktivHund($dblink,$hundID);
        header('Location: minSideEndreHund2.php');
    }
}

/** 
 *  Funksjon for å endre en hund
 *  @author Trygve Johannessen
 */ 
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
        $forID = $_POST['forID'];

        echo "info:  " . $info  . "<br>";
        echo "forID: " . $forID . "<br>";

        $sql = "UPDATE hund SET navn = '$navn', rase = '$rase', 
        fdato = '$fdato', kjønn = '$kjønn', sterilisert = '$sterilisert', løpeMedAndre = '$løpeMedAndre',
        info = '$info', forID = '$forID' WHERE hundID = $hundID;";
        $resultat = mysqli_query($dblink, $sql);
        echo "hund " . $hundID . " - ". $navn . " oppdatert" . "<br>";
        setAktivHund($dblink,$hundID);
        header('Location: minSide.php');
    }
}

// ************************** 7) minSideSlettHund **************************
// Denne siden lar brukeren slette en hund

/** 
 *  Funksjon for å slette en hund
 *  @author Trygve Johannessen
 */ 
function slettHund($dblink) {
    if (isset($_POST['slettHund'])) {  
        $brukerID = $_SESSION['bruker']->getBrukerID();
        $hund = $_POST['hund'];
        $hundID = substr($hund,0,2);
        $sql = "DELETE FROM hund WHERE hundID = '$hundID' ;";
        $resultat = mysqli_query($dblink, $sql);
        echo "<br><br>".'<i style="color:green; position:absolute";"> Hund slettet </i>';
        header("Refresh:0");
    }
}



// ************************** 8) minSideAvbestill **************************
// Denne siden lar brukeren avbestille et opphold

/** 
 *  Funksjon for å lage en tabell med brukerens ikke-begynte bestillinger
 *  @return String Array $bestillinger
 *  @author Trygve Johannessen
 */ 
function lagIkkeBegyntBestillingTab($dblink) {
    //Avbestilling Frist
    $date = new DateTime();
    $date->modify('-1 day');
    $date = $date->format('Y-m-d');

    $bruker = $_SESSION['bruker'];
    $brukerID = $bruker->getBrukerID();
    $bestillinger = array();
    $pos = 0;
    $sql = "SELECT DISTINCT B.* FROM bestilling AS B, opphold AS O, hund AS H
    WHERE B.bestillingID = O.bestillingID
    AND O.hundID = H.hundID
    AND H.brukerID = $brukerID 
    AND B.sjekketInn IS NULL ;" ;
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)) {
        $bestillingID = $rad['bestillingID'];
        $startDato = $rad['startDato'];
        $sluttDato = $rad['sluttDato'];
        $bestillinger[$pos++] = $bestillingID . ", fra " . $startDato . " til " . $sluttDato;
    }
    return $bestillinger;
}

/** 
 *  Funksjon for å lage en option til avbestill opphold select boksen i minsSideAvbestill.php
 *  @param String Array $bestillinger
 *  @author Trygve Johannessen
 */ 
function lagBestillingOption($bestilling) {
    ?> <option value= <?php echo $bestilling?> > <?php echo $bestilling?> </option><?php
}

/** 
 *  Funksjon for å avbestille et opphold. 
 *  Sletter alle rader i databasen fra bestilling og opphold som matcher valgt bestillingID
 *  @author Trygve Johannessen
 */ 
function avbestill($dblink) {
    if (isset($_POST['Avbestill']) && isset($_POST['bestillinger'])) { 
        $bestillingID = $_POST['bestillinger'];

        if ($bestillingID !== null) { 
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

            // oppdater LedigeBur
            oppdaterLedigeBur($dblink,$startDato,$sluttDato);

            header("Refresh:0");
        }
    }
}

/** 
 *  Funksjonen for oppdaterer "ledigeBurPrDag"-tabellen i databasen etter at et opphold er avbestilt
 *  @author Trygve Johannessen
 */ 
function oppdaterLedigeBur($dblink,$startDato,$sluttDato) {  
    $dato = $startDato;
    while ($dato < $sluttDato) {
        $sql = "UPDATE ledigeBurPrDag SET antallLedigeBur = antallLedigeBur+1 WHERE dato = '$dato';";
        $resultat = mysqli_query($dblink, $sql); 
        $dato = new DateTime($dato);    // til Date obj
        $dato->modify('+1 day');
        $dato = $dato->format('Y-m-d'); // til string igjen
    }
}

// ************************** 9) minSideSkrivAnmeldelse **************************
// Denne siden lar brukeren skrive en anmeldelse

/** 
 *  Funksjon for å lagre en Anmeldelse
 *  @author Trygve Johannessen
 */ 
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
