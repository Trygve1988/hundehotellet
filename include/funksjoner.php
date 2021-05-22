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
// $_SESSION['endreBruker']                     (  9) Admin -> c) endre Bruker
// $_SESSION['adminSeBrukertype']               (  9) Admin 

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
            ?> <a id="alleOppholdLink" href="alleOpphold.php">Ansatt side</a> <?php
            
        }
        // admin
        if (erAdmin()) {
           ?> <a href="admin.php">Admin side</a> <?php 
        }
        // minSide loggUt / loggInn registrerDeg
        if (erLoggetInn()) {
             ?> <a id="minSideLink" class="right" href="minSide.php">Min Side</a> <?php 
             ?> <a id="minSideLink" class="right" href="minSideTest.php">Min Side Test</a> <?php 
             ?> <a id="loggUtLink" class="right" href="loggUt.php">Logg Ut</a> <?php
        }
        else {
            ?> <a id="loggInnLink" class="right" href="loggInn.php">Logg Inn</a> <?php
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
            ?> <a id="kunderLink" href="admin.php">Admin</a> <?php 
        }
    ?>
    </div>
        <?php
}

function visNav3() { 
    ?> <div class="navbar2">

        <?php
        if(erAnsatt()) {
            ?> <a href="ansattBur.php">Bur-Oversikt</a> <?php
            ?> <a href="ansattAlleOpphold.php">Alle Opphold</a> <?php 
            ?> <a href="ansattSjekkInnUt.php">Sjekk Inn/Ut</a> <?php
            ?> <a href="ansattHunder.php">Hunder</a> <?php 
            ?> <a href="ansattMating.php">Mating</a> <?php 
            ?> <a href="ansattLuftegaard.php">Luftegård</a> <?php  
            ?> <a href="ansattTur.php">Tur</a> <?php 
            ?> <a href="ansattKommentar.php">Kommentar</a> <?php 
            ?> <a href="ansattAnmeldelse.php">Anmeldelser</a> <?php 
            ?> <a href="ansattLogg.php">Logg</a> <?php 
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
            <h1 id="navkontaktInformasjon">Kontakinformsjon</h1>
            <p>Bø Hundehotell</p>
            <p><strong>Tlf:</strong><a href="tel:+12345678"> 12345678</a> </p>
            <p><strong id="navEpost" > Epost:</strong> <a href="mailto:bohundehotell@outlook.com">bohundehotell@outlook.com</a></p>
            <p> <strong id="navAdresse">Adresse:</strong>Lektorvegen 91 <br> 3802 Bø i Telemark</p>
        </div>

        <div class="midten sosiale-medier">
            <h1 id="navSosialMedier">Sosiale medier</h1>
            <a href="https://www.instagram.com" target="_blank">
                <img src="./bilder/instagramIkon.png" alt="Instagram Logo" class="instagram-ikon"></a>
            <a href="https://www.facebook.com" target="_blank">
                <img src="./bilder/facebookIkon.png" alt="Facebook Logo" class="facebook-ikon"></a>
            <a href="https://twitter.com/twitter" target="_blank">
                <img src="./bilder/twitterIkon.png" alt="Twitter Logo" class="twitter-ikon"></a>
        </div>

        <!-- Gratis google kart fra https://maps-website.com-->
        <div class="høyre kart">
            <h1 id="navBøskOss">Besøk oss</h1>
            <iframe width="350" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
            id="gmap_canvas"
                src="https://maps.google.com/maps?width=350&amp;height=200&amp;hl=en&amp;q=Lektorvegen%2091%20B%C3%B8%20i%20Telemark+()&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
           
                <a target="_blank" href="https://www.google.com/maps/place/Lektorvegen+91,+3802+Bø,+Norway/@59.412934,9.078556,12z/data=!4m2!3m1!1s0x46474940ffa6344f:0x913038103500cc71?hl=en&gl=US" title="Trykk her for å åpne kartet">
                  <br>  <i id="navKlikk" class="fas fa-map-marker-alt"></i></a>
        </div>

        <div class="høyre">
            <h1 id="navSamerbeid">Samarbeidspartnere</h1>
            <p>Royal Canin</p>
        </div>
    </footer>
    <?php 
}







function test($dblink) {
    //tabell overskrifter
    echo "<h2> Min Info </h2>";
    echo "<table>";
    echo "<tr>";
    echo    "<th>brukerID</th>";  
    echo    "<th>navn</th>";      
    echo "</tr>";

    //sql spørring
    $brukerID = 6;
    $sql = "SELECT * FROM bruker WHERE brukerID = '$brukerID' ;";

    //sql resultat -> tabell rader
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)) {
        echo "<tr>";
            echo "<td>". $rad['brukerID'] . "</td>";
            echo "<td>". $rad['fornavn'] ." ". $rad['etternavn']. "</td>";
        echo "</tr>";
    } 
    echo "</table>";
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
        $sql = "SELECT MAX(hundID) FROM hund;"; 
        $resultat = mysqli_query($dblink, $sql); 
        while($rad = mysqli_fetch_assoc($resultat)) {
            $hundID = implode($rad);
        }

        //echo "hund " . $hundID . " - ". $navn . " registrert" . "<br>";
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


















// ************************** 7a) Ansatt: Bur-Oversikt ************************** 
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


// ************************** 7b) Ansatt: Alle Opphold ************************** 
function visIkkeBegynteOpphold($dblink) {
    echo "<h3> Ikke begynte opphold </h3>";
    visoppholdOverskrifter($dblink);
    $sql = lagIkkeBegynteOppholdSQLSpørring($dblink);
    oppholdSQLSvar($dblink,$sql);
}

function visAktiveOpphold($dblink) {
    echo "<h3> Aktive Opphold </h3>";
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
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>bID</th>";             // bestilling
    echo    "<th>start</th>";           // bestilling
    echo    "<th>slutt</th>";           // bestilling
    echo    "<th>bestilt</th>";         // bestilling

    echo    "<th>sjekkInn</th>";        // bestilling
    echo    "<th>sjekkUt</th>";         // bestilling

    echo    "<th>betalt</th>";          // bestilling
    echo    "<th>pris</th>";            // bestilling
    echo    "<th>oID</th>";             // opphold
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

        //sjekkInn
        $sjekketInn = $rad['sjekketInn'];
        if ($bestillingID !== $forigeBestillingID) { // skriver bare viss IKKE lik den forige
            echo "<td>" . substr($sjekketInn,10,6). "</td>";  
        }
        else {
            echo "<td>"."</td>"; 
        }

        //sjekkUt
        $sjekketUt = $rad['sjekketUt'];
        if ($bestillingID !== $forigeBestillingID) { // skriver bare viss IKKE lik den forige
            echo "<td>" . substr($sjekketUt,10,6) . "</td>";  
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
        echo "<td>" . $rad['hundID'] . "</td>";         // opphold
        echo "<td>" . $rad['navn'] . "</td>";           // hund
        echo "<td>" . $rad['burID'] . "</td>";          // opphold
        echo "</tr>";

        $forigeBestillingID = $bestillingID;
    }
    echo "</table>" . "<br>";
}

function lagIkkeBegyntBestillingTabForAnsatt($dblink) {
    $bestillinger = array();
    $pos = 0;
    $sql = "SELECT DISTINCT B.* FROM bestilling AS B, opphold AS O, hund AS H
    WHERE B.bestillingID = O.bestillingID
    AND O.hundID = H.hundID ;" ;
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)) {
        $bestillingID = $rad['bestillingID'];
        $startDato = $rad['startDato'];
        $sluttDato = $rad['sluttDato'];
        $bestillinger[$pos++] = $bestillingID . ", fra " . $startDato . " til " . $sluttDato;
    }
    return $bestillinger;
 
}

// ************************** 7) Ansatt: Inspiser Hund ************************** 
function lagInspiserHundOption($hund,$inspiserHundID) {
    if ($inspiserHundID == substr($hund,0,1)) {
        ?> <option value= <?php echo $hund?> selected > <?php echo $hund ?> </option><?php
    }
    else {
        ?> <option value= <?php echo $hund?> > <?php echo $hund ?> </option><?php
    }
}

function visInspiserHundInfo($dblink) {
    $inspiserHund = $_SESSION['inspiserHund']; 
    echo "<h3>Hund-Info</h3>";
    echo "<table class=\"blaaTabSmal\">";

    $sql = "SELECT H.* FROM hund AS H, opphold AS O
    WHERE H.hundID = O.hundID 
    AND oppholdID = '$inspiserHund' ;" ;
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)) {
        echo "<tr>";
        echo    "<th>HundID</th>";   
        echo    "<td>".$rad['hundID']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>Navn</th>";   
        echo    "<td>".$rad['navn']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>Rase</th>";   
        echo    "<td>".$rad['rase']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>Fdato</th>";   
        echo    "<td>".$rad['fdato']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>Kjønn</th>";   
        echo    "<td>".$rad['kjønn']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>Sterilisert</th>";   
        echo    "<td>".$rad['sterilisert']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>LøpeMedAndre</th>";   
        echo    "<td>".$rad['løpeMedAndre']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>Info</th>";   
        echo    "<td>".$rad['info']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>ForID</th>";   
        echo    "<td>".$rad['forID']."</td>";  
        echo "</tr>";
    }
    echo "</table>";
}


function visInspiserHundOppholdInfo($dblink) {
    $inspiserHund = $_SESSION['inspiserHund']; 
    echo "<h3>Opphold-Info</h3>";
    echo "<table class=\"blaaTabSmal\">";

    $sql = "SELECT O.*, B.*
    FROM opphold AS O, bestilling AS B
    WHERE O.bestillingID = B.bestillingID 
    AND oppholdID = '$inspiserHund' ;" ;
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)) {
        echo "<tr>";
        echo    "<th>OppholdID</th>";   
        echo    "<td>".$rad['oppholdID']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>BestillingID</th>";   
        echo    "<td>".$rad['bestillingID']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>BurID</th>";   
        echo    "<td>".$rad['burID']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>StartDato</th>";   
        echo    "<td>".$rad['startDato']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>SluttDato</th>";   
        echo    "<td>".$rad['sluttDato']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>BestiltDato</th>";   
        echo    "<td>".$rad['bestiltDato']."</td>";  
        echo "</tr>";

        echo "<tr>";
        echo    "<th>SjekketInn</th>";   
        echo    "<td>".$rad['sjekketInn']."</td>";  
        echo "</tr>";
        echo "<tr>";
        echo    "<th>SjekketUt</th>";   
        echo    "<td>".$rad['sjekketUt']."</td>";  
        echo "</tr>";

        echo "<tr>";
        echo    "<th>TotalPris</th>";   
        echo    "<td>".$rad['totalPris']."</td>";  
        echo "</tr>";
    }
    echo "</table>";
}

function visAlleRegistrerteMatingerDetteOppholdet($dblink) {
    $inspiserHund = $_SESSION['inspiserHund']; 

    $idag = new DateTime();
    echo "<h3>" . "Registrerte matinger på dette oppholdet " . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>oID</th>";  
    echo    "<th>hund</th>";  
    echo    "<th>forType</th>";  
    echo    "<th>Mating</th>";       
    echo "</tr>";

    // SQLSpørring  
    $sql = " SELECT M.*, H.navn, F.forType FROM mating AS M, opphold AS O, hund AS H, hundefor AS F
    WHERE M.oppholdID = O.oppholdID
    AND O.hundID = H.hundID
    AND H.forID = F.forID
    AND O.oppholdID = '$inspiserHund' ;";
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['oppholdID'] . "</td>"; 
        echo "<td>" . $rad['navn']      . "</td>";    
        echo "<td>" . $rad['forType'] . "</td>";     
        $tidspunkt = $rad['tidspunkt'];  
        echo "<td>" . substr($tidspunkt,10,6) . "</td>";            
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

function visAlleRegistrerteLuftingerDetteOppholdet($dblink) {  
    $inspiserHund = $_SESSION['inspiserHund']; 

    $idag = new DateTime();
    echo "<h3>" . "Registrerte Luftinger på dette oppholdet" . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>oID</th>";  
    echo    "<th>hund</th>";  
    echo    "<th>start</th>";    
    echo    "<th>slutt</th>";    
    echo "</tr>";

    // SQLSpørring  
    $sql = " SELECT L.*, H.navn
    FROM lufting AS L, opphold AS O, hund AS H
    WHERE L.oppholdID = O.oppholdID
    AND O.hundID = H.hundID
    AND O.oppholdID = '$inspiserHund' ;";
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['oppholdID'] . "</td>"; 
        echo "<td>" . $rad['navn']      . "</td>";        
        $startTidspunkt = $rad['startTidspunkt'];  
        echo "<td>" . substr($startTidspunkt,10,6) . "</td>";  
        $sluttTidspunkt = $rad['sluttTidspunkt'];  
        echo "<td>" . substr($sluttTidspunkt,10,6) . "</td>";  
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

function visAlleRegistrerteKommentarerDetteOppholdet($dblink) { 
    $inspiserHund = $_SESSION['inspiserHund']; 

    $idag = new DateTime();
    echo "<h3>"."Registrerte kommentarer på dette oppholdet"."</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>oID</th>";  
    echo    "<th>hund</th>"; 
    echo    "<th>tidspunkt</th>";   
    echo    "<th>tekst</th>"; 
    echo "</tr>";

    // SQLSpørring 
    $sql = " SELECT K.*, H.navn 
    FROM hund AS H, opphold AS O, kommentar AS K 
    WHERE H.hundID = O.hundID 
    AND O.oppholdID = K.oppholdID 
    AND O.oppholdID = '$inspiserHund' ;";
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['oppholdID'] . "</td>"; 
        echo "<td>" . $rad['navn'] . "</td>";
        echo "<td>" . substr($rad['tidspunkt'],0,16) . "</td>";  
        echo "<td>" . $rad['tekst'] . "</td>"; 
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}


// ************************** 7c) Ansatt: Inn/utsjekk ************************** 
function visSkalSjekkeInnIDag($dblink) {
    $idag = new DateTime();
    echo "<h2>" . "Innsjekkinger i dag " . $idag->format('Y-m-d') . "</h2>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>bID</th>";  
    echo    "<th>hund</th>";  
    echo    "<th>kunde</th>";   
    echo    "<th>sjekketInn</th>";   
    echo "</tr>";

    $sql = " SELECT B.bestillingID, H.navn, BR.fornavn, BR.etternavn, B.sjekketInn 
    FROM opphold AS O, bestilling AS B, hund AS H, bruker AS BR       
    WHERE B.bestillingID = O.bestillingID  
    AND O.hundID = H.hundID 
    AND H.brukerID = BR.brukerID
    AND DAY(B.startDato) = DAY(CURRENT_TIMESTAMP)
    ORDER BY B.bestillingID ;"; 
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['bestillingID'] . "</td>";  
        echo "<td>" . $rad['navn']      . "</td>";    
        echo "<td>" . $rad['fornavn'] . " " . $rad['etternavn'] . "</td>";  
        echo "<td>" . substr($rad['sjekketInn'],11,5)      . "</td>";    
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

function lagSkalSjekkesInnTab($dblink) {
    // variabler
    $forigeBestillingID = "";
    $skalSjekkesInnTab = null;
    $pos = 0;

    /*$sql = " SELECT H.navn, BR.fornavn, BR.etternavn    */
    $sql = " SELECT B.bestillingID, H.navn
    FROM opphold AS O, bestilling AS B, hund AS H, bruker AS BR 
    WHERE B.bestillingID = O.bestillingID  
    AND O.hundID = H.hundID 
    AND H.brukerID = BR.brukerID
    AND DAY(B.startDato) = DAY(CURRENT_TIMESTAMP) 
    AND B.sjekketInn IS NULL ;";  
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        // bestillingID
        
        $bestillingID = $rad['bestillingID'];
        echo $bestillingID . "<br>";
        // er dette en ny bestilling?
        if ($forigeBestillingID !== $bestillingID) {
            //ny bestilling: lager et FerdigBestilling objekt
            $b1 = new FerdigBestilling($bestillingID);
            $skalSjekkesInnTab[$pos++] = $b1;
        }
        // resten
        $b1->setStartDato($rad['startDato']);
        $b1->setSluttDato($rad['sluttDato']);
        $b1->addHund($rad['navn']);
        $forigeBestillingID = $bestillingID;
    }
    return $skalSjekkesInnTab;
}

function sjekkInn($dblink) {
    if (isset($_POST['sjekkInnKnapp'])) { 
        ob_start();
        $bestillingID = $_POST['sjekkInnSelect'];
        $bestillingID = substr($bestillingID,0,1);

        $sql = "UPDATE bestilling SET sjekketInn = CURRENT_TIMESTAMP WHERE bestillingID = '$bestillingID' ;";
        mysqli_query($dblink,$sql);
        header("Refresh:0");
        ob_end_flush();
    }
}

function nullStillInnsjekkinger($dblink) {
    if (isset($_POST['nullstillInnsjekkingerKnapp'])) { 
        ob_start();
        $sql = "UPDATE bestilling SET sjekketInn = null ;";
        mysqli_query($dblink,$sql);
        header("Refresh:0");
        ob_end_flush();
    }
}

//sjekk Ut
function visSkalSjekkeUtIDag($dblink) {
    $idag = new DateTime();
    echo "<h2>" . "Utsjekkinger i dag " . $idag->format('Y-m-d') . "</h2>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>bID</th>";  
    echo    "<th>hund</th>";  
    echo    "<th>kunde</th>";   
    echo    "<th>sjekketUt</th>";   
    echo "</tr>";

    $sql = " SELECT B.bestillingID, H.navn, BR.fornavn, BR.etternavn, B.sjekketUt 
    FROM opphold AS O, bestilling AS B, hund AS H, bruker AS BR       
    WHERE B.bestillingID = O.bestillingID  
    AND O.hundID = H.hundID 
    AND H.brukerID = BR.brukerID
    AND DAY(B.sluttDato) = DAY(CURRENT_TIMESTAMP)
    ORDER BY B.bestillingID ;"; 
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['bestillingID'] . "</td>";  
        echo "<td>" . $rad['navn']      . "</td>";    
        echo "<td>" . $rad['fornavn'] . " " . $rad['etternavn'] . "</td>";  
        echo "<td>" . substr($rad['sjekketUt'],11,5)      . "</td>";    
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

function lagSkalSjekkesUtTab($dblink) {
    // variabler
    $forigeBestillingID = "";
    $skalSjekkesInnTab = null;
    $pos = 0;

    $sql = " SELECT B.bestillingID, H.navn
    FROM opphold AS O, bestilling AS B, hund AS H, bruker AS BR 
    WHERE B.bestillingID = O.bestillingID  
    AND O.hundID = H.hundID 
    AND H.brukerID = BR.brukerID
    AND DAY(B.sluttDato) = DAY(CURRENT_TIMESTAMP) 
    AND B.sjekketUt IS NULL ;";  
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        // bestillingID
        
        $bestillingID = $rad['bestillingID'];
        echo $bestillingID . "<br>";
        // er dette en ny bestilling?
        if ($forigeBestillingID !== $bestillingID) {
            //ny bestilling: lager et FerdigBestilling objekt
            $b1 = new FerdigBestilling($bestillingID);
            $skalSjekkesInnTab[$pos++] = $b1;
        }
        // resten
        $b1->setStartDato($rad['startDato']);
        $b1->setSluttDato($rad['sluttDato']);
        $b1->addHund($rad['navn']);
        $forigeBestillingID = $bestillingID;
    }
    return $skalSjekkesInnTab;
}

function sjekkUt($dblink) {
    if (isset($_POST['sjekkUtKnapp'])) { 
        ob_start();
        $bestillingID = $_POST['sjekkUtSelect'];
        $bestillingID = substr($bestillingID,0,1);

        $sql = "UPDATE bestilling SET sjekketUt = CURRENT_TIMESTAMP WHERE bestillingID = '$bestillingID' ;";
        mysqli_query($dblink,$sql);
        header("Refresh:0");
        ob_end_flush();
    }
}

function nullStillUtsjekkinger($dblink) {
    if (isset($_POST['nullStillUtsjekkingerKnapp'])) { 
        ob_start();
        $sql = "UPDATE bestilling SET sjekketUt = null ;";
        mysqli_query($dblink,$sql);
        header("Refresh:0");
        ob_end_flush();
    }
}

// ************************** 7d) Mating ************************** 
function visAlleHunderPaaOppholdNaa($dblink) {
    echo "<h3>" . "Alle hunder som er på opphold nå" . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>oID</th>";  
    echo    "<th>hund</th>";  
    echo    "<th>forType</th>";   
    echo "</tr>";

    $sql = " SELECT O.oppholdID, F.forType, H.navn FROM bestilling AS B, opphold AS O, hund AS H, hundefor AS F
    WHERE B.bestillingID = O.bestillingID
    AND O.hundID = H.hundID
    AND H.forID = F.forID
    AND day(B.startDato) <= day(CURRENT_TIMESTAMP) AND day(B.sluttDato) >= day(CURRENT_TIMESTAMP)
    AND B.sjekketInn IS NOT NULL
    AND B.sjekketUt IS NULL
    ORDER BY O.oppholdID  ;";
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['oppholdID'] . "</td>";  
        echo "<td>" . $rad['navn']      . "</td>";   
        echo "<td>" . $rad['forType'] . "</td>";           
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}


function visAlleRegistrerteMatingerIDag($dblink) {
    // alle registrerte matinger i dag 
    $idag = new DateTime();
    echo "<h3>" . "Registrerte matinger i dag " . $idag->format('Y-m-d') . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>oID</th>";  
    echo    "<th>hund</th>";  
    echo    "<th>forType</th>";  
    echo    "<th>Mating</th>";       
    echo "</tr>";

    // SQLSpørring for å finne alle registrerte matinger i dag 
    $sql = " SELECT M.*, H.navn, F.forType FROM mating AS M, opphold AS O, hund AS H, hundefor AS F
    WHERE M.oppholdID = O.oppholdID
    AND O.hundID = H.hundID
    AND H.forID = F.forID
    AND day(M.tidspunkt) = day(CURRENT_TIMESTAMP);";
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['oppholdID'] . "</td>"; 
        echo "<td>" . $rad['navn']      . "</td>";    
        echo "<td>" . $rad['forType'] . "</td>";     
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
        $oppholdIDTab = getAktiveOppholdIDer($dblink);
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

function getAktiveOppholdIDer($dblink) {
    $oppholdIDTab;
    $pos = 0;
    $sql = " SELECT O.oppholdID 
    FROM bestilling AS B, opphold AS O, hund AS H
    WHERE B.bestillingID = O.bestillingID 
    AND   O.hundID = H.hundID
    AND day(B.startDato) <= day(CURRENT_TIMESTAMP) 
    AND day(sluttDato) >= day(CURRENT_TIMESTAMP) 
    AND B.sjekketInn IS NOT NULL 
    AND B.sjekketUt IS NULL ;";
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


// ************************** 7e) Ansatt Lufting ************************** 
function visAlleHunderPaaOppholdNaaLufting($dblink) {
    echo "<h3>" . "Alle hunder som er på opphold nå" . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>oID</th>";  
    echo    "<th>hund</th>";  
    echo    "<th>løpeMedAndre</th>";   
    echo "</tr>";

    $sql = " SELECT O.oppholdID, F.forType, H.navn, H.løpeMedAndre FROM bestilling AS B, opphold AS O, hund AS H, hundefor AS F
    WHERE B.bestillingID = O.bestillingID
    AND O.hundID = H.hundID
    AND H.forID = F.forID
    AND day(B.startDato) <= day(CURRENT_TIMESTAMP) AND day(B.sluttDato) >= day(CURRENT_TIMESTAMP)
    AND B.sjekketInn IS NOT NULL
    AND B.sjekketUt IS NULL
    ORDER BY O.oppholdID  ;";
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['oppholdID'] . "</td>";  
        echo "<td>" . $rad['navn']      . "</td>";   
        $løpeMedAndre = $rad['løpeMedAndre'];
        if ($løpeMedAndre == 1) {
            $løpeMedAndre = "JA"; 
        }
        else {
            $løpeMedAndre = "NEI";  
        }
        echo "<td>" . $løpeMedAndre . "</td>";           
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}


function visAlleRegistrerteLuftingerIDag($dblink) {
    // alle registrerte matinger i dag 
    $idag = new DateTime();
    echo "<h3>" . "Registrerte Luftinger i dag " . $idag->format('Y-m-d') . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>oID</th>";  
    echo    "<th>hund</th>";  
    echo    "<th>start</th>";    
    echo    "<th>slutt</th>";    
    echo "</tr>";

    // SQLSpørring for å finne alle registrerte matinger i dag    
    $sql = " SELECT L.*, H.navn
    FROM lufting AS L, opphold AS O, hund AS H
    WHERE L.oppholdID = O.oppholdID
    AND O.hundID = H.hundID
    AND day(L.startTidspunkt) = day(CURRENT_TIMESTAMP);";
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['oppholdID'] . "</td>"; 
        echo "<td>" . $rad['navn']      . "</td>";        
        $startTidspunkt = $rad['startTidspunkt'];  
        echo "<td>" . substr($startTidspunkt,10,6) . "</td>";  
        $sluttTidspunkt = $rad['sluttTidspunkt'];  
        echo "<td>" . substr($sluttTidspunkt,10,6) . "</td>";  
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}


function registrerLuftingStartAlle($dblink) {
    if (isset($_POST['registrerLuftingStartAlle'])) { 
        //har vi allerede registrert lufting start i dag?
        $sql = "SELECT * FROM lufting WHERE day(startTidspunkt) = day(CURRENT_TIMESTAMP);" ;
        $resultat = mysqli_query($dblink, $sql); 
        $antall = mysqli_num_rows($resultat);
        if ($antall > 0) { 
            echo "Har allerede registrert lufting start i dag!";
        }
        else {
            // brukerNavn
            $bruker = $_SESSION['bruker'];
            $brukerID = $bruker->getBrukerID();
            // lager oppholdIDTab
            $oppholdIDTab = getAktiveOppholdIDer($dblink);
            // kjører gjennom hele oppholdIDTab og registrerer luftinger
            for ($i=0; $i<count($oppholdIDTab); $i++) {
                echo $oppholdIDTab[$i] . "<br>";
                $oppholdID = $oppholdIDTab[$i];
                $sql = "INSERT INTO lufting (startTidspunkt,oppholdID,brukerID)
                VALUES (CURRENT_TIMESTAMP,'$oppholdID','$brukerID');" ;
                mysqli_query($dblink,$sql);
            } 
            header("Refresh:0");
        }
    }
}

function registrerLuftingSluttAlle($dblink) {
    if (isset($_POST['registrerLuftingSluttAlle'])) { 
        echo "ass";
        // brukerID
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        // lager oppholdIDTab
        $oppholdIDTab = getErILuftegaardIDer($dblink);
        // kjører gjennom hele oppholdIDTab og registrerer luftinger
        for ($i=0; $i<count($oppholdIDTab); $i++) {
            echo $oppholdIDTab[$i] . "<br>";
            $oppholdID = $oppholdIDTab[$i];
            $sql = "UPDATE lufting 
            SET sluttTidspunkt = CURRENT_TIMESTAMP
            WHERE oppholdID = '$oppholdID' 
            AND day(startTidspunkt) = day(CURRENT_TIMESTAMP);" ;
            mysqli_query($dblink,$sql);
        } 
        header("Refresh:0");
    }
}

function getErILuftegaardIDer($dblink) {
    $oppholdIDTab;
    $pos = 0;
    $sql = " SELECT O.oppholdID 
    FROM bestilling AS B, opphold AS O, hund AS H, lufting AS L
    WHERE B.bestillingID = O.bestillingID 
    AND   O.hundID = H.hundID
    AND   O.oppholdID = L.oppholdID
    AND day(B.startDato) <= day(CURRENT_TIMESTAMP) 
    AND day(B.sluttDato) >= day(CURRENT_TIMESTAMP) 
    AND B.sjekketInn IS NOT NULL 
    AND B.sjekketUt IS NULL 
    AND day(L.startTidspunkt) = day(CURRENT_TIMESTAMP) ;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        $oppholdIDTab[$pos++] = $rad['oppholdID'];    
    } 
    return $oppholdIDTab;
}

// test !!!!!!!!!
function slettAlleLuftinger($dblink) {
    if (isset($_POST['slettAlle'])) { 
        $sql = "DELETE FROM lufting ;" ;
        mysqli_query($dblink,$sql);
    }  
}

// ************************** 7f) Kommentar ************************** 
function visAlleHunderPaaOppholdNaaKommentar($dblink) {
    echo "<h3>" . "Alle hunder som er på opphold nå" . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>oID</th>";  
    echo    "<th>hund</th>";  
    echo "</tr>";

    $sql = " SELECT O.oppholdID, H.navn FROM bestilling AS B, opphold AS O, hund AS H
    WHERE B.bestillingID = O.bestillingID
    AND O.hundID = H.hundID
    AND day(B.startDato) <= day(CURRENT_TIMESTAMP) AND day(B.sluttDato) >= day(CURRENT_TIMESTAMP)
    AND B.sjekketInn IS NOT NULL
    AND B.sjekketUt IS NULL
    ORDER BY O.oppholdID  ;";
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['oppholdID'] . "</td>";  
        echo "<td>" . $rad['navn']      . "</td>";             
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}


function lagHunderPaaOppholdNaaTab($dblink) {
    $hunder;
    $pos = 0;

    $sql = " SELECT O.oppholdID, F.forType, H.navn 
    FROM bestilling AS B, opphold AS O, hund AS H, hundefor AS F 
    WHERE B.bestillingID = O.bestillingID
    AND O.hundID = H.hundID
    AND H.forID = F.forID
    AND day(B.startDato) <= day(CURRENT_TIMESTAMP) AND day(B.sluttDato) >= day(CURRENT_TIMESTAMP)
    AND B.sjekketInn IS NOT NULL
    AND B.sjekketUt IS NULL
    ORDER BY O.oppholdID ;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        $hunder[$pos++] = $rad['oppholdID']." ".$rad['navn'];
    }
    return $hunder;
}

function registrerKommentar($dblink) {
    if (isset($_POST['registrerKommentarKnapp'])) { 
        $tekst = $_POST['kommentarText'];
        $oppholdID = $_POST['velgHundSelect'];
        $brukerID = $_SESSION['bruker']->getBrukerID();
        $sql = "INSERT INTO kommentar(tekst,tidspunkt,oppholdID,brukerID) 
        VALUES ('$tekst',CURRENT_TIMESTAMP,'$oppholdID','$brukerID');";
        $resultat = mysqli_query($dblink, $sql);
        echo "<br>".'<i style="color:green; position:absolute";"> Kommentar registrert </i>';
    }
}

function visAlleRegistrerteKommentarIDag($dblink) {   
    $idag = new DateTime();
    echo "<h3>" . "Registrerte kommentarer i dag " . $idag->format('Y-m-d') . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTabSmal\">";
    echo "<tr>";
    echo    "<th>oID</th>";  
    echo    "<th>hund</th>"; 
    echo    "<th>tidspunkt</th>";   
    echo    "<th>tekst</th>"; 
    echo "</tr>";

    // SQLSpørring for å finne alle registrerte kommentarer i dag    
    $sql = " SELECT K.*, H.navn 
    FROM hund AS H, opphold AS O, kommentar AS K 
    WHERE H.hundID = O.hundID 
    AND O.oppholdID = K.oppholdID 
    AND day(K.tidspunkt) = day(CURRENT_TIMESTAMP);";
    $resultat = mysqli_query($dblink, $sql); 

    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['oppholdID'] . "</td>"; 
        echo "<td>" . $rad['navn'] . "</td>";
        echo "<td>" . substr($rad['tidspunkt'],0,16) . "</td>";  
        echo "<td>" . $rad['tekst'] . "</td>"; 
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

// ************************** 7i) Ansatt Anmeldelser ************************** 
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

// ************************** 7j) Ansatt Logg ************************** 
function visAvbestilteOpphold($dblink)  {  
    echo "<table class=\"blaaTab\">";
    echo "<tr>";
    echo    "<th>startDato</th>";
    echo    "<th>sluttDato</th>";
    echo    "<th>bestiltDato</th>";
    echo    "<th>totalPris</th>";
    echo    "<th>brukerID</th>";
    echo "</tr>";

    $sql = "SELECT * FROM slettetBestilling ;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>"; 
        echo "<td>" . $rad['startDato'] . "</td>"; 
        echo "<td>" . $rad['sluttDato'] . "</td>"; 
        echo "<td>" . $rad['bestiltDato'] . "</td>"; 
        echo "<td>" . $rad['totalPris'] . "</td>"; 
        echo "<td>" . $rad['brukerID'] . "</td>"; 
        echo "</tr>";
    }
    echo "</table>";

}




























































// ************************** 9) Admin -> a) Bruker admin ************************** 
function visAlleBrukere($dblink)  {     
    $brukertype = $_SESSION['adminSeBrukertype'];
    $sql = "SELECT * FROM bruker WHERE brukertype = '$brukertype' ;";
    $resultat = mysqli_query($dblink, $sql); 
    
    echo "<table class=\"blaaTab\">";
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

// ************************** 9) Admin -> b) registrerNyBruker ************************** 
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

// ************************** 9) Admin -> c) endre Bruker ************************** 
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
        header("Refresh:0");
    }
}

// ************************** 9) Admin -> d) slett Bruker ************************** 
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

// ************************** 9) Admin -> e) gjennoprett Bruker **************************
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

function gjennoprettBruker($dblink) {
    if (isset($_POST['velgGjennoprettBrukerKnapp'])) { 
        $brukerID = $_POST['velgGjennoprettBrukerSelect'];
        $sql = "UPDATE bruker SET slettetDato = null WHERE brukerID = '$brukerID' ;";
        $resultat = mysqli_query($dblink, $sql);
        echo "kontoen er gjennoprettet ";
        header("Refresh:0");
    }
}

// ************************** 9) Admin -> f) visPrisHistorikk**************************
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

// ************************** 10) Min Side **************************
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

// ************************** 10) minSide -> a)endre brukerinfo **************************
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

// ************************** 10) minSide -> b)endrePassord **************************
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

// ************************** 10) minSide -> c) slettKonto **************************
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

// ************************** 10) minSide -> registrerHund **************************
//denne funskjonen er allerede laget under bestill opphold

// ************************** 10) minSide -> d) endre hund1  **************************
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

// ************************** 10) minSide -> e) endre hund2 **************************
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

// ************************** 10) minSide -> f) avbestill bestilling ************************** 
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

// ************************** 10) Min side -> g) Skriv anmeldelse **************************
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


// ************************** 11) Logg Inn **************************
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
                echo "<br>".'<i style="color:red; position:absolute";"> feil epost og/eller passord! </i>'; 
            }
            $_SESSION['adminSeBrukertype'] = "kunde";
        }        
    }     
}

function opprettBrukerSession($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
$tlf, $adresse, $fødselsNr, $stilling, $postNr) {
    $bruker = new Bruker($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
    $tlf, $adresse, $fødselsNr, $stilling, $postNr);
    $_SESSION['bruker'] = $bruker;
}

// ************************** 12) Registrer deg **************************
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
            //echo "<br>".'<i style="color:red; position:absolute";"> epost er allerede registrert! </i>'; 
        }

        //registrerer ny bruker
        else {
            $sql = "INSERT INTO bruker(epost,passord,brukerType,fornavn,etternavn,tlf,adresse) 
                    VALUES ('$epost','$passord','$brukerType','$fornavn','$etternavn','$tlf','$adresse');";
            $resultat = mysqli_query($dblink, $sql);
            loggInn($dblink);
        }
    }
}

//test
function lagreInnlegg($dblink) {
    if (isset($_POST['lagreInnleggKnapp'])) { 
        $navn = "aktuelt";
        $innleggOverskrift = $_POST['innleggOverskrift'];
        $innleggText = $_POST['innleggText'];
        $tekst = "<div class=\"mellomromMellomInnlegg\">"."<h2>".$innleggOverskrift."</h2>".  
        "<p>".$innleggText."</p>"."</div>"."<hr>";
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        $sql = "INSERT INTO innlegg(navn,tekst,brukerID) VALUES ('$navn','$tekst','$brukerID') ;";
        mysqli_query($dblink, $sql);
    }
}

function visAlleInnlegg($dblink) {
    $sql = "SELECT * FROM innlegg ;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)) {
        echo $rad['tekst'];
    }
}

/*
// ********************* Gunni - Min side - Tabeller ********************* 

// Min profil tabell 
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
        echo "</table>";
    } 
}

//Mine hunder tabell
function mineHunderTab($dblink) {
    
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
            echo "<tr>";
                echo "<th class=\"thKolonne\">Kjønn</th>";
                echo "<td>". $rad['kjønn'] . "</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Sterilisert</th>";
                echo "<td>". $rad['sterilisert']. "</td>";
             echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Kan omgås andre hunder</th>";
                echo "<td>". $rad['løpeMedAndre'] . "</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Fòrtype</th>";
                echo "<td>". $rad['forID'] . "</td>";    
            echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Ekstra informasjon</th>";
                echo "<td>". $rad['info'] . "</td>";
            echo "</tr>";
        echo "</table>";
    } 
}

// Mine opphold tabell
function mineOppholdTab($dblink) {
    
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
            echo "<th class=\"thKolonne\">Start</th>";
                echo "<td>". $rad['startDato'] ."</td>";
                echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Slutt</th>";
                echo "<td>". $rad['sluttDato'] . "</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Bestilt</th>";
                echo "<td>". $rad['bestiltDato'] . "</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Betalt</th>";
                echo "<td>". $rad['betaltDato'] . "</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Totalpris</th>";
                echo "<td>". $rad['totalPris']. "</td>";
             echo "</tr>";
            echo "<tr>";
                echo "<th class=\"thKolonne\">Hund</th>";
                echo "<td>". $rad['HundID'] . "</td>";
            echo "</tr>";
        echo "</table>";
    } 
}



ob_end_flush();

/*
Kilder
password hashing: https://www.w3schools.com
password hashing: https://www.youtube.com/watch?v=Q-fBhFTe2H8
password hashing: https://www.w3schools.com
*/
