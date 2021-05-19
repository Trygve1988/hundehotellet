<?php
ob_start();
include_once "domeneklasser/Bruker.php";
include_once "domeneklasser/Hund.php";
include_once "domeneklasser/Bestilling.php";
include_once "domeneklasser/FerdigBestilling.php";

/* ************************** 0) Alle: a) konstanter ************************** */
// øverst i include/funksjoner.php
//koble på itfag databasen
define("TJENER",  "itfag.usn.no");
define("BRUKER",  "h20APP2000gr5");
define("PASSORD", "pw5");
define("DB",      "h20APP2000grdb5");

/* ************************** 0) Alle: b) SESSIONS ************************** */
// $bruker = $_SESSION['bruker'];               ( 10) Logg Inn)
// $valgteHunder = $_SESSION['valgteHunder'];   ( 6) Bestill Opphold 2  oppdater Hunder)
// $pos = $_SESSION['valgteHunderPos'];         ( 6) Bestill Opphold 2  oppdater Hunder)
// $_SESSION['aktivHund'] = $hund;              ( 6) Bestill Opphold 2  oppdater Hunder)
// $_SESSION['bestilling'] =  $bestilling;      ( 6) Bestill Opphold 3 - velg Datoer)


/* ************************** 0) Alle: c) database ************************** */ 
function kobleOpp() {
    $dblink = mysqli_connect(TJENER, BRUKER, PASSORD, DB);
    if (!$dblink) {
        die('Klarte ikke å koble til databasen: ' . mysqli_error($dblink));
    }
    mysqli_set_charset($dblink, 'utf8');
    return $dblink;
}

function lukk($dblink) {
    mysqli_close($dblink);
}


/* ************************** 0) Alle: d) topp ************************** */ 
function visBildeBakgrunn() { 
    ?> <div class="bildeBakgrunn">
     </div><?php
}

function visNav() { 
    ?> <div class="navbar">
        <a href="index.php"> <img class="logo" src="bilder/logohvit.png"> <img class="logotext" src="bilder/teksthvit.png"></a>
        <a id="hjemLink" href="index.php">Hjem</a>
        <a id="aktueltLink" href="aktuelt.php">Aktuelt</a>
        <a id="omOssLink" href="omOss.php">Om Oss</a>
        <a id="priserLink" href="priserOgInfo.php">Pris og info</a>
        <a id="kontaktOssLink" href="kontaktOss.php">Kontakt Oss</a>

        <?php
        // bestill Opphold
        if (erLoggetInn()) {
            ?> <a id="bestillLink" href="bestillOpphold.php">Bestill Opphold</a> <?php 
        }
        else {
            ?> <a id="bestillLink" href="loggInn.php">Bestill Opphold</a> <?php
        } 
        // anmeldelser 
        if (erAnsatt()) {
            ?> <a id="anmeldelserLink" href="anmeldelser.php">Anmeldelser</a> <?php
            ?> <a id="alleOppholdLink" href="alleOpphold.php">Ansatt</a> <?php
            
        }
        // admin
        if (erAdmin()) {
           ?> <a href="kunder.php">Admin</a> <?php 
        }
        // minSide loggUt / loggInn registrerDeg
        if (erLoggetInn()) {
             ?> <a id="minSideLink" class="right" href="minSide.php">Min Side</a> <?php 
             ?> <a id="loggUtLink" class="right" href="loggUt.php">Logg Ut</a> <?php
        }
        else {
            ?> <a class="right" href="loggInn.php">Logg Inn</a> <?php
            ?> <a id="registrerDegLink" class="right" href="registrerDeg.php">Registrer Deg</a> <?php
        } ?>
        <!-- spraakKnapp--> 
        <img id="spraakKnapp" class="right" src="bilder/FlaggNO.png" alt="Norway">
    </div><?php
}

function visNav2() { 
    ?> <div class="navbar2">

        <?php
        if(erAdmin()) {
            ?> <a id="kunderLink" href="kunder.php">Kunder</a> <?php 
            ?> <a id="ansatteLink" href="ansatte.php">Ansatte</a> <?php
            ?> <a id="seLoggerLink" href="seLogger.php">Se logger</a> <?php
        }
    ?>
    </div>
        <?php
}

function visNav3() { 
    ?> <div class="navbar2">

        <?php
        if(erAnsatt()) {
            ?> <a id="alleOppholdLink" href="alleOpphold.php">Alle Opphold</a> <?php 
            ?> <a id="ansatteLink" href="ansatte.php">Bur</a> <?php
            ?> <a id="seLoggerLink" href="seLogger.php">Inn og utsjekkinger</a> <?php
            ?> <a id="kunderLink" href="kunder.php">Mating</a> <?php 
            ?> <a id="ansatteLink" href="ansatte.php">Luftegård</a> <?php
            ?> <a id="seLoggerLink" href="seLogger.php">Tur</a> <?php
        }
    ?>
    </div>
        <?php
}

function erLoggetInn() {
    return ( isset($_SESSION['bruker']) );
}

function erAnsatt() {
    $erAnsatt = false;
    if (isset($_SESSION['bruker'])) {
        $bruker = $_SESSION['bruker'];
        $brukerType = $bruker->getBrukerType();
        if ( ($brukerType == "ansatt") || ($brukerType == "admin") ) {
            $erAnsatt = true;
        }
    }
    return $erAnsatt;
}

function erAdmin() {
    $erAdmin = false;
    if (isset($_SESSION['bruker'])) {
        $bruker = $_SESSION['bruker'];
        $brukerType = $bruker->getBrukerType();
        if ($brukerType == "admin") {
            $erAdmin = true;
        }
    }
    return $erAdmin;
}

/* ************************** 0) Alle: e) bunn ************************** */ 
function visToppKnapp() { 
    ?> 
    <!-- gratis Opp ikon fra https://fontawesome.com/icons/chevron-up?style=solid-->
    <button onclick="toppKnappFunksjon()" id="tilToppKnapp" title="Gå til toppen"><i class="fas fa-chevron-up"></i> </button>  
    <script src="./include/toppknappen.js"></script>
    <?php 
}

function visFooter() { 
    ?>
    <!--sett footeren din inn her kristina -->
    <footer class="main-footer">
        <div class="venstre">
            <h1>Kontakinformsjon</h1>
            <p>Bø Hundehotell</p>
            <p><strong>Tlf:</strong><a href="tel:+12345678"> 12345678</a> </p>
            <address>
                <strong> Epost:</strong> <a href="mailto:bohundehotell@outlook.com">bohundehotell.@outlook.com</a><br>    
                   </address>
            <p> <strong>Adresse:</strong>Lektorvegen 91 <br> 3802 Bø i Telemark</p>
        </div>

        <div class="midten sosiale-medier">
            <h1>Sosiale medier</h1>
            <a href="https://www.instagram.com" target="_blank">
                <img src="./bilder/instagramIkon.png" alt="Instagram Logo" class="instagram-ikon"></a>
            <a href="https://www.facebook.com" target="_blank">
                <img src="./bilder/facebookIkon.png" alt="Facebook Logo" class="facebook-ikon"></a>
            <a href="https://twitter.com/twitter" target="_blank">
                <img src="./bilder/twitterIkon.png" alt="Twitter Logo" class="twitter-ikon"></a>
        </div>

        <!-- Gratis google kart fra https://maps-website.com-->
        <div class="høyre kart">
            <h1>Besøk oss</h1>
            <iframe width="350" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
            id="gmap_canvas"
                src="https://maps.google.com/maps?width=350&amp;height=200&amp;hl=en&amp;q=Lektorvegen%2091%20B%C3%B8%20i%20Telemark+()&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
           
                <a target="_blank" href="https://www.google.com/maps/place/Lektorvegen+91,+3802+Bø,+Norway/@59.412934,9.078556,12z/data=!4m2!3m1!1s0x46474940ffa6344f:0x913038103500cc71?hl=en&gl=US" title="Trykk her for å åpne kartet">
                  <br>  <i class="fas fa-map-marker-alt"></i> Klikk her for å se kartet</a>
        </div>

        <div class="høyre">
            <h1>Samarbeidspartnere</h1>
            <p>Royal Canin</p>
        </div>
    </footer>
    <?php 
}
































// ************************** 1) Index **************************
// ************************** 2) Aktuelt  **************************
// ************************** 3) Om Oss  **************************
// ************************** 4) Priser  **************************
function visPriser($dblink) {
    echo "<table>";

    //overskrifter
    echo "<tr>";
    echo    "<th>prisID</th>";
    echo    "<th>beskrivelse</th>";
    echo    "<th>kr</th>";
    echo "</tr>";

    //rader
    $sql = "SELECT * FROM pris;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['prisID'] . "</td>"; 
        echo "<td>" . $rad['beskrivelse'] . "</td>";
        echo "<td>" . $rad['beløp'] . "</td>";
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

function visDagPris($dblink) {
    $beskrivelse = "dagPris";
    $sql = "SELECT * FROM pris WHERE beskrivelse = '$beskrivelse' ;";
    $resultat = mysqli_query($dblink, $sql); 
    $rad = mysqli_fetch_assoc($resultat);
    echo $rad['beløp']; 
}


// ************************** 5) Kontakt Oss  **************************
function visKontaktOssInfo($dblink) {
    $navn = "kontaktOss";
    $sql = "SELECT * FROM innlegg WHERE navn = '$navn' ;" ;
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)) {
        $tekst = $rad['tekst'] . "<br>";
        echo "<p class=\"endreKontaktOssTekst\">" . $tekst . "</p>" ;
    }
}

function lagreKontaktOssInfo($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {  
        $navn = "kontaktOss";    
        $tekst = $_POST['endreKontaktOssTekstfelt'];
        $sql = "UPDATE innlegg SET tekst = '$tekst' WHERE navn = '$navn' ;" ;
        $resultat = mysqli_query($dblink, $sql);
        header("Refresh:0");
    }
}


// ************************** 6) Bestill Opphold 1 - velg hund(er) ************************** 
// denne siden lar brukeren registrere nye hunder 
// og velge hunder som skal være med i bestillingen

//hjelpemetoder
function registrerHund($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {  
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
        $sql = "SELECT MAX(hundID) FROM hund;"; 
        $resultat = mysqli_query($dblink, $sql); 
        while($rad = mysqli_fetch_assoc($resultat)) {
            $hundID = implode($rad);
        }

        echo "hund " . $hundID . " - ". $navn . " registrert" . "<br>";
        //header('Location: bestillOpphold1.php');
    }
}

//oppdaterValgteHunderSession($hund);

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

function setAktivHund($dblink,$hundID) {
    // setter valgt hund-objekt sesjonsvariabel
    $sql = "SELECT * FROM hund WHERE hundID = '$hundID' ;"; 
    $resultat = mysqli_query($dblink, $sql); 
    $rad = mysqli_fetch_assoc($resultat);

    $hundID = $rad['hundID'];
    $navn = $rad['navn'];
    $rase = $rad['rase'];
    $fdato = $rad['fdato'];
    $kjønn = $rad['kjønn'];

    $sterilisert = $rad['sterilisert'];
    $løpeMedAndre = $rad['løpeMedAndre'];
    $info = $rad['info'];
    $brukerID = $rad['brukerID'];
    $forID = $rad['forID'];

    $hund = new Hund($hundID,$navn,$rase,$fdato,$kjønn,
    $sterilisert,$løpeMedAndre,$info,$brukerID,$forID);

    $_SESSION['aktivHund'] = $hund;

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
        echo "hund " . $hundID . " - ". $navn . " oppdatert" . "<br>";
    }
}

// ************************** 6) Bestill Opphold 3 - velg Datoer  ************************** /**//
function bekreftDatoer($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<br>".'<i style="color:red";> aaaaaaaaaaaaaaaaas </i>'; 
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

// ************************** 6b) Alle Opphold **************************
function visIkkeBegynteOpphold($dblink) {
    echo "<h3> Ikke begynte opphold </h3>";
    visoppholdOverskrifter($dblink);
    $sql = lagIkkeBegynteOppholdSQLSpørring($dblink);
    oppholdSQLSvar($dblink,$sql);
}

function visPågåendeOpphold($dblink) {
    echo "<h3> Pågående Opphold </h3>";
    visoppholdOverskrifter($dblink);
    $sql = lagPågåendeOppholdSQLSpørring($dblink);
    oppholdSQLSvar($dblink,$sql);
}

function visFerdigeOpphold($dblink) {
    echo "<h3> Ferdige Opphold </h3>";
    visoppholdOverskrifter($dblink);
    $sql = lagFerdigeOppholdSQLSpørring($dblink);
    oppholdSQLSvar($dblink,$sql);
}

function vis5SisteFerdigeOpphold($dblink) {
    echo "<h3> Ferdige Opphold </h3>";
    visoppholdOverskrifter($dblink);
    $sql = lag5SisteFerdigeOppholdSQLSpørring($dblink);
    oppholdSQLSvar($dblink,$sql);
}


// hjelpefunksjoner
function visoppholdOverskrifter($dblink) {
    echo "<table>";
    echo "<tr>";
    echo    "<th>bestillingID</th>";    // bestilling
    echo    "<th>start</th>";           // bestilling
    echo    "<th>slutt</th>";           // bestilling
    echo    "<th>bestilt</th>";         // bestilling
    echo    "<th>betalt</th>";          // bestilling
    echo    "<th>totalPris</th>";       // bestilling
    echo    "<th>oppholdID</th>";       // opphold
    echo    "<th>bade</th>";            // opphold
    echo    "<th>hundID</th>";          // opphold
    echo    "<th>navn</th>";            // hund
    echo    "<th>burID</th>";           // opphold
    echo "</tr>";
}

function lagIkkeBegynteOppholdSQLSpørring($dblink) { 
    // finner ikke begynte opphold
    return "SELECT B.*, O.*, H.*
        FROM bestilling AS B, opphold AS O, hund AS H
        WHERE B.bestillingID = O.bestillingID
        AND   O.hundID = H.hundID
        AND   B.startDato > CURRENT_TIMESTAMP ;" ; 
}

function lagPågåendeOppholdSQLSpørring($dblink) { 
    // finner ikke begynte opphold
    return "SELECT B.*, O.*, H.*
        FROM bestilling AS B, opphold AS O, hund AS H
        WHERE B.bestillingID = O.bestillingID
        AND   O.hundID = H.hundID
        AND   B.startDato < CURRENT_TIMESTAMP AND sluttDato > CURRENT_TIMESTAMP;";
}

function lagFerdigeOppholdSQLSpørring($dblink) { 
    // finner ikke begynte opphold
    return "SELECT B.*, O.*, H.*
        FROM bestilling AS B, opphold AS O, hund AS H
        WHERE B.bestillingID = O.bestillingID
        AND   O.hundID = H.hundID
        AND   B.startDato < CURRENT_TIMESTAMP AND B.sluttDato < CURRENT_TIMESTAMP
        ORDER BY B.sluttDato DESC ;";
}

function lag5SisteFerdigeOppholdSQLSpørring($dblink) { 
    // finner ikke begynte opphold
    return "SELECT B.*, O.*, H.*
        FROM bestilling AS B, opphold AS O, hund AS H
        WHERE B.bestillingID = O.bestillingID
        AND   O.hundID = H.hundID
        AND   B.startDato < CURRENT_TIMESTAMP AND B.sluttDato < CURRENT_TIMESTAMP
        ORDER BY B.sluttDato DESC
        LIMIT 5 ;";
}

function oppholdSQLSvar($dblink,$sql) { 
    $resultat = mysqli_query($dblink, $sql); 
    $forigeBestillingID = "";
    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";

        //bestillingID
        $bestillingID = $rad['bestillingID'];
        if ($bestillingID !== $forigeBestillingID) { // skriver bare viss IKKE lik den forige
            echo "<td>" . $bestillingID . "</td>";  
        }
        else {
            echo "<td>"."</td>"; 
        }
        
        //startDato
        $startDato = $rad['startDato'];
        if ($bestillingID !== $forigeBestillingID) { // skriver bare viss IKKE lik den forige
            echo "<td>" . $startDato . "</td>";  
        }
        else {
            echo "<td>"."</td>"; 
        }

        //sluttDato
        $sluttDato = $rad['sluttDato'];
        if ($bestillingID !== $forigeBestillingID) { // skriver bare viss IKKE lik den forige
            echo "<td>" . $sluttDato . "</td>";  
        }
        else {
            echo "<td>"."</td>"; 
        }

        //bestiltDato
        $bestiltDato = $rad['bestiltDato'];
        if ($bestillingID !== $forigeBestillingID) { // skriver bare viss IKKE lik den forige
            echo "<td>" . $bestiltDato . "</td>";  
        }
        else {
            echo "<td>"."</td>"; 
        }

        //betaltDato
        $betaltDato = $rad['betaltDato'];
        if ($bestillingID !== $forigeBestillingID) { // skriver bare viss IKKE lik den forige
            echo "<td>" . $betaltDato . "</td>";  
        }
        else {
            echo "<td>"."</td>"; 
        }

        //totalPris
        $totalPris = $rad['totalPris'];
        if ($bestillingID !== $forigeBestillingID) { // skriver bare viss IKKE lik den forige
            echo "<td>" . $totalPris . "</td>";  
        }
        else {
            echo "<td>"."</td>"; 
        }

        echo "<td>" . $rad['oppholdID'] . "</td>";      //opphold
        echo "<td>" . $rad['skalBade'] . "</td>";       //opphold
        echo "<td>" . $rad['hundID'] . "</td>";         // opphold
        echo "<td>" . $rad['navn'] . "</td>";           // hund
        echo "<td>" . $rad['burID'] . "</td>";          // opphold
        echo "</tr>";

        $forigeBestillingID = $bestillingID;
    }
    echo "</table>" . "<br>";
}

// ************************** 6c) Bur-Oversikt ************************** 
function visLedigeBurPrDag($dblink) {
    // lager burTab med alle dagene
    $burTab = lagBurTab($dblink);

    // oppretter variabler
    $ukeTab;
    $dagNr=0;
    $ukeNr = new DateTime();
    $ukeNr = $ukeNr->format("W");
    $mnd = new DateTime();
    $aar = new DateTime();
    $aar = $aar->format('Y');

    // mnd-navn overskrift
    $mndStr = $mnd->format('M');
    echo "<h3>" . $mndStr . " " . $aar. "</h3>";
    $mnd->modify('+1 month');

    // kjører gjennom hele burTab
    for ($i=0; $i<count($burTab); $i++) {
        $ukeTab[$dagNr] = $burTab[$i];
        $dagNr++;
        if ($dagNr==7) {
            if ( nesteMndSjekk($burTab[$i]) ) {
                // mnd-navn overskrift
                $mndStr = $mnd->format('M');
                echo "<h3>" . $mndStr . " " . $aar. "</h3>";
                $mnd->modify('+1 month');
            }
            // skriver neste UkeTab
            skrivUkeTab($ukeTab);
            $dagNr = 0;
            $ukeTab  = array();
            $ukeNr++;
        }
        $aar = oppdaterAar($burTab[$i]);
    }  
} 

function nesteMndSjekk($dato) {
    $dato = substr($dato,8,2);
    if ($dato > 0 && $dato < 8) {  
       return true;   
    }
    else {
        return false;   
    }
} 

function oppdaterAar($dato) {
    return substr($dato,0,4);
} 

function lagBurTab($dblink) {
    $burTab = null;
    //startDato (forige mandag )
    $aar = new DateTime();
    $aar = $aar->format('Y');
    $mnd = new DateTime();
    $mnd = $mnd->format('m');
    $startDato = date("Y-m-d", strtotime("first monday ".$aar."-".$mnd."")); 

    //sluttDato (1 aar frem i tid)
    $sluttDato = new DateTime();
    $sluttDato->modify('+1 year');
    $sluttDato = $sluttDato->format('Y-m-d');

    $pos = 0;
    $sql = "SELECT * FROM ledigeBurPrDag WHERE dato >= '$startDato' AND dato <= '$sluttDato' ;";
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)){
        $burTab[$pos++] = $rad['dato'] . " ". $rad['antallLedigeBur']; 
    }
    return $burTab;
} 

function skrivUkeTab($burTab) {
    $dagNavn = array("Man", "Tirs", "Ons", "Tors", "Fre", "Lør", "Søn");
    echo "<table class=\"burTab\">";
    echo "<tr>";
    echo    "<th>dag</th>";
    echo    "<th>dato</th>";
    echo    "<th>ledige</th>";
    echo "</tr>";

    for ($i=0; $i<count($burTab); $i++) {
        echo "<tr>"; 
        $linje = $burTab[$i];
        $dataTab = explode(" ",$linje);
        echo    "<td>" . $dagNavn[$i] . "</td>"; 

        //dato (norsk format)
        $dato = substr($dataTab[0],5);
        $dataTab2 = explode("-",$dato);
        $mnd = $dataTab2[0];
        $dag = $dataTab2[1];
        echo  "<td>" . $dag . "-" . $mnd  . "</td>"; 

        echo    "<td>" . $dataTab[1] . "</td>"; 
        echo "</tr>";
    }
    echo "</table>";
}

// ************************** 6d) Mating ************************** 
function visAlleHunderPaaOppholdNaa($dblink) {
    echo "<h2>" . "Alle hunder som er på opphold nå" . "</h2>";
    // vis opphold Overskrifter
    echo "<table id=\"matingTab\">";
    echo "<tr>";
    echo    "<th>oppholdID</th>";  
    echo    "<th>forID</th>";  
    echo    "<th>navn</th>";          
    echo "</tr>";

    //$sql = " SELECT O.oppholdID, F.forID, H.navn FROM bestilling AS B, opphold AS O, hund AS H, hundefor AS F
    $sql = " SELECT O.oppholdID, F.forID, H.navn FROM bestilling AS B, opphold AS O, hund AS H, hundefor AS F
    WHERE B.bestillingID = O.bestillingID
    AND O.hundID = H.hundID
    AND H.forID = F.forID
    AND B.startDato < CURRENT_TIMESTAMP AND sluttDato > CURRENT_TIMESTAMP
    ORDER BY O.oppholdID  ;";
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['oppholdID'] . "</td>";  
        echo "<td>" . $rad['forID'] . "</td>";     
        echo "<td>" . $rad['navn']      . "</td>";                  
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}


function visAlleRegistrerteMatingerIDag($dblink) {
    // alle registrerte matinger i dag 
    $idag = new DateTime();
    echo "<h2>" . "Registrerte matinger i dag " . $idag->format('Y-m-d') . "</h2>";
    // vis opphold Overskrifter
    echo "<table id=\"matingTab\">";
    echo "<tr>";
    echo    "<th>oppholdID</th>";  
    echo    "<th>forID</th>";  
    echo    "<th>navn</th>";    
    echo    "<th>Mating</th>";       
    echo "</tr>";

    // SQLSpørring for å finne alle registrerte matinger i dag 
    $sql = " SELECT M.*, H.navn, F.forID FROM mating AS M, opphold AS O, hund AS H, hundefor AS F
    WHERE M.oppholdID = O.oppholdID
    AND O.hundID = H.hundID
    AND H.forID = F.forID
    AND day(M.tidspunkt) = day(CURRENT_TIMESTAMP)
    ORDER BY O.oppholdID ;";
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['oppholdID'] . "</td>";  
        echo "<td>" . $rad['forID'] . "</td>";     
        echo "<td>" . $rad['navn']      . "</td>";         
        $tidspunkt = $rad['tidspunkt'];  
        echo "<td>" . substr($tidspunkt,10,6) . "</td>";            
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

function registrerMatingAlle($dblink) {
    if (isset($_POST['registrerMatingAlle'])) { 
        // brukerNavn
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        // lager oppholdIDTab
        $oppholdIDTab = getMatingOppholdIDer($dblink);
        // kjører gjennom hele oppholdIDTab og registrerer matinger
        for ($i=0; $i<count($oppholdIDTab); $i++) {
            $oppholdID = $oppholdIDTab[$i];
            $sql = "INSERT INTO mating (tidspunkt,oppholdID,forID,brukerID) 
            VALUES (CURRENT_TIMESTAMP,'$oppholdID',1,'$brukerID');" ;
            mysqli_query($dblink,$sql);
        } 
        header("Refresh:0");
    }   
}

function getMatingOppholdIDer($dblink) {
    $oppholdIDTab;
    $pos = 0;
    $sql = " SELECT O.oppholdID FROM bestilling AS B, opphold AS O, hund AS H
    WHERE B.bestillingID = O.bestillingID AND   O.hundID = H.hundID
    AND   B.startDato < CURRENT_TIMESTAMP AND sluttDato > CURRENT_TIMESTAMP;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        $oppholdIDTab[$pos++] = $rad['oppholdID'];    
    } 
    return $oppholdIDTab;
}

// test !!!!!!!!!
function slettAlleMatinger($dblink) {
    if (isset($_POST['slettAlle'])) { 
        $sql = "DELETE FROM mating ;" ;
        mysqli_query($dblink,$sql);
    }  
}

// ************************** 7) Anmeldelser **************************
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

function visNesteIkkeGodkjenteAnmeldelse($dblink) {
    // henter ut neste ikke godkjente anmeldelse
    $sql = "SELECT * FROM anmeldelse WHERE godkjent = 0";
    $resultat = mysqli_query($dblink,$sql);

    // fant vi noe?
    $antall = mysqli_num_rows($resultat);
    if ($antall == 0) {
        echo "<br>".'<i> Ingen flere anmeldelser å godkjenne </i>'."<br>"."<br>"; 

        //aktivAnmeldelse
        $_SESSION['aktivAnmeldelseID'] = null;
    }
    else {
        $rad = mysqli_fetch_assoc($resultat);
        echo $rad['dato'] . "<br>";
        echo $rad['tekst'] . "<br>";
    
        //aktivAnmeldelse
        $_SESSION['aktivAnmeldelseID'] = $rad['anmeldelseID'];
    }  
}

function slettAnmeldelse($dblink) {
    if ( isset($_POST['slettAnmeldelseKnapp']) && $_SESSION['aktivAnmeldelseID'] !== null) { 
        $aktivAnmeldelseID = $_SESSION['aktivAnmeldelseID'];
        $sql = "DELETE FROM anmeldelse WHERE anmeldelseID = '$aktivAnmeldelseID' ;";
        mysqli_query($dblink,$sql);

        //melding
        echo "<br>".'<i style="color:green; position:absolute";"> Anmeldelse slettet</i>';

        header("Refresh:0");
    }
}

function godkjennAnmeldelse($dblink) {
    if (isset($_POST['godkjennAnmeldelseKnapp']) && $_SESSION['aktivAnmeldelseID'] !== null) { 
        $aktivAnmeldelseID = $_SESSION['aktivAnmeldelseID'];
        $sql = "UPDATE anmeldelse SET godkjent = 1 WHERE anmeldelseID = '$aktivAnmeldelseID' ;";
        mysqli_query($dblink,$sql);

        //melding
        echo "<br>".'<i style="color:green; position:absolute";"> Anmeldelse godkjent</i>';

        header("Refresh:0");
    }
}

// ************************** 8) Admin **************************
function visPrisHistorikk($dblink) {
    echo "<h2> Pris-Historikk </h2>";

    $sql = "SELECT P.beskrivelse, H.* FROM pris AS P, prisHistorikk AS H WHERE P.prisID = H.prisID;";
    $resultat = mysqli_query($dblink, $sql); 

    echo "<table>";
    echo "<tr>";
    echo    "<th>brukerID</th>";
    echo    "<th>beskrivelse</th>";
    echo    "<th>endretDato</th>";
    echo    "<th>nyttbeløp</th>";
    echo    "<th>gammeltbeløp</th>";
    echo "</tr>";

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>"; 
        echo "<td>" . $rad['brukerID'] . "</td>";
        echo "<td>" . $rad['beskrivelse'] . "</td>"; 
        echo "<td>" . $rad['endretDato'] . "</td>"; 
        echo "<td>" . $rad['nyttbeløp'] . "</td>"; 
        echo "<td>" . $rad['gammeltbeløp'] . "</td>"; 
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

// ************************** 9) Min Side **************************
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

// ************************** 9) minSide -> a)endre brukerinfo **************************
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

// ************************** 9) minSide -> b)endrePassord **************************
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

// ************************** 9) minSide -> c) registrerHund **************************
//denne funskjonen er allerede laget under bestill opphold

// ************************** 9) minSide -> d) endre hund1  **************************
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

function lagOption($hund) {
    ?> <option value= <?php echo $hund?> > <?php echo $hund?> </option><?php
}

function velgHundSomSkalEndres($dblink) {
    if (isset($_POST['velgHund'])) { 
        //får tak i hundID ut ifra $brukerID og $navn  IKKE PERFEKT LØSNING!
        $navn = $_POST['hund']; 
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        $sql = "SELECT * FROM hund WHERE navn = '$navn' AND brukerID = '$brukerID' ;"; 
        $resultat = mysqli_query($dblink, $sql); 
        $rad = mysqli_fetch_assoc($resultat);
        $hundID = $rad['hundID'];
        setAktivHund($dblink,$hundID);
        header('Location: endreHund2.php');
    }
}

// ************************** 9) minSide -> e) endre hund2 **************************
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

// ************************** 9) minSide -> f) avbestill bestilling ************************** 
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
        
        //slett opphold
        $sql = "DELETE FROM opphold WHERE bestillingID = '$bestillingID' ;";
        $resultat = mysqli_query($dblink, $sql); 

        //slett bestilling
        $sql = "DELETE FROM bestilling WHERE bestillingID = '$bestillingID' ;";
        $resultat = mysqli_query($dblink, $sql); 

        echo "bestillingID " . $bestillingID . " avbestil. <br>";
    }
}
// ************************** 10) Logg Inn **************************
function loggInn($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $epost = $_POST['epost'];
        $passord = $_POST['passord'];
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
                $fødselsNr=0; 
                $stilling=" ";
                $postNr=0;
                opprettBrukerSession($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
                $tlf, $adresse, $fødselsNr, $stilling, $postNr);

                echo "<br>".'<i style="color:green; position:absolute";"> Du er nå logget inn </i>'; 
                //header('Location: minSide.php');
                $innloggingOk = true;
            }
        }
        if($innloggingOk == false) {
            echo "<br>".'<i style="color:red; position:absolute";"> feil epost og/eller passord! </i>'; 
        }
    }
}

function opprettBrukerSession($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
$tlf, $adresse, $fødselsNr, $stilling, $postNr) {
    $bruker = new Bruker($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
    $tlf, $adresse, $fødselsNr, $stilling, $postNr);
    $_SESSION['bruker'] = $bruker;
}

// ************************** 11) Registrer deg **************************
function registrerDeg($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $epost = $_POST['epost'];
        $passord = $_POST['passord'];
        $passord = password_hash($passord, PASSWORD_DEFAULT);

        // velg brukertype (bare for testing) 
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
            loggInn($dblink);
            header('Location: minSide.php');
        }
    }
}

ob_end_flush();

/*
Kilder
password hashing: https://www.w3schools.com
password hashing: https://www.youtube.com/watch?v=Q-fBhFTe2H8
password hashing: https://www.w3schools.com
*/