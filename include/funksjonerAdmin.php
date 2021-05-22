<?php
ob_start();

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

ob_end_flush();