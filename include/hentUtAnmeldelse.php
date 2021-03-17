<?php
$dblink = mysqli_connect("itfag.usn.no", "pw5", "", "h20APP2000grdb5");

$anmeldelseID = $_GET['q'];
$sql = "SELECT * FROM anmeldelse WHERE anmeldelseID = '$anmeldelseID';"; 
$resultat = mysqli_query($dblink,$sql);

//er det flere anmeldelser?
if (mysqli_num_rows($resultat)==0) { 
    echo -1; 
}
else {
    while($rad = mysqli_fetch_assoc($resultat)) {
        echo $rad['tekst']; 
    }
}
?>