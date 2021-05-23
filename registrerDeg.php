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

	<!-- **************************   main    ************************** -->
	<main>
		<!-- ************************ (Gunni) ************************** -->
		<!-- Hvit bakgrunn -->	
		<div class="hvitBakgrunn">		
			
			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST"> 
				
				<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

				<!-- Overskrift -->
				<h2 class="hovedOverskrift">Registrer ny bruker</h2>

				<div class="skjemaKolonner">
					<div class="kolonne1">
						<!-- Labels og input i kolonne 1 -->
						<label for="fornavn">Fornavn:</label>
						<input  class="inputTekst" type="text" name="fornavn" required  value="peter">

						<label for="fDato">Fødselsdato:</label>
						<input class="inputDato" type="date" name="fDato" placeholder="YYYY-MM-DD" required value="2000-01-01">	

						<label for="tlf">Telefonnummer:</label>
						<input class="inputTekst" type="text" name="tlf" required pattern="[0-9]{8}" value="77733111">	
						
						<label for="adresse">Adresse:</label>
						<input class="inputTekst" type="text" name="adresse" required value="Epleveien 5">	
						
						<label for="postNr">Postnummer:</label>
						<input class="inputTekst" type="text" name="postNr" required pattern="[0-9]{4}" value="9944">	

						<!-- velg brukertype (bare for testing)  -->
						<select class="inputSelect" name="brukertype">
							<option value="kunde">kunde</option>
							<option value="ansatt">ansatt</option>
							<option value="admin">admin</option>
                   		</select>
					</div>
					
					<div>
						<!-- Labels og input i kolonne 2 -->
						<label for="etternavn">Etternavn:</label>
						<input class="inputTekst" type="text" name="etternavn" required value="griffin">	
						
						<label for="epost">E-post:</label>
						<input class="inputTekst" type="text" name="epost" required pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" value="test@ha.no">	
							
						<label for="passord">Ønsket passord:</label>
						<input class="inputPassord" type="password" name="passord" required 
						id="passord" pattern="[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15})" value="123Ab%12">

						<!-- Vis passord checkbox -->
						<div class="visPassord">
							<label for="passordCheckbox">Vis Passord</label>
							<input class="inputCheckbox" type="checkbox" name="passordCheckbox" onclick="visPassord()">
						</div>
						<!-- Passord tilbakemelding -->
						<div class="passordKrav">
							<p>Passord krav:</p>
							<p id="status" melding()></p>
						</div>
						
						<div class="gjentaPKolonne">
							<label for="passordSjekk">Gjenta passord:</label>
							<input class="inputPassord" type="password" name="passordSjekk" required value="123Ab%12">	
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

				<!-- registrerDeg (Trygve) -->
				<?php registrerDeg($dblink); ?> 

			</form>	
		</div>
			
	</main>

	<!-- ************************** fellesBunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>