<?php
ob_start();

/**
 *  Denne klassen inneholder funksjoner til bestillOpphold siden.
 *  Det er funksjoner som lar brukeren registrere nye hunder og 
 *  velge hunder som skal være med i bestillingen
 *  @author    Trygve Johannessen
 */ 


//  Funksjon for å registrer en Hund. Sender brukeren tilbake til bestillOpphold
function registrerHundBestillOpphold($dblink) {
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

        echo "<br>".'<i style="color:green";> Hund registrert! </i>'; 
        header('Location: bestillOpphold.php');
    }
}



// ********************* 6) Bestill Opphold 2  oppdater Hunder  ********************* 
// Denne siden lar brukeren kontrollere at informasjonen om hundene som skal være med på opphold er oppdatert



/** 
 *  Funksjon som kjører gjennom alle hundene som skal være med på oppholdet.
 *  Hundnene settes en etter en som aktiv hund mens den blir oppdatert.
 *  Når alle hunder er oppdatert så sendes brukeren viderer til bestillOpphold3
 **/  
function oppdaterHunder($dblink) {
    //kjører gjennom alle valgte hunder
    $valgteHunder = $_SESSION['valgteHunder'];
    $pos = $_SESSION['valgteHunderPos'];

    //er det flere hunder som må kontorlleres/oppdateres?
    if ($pos < count($valgteHunder)) {
        $hundID = $valgteHunder[$pos];
        setAktivHund($dblink,$hundID);
    
        $pos++;
        $_SESSION['valgteHunderPos'] = $pos;
    }
    else {
        header('Location: bestillOpphold3.php'); 
    }
}

/** 
 *  Funksjon som kalles når brukeren godkjenner at en hund er "up to date"
 *  Funksjonen oppdaterer hundens info
 **/  
function bekreftHundInfo($dblink) {
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

        echo $navn . " oppdatert";
    }
}



// ************************** 6) Bestill Opphold 3 - velg Datoer ************************** 
// Denne siden lar brukeren velge startDato og sluttDato for oppholdet


/** 
 *  Funksjonen for å bekrefte startDato og sluttDato som brukeren har valgt
 *  Denne funksjonen kaller på funksjonen "totalpris" for å regne ut oppholdets totalpris
 *  startDato, sluttDato og totalpris lagres i en sesjonsvariabelen "bestillingSession"
 *  Sender til slutt brukeren til bestillOpphold4
 **/  
function bekreftDatoer($dblink) {
    if (isset($_POST['bekreftDatoer'])) { 
        $startDato = $_POST['startDato']; 
        $sluttDato = $_POST['sluttDato'];
        if ($startDato >= $sluttDato) {
            echo "<br>".'<i style="color:red";> StartDato må være før sluttDato! </i>'; 
        }
        else {
            $totalPris = totalPris($dblink,$startDato,$sluttDato);
            opprettBestillingSession($startDato, $sluttDato, $totalPris);
            header('Location: bestillOpphold4.php');
        }
    }
}

/**
 *  Funksjonen for å lagre startDato, sluttDato og totalpris i sesjonsvariabelen "bestillingSession"
 * 
 *  @param String $startDato
 *  @param String $sluttDato
 *  @param double $totalPris
 */ 
function opprettBestillingSession($startDato, $sluttDato, $totalPris) { 
    $bestilling = new Bestilling($startDato, $sluttDato, $totalPris);
    $_SESSION['bestilling'] =  $bestilling;
}

/**
 *  Funksjonen for å for å regne ut oppholdets totalpris
 * 
 *  @param String $startDato
 *  @param String $sluttDato
 *  @return double totalPris       
 */ 
function totalPris($dblink,$startDato,$sluttDato) {
    //finner antall hunder
    $valgteHunder = $_SESSION['valgteHunder'];
    $antHunder = count($valgteHunder);

    //finner dagPrisen   1Hund
    if ($antHunder > 3) { //maks rabatten er 3 hunder
        $antHunder = 3;
    }
    $beskrivelse =  $antHunder."HundPrDøgn";
    $sql = "SELECT beløp FROM pris WHERE beskrivelse = '$beskrivelse' ;"; 
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)) {
        $dagPris = implode($rad);
    }
    //finner antall dager
    $datetime1 = new DateTime($startDato);
    $datetime2 = new DateTime($sluttDato);
    $antDager = $datetime1->diff($datetime2);
    $antDager = $antDager->format('%a');
    //finner totalPris
    $antHunder = count($valgteHunder);
    return $dagPris * $antDager;
}


/** 
 *  Funksjonen for å finne dato i morgen 
 *  Brukes i bestill opphold4 for å sette default dato på tilDato
 **/  
function datoIMorgen() {
    $date = new DateTime();
    $date->modify('+1 day');
    echo $date->format('Y-m-d');
}



// ************************** 6) Bestill Opphold 4 - betalingsinfo **************************
// Denne siden lar brukeren registrer betalingsinfo

/** 
 *  Funksjonen for lagre bestilling. Setter inn en ny rad i bestilling 
 *  og en ny rad inn i opphold pr valgte hund
 *  Kaller på funksjonene "finnLedigBur", "harNoenAvHundeneAlleredeOpphold" og "oppdaterLedigeBur"
 *  Til slutt sendes brukeren til "bestillingBekreftelse"
 **/  
function bestilling($dblink) {
    if (isset($_POST['bestill'])) { 
        $bestilling = $_SESSION['bestilling'];
        $startDato = $bestilling->getStartDato();
        $sluttDato = $bestilling->getSluttDato();
        $totalPris = $bestilling->getTotalPris();
        $bestiltDato = new DateTime();
        $bestiltDato = $bestiltDato->format('Y-m-d'); //til string

        //først må vi sjekke at vi har ledig bur disse datoene
        $burID = finnLedigBur($dblink,$startDato,$sluttDato);
        if ($burID<1) {
            echo "<br>".'<i style="color:red";> Beklager! Vi har ingen ledige bur disse datoene! </i>'; 
        }

        //så må vi skjekke at ingen av disse hundene allerede har opphold i denne tidsperioden
        else if (harNoenAvHundeneAlleredeOpphold($dblink)) {
            echo "<br>".'<i style="color:red";> Hund(ene) har allerede opphold i dette tidsrommet! </i>'; 
        }

        else {
            // setter en ny rad inn i bestilling
            $sql = "INSERT INTO bestilling(startDato,sluttDato,bestiltDato,totalPris)
            VALUES ('$startDato','$sluttDato','$bestiltDato','$totalPris');";
            $resultat = mysqli_query($dblink, $sql);   

            // får tak i bestillingID
            $sql = "SELECT MAX(bestillingID) FROM bestilling;";
            $resultat = mysqli_query($dblink, $sql);
            $bestillingID = 1;
            while($rad = mysqli_fetch_assoc($resultat)) {
                $bestillingID = implode($rad);
            }
            echo "bestillingID: " . $bestillingID . "<br>";

            // setter ny rad(er) inn i opphold
            $valgteHunder = $_SESSION['valgteHunder'];
            for ($i=0; $i<count($valgteHunder); $i++) {
                $hundID = $valgteHunder[$i];
                $sql = "INSERT INTO opphold(hundID,burID,bestillingID)
                VALUES ('$hundID','$burID','$bestillingID');";
                $resultat = mysqli_query($dblink, $sql); 
            }
            
            // tilbakemelding
            echo "bestilling til hund " . $hundID. " registrert (bur:" . $burID .") <br>";

            // oppdater LedigeBur
            oppdaterLedigeBur($dblink,$startDato,$sluttDato);

            header('Location: bestillingBekreftelse.php');
        }
    }
}


/** 
 *  Funksjonen for sjekke om noen av hundene allerede har opphold 
 *  på minst en av dagene i det valgte tidsrommet
 *  Kjører gjennom alle hundene og kaller "harHundenAlleredeOpphold" for å sjekke hver hund.
 *  @return boolean $alleredeOpphold  
 **/  
function harNoenAvHundeneAlleredeOpphold($dblink) { 
    $alleredeOpphold = false;
    // valgteHunder
    $valgteHunder = $_SESSION['valgteHunder'];
    for ($i=0; $i<count($valgteHunder); $i++) {
        $hundID = $valgteHunder[$i];
        if ( harHundenAlleredeOpphold($dblink,$hundID)) {
            $alleredeOpphold = true;
        }
    }
    return $alleredeOpphold;
}

/** 
 *  Funksjonen for sjekke denne hunden allerede har opphold på minst en av dagene i det valgte tidsrommet
 *  @param int $hundID  
 *  @return boolean $alleredeOpphold  
 **/  
function harHundenAlleredeOpphold($dblink,$hundID) { 
    $alleredeOpphold = false;

    // startDato og sluttDato
    $bestilling = $_SESSION['bestilling'];
    $startDato = $bestilling->getStartDato();
    $sluttDato = $bestilling->getSluttDato();

    $sql = "SELECT B.* FROM opphold AS O, bestilling AS B 
    WHERE O.bestillingID = B.bestillingID 
    AND B.startDato <= '$startDato' 
    AND B.sluttDato >= '$sluttDato' 
    AND O.hundID >= '$hundID';" ;
    $resultat = mysqli_query($dblink, $sql); 
    $antall = mysqli_num_rows($resultat);
    if ($antall > 0) { 
        echo "hundID " . $hundID . " har allerede opphold i dette tidsrommet!" . "<br>"; 
        $alleredeOpphold = true;
    }
    return $alleredeOpphold; 
}

/** 
 *  Funksjonen for å finne et bur som er ledig alle dagene i det aktuelle tidsrommet.  
 *  Untatt den siste dagen for da må man sjekke ut før kl 12.
 *  Kjører gjennom hvert bur og kaller "erBurLedigAlleDatoene" for å sjekke om dette buret er ledig.
 *  @param String $startDato
 *  @param String $sluttDato
 *  @return int $burID  
 **/  
function finnLedigBur($dblink,$startDato,$sluttDato) { 
    // får tak i antall bur
    $sql = "SELECT COUNT(*) FROM bur;"; 
    $resultat = mysqli_query($dblink, $sql); 
    $antallbur = 0;
    while($rad = mysqli_fetch_assoc($resultat)) {
        $antallbur = implode($rad);
    }
    // går gjennom alle burene 
    $funnetBur = false;
    $burID = 1;
    while ($funnetBur == false && $burID<=$antallbur) {
        if ( erBurLedigAlleDatoene($dblink,$startDato,$sluttDato,$burID) ) {
            $funnetBur = true;
        }
        else {
            $burID++; 
        }
    }
    // sender tilbake resultatet
    if ($funnetBur == true) {
        return $burID;
    }
    else {
        return -1;
    }
}

/** 
 *  Funksjonen for å finne om dette buret er ledig alle dagene i det aktuelle tidsrommet. 
 *  Kjører gjennom hver dato og kaller "erBurLedigDenneDatoen" for å sjekke om buret er ledig den datoen
 *  @param String $startDato
 *  @param String $sluttDato
 *  @param int $burID
 *  @return $burLedigAlleDatoene;
 **/  
function erBurLedigAlleDatoene($dblink,$startDato,$sluttDato,$burID) {
    $burLedigAlleDatoene = true;

    //hvor mange dager skal vi sjekke?
    $startDato = new DateTime($startDato);
    $sluttDato = new DateTime($sluttDato);
    $antDager = date_diff($startDato, $sluttDato);
    $antDager = $antDager->format('%a');

    //går gjennom alle datoene
    $sjekkDato = $startDato;
    $i=0;
    while ($i < $antDager && $burLedigAlleDatoene == true) {
        $strDato = $sjekkDato->format('Y-m-d');
        //echo $strDato . "<br>"; 
        if (erBurLedigDenneDatoen($dblink,$strDato,$burID) == false ) {
            $burLedigAlleDatoene = false;
        }
        $sjekkDato->modify('+1 day'); //øker dag med 1 
        $i++;
    }
    return $burLedigAlleDatoene;
}

/** 
 *  Funksjonen for å sjekke om dette buret er ledig denne datoen
 *  @param String $dato
 *  @param int $burID
 *  @return boolean $burLedig;
 **/ 
function erBurLedigDenneDatoen($dblink,$dato,$burID) {  
    $burLedig = true;
    $sql = "SELECT B.* 
            FROM opphold AS O, bestilling AS B
            WHERE O.bestillingID = B.bestillingID
            AND O.burID = '$burID' 
            AND B.startDato <= '$dato'
            AND B.sluttDato >= '$dato';";
    $resultat = mysqli_query($dblink, $sql); 
    $antall = mysqli_num_rows($resultat);
    if ($antall > 0) { 
        echo "burID " . $burID . " er opptatt " .$dato . "<br>"; 
        $burLedig = false;
    }
    else { 
        echo "burID " . $burID . " er ledig " .$dato . "<br>"; 
    } 
    return $burLedig; 
}

/** 
 *  Funksjonen for hente ut navnene til alle hundene som skal ha opphold.
 *  Kalles i bestillOpphold4.php for å vise oppsumering av oppholdet til brukeren.
 *  @return boolean $burLedig;
 **/  
function getValgteHunderNavn($dblink) {
    $valgteHunderNavn = "";
    $valgteHunder = $_SESSION['valgteHunder'];  
    for ($i=0; $i<count($valgteHunder); $i++) {
        $hundID = $valgteHunder[$i];
        $sql = "SELECT navn FROM hund WHERE hundID = '$hundID';";
        $resultat = mysqli_query($dblink, $sql); 
        while($rad = mysqli_fetch_assoc($resultat)) {
            $valgteHunderNavn = $valgteHunderNavn . " " . $rad['navn'];
        }
    }
    return $valgteHunderNavn;
}

// Funksjonen for oppdaterer "ledigeBurPrDag"-tabellen i databasen etter at et opphold er bestilt
function oppdaterLedigeBur($dblink,$startDato,$sluttDato) {  
    $dato = $startDato;
    while ($dato < $sluttDato) {
        $sql = "UPDATE ledigeBurPrDag SET antallLedigeBur = antallLedigeBur-1 WHERE dato = '$dato';";
        $resultat = mysqli_query($dblink, $sql); 
        $dato = new DateTime($dato);    // til Date obj
        $dato->modify('+1 day');
        $dato = $dato->format('Y-m-d'); // til string igjen
    }
}

ob_end_flush();