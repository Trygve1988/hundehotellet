<?php
ob_start();

// ************************** 6) Bestill Opphold 1 - velg hund(er) ************************** 
// denne siden lar brukeren registrere nye hunder 
// og velge hunder som skal være med i bestillingen
//function registrerHund($dblink) {

//  Funksjon for å registrer en Hund
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

        //får tak i hundID
        $hundID; 
        $sql = "SELECT MAX(hundID) FROM hund;"; 
        $resultat = mysqli_query($dblink, $sql); 
        while($rad = mysqli_fetch_assoc($resultat)) {
            $hundID = implode($rad);
        }

        echo "<br>".'<i style="color:green";> Hund registrert! </i>'; 
        header('Location: bestillOpphold.php');
    }
}

// ********************* 6) Bestill Opphold 2  oppdater Hunder  ********************* 
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

// c) bekreftHundInfo
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
    }
}



// ************************** 6) Bestill Opphold 3 - velg Datoer og bading ************************** /**//
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

function opprettBestillingSession($startDato, $sluttDato, $totalPris) { 
    $bestilling = new Bestilling($startDato, $sluttDato, $totalPris);
    $_SESSION['bestilling'] =  $bestilling;
}

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

function datoIMorgen() {
    $date = new DateTime();
    $date->modify('+1 day');
    echo $date->format('Y-m-d');
}

// ************************** 6) Bestill Opphold 4 - betalingsinfo ************************** /**//
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



// ************************** 6) Bestill Opphold 5 - etter at oppholdet er bestilt ************************** /**//
// oppdaterer ledigeBurPrDag tabellen i db
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