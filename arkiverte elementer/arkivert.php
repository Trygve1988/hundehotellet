function bestillOpphold($dblink) {
    if (isset($_POST['endreHund'])) { 
        $hund = $_POST['hund'];
        opprettHundSession($hund); 
    }
    if (isset($_POST['bestill'])) { 
        $startTidspunkt = $_POST['startTidspunkt'];
        $sluttTidspunkt = $_POST['sluttTidspunkt'];
        $bestiltDato = date("Y/m/d");
        $prisID = 1; //MÅ FINNE RIKTIG prisID !!!!!!!!!!!!!!!!
        //finner hundId ut i fra hundNavn
        $navn = $_SESSION['hund'];
        $sql = "SELECT * FROM hund WHERE navn = '$navn';";
        $resultat = mysqli_query($dblink, $sql); 
        $hundID = 1;
        while($rad = mysqli_fetch_assoc($resultat)){
            $hundID = $rad['hundID'];
        }
        $burID = 1; //MÅ FINNE LEDIG BUR!!!!!!!!!!!!!!!!

        $sql = "INSERT INTO opphold(startTidspunkt,sluttTidspunkt,bestiltDato,prisID,hundID,burID)
        VALUES ('$startTidspunkt','$sluttTidspunkt','$bestiltDato','$prisID','$hundID','$burID');";
        $resultat = mysqli_query($dblink, $sql);

        echo "bestilling til hund " . $navn. " registrert" . "<br>";;
    }
}