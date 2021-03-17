<?php
$dblink = mysqli_connect("localhost", "root", "", "hundehotellet");

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