<?php
ob_start();
include_once "domeneklasser/Bruker.php";
include_once "domeneklasser/Hund.php";
include_once "domeneklasser/Bestilling.php";
include_once "domeneklasser/FerdigBestilling.php";

/**
 *  Denne klassen inneholder funksjoner som brukes på alle sidene, 
 *  databasetilkobling, "visNavbar", "visFooter" og "visTilToppenKnapp"
 *  @author    Trygve, Even, Kristina
 */ 


// ************************** database **************************

// Konstanter som vi bruker til å koble på databasen på itfag.usn.no
define("TJENER",  "itfag.usn.no");
define("BRUKER",  "h20APP2000gr5");
define("PASSORD", "pw5");
define("DB",      "h20APP2000grdb5");

/**
 *  Funksjon for å koble på databasen
 *  @return $dblink
 *  @author Trygve Johannessen     
 */ 
function kobleOpp() {
    $dblink = mysqli_connect(TJENER, BRUKER, PASSORD, DB);
    if (!$dblink) {
        die('Klarte ikke å koble til databasen: ' . mysqli_error($dblink));
    }
    mysqli_set_charset($dblink, 'utf8');
    return $dblink;
}

/**
 *  Funksjon for å koble fra databasen
 *  @return $dblink
 *  @author Trygve Johannessen     
 */ 
function lukk($dblink) {
    mysqli_close($dblink);
}

// ************************** topp-elementer ************************** 
// Funksjon som lager standard navbar på alle sidene (Even)
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
        <a> <img id="spraakKnapp" src="flaggNO.png" alt="Change language"> </a>

    </div><?php
}

// Funksjon som lager admin under-navbar på alle admin sidene (Even) 
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

// Funksjon som lager ansatt under-navbar på alle ansatt sidene (Even)
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


/**
 *  Funksjon for å sjekke om brukeren er logget inn (Trygve)
 *  @return boolean   
 *  @author Trygve Johannessen         
 */ 
function erLoggetInn() {
    return ( isset($_SESSION['bruker']) );
}

/**
 *  Funksjon for å sjekke om brukeren er en ansatt (Trygve)
 *  @return boolean $erAnsatt   
 *  @author Trygve Johannessen    
 */ 
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

/**
 *  Funksjon for å sjekke om brukeren er en admin (Trygve)
 *  @return boolean $erAdmin 
 *  @author Trygve Johannessen      
 */ 
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

// ************************** bunn-elementer ************************** 
// Funksjon som lager ToppKnapp på alle sidene. (Kristina)
// Toppknappen gjør at man lett kan navigere til Toppen av siden
function visToppKnapp() { 
    ?> 
    <!-- gratis Opp ikon fra https://fontawesome.com/icons/chevron-up?style=solid-->
    <button onclick="toppKnappFunksjon()" id="tilToppKnapp" title="Gå til toppen"><i class="fas fa-chevron-up"></i> </button>  
    <script src="./include/toppknappen.js"></script>
    <?php 
}

// Funksjon som lager Footer på alle sidene. (Kristina)
function visFooter() { 
    ?>
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

// ************************** 0) Brukes på flere sider **************************

/** 
 *  Funksjon som lager option elementer til valgbokser 
 *  @param String $verdi
 *  @author Trygve Johannessen   
 **/  
function lagOption($verdi) {
    ?> <option value= <?php echo $verdi?> > <?php echo $verdi?> </option><?php
}

/** 
 *  Funksjon for å registrer en Hund. Brukes på bestillOpphold og minSide
 *  @param String $verdi
 *  @author Trygve Johannessen   
 **/  
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


/** 
 *  Funksjon for å lage et hund-objekt og legge det til sessionen "aktivHund"
 *  Når brukeren skal bestille opphold lagres alle hundene som er valgt i sessionen "valgteHunder"
 *  alle hundene i "valgteHunder" blir satt som "aktivHund" en etter en når hunden skal oppdateres
 *  Brukes også på min side når brukeren har valgt hund som skal endres
 *  @param int $hundID
 *  @author Trygve Johannessen  
 **/  
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

ob_end_flush();