<?php
ob_start();


/**
 *  Denne klassen inneholder funksjoner til alle ansatt sider og undersidene som hører til dem
 *  @author    Trygve Johannessen
 */ 



// ************************** 1) ansattBur **************************
// Denne siden lar ansatt-brukeren få en se en oversikt 
// over hvor mange bur som er ledige pr dato 1 år framover i tid

/** 
 *  Funksjon for å vise vis Ledige bur pr dato 1 år framover i tid
 *  Kaller funksjonene "lagBurTab", "nesteMndSjekk", "skrivUkeTab" og "oppdaterAar"
 **/ 
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
        $aar = getAar($burTab[$i]);
    }  
} 

/**
 * "visLedigeBurPrDag" funksjonen kjører gjennom alle dagene er år fram i tid
 *  Denne funsjonen kjøres en gang pr dag for å sjekke om vi har komt til en ny mnd
 *  @return boolean
 **/ 
function nesteMndSjekk($dato) {
    $dato = substr($dato,8,2);
    if ($dato > 0 && $dato < 8) {  
       return true;   
    }
    else {
        return false;   
    }
} 

/**
 *  Trekker ut år verdien fra en dato
 *  @param String $dato
 *  @return String $aar
 **/ 
function getAar($dato) {
    return substr($dato,0,4);
} 

/**
 *  Lager en String tabell som inneholder ledige bur pr dag
 *  @return String $burTab
 **/ 
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

/**
 *  Skriver en tabell som inneholder ledige pr bur pr dag for en uke
 *  @param String $burTab
 **/ 
function skrivUkeTab($burTab) {
    $dagNavn = array("Man", "Tirs", "Ons", "Tors", "Fre", "Lør", "Søn");
    echo "<table class=\"burTab\">";
    echo "<tr>";
    echo    "<th>Dag</th>";
    echo    "<th>Dato</th>";
    echo    "<th>Ledige</th>";
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



// ********************************* 2) ansattAlleOpphold ******************************************
// Denne siden lar ansatt-brukeren få en se en oversikt over 5 siste ferdige oppgold,
// alle aktive opphold og alle fremtide opphold

/**
 *  Funksjon for å side alle opphold. Deler opp opphold i 3 kategorier: Ferdige, aktive og kommende
 *  Skriver en tabell pr kategori.
 *  @param String $burTab
 **/ 
function visAlleOpphold($dblink) {
    //3) ferdige Opphold
    lagOppholdOverskrifter("Ferdige");
    $sql = lagFerdigeOppholdSpørring5Siste($dblink); //
    $bestillingTab = lagOppholdTab($dblink,$sql);
    visOppholdTab($bestillingTab);

    //2) aktive Opphold
    lagOppholdOverskrifter("Aktive");
    $sql = lagAktiveOppholdSpørring($dblink); //
    $bestillingTab = lagOppholdTab($dblink,$sql);
    visOppholdTab($bestillingTab);

    //1) IkkeBegynte Opphold
    lagOppholdOverskrifter("Kommende");
    $sql = lagIkkeBegynteOppholdSpørring($dblink); //
    $bestillingTab = lagOppholdTab($dblink,$sql);
    visOppholdTab($bestillingTab);
}

/**
 *  Funksjon for å skrive overskrifter til hver opphold kategori
 *  @param String $oppholdStatus  
 **/ 
function lagOppholdOverskrifter($oppholdStatus) {
    echo "<h3>".$oppholdStatus." opphold"."</h3>";
    //overskrifter
    echo "<table class=\"blaaTabSmal\">";  
    echo "<tr>";
    echo    "<th>BestillingID</th>";    // bestilling
    echo    "<th>Start</th>";           // bestilling
    echo    "<th>Slutt</th>";           // bestilling
    echo    "<th>Bestilt</th>";         // bestilling
    echo    "<th>SjekkInn</th>";        // bestilling
    echo    "<th>SjekkUt</th>";         // bestilling
    echo    "<th>TotalPris</th>";       // bestilling
    echo    "<th>BurID</th>";           // opphold
    echo    "<th>Hunder</th>";            // hund
    echo "</tr>";
}

/**
 *  Funksjon for å lage en SQL spørring for ikke-begynte opphold
 *  @return String $sql
 **/ 
function lagIkkeBegynteOppholdSpørring($dblink) {
    return "SELECT B.*, O.*, H.* FROM bestilling AS B, opphold AS O, hund AS H
    WHERE B.bestillingID = O.bestillingID 
    AND O.hundID = H.hundID 
    AND   B.sjekketInn IS NULL
    ORDER BY B.startDato ; ";
}

/**
 *  Funksjon for å lage en SQL spørring for aktive opphold
 *  @return String $sql
 **/ 
function lagAktiveOppholdSpørring($dblink) {
    return "SELECT B.*, O.*, H.* FROM bestilling AS B, opphold AS O, hund AS H
    WHERE B.bestillingID = O.bestillingID 
    AND O.hundID = H.hundID 
    AND   B.sjekketInn IS NOT NULL
    AND   B.sjekketUt IS NULL
    ORDER BY B.startDato ; ";
}

/**
 *  Funksjon for å lage en SQL spørring for ferdige opphold (5 siste)
 *  @return String $sql
 **/ 
function lagFerdigeOppholdSpørring5Siste($dblink) {
    return "SELECT B.*, O.*, H.* FROM bestilling AS B, opphold AS O, hund AS H
    WHERE B.bestillingID = O.bestillingID 
    AND O.hundID = H.hundID 
    AND   B.sjekketUt IS NOT NULL
    ORDER BY B.startDato 
    LIMIT 5;
    ; ";
}

/**
 *  Funksjon for å lage en SQL spørring for alle ferdige opphold
 *  @return String $sql
 **/ 
function lagFerdigeOppholdSpørring($dblink) {
    return "SELECT B.*, O.*, H.* FROM bestilling AS B, opphold AS O, hund AS H
    WHERE B.bestillingID = O.bestillingID 
    AND O.hundID = H.hundID 
    AND   B.sjekketUt IS NOT NULL
    ORDER BY B.startDato ; ";
}

/**
 *  Funksjon for å lage et tabell med "FerdigBestilling"-objekter
 *  "FerdigBestilling"-objekter representerer en bestilling som er ferdig utfylt og registrert 
 *  og må ikke forveksles med ferdige opphold (litt uheldig navngiving)
 *  @param String $sql
 *  @return String $bestillingTab
 **/ 
function lagOppholdTab($dblink,$sql) {
    // variabler
    $forigeBestillingID = "";
    $bestillingTab = null;
    $bestillingTabPos = 0;

    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
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
        $b1->setSjekketInn($rad['sjekketInn']);
        $b1->setSjekketUt($rad['sjekketUt']);
        $b1->setBestiltDato($rad['bestiltDato']);
        $b1->setTotalPris($rad['totalPris']);
        $b1->setBurID($rad['burID']);
        $b1->addHund($rad['navn']);
        $forigeBestillingID = $bestillingID;
    }
    return $bestillingTab;
}

/**
 *  Funksjon som tar i mot en tabell med "FerdigBestilling"-objekter
 *  @param String $sql
 *  @return String $bestillingTab
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
            echo "<td>" . substr($b->getSjekketInn(),11,5) . "</td>";  
            echo "<td>" . substr($b->getSjekketUt(),11,5)  . "</td>";  
            echo "<td>" . $b->getTotalPris() . "</td>"; 
            echo "<td>" . $b->getBurID() . "</td>"; 
            echo "<td>" . implode(", ",$b->getHundTab()) . "</td>"; 
            echo "</tr>";
        } 
    } 
    echo "</table>";
} 



// ********************************* 3) ansattAlleOppholdEldre ******************************************
// Side for å se alle ferdige opphold

// Funksjon for å vise alle ferdige opphold. Kaller på funksjoner over.
function visFerdigeOpphold($dblink) {
    lagOppholdOverskrifter("Alle Ferdige");
    $sql = lagFerdigeOppholdSpørring($dblink); //
    $bestillingTab = lagOppholdTab($dblink,$sql);
    visOppholdTab($bestillingTab);
}



// ********************************* 4) ansattAvbestill ******************************************
// Side som lar ansatt-brukere avbestille en bestilling for kunder

// Funksjon for å lage en tabell med ikke-begynte bestillinger som String objekter
function lagIkkeBegyntBestillingTabAnsatt($dblink) {
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
    AND B.sjekketInn IS NULL;" ;
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
 *  Funksjon som lager en bestilling option til en select-boks
 *  @param String $bestilling
**/
function lagBestillingOption($bestilling) {
    ?> <option value= <?php echo $bestilling?> > <?php echo $bestilling?> </option><?php
}

// Funksjon for å avbestille en bestilling for kunde
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



// ********************************* 5) ansattSjekkInnUt ******************************************
// Side som lar ansatt-brukere sjekke inn og ut hunder

/**
 *  Funksjon vis alle bestillinger som skal sjekkes INN i dag
 *  Kaller på funksjoner for å skriver overskrifter lage tabeller med bestillinger og skrive rader
 *  @param String $bestilling
**/
function visSkalSjekkeInnIDag($dblink) {
    visSkalSjekkesOverskrifter($dblink,"Innsjekkinger");
    $sql = lagSkalSjekkesInnIDagOverskrifter($dblink);
    visSkalSjekkesRader($dblink,$sql,"sjekketInn");
}

/**
 *  Funksjon vis alle bestillinger som skal sjekkes UT i dag
 *  Kaller på funksjoner for å skriver overskrifter lage tabeller med bestillinger og skrive rader
 *  @param String $bestilling
**/
function visSkalSjekkeUtIDag($dblink) {
    visSkalSjekkesOverskrifter($dblink,"Utsjekkinger");
    $sql = lagSkalSjekkesUtIDagOverskrifter($dblink);
    visSkalSjekkesRader($dblink,$sql,"sjekketUt");
} 

/**
 *  Funksjon for å skrive overskrifter i sjekk inn eller ut tabell
 *  @param String $ord sjekketUt/ sjekketUt
**/
function visSkalSjekkesOverskrifter($dblink,$ord) {  
    $idag = new DateTime();
    echo "<h2>" . $ord . " i dag " . $idag->format('Y-m-d') . "</h2>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTab\">";
    echo "<tr>";
    echo    "<th>BestillingID</th>";  
    echo    "<th>Hund</th>";  
    echo    "<th>Kunde</th>";   
    echo    "<th>".$ord."</th>";   
    echo "</tr>";
} 

/**
 *  Funksjon for å lage en sql spørring som returnerer alle bestillinger som skal sjekkes INN idag
 *  @return String $sql
**/
function lagSkalSjekkesInnIDagOverskrifter($dblink) {  
    return "SELECT B.bestillingID, H.navn, BR.fornavn, BR.etternavn, B.sjekketInn 
    FROM opphold AS O, bestilling AS B, hund AS H, bruker AS BR       
    WHERE B.bestillingID = O.bestillingID  
    AND O.hundID = H.hundID 
    AND H.brukerID = BR.brukerID
    AND DAY(B.startDato) = DAY(CURRENT_TIMESTAMP)
    ORDER BY B.bestillingID ;"; 
} 

/**
 *  Funksjon for å lage en sql spørring som returnerer alle bestillinger som skal sjekkes UT idag
 *  @return String $sql
**/
function lagSkalSjekkesUtIDagOverskrifter($dblink) {  
    return "SELECT B.bestillingID, H.navn, BR.fornavn, BR.etternavn, B.sjekketUt 
    FROM opphold AS O, bestilling AS B, hund AS H, bruker AS BR       
    WHERE B.bestillingID = O.bestillingID  
    AND O.hundID = H.hundID 
    AND H.brukerID = BR.brukerID
    AND DAY(B.sluttDato) = DAY(CURRENT_TIMESTAMP)
    ORDER BY B.bestillingID ;";
} 

/**
 *  Funksjon for å lage en tabellrader med alle bestillinger som skal sjekkes inn eller ut idag
 *  @param String $sql
 *  @param String $kolonneNavn  sjekketUt/ sjekketUt
**/
function visSkalSjekkesRader($dblink,$sql,$kolonneNavn) {  
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>" . $rad['bestillingID'] . "</td>";  
        echo "<td>" . $rad['navn']      . "</td>";    
        echo "<td>" . $rad['fornavn'] . " " . $rad['etternavn'] . "</td>";  
        echo "<td>" . substr($rad[$kolonneNavn],11,5)      . "</td>";    
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

/**
 *  Funksjon for å lage en tabell med alle bestillinger som skal sjekkes INN idag
 *  @return String $sql
**/
function lagSkalSjekkesInnTab($dblink) {
    // variabler
    $forigeBestillingID = "";
    $skalSjekkesInnTab = null;
    $pos = 0;

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

/**
 *  Funksjon for å lage en tabell med alle bestillinger som skal sjekkes UT idag
 *  @return String $sql
**/
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
    AND DAY(B.sluttDato) <= DAY(CURRENT_TIMESTAMP) 
    AND B.sjekketInn IS NOT NULL  
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

// Funksjon for å registrere en innsjekking i databasen
function sjekkInn($dblink) {
    if (isset($_POST['sjekkInnKnapp'])) { 
        $bestillingID = $_POST['sjekkInnSelect'];
        $bestillingID = substr($bestillingID,0,1);
        $sql = "UPDATE bestilling SET sjekketInn = CURRENT_TIMESTAMP WHERE bestillingID = '$bestillingID' ;";
        mysqli_query($dblink,$sql);
        header("Refresh:0");
    }
}

// Funksjon for å registrere en utsjekking i databasen
function sjekkUt($dblink) {
    if (isset($_POST['sjekkUtKnapp'])) { 
        $bestillingID = $_POST['sjekkUtSelect'];
        $bestillingID = substr($bestillingID,0,1);
        $sql = "UPDATE bestilling SET sjekketUt = CURRENT_TIMESTAMP WHERE bestillingID = '$bestillingID' ;";
        mysqli_query($dblink,$sql);
        header("Refresh:0");
    }
}

// Funksjon for å nullstille alle innsjekkinger i dag
function nullStillInnsjekkinger($dblink) {
    if (isset($_POST['nullstillInnsjekkingerKnapp'])) { 
        ob_start();
        $sql = "UPDATE bestilling SET sjekketInn = null WHERE day(startDato) = day(CURRENT_TIMESTAMP);";
        mysqli_query($dblink,$sql);
        header("Refresh:0");
        ob_end_flush();
    }
}

// Funksjon for å nullstille alle utsjekkinger i dag
function nullStillUtsjekkinger($dblink) {
    if (isset($_POST['nullStillUtsjekkingerKnapp'])) { 
        ob_start();
        $sql = "UPDATE bestilling SET sjekketUt = null WHERE day(sluttDato) = day(CURRENT_TIMESTAMP);";
        mysqli_query($dblink,$sql);
        header("Refresh:0");
        ob_end_flush();
    }
}



// ********************************* 5) ansattInspiserHund ******************************************
// Side som lar ansatt-brukere sjekke inn og ut hunder

// Funksjon for å lage en option for å velge en av hundene som har aktivt opphold å inspisere dem
function lagInspiserHundOption($hund,$inspiserHundID) {
    if ($inspiserHundID == substr($hund,0,1)) {
        ?> <option value= <?php echo $hund?> selected > <?php echo $hund ?> </option><?php
    }
    else {
        ?> <option value= <?php echo $hund?> > <?php echo $hund ?> </option><?php
    }
}

/**
 *  Funksjon for å vise fram info om hunden som skal inspiserers i tabellform
 *  Bruker sessions-variabelen "inspiserHund" som blir laget med et ajax kall 
 *  når brukeren velger en hund i select boksen på denne siden.
 */
function visInspiserHundInfo($dblink) {
    $inspiserHund = $_SESSION['inspiserHund']; 
    echo "<h3>Hund-Info</h3>";
    echo "<table class=\"toKolTab\">";

    $sql = "SELECT H.* FROM hund AS H, opphold AS O
    WHERE H.hundID = O.hundID 
    AND oppholdID = '$inspiserHund' ;" ;
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)) {
        skrivRad("HundID",$rad['hundID']);
        skrivRad("Navn",$rad['navn']);
        skrivRad("Rase",$rad['rase']);
        skrivRad("Fdato",$rad['fdato']);
        skrivRad("Kjønn",$rad['kjønn']);
        skrivRad("Sterilisert",$rad['sterilisert']);
        skrivRad("LøpeMedAndre",$rad['løpeMedAndre']);
        skrivRad("Info",$rad['info']);
        skrivRad("ForID",$rad['forID']);
    }
    echo "</table>";
}

// Funksjon for å vise en rad i en av tabellene på ansatteHund siden
function skrivRad($navn,$verdi) {
    echo "<tr>";
    echo    "<th>".$navn."</th>";   
    echo    "<td>".$verdi."</td>";  
    echo "</tr>";
}

/**
 *  Funksjon for å vise fram bestilling+opphold-info om hunden som skal inspiserers i tabellform
 *  Bruker sessions-variabelen "inspiserHund" som blir laget med et ajax kall 
 *  når brukeren velger en hund i select boksen på denne siden.
 */
function visInspiserHundOppholdInfo($dblink) {
    $inspiserHund = $_SESSION['inspiserHund']; 
    echo "<h3>Opphold-Info</h3>";
    echo "<table class=\"toKolTab\">";

    $sql = "SELECT O.*, B.*
    FROM opphold AS O, bestilling AS B
    WHERE O.bestillingID = B.bestillingID 
    AND oppholdID = '$inspiserHund' ;" ;
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)) {
        skrivRad("OppholdID",$rad['oppholdID']);
        skrivRad("BestillingID",$rad['bestillingID']);
        skrivRad("BurID",$rad['burID']);
        skrivRad("StartDato",$rad['startDato']);
        skrivRad("SluttDato",$rad['sluttDato']);
        skrivRad("BestiltDato",$rad['bestiltDato']);
        skrivRad("SjekketInn",$rad['sjekketInn']);
        skrivRad("SjekketUt",$rad['sjekketUt']);
        skrivRad("TotalPris",$rad['totalPris']);
    }
    echo "</table>";
}

// Funksjon for å vise fram alle matinger på dette oppholdet
function visAlleRegistrerteMatingerDetteOppholdet($dblink) {
    $inspiserHund = $_SESSION['inspiserHund']; 
    $idag = new DateTime();
    echo "<h3>" . "Registrerte matinger på dette oppholdet " . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTab\">";
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

// Funksjon for å vise fram alle luftinger på dette oppholdet
function visAlleRegistrerteLuftingerDetteOppholdet($dblink) {  
    $inspiserHund = $_SESSION['inspiserHund']; 

    $idag = new DateTime();
    echo "<h3>" . "Registrerte Luftinger på dette oppholdet" . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTab\">";
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

// Funksjon for å vise fram alle kommentarer på dette oppholdet
function visAlleRegistrerteKommentarerDetteOppholdet($dblink) { 
    $inspiserHund = $_SESSION['inspiserHund']; 

    $idag = new DateTime();
    echo "<h3>"."Registrerte kommentarer på dette oppholdet"."</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTab\">";
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



// ********************************* 6) Mating ******************************************
// Side som lar ansatt-brukere registrere når hundene har blitt matet

// Funksjon for å vise alle registrerte matinger i dag
function visAlleRegistrerteMatingerIDag($dblink) {
    // alle registrerte matinger i dag 
    $idag = new DateTime();
    echo "<h3>" . "Registrerte matinger i dag " . $idag->format('Y-m-d') . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTab\">";
    echo "<tr>";
    echo    "<th>OppholdID</th>";  
    echo    "<th>Hund</th>";  
    echo    "<th>ForType</th>";  
    echo    "<th>Mating</th>";       
    echo "</tr>";

    // SQLSpørring for å finne alle registrerte matinger i dag 
    $sql = " SELECT M.*, H.navn, F.forType FROM mating AS M, opphold AS O, hund AS H, hundefor AS F
    WHERE M.oppholdID = O.oppholdID
    AND O.hundID = H.hundID
    AND H.forID = F.forID
    AND day(M.tidspunkt) = day(CURRENT_TIMESTAMP);";
    $resultat = mysqli_query($dblink, $sql); 

    //viss ingen treff
    $antall = mysqli_num_rows($resultat);
    if ($antall == 0) { 
        visAlleHunderPaaOppholdNaaMating($dblink);
    }

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

/**
 *  Funksjon for å vise alle hunder som SKAL bli matet i dag
 *  Kalles av funksjonen over viss det ikke er registrert noen matinger i dag
 */
function visAlleHunderPaaOppholdNaaMating($dblink) {
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
        echo "<td></td>";          
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

// Funksjon for å registrere mating på alle aktive opphold
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

// Funksjon for finne alle hundene som har aktive opphold nå
function getAktiveOppholdIDer($dblink) {
    $oppholdIDTab;
    $pos = 0;
    $sql = " SELECT O.oppholdID 
    FROM bestilling AS B, opphold AS O, hund AS H
    WHERE B.bestillingID = O.bestillingID 
    AND   O.hundID = H.hundID
    AND B.sjekketInn IS NOT NULL 
    AND B.sjekketUt IS NULL ;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        $oppholdIDTab[$pos++] = $rad['oppholdID'];    
    } 
    return $oppholdIDTab;
}

// Funksjon for å slett alle matinger
function ($dblink) {
    if (isset($_POST['slettAlle'])) { 
        $sql = "DELETE FROM mating ;" ;
        mysqli_query($dblink,$sql);
    }  
}



// ********************************* 7) Lufting ******************************************
// Side som lar ansatt-brukere registrere når hundene har vert i luftegaard

// Funksjon for å vise alle luftinger i dag
function visAlleRegistrerteLuftingerIDag($dblink) {
    // alle registrerte matinger i dag 
    $idag = new DateTime();
    echo "<h3>" . "Registrerte Luftinger i dag " . $idag->format('Y-m-d') . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTab\">";
    echo "<tr>";
    echo    "<th>OppholdID</th>";  
    echo    "<th>Hund</th>";  
    echo    "<th>LøpeMedAndre</th>";  
    echo    "<th>Start</th>";    
    echo    "<th>Slutt</th>";    
    echo "</tr>";

    // SQLSpørring for å finne alle registrerte matinger i dag    
    $sql = " SELECT L.*, H.navn, H.løpeMedAndre
    FROM lufting AS L, opphold AS O, hund AS H
    WHERE L.oppholdID = O.oppholdID
    AND O.hundID = H.hundID
    AND day(L.startTidspunkt) = day(CURRENT_TIMESTAMP);";
    $resultat = mysqli_query($dblink, $sql); 

    //viss ingen treff
    $antall = mysqli_num_rows($resultat);
    if ($antall == 0) { 
        visAlleHunderPaaOppholdNaaLufting($dblink);
    }
    else {
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
            $startTidspunkt = $rad['startTidspunkt'];  
            echo "<td>" . substr($startTidspunkt,10,6) . "</td>";  
            $sluttTidspunkt = $rad['sluttTidspunkt'];  
            echo "<td>" . substr($sluttTidspunkt,10,6) . "</td>";  
            echo "</tr>";
        }
        echo "</table>" . "<br>";
    }
}

/**
 *  Funksjon for å vise alle opphold som SKAL bli luftet i dag
 *  Kalles av funksjonen over viss det ikke er registrert noen luftinger i dag
 */
function visAlleHunderPaaOppholdNaaLufting($dblink) {
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
        echo "<td></td>";    
        echo "<td></td>";          
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

// Funksjon for å registrer lufting-start på alle aktive opphold
function registrerLuftingStartAlle($dblink) {
    if (isset($_POST['registrerLuftingStartAlle'])) { 
        //har vi allerede registrert lufting start i dag?
        $sql = "SELECT * FROM lufting WHERE day(startTidspunkt) = day(CURRENT_TIMESTAMP);" ;
        $resultat = mysqli_query($dblink, $sql); 
        $antall = mysqli_num_rows($resultat);
        if ($antall > 0) { 
            echo "<br>".'<i style="color:red; position:absolute";"> 
            Har allerede registrert lufting start i dag! </i>';
        }
        else {
            // brukerNavn
            $bruker = $_SESSION['bruker'];
            $brukerID = $bruker->getBrukerID();
            // lager oppholdIDTab
            $oppholdIDTab = getAktiveOppholdIDer($dblink);
            // kjører gjennom hele oppholdIDTab og registrerer luftinger
            for ($i=0; $i<count($oppholdIDTab); $i++) {
                $oppholdID = $oppholdIDTab[$i];
                $sql = "INSERT INTO lufting (startTidspunkt,oppholdID,brukerID)
                VALUES (CURRENT_TIMESTAMP,'$oppholdID','$brukerID');" ;
                mysqli_query($dblink,$sql);
            } 
            header("Refresh:0");
        }
    }
}

// Funksjon for å registrer lufting-slutt på alle aktive opphold
function registrerLuftingSluttAlle($dblink) {
    if (isset($_POST['registrerLuftingSluttAlle'])) { 
        // brukerID
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        // lager oppholdIDTab
        $oppholdIDTab = null; 
        $oppholdIDTab = getErILuftegaardIDer($dblink);
        // kjører gjennom hele oppholdIDTab og registrerer luftinger
        if ($oppholdIDTab != null) {
            for ($i=0; $i<count($oppholdIDTab); $i++) {
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
}

/**
 *  Funksjon for å henter ut hundIDene til alle hunder som er i luftegaard nå
 *  @return $oppholdIDTab;
 */
function getErILuftegaardIDer($dblink) {
    $oppholdIDTab = null; 
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

//  Funksjon for å slette alle luftinger
function slettAlleLuftinger($dblink) {
    if (isset($_POST['slettAlle'])) { 
        $sql = "DELETE FROM lufting;" ;
        mysqli_query($dblink,$sql);
    }  
}


// ********************************* 8) Tur ******************************************
// Side som lar ansatt-brukere registrere når hundene har vert på tur

// Funksjon for å vise alle opphold som har vert på tur idag
function visAlleRegistrerteTurerIDag($dblink) {
    // alle registrerte matinger i dag 
    $idag = new DateTime();
    echo "<h3>" . "Registrerte Turer i dag " . $idag->format('Y-m-d') . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTab\">";
    echo "<tr>";
    echo    "<th>OppholdID</th>";  
    echo    "<th>Hund</th>";  
    echo    "<th>LøpeMedAndre</th>";  
    echo    "<th>Start</th>";    
    echo    "<th>Slutt</th>";    
    echo "</tr>";

    // SQLSpørring for å finne alle registrerte matinger i dag    
    $sql = " SELECT T.*, H.navn, H.løpeMedAndre
    FROM tur AS T, opphold AS O, hund AS H 
    WHERE T.oppholdID = O.oppholdID
    AND O.hundID = H.hundID
    AND day(T.startTidspunkt) = day(CURRENT_TIMESTAMP) ;";
    $resultat = mysqli_query($dblink, $sql); 

    //viss ingen treff
    $antall = mysqli_num_rows($resultat);
    if ($antall == 0) { 
        visAlleHunderPaaOppholdNaaTur($dblink);
    }
    else {
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
            $startTidspunkt = $rad['startTidspunkt'];  
            echo "<td>" . substr($startTidspunkt,10,6) . "</td>";  
            $sluttTidspunkt = $rad['sluttTidspunkt'];  
            echo "<td>" . substr($sluttTidspunkt,10,6) . "</td>";  
            echo "</tr>";
        }
        echo "</table>" . "<br>";
    }
}

/**
 *  Funksjon for å vise alle hunder på opphold nå som skal på tur i dag
 *  Kalles bare av funksjonen over når det ikke er registrert noen turer i dag
 */
function visAlleHunderPaaOppholdNaaTur($dblink) {
    $sql = " SELECT O.oppholdID, F.forType, H.navn, H.løpeMedAndre 
    FROM bestilling AS B, opphold AS O, hund AS H, hundefor AS F
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
        echo "<td></td>";    
        echo "<td></td>";          
        echo "</tr>";
    }
    echo "</table>" . "<br>";
}

// Funksjon for å registrere tur-start for alle hundene
function registrerTurStartAlle($dblink) {
    if (isset($_POST['registrerTurStartAlle'])) { 
        //har vi allerede registrert lufting start i dag?
        $sql = "SELECT * FROM tur WHERE day(startTidspunkt) = day(CURRENT_TIMESTAMP);" ;
        $resultat = mysqli_query($dblink, $sql); 
        $antall = mysqli_num_rows($resultat);
        if ($antall > 0) { 
            echo "<br>".'<i style="color:red; position:absolute";"> 
            Har allerede registrert tur start i dag! </i>';
        }
        else {
            // brukerNavn
            $bruker = $_SESSION['bruker'];
            $brukerID = $bruker->getBrukerID();
            // lager oppholdIDTab
            $oppholdIDTab = getAktiveOppholdIDer($dblink);
            // kjører gjennom hele oppholdIDTab og registrerer luftinger
            for ($i=0; $i<count($oppholdIDTab); $i++) {
                $oppholdID = $oppholdIDTab[$i];
                $sql = "INSERT INTO tur (startTidspunkt,oppholdID,brukerID)
                VALUES (CURRENT_TIMESTAMP,'$oppholdID','$brukerID');" ;
                mysqli_query($dblink,$sql);
            } 
            header("Refresh:0");
        }
    }
}

// Funksjon for å registrere tur-slutt for alle hundene
function registrerTurSluttAlle($dblink) {
    if (isset($_POST['registrerTurSluttAlle'])) { 
        // brukerID
        $bruker = $_SESSION['bruker'];
        $brukerID = $bruker->getBrukerID();
        // lager oppholdIDTab
        $oppholdIDTab = null; 
        $oppholdIDTab = getErPaaTurIDer($dblink);
        // kjører gjennom hele oppholdIDTab og registrerer luftinger
        if ($oppholdIDTab != null) {
            for ($i=0; $i<count($oppholdIDTab); $i++) {
                $oppholdID = $oppholdIDTab[$i];
                $sql = "UPDATE tur 
                SET sluttTidspunkt = CURRENT_TIMESTAMP
                WHERE oppholdID = '$oppholdID' 
                AND day(startTidspunkt) = day(CURRENT_TIMESTAMP);" ;
                mysqli_query($dblink,$sql);
            } 
            header("Refresh:0");
        }
    }
}

// Funksjon for å hente ut oppholdIDene til alle hundene som er på tur nå
function getErPaaTurIDer($dblink) {
    $oppholdIDTab = null; 
    $pos = 0;
    $sql = " SELECT O.oppholdID 
    FROM bestilling AS B, opphold AS O, hund AS H, tur AS T
    WHERE B.bestillingID = O.bestillingID 
    AND   O.hundID = H.hundID
    AND   O.oppholdID = T.oppholdID
    AND day(B.startDato) <= day(CURRENT_TIMESTAMP) 
    AND day(B.sluttDato) >= day(CURRENT_TIMESTAMP) 
    AND B.sjekketInn IS NOT NULL 
    AND B.sjekketUt IS NULL 
    AND day(T.startTidspunkt) = day(CURRENT_TIMESTAMP) ;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        $oppholdIDTab[$pos++] = $rad['oppholdID'];    
    } 
    return $oppholdIDTab;
}

// Funksjon for å slette alle hunder
function slettAlleTurer($dblink) {
    if (isset($_POST['slettAlle'])) { 
        $sql = "DELETE FROM tur;" ;
        mysqli_query($dblink,$sql);
        header("Refresh:0");
    }  
}



// ********************************* 9) Kommentar ******************************************
// Side som lar ansatt-brukere kan registrere kommentarer på hunder på opphold

// Funksjon for å vise alle registrerte kommentarer på aktive opphold
function visAlleHunderPaaOppholdNaaKommentar($dblink) {
    echo "<h3>" . "Alle hunder som er på opphold nå" . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTab\">";
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

// Funksjon for å lage en tabell med aktive-opphold som String objekter
function lagHunderPaaOppholdNaaTab($dblink) {
    $hunder;
    $pos = 0;
    $sql = " SELECT O.oppholdID, F.forType, H.navn 
    FROM bestilling AS B, opphold AS O, hund AS H, hundefor AS F 
    WHERE B.bestillingID = O.bestillingID
    AND O.hundID = H.hundID
    AND H.forID = F.forID
    AND B.sjekketInn IS NOT NULL
    AND B.sjekketUt IS NULL
    ORDER BY O.oppholdID ;";
    $resultat = mysqli_query($dblink, $sql); 
    while($rad = mysqli_fetch_assoc($resultat)){
        $hunder[$pos++] = $rad['oppholdID']." ".$rad['navn'];
    }
    return $hunder;
}

// Funksjon for å registrer en kommentar på et aktivt opphold
function registrerKommentar($dblink) {
    if (isset($_POST['registrerKommentarKnapp'])) { 
        $tekst = $_POST['kommentarText'];
        $oppholdID = $_POST['velgHundSelect'];
        $brukerID = $_SESSION['bruker']->getBrukerID();
        $sql = "INSERT INTO kommentar(tekst,tidspunkt,oppholdID,brukerID) 
        VALUES ('$tekst',CURRENT_TIMESTAMP,'$oppholdID','$brukerID');";
        $resultat = mysqli_query($dblink, $sql);
        echo "<br>".'<i style="color:green; position:absolute";"> Kommentar registrert </i>';
        header("Refresh:0");
    }
}

// Funksjon for å slette alle komentarene som er registrert i dag
function slettAlleKommentarer($dblink) {
    if (isset($_POST['slettAlle'])) { 
        $sql = "DELETE FROM kommentar WHERE day(tidspunkt) = day(CURRENT_TIMESTAMP) ;" ;
        mysqli_query($dblink,$sql);
    }  
}

// Funksjon for å vis alle registrerte mommentarer i dag
function visAlleRegistrerteKommentarIDag($dblink) {   
    $idag = new DateTime();
    echo "<h3>" . "Registrerte kommentarer i dag " . $idag->format('Y-m-d') . "</h3>";
    // vis opphold Overskrifter
    echo "<table class=\"blaaTab\">";
    echo "<tr>";
    echo    "<th>OppholdID</th>";  
    echo    "<th>Hund</th>"; 
    echo    "<th>Tidspunkt</th>";   
    echo    "<th>Tekst</th>"; 
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



// ********************************* 10) ansattAnmeldelser ******************************************
// Side som lar ansatt-brukere godkjenne/slette anmeldelser

// Funksjon for å viss neste ikke-godkjente anmeldelse
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

// Funksjon for å slette en anmeldelse
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

// Funksjon for å godkjenn en anmeldelse
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



// ********************************* 10) ansattLogg ******************************************
// Side som lar ansatt-brukere se logg over alle opphold som er blitt avbestilte

// Funksjon for å vise avbestilte Opphold
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

ob_end_flush();