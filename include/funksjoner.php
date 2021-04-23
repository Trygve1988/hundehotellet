<?php
/* ************************** 0) Alle: a) konstanter ************************** */
// øverst i include/funksjoner.php
//koble på itfag databasen
define("TJENER",  "itfag.usn.no");
define("BRUKER",  "h20APP2000gr5");
define("PASSORD", "pw5");
define("DB",      "h20APP2000grdb5");

/* ************************** 0) Alle: b) SESSION ************************** */
function opprettBrukerSession($brukerID,$epost,$passord,$brukerType) {
    $_SESSION['brukerID'] = $brukerID;
    $_SESSION['epost'] = $epost;
    $_SESSION['passord'] = $passord;
    $_SESSION['brukerType'] = $brukerType;
    echo "oprettet bruker-session " . $_SESSION['brukerID'] . " - " . $_SESSION['epost'] . 
    $_SESSION['passord'] . " - " . $_SESSION['brukerType'] . "<br>" ;
}

function opprettHundSession($hundID,$navn) { 
    $_SESSION['hundID'] = $hundID;
    $_SESSION['navn'] = $navn;
    echo "oprettet hund-session " . $_SESSION['hundID'] . " - " . $_SESSION['navn'] . "<br>" ; 
}

function opprettBestillingSession($startDato, $sluttDato, $sumÅBetale) { 
    $_SESSION['startDato'] = $startDato;
    $_SESSION['sluttDato'] = $sluttDato;
    $_SESSION['sumÅBetale'] = $sumÅBetale;
    echo "oprettet bestilling-session fra: " . $_SESSION['startDato'] . " - til: " . 
    $_SESSION['sluttDato'] . " - " . $_SESSION['sumÅBetale'] . "kr " . "<br>" ; 
}

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
        <a href="index.php"> <img  class="logo" src="bilder/logo.png"> Bø Hundehotell </a>
        <a href="index.php">Hjem</a>
        <a href="aktuelt.php">Aktuelt</a>
        <a href="omOss.php">Om Oss</a>
        <a href="priser.php">Priser</a>
        <a href="KontaktOss.php">Kontakt Oss</a>
        
         <?php
        // bestill Opphold
        if (erLoggetInn()) {
            ?> <a href="bestillOpphold.php">Bestill Opphold</a> <?php 
        }
        else {
            ?> <a href="loggInn.php">Bestill Opphold</a> <?php
        } 
        // anmeldelser 
        if (erAnsatt()) {
            ?> <a href="anmeldelser.php">Anmeldelser</a> <?php 
        }
        // admin
        if (erAdmin()) {
            ?> <a href="admin.php">Admin</a> <?php 
        } 
        // minSide loggUt / loggInn registrerDeg
        if (erLoggetInn()) {
             ?> <a class="right" href="minSide.php">Min Side</a> <?php 
             ?> <a class="right" href="loggUt.php">Logg Ut</a> <?php
        }
        else {
            ?> <a class="right" href="loggInn.php">Logg Inn</a> <?php
            ?> <a class="right" href="registrerDeg.php">Registrer Deg</a> <?php
        } ?>
    </div><?php
}

function erLoggetInn() {
    return ( isset($_SESSION['epost']) );
}

function erAnsatt() {
    $erAnsatt = false;
    if (isset($_SESSION['epost'])) {
        if ( ($_SESSION['brukerType'] == "ansatt") || ($_SESSION['brukerType'] == "admin") ) {
            $erAnsatt = true;
        }
    }
    return $erAnsatt;
}

function erAdmin() {
    $erAdmin = false;
    if (isset($_SESSION['epost'])) {
        if ($_SESSION['brukerType'] == "admin") {
            $erAdmin = true;
        }
    }
    return $erAdmin;
}

/* ************************** 0) Alle: e) bunn ************************** */ 
function visToppKnapp() { 
    ?> 

    <!--sett tilToppKnappen din inn her kristina -->
    <!-- gratis Opp ikon fra https://fontawesome.com/icons/chevron-up?style=solid-->
    <button onclick="toppKnappFunksjon()" id="Knappen" title="Gå til toppen"><i class="fas fa-chevron-up"></i> </button>  
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
                <strong> Epost:</strong><a href="mailto:bohundehotell@example.com">bohundehotell.@example.com</a><br>    
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
// ************************** 5) Bestill Opphold 1 - velg hund ************************** /**//
function laghunderTab($dblink) {
    $brukerID = $_SESSION['brukerID'];
    $sql = "SELECT * FROM hund WHERE brukerID = '$brukerID';";
    $resultat = mysqli_query($dblink, $sql); 

    $hunder = array();
    $pos = 0;
    while($rad = mysqli_fetch_assoc($resultat)) {
        $hunder[$pos++] = $rad['navn'];
    }
    $pos = 0; 
    return $hunder;
}

function lagOption($hund) {
    ?> <option value= <?php echo $hund?> > <?php echo $hund?> </option><?php
}

function velgHund($dblink) {
    if (isset($_POST['neste'])) { 
        //får tak i hundID ut ifra $brukerID og $navn  IKKE PERFEKT LØSNING!
        $navn = $_POST['hund']; 
        $brukerID = $_SESSION['brukerID'];
        $sql = "SELECT hundID FROM hund WHERE navn = '$navn' AND brukerID = '$brukerID' ;"; 
        $resultat = mysqli_query($dblink, $sql); 
        while($rad = mysqli_fetch_assoc($resultat)) {
            $hundID = implode($rad);
        }
        opprettHundSession($hundID,$navn);
        header('Location: bestillOpphold2.php');
    }
}



// ************************** 5) Bestill Opphold 2 - registrer/ oppdater HundInfo  ************************** /**//
// a) overskift
function bestillOpphold2Overskrift() {
    if ( erNyHund() ) {
        echo "<h3>Skriv inn informasjon om hunden din</h3>"; 
    }
    else {
        echo "<h3>Opdater informasjon om hunden din</h3>";
    }
}

// b) autofyll
function autofyllHund($variabel,$dblink) {
    if (isset($_SESSION['hundID'])) { 
        $hundID = $_SESSION['hundID'];
        $sql = "SELECT * FROM hund WHERE hundID = '$hundID'";
        $resultat = mysqli_query($dblink, $sql);
        while($rad = mysqli_fetch_assoc($resultat)){
            $svar = $rad[$variabel]; 
        }
        echo "value=" . $svar;
    }
    else {
        echo "value=" . "eksempel-". $variabel; 
    }
}

function autofyllHundKjønn($variabel,$dblink) {
    $hundID = $_SESSION['hundID'];
    $sql = "SELECT * FROM hund WHERE hundID = '$hundID'";
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)){
        $kjønn = $rad[$variabel]; 
    }
    if ($kjønn == "gutt") { 
        echo "<option selected=\"selected\" value=\"gutt\"> gutt </option>";
        echo "<option value=\"jente\"> jente </option>";
    }
    else { 
        echo "<option value=\"gutt\"> gutt </option>";
        echo "<option selected=\"selected\"value=\"jente\"> jente </option>";
    } 
}

function autofyllHundBoolsk($variabel,$dblink) {
    $hundID = $_SESSION['hundID'];
    $sql = "SELECT * FROM hund WHERE hundID = '$hundID'";
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)){
        $tall = $rad[$variabel]; 
    }
    if ($tall == 1) { 
        echo "<option selected=\"selected\" value=\"1\">ja</option>";
        echo "<option value=\"0\">nei</option>";
    }
    else { 
        echo "<option value=\"1\">ja</option>";
        echo "<option selected=\"selected\"value=\"0\">nei</option><?php";
    } 
    echo "<option value=\"0\">usikker</option>";
}

function autofyllHundFortype($variabel,$dblink) {
    $hundID = $_SESSION['hundID'];
    $sql = "SELECT * FROM hund WHERE hundID = '$hundID'";
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)){
        $forID = $rad[$variabel]; 
    }
    if ($forID == "1") { 
        echo "<option selected=\"selected\" value=\"1\"> Normal-for </option>";
        echo "<option value=\"2\"> Allergi-for </option>";
    }
    else { 
        echo "<option value=\"1\"> Normal-for </option>";
        echo "<option selected=\"selected\"value=\"2\"> Allergi-for </option><?php";
    } 
}

function autofyllHundInfo($variabel,$dblink) {
    if (isset($_SESSION['hundID'])) { 
        $hundID = $_SESSION['hundID'];
        $sql = "SELECT * FROM hund WHERE hundID = '$hundID'";
        $resultat = mysqli_query($dblink, $sql);
        while($rad = mysqli_fetch_assoc($resultat)){
            $info = $rad[$variabel]; 
        }
        echo $info;
    }
}

function datoIMorgen() {
    $date = new DateTime();
    $date->modify('+1 day');
    echo $date->format('Y-m-d');
}

function datoOmEttAar() {
    $date = new DateTime();
    $date->modify('+1 year');
    echo $date->format('Y-m-d');
}

// c) bekreftHundInfo
function bekreftHundInfo($dblink) {
    if (isset($_POST['neste'])) { 
        //registrer eller oppdater hund
        /*
        if ( erNyHund() ) {
            registrerHund($dblink);
        }
        else {
            oppdaterHund($dblink);
        } */
        header('Location: bestillOpphold3.php');
    }
}

function registrerHund($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {   
        $navn = $_POST['navn'];
        $rase = $_POST['rase'];
        $fdato = $_POST['fdato'];
        $kjønn = $_POST['kjønn'];
        $sterilisert = $_POST['sterilisert'];
        $vaksniert = $_POST['vaksniert'];
        $løpeMedAndre = $_POST['løpeMedAndre'];
        $løsPåTur = $_POST['løsPåTur'];
        $info = $_POST['info'];
        $brukerID = $_SESSION['brukerID'];
        $forID = $_POST['forID'];

        $sql = "INSERT INTO hund(navn,rase,fdato,kjønn,sterilisert,vaksniert,løpeMedAndre,løsPåTur,info,brukerID,forID)
        VALUES ('$navn','$rase','$fdato','$kjønn','$sterilisert','$vaksniert','$løpeMedAndre','$løsPåTur','$info','$brukerID','$forID');";
        $resultat = mysqli_query($dblink, $sql);

        //$sql = "INSERT INTO hund(navn,rase,fdato,kjønn,sterilisert,brukerID,forID)
        //VALUES ('$navn','$rase','$fdato','$kjønn','$sterilisert','$brukerID','$forID');";
        //$resultat = mysqli_query($dblink, $sql);

        //får tak i hundID
        $sql = "SELECT MAX(hundID) FROM hund;"; 
        $resultat = mysqli_query($dblink, $sql); 
        while($rad = mysqli_fetch_assoc($resultat)) {
            $hundID = implode($rad);
        }

        opprettHundSession($hundID,$navn); 

        echo "brukerID " . $brukerID . "<br>";
        echo "forID " . $forID . "<br>";
        
        echo "hund " . $hundID . " - ". $navn . " registrert" . "<br>";
    }
}

function oppdaterHund($dblink) {
    $hundID = $_SESSION['hundID'] ;
    $navn = $_POST['navn'];
    $rase = $_POST['rase'];
    $fdato = $_POST['fdato'];
    $kjønn = $_POST['kjønn'];
    $sterilisert = $_POST['sterilisert'];
    $vaksniert = $_POST['vaksniert'];
    $løpeMedAndre = $_POST['løpeMedAndre'];
    $løsPåTur = $_POST['løsPåTur'];
    $info = $_POST['info'];
    $brukerID = $_SESSION['brukerID'];
    $forID = $_POST['forID'];

    $sql = "UPDATE hund SET navn = '$navn', rase = '$rase', fdato = '$fdato', kjønn = '$kjønn',
    sterilisert = '$sterilisert', vaksniert = '$vaksniert', løpeMedAndre = '$løpeMedAndre', løsPåTur = '$løsPåTur',
    info = '$info', brukerID = '$brukerID', forID = '$forID' WHERE hundID = $hundID;";
    $resultat = mysqli_query($dblink, $sql);
    opprettHundSession($hundID,$navn);
    echo "hund " . $hundID . " - ". $navn . " oppdatert" . "<br>";
}

// d) hjelpefunksjoner
function erNyHund() {
    $nyHund = false;
    //er dette en helt ny hund?
    $navn = $_SESSION['navn'];
    if ($navn == "+ Registrer ny Hund") { 
        $nyHund = true;
    }
    return $nyHund;
}

// ************************** 5) Bestill Opphold 3 - velg Datoer og bading ************************** /**//
function bekreftDatoer($dblink) {
    if (isset($_POST['bekreftDatoer'])) { 
        $startDato = $_POST['startDato']; 
        $sluttDato = $_POST['sluttDato'];
        $sumÅBetale = sumÅBetale($dblink,$startDato,$sluttDato);
        opprettBestillingSession($startDato, $sluttDato, $sumÅBetale);
        header('Location: bestillOpphold4.php');
    }
}

function sumÅBetale($dblink,$startDato,$sluttDato) {
    //finner dagPrisen
    $sql = "SELECT beløp FROM pris WHERE beskrivelse=\"dagPris\";"; 
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)) {
        $dagPris = implode($rad);
    }
    //finner antall dager
    $datetime1 = new DateTime($startDato);
    $datetime2 = new DateTime($sluttDato);
    $antDager = $datetime1->diff($datetime2);
    $antDager = $antDager->format('%a');
    // kilde http://php.kambing.ui.ac.id/manual/en/datetime.diff.php
    //finner totalPris
    return $dagPris * $antDager;
}


// ************************** 5) Bestill Opphold 4 - betalingsinfo ************************** /**//
function bestilling($dblink) {
    if (isset($_POST['bestill'])) { 
        $startDato = $_SESSION['startDato'];
        $sluttDato = $_SESSION['sluttDato'];
        $bestiltDato = date("Y/m/d");
        $totalPris = $_SESSION['sumÅBetale'];
        
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

        // setter ny rad inn i opphold
        $hundID = $_SESSION['hundID'] ;
        $burID = 1; //!!!!!!!
        $sql = "INSERT INTO opphold(hundID,burID)
        VALUES ('$hundID','$burID');";
        $resultat = mysqli_query($dblink, $sql); 

        // tilbakemelding
        $navn = $_SESSION['navn'];
        echo "bestilling til hund " . $hundID. " - ". $navn. " registrert (bur:" . $burID .") <br>";
    }
}

// ************************** 6) Alle Opphold **************************
// ikke begynte O.startDato > CURRENT_TIMESTAMP
// pågående O.startDato < CURRENT_TIMESTAMP AND sluttDato > CURRENT_TIMESTAMP;";
// ferdige O.startDato < CURRENT_TIMESTAMP AND O.sluttDato < CURRENT_TIMESTAMP;";

// ************************** 7) Anmeldelser **************************
// ************************** 8) Admin **************************
// ************************** 9) Min Side **************************
function visInnloggetInfo($dblink) {
    if (isset($_SESSION['epost'])) {
        echo "<h2> Min profil </h2>";
        $epost = $_SESSION['epost'];
        $sql = "SELECT * FROM bruker WHERE epost = '$epost';";
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
        echo    "<th>fødselsNr</th>";
        echo    "<th>stilling</th>";
        echo    "<th>postNr</th>";
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
            echo "<td>" . $rad['fødselsNr'] . "</td>"; 
            echo "<td>" . $rad['stilling'] . "</td>"; 
            echo "<td>" . $rad['postNr'] . "</td>"; 
            echo "</tr>";
        }
        echo "</table>" . "<br>";
    } 
}

function visMineHunder($dblink) {
    echo "<h2> Mine registrerte hunder </h2>";
    $brukerID = $_SESSION['brukerID'];
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
    echo    "<th>vaksniert</th>";
    echo    "<th>løpeMedAndre</th>";
    echo    "<th>løsPåTur</th>";
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
        echo "<td>" . $rad['vaksniert'] . "</td>";
        echo "<td>" . $rad['løpeMedAndre'] . "</td>";
        echo "<td>" . $rad['løsPåTur'] . "</td>";
        echo "<td>" . $rad['info'] . "</td>";
        echo "<td>" . $rad['brukerID'] . "</td>";
        echo "<td>" . $rad['forID'] . "</td>";
        echo "</tr>";
    }
    echo "</table>" . "<br>";;
}

function visBestillinger($dblink) {
    echo "<h2> Mine bestillinger </h2>";
    echo "<table>";
    echo "<tr>";
    echo    "<th>bestillingID</th>";
    echo    "<th>startDato</th>";
    echo    "<th>sluttDato</th>";
    echo    "<th>bestiltDato</th>";
    echo    "<th>betaltDato</th>";
    echo    "<th>totalPris</th>";
    echo    "<th>hundID</th>";
    echo "</tr>";

    //lager tabell med brukeren sine hundIDer
    $brukerID = $_SESSION['brukerID'];
    $sql = "SELECT * FROM hund WHERE brukerID = '$brukerID';";
    $resultat = mysqli_query($dblink, $sql); 

    $hundIDTab = array();
    $pos = 0;
    while($rad = mysqli_fetch_assoc($resultat)){
        $hundIDTab[$pos++] = $rad['hundID']; 
    }

    //finner alle bestillinger
    for ($i=0; $i<count($hundIDTab); $i++) {
        //$sql = "SELECT * FROM bestilling  ;";
        $sql = "SELECT B.*, O.hundID
                FROM bestilling AS B, opphold AS O 
                WHERE B.oppholdID = O.oppholdID
                AND   O.hundID = '$hundIDTab[$i]' ;" ;
                
        $resultat = mysqli_query($dblink, $sql); 
        while($rad = mysqli_fetch_assoc($resultat)){
            echo "<tr>";
            echo "<td>" . $rad['oppholdID'] . "</td>"; 
            echo "<td>" . $rad['startDato'] . "</td>";
            echo "<td>" . $rad['sluttDato'] . "</td>";
            echo "<td>" . $rad['bestiltDato'] . "</td>";
            echo "<td>" . $rad['betaltDato'] . "</td>";
            echo "<td>" . $rad['totalPris'] . "</td>";
            echo "<td>" . $rad['hundID'] . "</td>";
            echo "</tr>";
        }    
    }
    echo "</table>" . "<br>";
}

// ************************** 9) minSide -> a)endre brukerinfo **************************
// ************************** 10) Logg Inn **************************
function loggInn($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $epost = $_POST['epost'];
        $passord = $_POST['passord'];
        $innloggingOk = false;
        $stmt = $dblink->prepare("SELECT brukerID,epost,passord,brukerType FROM bruker WHERE (epost) = (?)");
        $stmt->bind_param("s", $_POST['epost']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($brukerID, $epost, $hashPw, $brukerType);
        
        if ($stmt->num_rows == 1) {    
            $stmt->fetch();
            if (password_verify($passord, $hashPw))   {
                opprettBrukerSession($brukerID,$epost,$pw,$brukerType);
                header('Location: bestillOpphold.php');
                $innloggingOk = true;
            } 
        }  
        if($innloggingOk == false) {
            echo "<br>".'<i style="color:red; position:absolute";"> feil epost og/eller passord! </i>'; 
        }
    }
}

// ************************** 11) Registrer deg **************************
function registrerDeg($dblink) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $epost = $_POST['epost'];
        $passord = $_POST['passord'];
        $passord = password_hash($passord, PASSWORD_DEFAULT);
        $brukerType = "kunde"; //!!!!!!!!!!!!
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
            header('Location: bestillOpphold.php');
        }
    }
}

/*
Kilder
password hashing: https://www.w3schools.com

password hashing: https://www.youtube.com/watch?v=Q-fBhFTe2H8

password hashing: https://www.w3schools.com

        $sql = "INSERT INTO innlegg(navn,tekst,brukerID)  
        VALUES ('$navn','$tekst','$brukerID');";

*/
