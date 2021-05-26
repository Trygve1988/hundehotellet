<?php
ob_start();
include_once "domeneklasser/Bruker.php";
include_once "domeneklasser/Hund.php";
include_once "domeneklasser/Bestilling.php";
include_once "domeneklasser/FerdigBestilling.php";

/* ************************** 0) Alle: a) konstanter ************************** */
// Konstanter som vi bruker til å koble på databasen på itfag.usn.no
define("TJENER",  "itfag.usn.no");
define("BRUKER",  "h20APP2000gr5");
define("PASSORD", "pw5");
define("DB",      "h20APP2000grdb5");

/* ************************** 0) Alle: b) SESSIONS ************************** */
// Oversikt over sessionsvariabler og hvor de opprettes
// $bruker = $_SESSION['bruker'];               ( 10) Logg Inn)
// $valgteHunder = $_SESSION['valgteHunder'];   ( 6) Bestill Opphold 2  oppdater Hunder)
// $pos = $_SESSION['valgteHunderPos'];         ( 6) Bestill Opphold 2  oppdater Hunder)
// $_SESSION['aktivHund'] = $hund;              ( 6) Bestill Opphold 2  oppdater Hunder)
// $_SESSION['bestilling'] =  $bestilling;      ( 6) Bestill Opphold 3 - velg Datoer)
// $_SESSION['endreBruker']                     (  9) Admin -> c) endre Bruker
// $_SESSION['adminSeBrukertype']               (  9) Admin 

/* ************************** 0) Alle: c) database ************************** */ 
// Funksjon for å koble på databasen
function kobleOpp() {
    $dblink = mysqli_connect(TJENER, BRUKER, PASSORD, DB);
    if (!$dblink) {
        die('Klarte ikke å koble til databasen: ' . mysqli_error($dblink));
    }
    mysqli_set_charset($dblink, 'utf8');
    return $dblink;
}

// Funksjon for å koble fra databasen
function lukk($dblink) {
    mysqli_close($dblink);
}


/* ************************** 0) Alle: d) topp ************************** */ 
// Inneholder funksjoner for å lage HTML elementer som skal brukes på mange sider.

// Funksjon som lager standard navbar på alle sidene 
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
            ?> <a id="alleOppholdLink" href="ansattAlleOpphold.php">Ansatt side</a> <?php
            
        }
        // admin
        if (erAdmin()) {
           ?> <a href="admin.php">Admin side</a> <?php 
        }
        // minSide loggUt / loggInn registrerDeg
        if (erLoggetInn()) {
             ?> <a id="minSideLink" class="right" href="minSide.php">Min Side</a> <?php 
             ?> <a id="loggUtLink" class="right" href="loggUt.php">Logg Ut</a> <?php
        }
        else {
            ?> <a id="loggInnLink" class="right" href="loggInn.php">Logg Inn</a> <?php
            ?> <a id="registrerDegLink" class="right" href="registrerDeg.php">Registrer Deg</a> <?php
        } ?>
        <!-- spraakKnapp--> 
        <img id="spraakKnapp" class="right" src="bilder/FlaggNO.png" alt="Change language">
    </div><?php
}

// Funksjon som lager admin under-navbar på alle admin sidene 
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

// Funksjon som lager ansatt under-navbar på alle ansatt sidene 
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

// Funksjon for å sjekke om brukeren er logget inn
function erLoggetInn() {
    return ( isset($_SESSION['bruker']) );
}

// Funksjon for å sjekke om brukeren er en ansatt
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

// Funksjon for å sjekke om brukeren er en admin
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
// Funksjon som lager ToppKnapp på alle sidene. Toppknappen gjør at man lett kan navigere til Toppen av siden
function visToppKnapp() { 
    ?> 
    <!-- gratis Opp ikon fra https://fontawesome.com/icons/chevron-up?style=solid-->
    <button onclick="toppKnappFunksjon()" id="tilToppKnapp" title="Gå til toppen"><i class="fas fa-chevron-up"></i> </button>  
    <script src="./include/toppknappen.js"></script>
    <?php 
}

// Funksjon som lager Footer på alle sidene.
function visFooter() { 
    ?>
    <!--sett footeren din inn her kristina -->
    <footer class="main-footer">
        <div class="venstre">
            <h1 id="navkontaktInformasjon">Kontakinformsjon</h1>
            <p>Bø Hundehotell</p>
            <p><strong>Tlf:</strong><a href="tel:+12345678"> +4712345678</a> </p>
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

// ************************** 0) alle **************************
//  Funksjon som lager option elementer til valgbokser
function lagOption($verdi) {
    ?> <option value= <?php echo $verdi?> > <?php echo $verdi?> </option><?php
}

//  Funksjon for å registrer en Hund. Brukes på bestillOpphold og minSide
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

// Funksjon for å lage et hund-objekt og legge det til sessionen "aktivHund"
// Når brukeren skal bestille opphold lagres alle hundene som er valgt i sessionen "valgteHunder"
// alle hundene i "valgteHunder" blir satt som "aktivHund" en etter en når hunden skal oppdateres
// Brukes også på min side når brukeren har valgt hund som skal endres
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


// ************************** 1) Index **************************
// ************************** 2) Aktuelt  **************************
function lagreInnlegg($dblink) {
    if (isset($_POST['lagreInnleggKnapp'])) { 
        $dato = new DateTime();
        $dato = $dato->format('Y-m-d');
        $navn = "aktuelt";
        $innleggOverskrift = $_POST['innleggOverskrift'];
        $innleggText = $_POST['innleggText'];
        $tekst = "<div class=\"mellomromMellomInnlegg\">"."<h3>".$innleggOverskrift."</h3>".  
        "<p>".$innleggText."</p>"."<p>".$dato."</p>"."</div>"."<hr>";
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        $sql = "INSERT INTO innlegg(navn,tekst,brukerID) VALUES ('$navn','$tekst','$brukerID') ;";
        mysqli_query($dblink, $sql);
    }
}

function visAlleInnlegg($dblink) {
    $sql = "SELECT * FROM innlegg 
    ORDER BY innleggID DESC ;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)) {
        echo $rad['tekst'];
    }
}

function slettInnlegg($dblink) {
    if (isset($_POST['slettInnleggKnapp'])) { 
        $sql = "DELETE FROM innlegg
        ORDER BY innleggID DESC
        LIMIT 1 ;";
        $resultat = mysqli_query($dblink, $sql);
        header("Refresh:0");
    }  
}

// ************************** 3) Om Oss  **************************
// ************************** 4) Priser og Info **************************
// Funksjon for å lage en tabell med alle prisene til å vise på "Priser og Info" siden
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

// ************************** 11) Logg Inn **************************
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

// Hjelpefunksjon til loggInn.
// Når en bruker logger inn blir det laget et brukerObjekt som inneholder brukerens info
function opprettBrukerSession($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
$tlf, $adresse, $fødselsNr, $stilling, $postNr) {
    $bruker = new Bruker($brukerID, $epost, $brukerType, $fornavn, $etternavn, 
    $tlf, $adresse, $fødselsNr, $stilling, $postNr);
    $_SESSION['bruker'] = $bruker;
}

// ************************** 12) Registrer deg **************************
// Funksjon for registrere seg på nettsiden
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
            echo "<br>".'<i style="color:green; position:absolute";"> Du er nå registrert! </i>'; 
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
