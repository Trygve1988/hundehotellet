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
</head>

<body>

	<!-- ************************** fellesTop ************************** -->
	<?php visNav(); ?>

	<!-- **************************   main    ************************** -->
	<main>
		<!-- ************************ (Gunni) ************************** -->
		<!-- Hvit bakgrunn -->	
		<div class="hvitBakgrunn">		
			
			<!-- Skjema -->	
			<form class="skjemaBakgrunn">
				
				<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

				<!-- Overskrift -->
				<h1>Registrer ny bruker</h1>

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

						<!-- Vis passord checkbox -->
						<div class="visPassord">
							<label for="passordCheckbox">Vis Passord</label>
							<input class="inputCheckbox" type="checkbox" name="passordCheckbox" onclick="visPassord()">
						</div>
						<!-- SKRIV INN PASSORDTILBAKEMELDING-->
						<div class="passordKrav">
							<p>Passord krav:</p>
							<p id="status" melding()></p>
						</div>
						
						<div class="gjentaPKolonne">
							<label for="passordSjekk">Gjenta passord:</label>
							<input class="inputPassord" type="password" name="passordSjekk">	
						</div>
					</div>
				</div>

				<div class="etterKolonnerKnapp">
					<!--Registrer knapp-->
						<a href="index.php">
							<input class="hovedKnapp2 inputSubmit" type="submit" name="registrerBruker" value="Registrer ny bruker"> <!-- HVOR SKAL DENNE LEDE?? -->
						</a>
							<!-- Logg inn link -->
					<p class="ekstraLink"> <a class="link" href="loggInn.php">Har du allerede en bruker? Logg inn her</a></p>
				</div>
				</div>
				<!-- ************************** (Trygve) ************************** -->
				<!-- registrerDeg -->
				<?php registrerDeg($dblink); ?> 
			</form>	
		</div>
			
	</main>

	<!-- ************************** fellesBunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>