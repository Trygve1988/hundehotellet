<?php
ob_start();

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















// ************************** 7d) Ansatt: Inspiser Hund ************************** 
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
    echo "<table class=\"inspiserHundTab\">";

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

function skrivRad($navn,$verdi) {
    echo "<tr>";
    echo    "<th>".$navn."</th>";   
    echo    "<td>".$verdi."</td>";  
    echo "</tr>";
}

function visInspiserHundOppholdInfo($dblink) {
    $inspiserHund = $_SESSION['inspiserHund']; 
    echo "<h3>Opphold-Info</h3>";
    echo "<table class=\"inspiserHundTab\">";

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






// ************************** 7e) Mating ************************** 
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












// ************************** 7f) Ansatt Lufting ************************** 
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














// ************************** 7g) Kommentar ************************** 
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







// ************************** 7i) Ansatt Logg ************************** 
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