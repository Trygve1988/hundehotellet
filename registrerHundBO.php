<?php
include_once "include/funksjoner.php";
include_once "include/funksjonerBestillOpphold.php";
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

	<!-- ************************** Felles topp ************************** -->
	<?php visNav(); ?>

	<!-- ************************** Main ******************************* -->
	
	<main>
		<!-- erLoggetInn sjekk -->
		<?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>
		
		<!-- ************************* (Gunni) ************************* -->
		<!-- Hvit bakgrunn -->	
		<div class="hvitBakgrunn">

			<!-- Skjema -->		
			<form class="skjemaBakgrunn" method="POST">
			
				<!-- Avbryt knapp -->
				<a href = "bestillOpphold.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>	

				<!-- Overskrift -->
				<h2 class="hovedOverskrift">Registrer hund</h2>	

				<div class="skjemaKolonner">
					<div class="kolonne1">
						<!-- Labels og input i kolonne 1 -->
						<label for="hNavn">Hundens navn:</label>
						<input  class="inputTekst" type="text" name="navn" value="Pluto" required>
			
						<label for="rase">Rase:</label>
						<input class="inputTekst" type="text" name="rase" value="Labrador" required >	

						<label for="fDato">Fødselsdato:</label>
						<input class="inputDato" type="date" name="fdato" value="2010-01-01" required >	

						<label for="kjonn">Kjønn:</label>
						<select class="inputSelect" name="kjønn" required >
							<option value="0">--Velg--</option>
							<option value="1">Hann</option>
							<option value="2">Tispe</option>
						
						</select>	
					
						<label for="sterilisert">Sterilisert:</label>
						<select class="inputSelect" name="sterilisert" required >
							<option value="0">--Velg--</option>
							<option value="1">Ja</option>
							<option value="0">Nei</option>
							
						</select>
					</div>	
					<!-- Labels og input i kolonne 2-->
					<div class="kolonne2">
						<label for="løpeMedAndre">Kan hunden omgås andre hunder:</label>
						<select class="inputSelect" name="løpeMedAndre" required >
							<option value="0">--Velg--</option>
							<option value="1">Ja</option>
							<option value="2">Nei</option>
						
						</select>

						<label for="forID">Fôrtype:</label>
						<select class="inputSelect" name="forID" required > 
							<option value="0">--Velg--</option>
							<option value="1">Royal Canin (vanlig)</option>
							<option value="2">Vom (allergi)</option>
						
						</select>

						<label for="info">Ekstra informasjon:</label>
						<textarea class="tekstboks tekstfelt1" name="info"></textarea>					
					</div>
				</div>

				<!-- registrerHund -->
				<?php registrerHundBestillOpphold($dblink); ?>

				<!-- Knapperad -->
				<div class="knappeRad">
					<div class="knapp1IRad">	
						<!-- Tilbake til Bestill opphold 1 -->
						<a href = "bestillOpphold.php">
	                		<input class="inputButton hovedKnapp" type="button" value="Tilbake"> 
	            		</a>
					</div>
					<div class="etterKolonnerKnapp">
						<!-- Registrer hund-knapp -->
						<a href = "bestillOpphold3.php">
	                		<input class="inputSubmit hovedKnapp" type="submit" value="Registrer hund" name="registrer"> 
	            		</a>	
					</div>
				</div>

			</form>
		</div>
	</main>

	<!-- ************************** Felles bunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>