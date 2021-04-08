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

	<!-- ************************** 1) fellesTop ************************** -->
	<?php visNav(); ?>

	<!-- ************************** 2) main **************************-->
	
	<main>
		<div class="hovedBakgrunn"> 	

			<!-- Form-->	
			<form class="skjemaBakgrunn" method="POST">
			
			<!-- Avbryt knapp -->
			<input class="avbrytKnapp" type="submit" name="avbryt" value="X">	

			<!-- Overskrift -->
			<h1>Registrer ny bruker</h1>	

			<div class="skjemaKolonner">
				<div class="kolonne1">
					<!-- Labels og input i kolonne 1 -->
					<label for="fornavn">Fornavn:</label>
					<input type="text" name="fornavn">	

					<label for="fDato">Fødselsdato:</label>
					<input type="date" name="fDato">		

					<label for="tlf">Telefonnummer:</label>
					<input type="text" name="tlf">	

					<label for="adresse">Adresse:</label>
					<input type="text" name="adresse">
					
					<label for="postNr">Postnummer:</label>
					<input type="text" name="postNr">
				</div>
			<div>
			
			<!-- Labels og input i kolonne 2 -->

			<label for="etternavn">Etternavn:</label>
				<input type="text" name="etternavn">
				<label for="epost">E-post:</label>
				<input type="text" name="epost">
			
				<label for="passord">Ønsket passord:</label>
				<input type="password" name="passord">		

				<!-- Vis passord checkbox! -->
				<div class="visPassord">
					<label>Vis passord</label>
					<input type="checkbox" name="visPassord" value="visPassord">
				</div>
				<!-- SKRIV INN PASSORDTILBAKEMELDING-->
				<div class="visPassord2">
					<p>Passord krav:</p>
					<p> - SETT INN PASSORD TILBAKEMELDING</p>
				</div>
				
				<div class="gjentaPKolonne">
					<label for="passordSjekk">Gjenta passord:</label>
					<input type="password" name="passordSjekk">	
				</div>	
			</div>	
			<div class="knappeKlynge">
				<!--Registrer knapp-->
				<input class="hovedKnapp2" type="submit" name="registrerBruker" value="Registrer ny bruker">
				<!-- Logg inn link -->
				<p class="ekstraLink2"> <a href="registrering.i">Har du allerede en bruker? Logg inn her</a></p>
			</div>
			
			</div> <!-- Her kan det være noe feil!-->
			<!-- 2b) registrerDeg (Trygve) -->
			<?php registrerDeg($dblink); ?>
		</form>
		</div>
	</main>

	<!-- ************************** 3) fellesBunn **************************-->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>

</html>