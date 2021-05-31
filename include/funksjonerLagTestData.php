<?php

function test($dblink) {

    //finner max brukerID
    $maxBrukerID = 0;
    $sql = "SELECT MAX(brukerID) FROM bruker ;" ;
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)) {
        $maxBrukerID = implode($rad);
    }

    //test registrerer 20 brukere
    if ($maxBrukerID < 20) {
        $brukerID = $maxBrukerID;
        while ($brukerID < 20) {
            $epost = $brukerID . "test@ha.no";
            registrerTestBruker($dblink,$epost,"123Ab%12");
            $brukerID++;
        }
    }

    $fornavnTab = array("Liam", "Olivia", "Emma", "Noah","Ava","Elijah","Oliver","Sophia","Amelia","Lucas",
        "Isabella","Mason","Ethan","Mia","Charlotte","Mateo","James","Luna","Harper","Logan","Benjamin","Ella",
        "Aiden","Mila","Gianna","Sebastian","Camila","Leo","Ellie","Jackson","Aria","Levi","Daniel","Evelyn",
        "Henry","Sofia","Alexander","Layla","Avery","Grayson");

    $etternavnTab = array("Liam","Brown","Campbell","Clark","Davies","Doherty","Evans","Graham",
        "Green","Hall","Hamilton","Hughes","Jackson","Johnson","Jones","Kelly","Martin","Moore","Murphy",
        "Murray","O’Neill","Quinn","Roberts","Robinson","Smith","Smyth","Stewart","Taylor","Thompson",
        "Walker","White","Williams","Wilson","Wood","Wright");

    //oppdaterer admin
    $sql = "UPDATE bruker SET brukerType = 'admin' , fornavn = 'Sansa', 
    etternavn = 'Stark', tlf = '+4712345678', adresse = 'Epleveien 5', postnummer = '3800', poststed = 'Bø i Telemark' WHERE brukerID = 1 ;" ;
    $resultat = mysqli_query($dblink, $sql);

    //oppdaterer ansatt 1
    $sql = "UPDATE bruker SET epost = 'jonsnow@ha.no', brukerType = 'ansatt' , fornavn = 'Jon', 
    etternavn = 'Snow', tlf = '+4712345678', adresse = 'Epleveien 5', postnummer = '3800', poststed = 'Bø i Telemark' WHERE brukerID = 2 ;" ;
    $resultat = mysqli_query($dblink, $sql);

    //oppdaterer ansatt 2
    $sql = "UPDATE bruker SET epost = 'daenerystargaryen@ha.no', brukerType = 'ansatt' , fornavn = 'Daenerys', 
    etternavn = 'Targaryen', tlf = '+4712345678', adresse = 'Epleveien 5', postnummer = '3800', poststed = 'Bø i Telemark' WHERE brukerID = 3 ;" ;
    $resultat = mysqli_query($dblink, $sql);

    //finner max brukerID
    $maxBrukerID = 0;
    $sql = "SELECT MAX(brukerID) FROM bruker ;" ;
    $resultat = mysqli_query($dblink, $sql);
    while($rad = mysqli_fetch_assoc($resultat)) {
        $maxBrukerID = implode($rad);
    }

    //kjører gjennom alle brukere og gir dem tilfeldige navn
    for ($i=4; $i<=$maxBrukerID; $i++) {

        //setter tilfeldige navn
        $n = rand(0,count($fornavnTab)-1);
        $fornavn = $fornavnTab[$n];
        $n = rand(0,count($etternavnTab)-1);
        $etternavn = $etternavnTab[$n];
        $epost = strtolower($fornavn).strtolower($etternavn)."@ha.no";

        //sql
        $sql = "UPDATE bruker SET epost = '$epost', brukerType = 'kunde', fornavn = '$fornavn', 
        etternavn = '$etternavn', tlf = '+4712345678', adresse = 'Epleveien 5', 
        postnummer = '3800', poststed = 'Bø i Telemark' WHERE brukerID = '$i' ;" ;
        $resultat = mysqli_query($dblink, $sql);
    }

    // opretter 60 hunder
    $sql = "DELETE FROM hund ;" ;
    $resultat = mysqli_query($dblink, $sql);

    $hundTab = array("Bella","Charlie","Luna","Lucy","Max","Bailey","Cooper","Daisy","Sadie","Molly","Buddy",
        "Lola","Stella","Tucker","Bentley","Zoey","Harley","Maggie","Riley","Bear","Sophie","Duke","Jax","Oliver",
        "Chloe","Jack","Penny","Rocky","Lily","Milo","Piper","Toby","Zeus","Ellie","Nala","Roxy","Winston","Gracie",
        "Coco","Murphy","Dexter","Teddy","Ruby","Diesel","Rosie","Marley","Loki","Scout","Mia","Leo","Gus","Abby",
        "Jake","Finn","Moose","Ollie","Koda","Louie","Hank","Lilly","Thor","Pepper","Gunner","Willow","Jackson",
        "Zoe","Bandit","Buster","Blue","Shadow","Kona","Baxter","Dixie","Henry","Lexi","Izzy","Apollo","Ginger",
        "Beau","Layla","Millie","Gizmo","Oscar","Tank","Bruno","Jasper","Lucky","Dakota","Ace","Olive","Brody",
        "Maverick","Lulu","Emma","Oakley","Sasha","Belle","Nova","Athena","Sammy","Sam");

    $raseTab = array("Australian sheperd","Beagle","Border collie","Cocker spaniel","Dachshund","Engelsk setter",
        "Finsk lapphund","Fransk bulldog","Golden retriever","Jack Russell terrier","Labrador retriever",
        "Langhåret Collie","Mops","Pomeranian","Puddel","Rhodesian ridgeback","Rottweiler","Schæferhund",
        "Shetland sheepdog","Shih Tzu","Siberian husky","Staffordshire bull terrier","Yorkshire Terrier");  
        
    $kjønnTab = array("gutt", "jente");   

    for ($i=1; $i<=60; $i++) {

        //setter tilfeldige verdier
        $n = rand(0,count($hundTab)-1);
        $navn = $hundTab[$n];

        $n = rand(0,count($raseTab)-1);
        $rase = $raseTab[$n];

        $aar = rand(2010,2020);
        $mnd = rand(1,12);
        $dag = rand(1,28);
        $fdato = $aar . "-" . $mnd . "-" . $dag;

        $n = rand(0,count($kjønnTab)-1);
        $kjønn = $kjønnTab[$n];

        $sterilisert = rand(0,1);
        $løpeMedAndre  = rand(0,1);

        $brukerID  = rand(1,$maxBrukerID-1);
        
        $forID  = rand(1,2);

        //sql
        $sql = "INSERT INTO hund (hundID,navn,rase,fdato,kjønn,sterilisert,løpeMedAndre,brukerID,forID)
        VALUES ('$i','$navn','$rase','$fdato','$kjønn','$sterilisert','$løpeMedAndre','$brukerID','$forID') ;" ;
        $resultat = mysqli_query($dblink, $sql);

    }


    // opretter 60 bestillinger

    $sql = "DELETE FROM opphold ;" ;
    $resultat = mysqli_query($dblink, $sql);
    $sql = "DELETE FROM bestilling ;" ;
    $resultat = mysqli_query($dblink, $sql);

    $startDato = "2021-5-20";

    for ($i=1; $i<=60; $i++) {

        if ($i % 2 ==0) {
            $startDato = new DateTime($startDato);
            $startDato = $startDato->modify("+1 day");
            $startDato = $startDato->format('Y-m-d');
        }

        $sluttDato = new DateTime($startDato);
        $sluttDato = $sluttDato->modify("+3 day");
        $sluttDato = $sluttDato->format('Y-m-d');

        $bestiltDato = $startDato;
        $bestiltDato = new DateTime($bestiltDato);
        $antDagerfør = rand(1,5);
        $antDagerStr = "-" . $antDagerfør . " day";
        $bestiltDato = $bestiltDato->modify($antDagerStr);
        $bestiltDato = $bestiltDato->format('Y-m-d');

        $betaltDato = $bestiltDato;

        $totalPris = 3 * 400;

        $idag = new DateTime();
        $idag = $idag->format('Y-m-d');
        if ($sluttDato < $idag) {
            $sjekketUt  = $sluttDato;
            $sjekketInn = $startDato;
            $sql = "INSERT INTO bestilling (bestillingID,startDato,sluttDato,
            bestiltDato,betaltDato,sjekketInn,sjekketUt,totalPris)
            VALUES ('$i','$startDato','$sluttDato','$bestiltDato',
            '$betaltDato','$sjekketInn','$sjekketUt','$totalPris') ;" ;
            $resultat = mysqli_query($dblink, $sql);
        }
        else if ($startDato < $idag) {
            $sjekketInn = $startDato;
            $sql = "INSERT INTO bestilling (bestillingID,startDato,sluttDato,
            bestiltDato,betaltDato,sjekketInn,totalPris)
            VALUES ('$i','$startDato','$sluttDato','$bestiltDato',
            '$betaltDato','$sjekketInn','$totalPris') ;" ;
            $resultat = mysqli_query($dblink, $sql);
        }
        else {
            $sql = "INSERT INTO bestilling (bestillingID,startDato,sluttDato,
            bestiltDato,betaltDato,totalPris)
            VALUES ('$i','$startDato','$sluttDato','$bestiltDato',
            '$betaltDato','$totalPris') ;" ;
            $resultat = mysqli_query($dblink, $sql);
        }
    }


    // opretter 60 opphold
    $burID = 1;
    for ($i=1; $i<=60; $i++) {

        //setter tilfeldige verdier
        $hundID = rand(1,60);
        if ($burID == 1) {
            $burID = 2; 
        }
        else {
            $burID = 1; 
        }

        //sql
        $sql = "INSERT INTO opphold (oppholdID,hundID,burID,bestillingID)
        VALUES ('$i','$hundID','$burID','$i') ;" ;
        $resultat = mysqli_query($dblink, $sql);
    }

    // endrer Ledigebur pr dag 2021-05-20 og 2021-06-21
    $sql = "UPDATE ledigeBurPrDag SET antallLedigeBur = 2
    WHERE dato = '2021-05-20' OR dato = '2021-06-21' ;";
    $resultat = mysqli_query($dblink, $sql);

    // endrer Ledigebur pr dag 2021-05-20
    $sql = "UPDATE ledigeBurPrDag SET antallLedigeBur = 1
    WHERE dato > '2021-05-21' AND dato < '2021-06-21' ;" ;
    $resultat = mysqli_query($dblink, $sql);
    

}

//echo $fornavn . " ";
//echo $etternavn . "<br>";
//echo $hund . "<br>";

//$n = rand(0,count($hundTab)-1);
//$hund = $hundTab[$n];

function registrerTestBruker($dblink,$epost,$passord) {
    $passord = password_hash($passord, PASSWORD_DEFAULT);

    //sjekker at epost ikke finnes fra før
    $sql = "SELECT * FROM bruker WHERE epost = '$epost'";
    $resultat = mysqli_query($dblink, $sql);
    $antall = mysqli_num_rows($resultat);
    if ($antall > 0) { // epost finnes fra før!
        echo "<br>".'<i style="color:red; position:absolute";"> epost er allerede registrert! </i>'; 
    }

    //registrerer ny bruker
    else {
        $sql = "INSERT INTO bruker(epost,passord) 
        VALUES ('$epost','$passord');";
        $resultat = mysqli_query($dblink, $sql);
    }
    echo "Ferdig med å lage testdata";
    
}