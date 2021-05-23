<?php
include_once "include/funksjoner.php";
session_start();
$dblink = kobleOpp();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bø Hundehotell</title>
	<link href="include/style.css" rel="stylesheet" type="text/css">
	<!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
	<script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
	<script src="include/script.js" defer> </script>
    <script src="include/scriptSpraak.js" defer> </script>
</head>

<body>

	<!-- ************************** fellesTop ************************** -->
	<?php visNav(); ?>


	<!-- ************************** main ******************************* -->
	<main>
	    <!-- erLoggetInn sjekk -->
        <?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>
        
    	<!-- ************************ (Gunni) ************************** -->
		<!-- Hvit bakgrunn -->  
        <div class="hvitBakgrunn">      
            
            <!-- Skjema --> 
            <form class="skjemaBakgrunn" method="POST">
                
                <!-- Avbryt knapp -->
                <a href = "minSide.php">
                    <input class="avbrytKnapp" type="button" value="X">
                </a>

                <!-- Overskrift -->
                <h2 class="hovedOverskrift">Rediger informasjon</h2>
    
                <h3 class="overskrift2">Min profil</h3>

                <div class="skjemaKolonner">
                    <div class="kolonne1">
                        <!-- Labels og input i kolonne 1 -->
                        <label for="fornavn">Fornavn:</label>
                        <input  class="inputTekst" type="text" name="fornavn">

                        <label for="fDato">Fødselsdato:</label>
                        <input class="inputDato" type="date" name="fDato">  

                        <label for="tlf">Telefonnummer:</label>
                        <input class="inputTekst" type="text" name="tlf">

                        <label for="adresse">Adresse:</label>
                        <input class="inputTekst" type="text" name="adresse">
                        
                        <label for="postNr">Postnummer:</label>
                        <input class="inputTekst" type="text" name="postNr">
                    </div>
                    
                    <div>
                        <!-- Labels og input i kolonne 2 -->
                        <label for="etternavn">Etternavn:</label>
                        <input class="inputTekst" type="text" name="etternavn">

                        <label for="epost">E-post:</label>
                        <input class="inputTekst" type="text" name="epost">
                    
                        <label for="passord">Ønsket passord:</label>
                        <input class="inputPassord" type="password" name="passord" required id="passord">   
                        <!-- Vis passord checkbox! -->
                        <div class="visPassord">
                            <input class="inputCheckbox" type="checkbox" onclick="visPassord()">Vis Passord
                        </div>
                        <!-- Passord krav -->
                        <div class="passordKrav">
                            <p>Passord krav:</p>
                            <p id="status" melding()></p>
                        </div>
                    </div>
                </div>

                <div class="etterKolonnerKnapp">
                    <!-- Registrer knapp-->
                        <a href="index.php">
                            <input class="hovedKnapp inputSubmit" type="submit" name="oppdaterBruker" value="Lagre"> <!-- HVOR SKAL DENNE LEDE?? -->
                        </a>
                </div>
            </form>
        </div>	
	</main>

	<!-- **************************  fellesBunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>