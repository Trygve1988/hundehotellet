<?php
include_once "include/funksjoner.php";
include_once "include/funksjonerMinSide.php";
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

	<!-- ************************** Main ********************************* -->
	
	<main>
		<!-- erLoggetInn sjekk -->
		<?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>
		
		<!-- ************************* (Gunni) ************************** -->
		<!-- Hvit bakgrunn -->	
		<div class="hvitBakgrunn">

			<!-- Skjema -->		
			<form class="skjemaBakgrunn" method="POST">
			
				<!-- registrerHund -->
				<?php minSideRegistrerHund($dblink); ?>
			
				<!-- Avbryt knapp -->
				<a href = "minSide.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>	

				<!-- Overskrift -->
				<h2 id="registerHund" class="hovedOverskrift">Registrer hund</h2>	

				<div class="skjemaKolonner">
					<div class="kolonne1">
						<!-- Labels og input i kolonne 1 -->
						<label id="hundNavn" for="hNavn">Hundens navn:</label>
						<input  class="inputTekst" type="text" name="navn" required>
			
						<label id="rase" for="rase">Rase:</label>
						<input class="inputTekst" type="text" name="rase" required>	

						<label id="fdato" for="fDato">Fødselsdato:</label>
						<input class="inputDato" type="date" name="fdato" required>	

						<label id="kjønn" for="kjonn">Kjønn:</label>
						<select class="inputSelect" name="kjønn" required >
							<option id="velg" value="0">--Velg--</option>
							<option id="hann" value="1">Hann</option>
							<option id="tispe" value="2">Tispe</option>
						</select>	
						
						<label id="sterilisert" for="sterilisert">Sterilisert:</label>
						<select class="inputSelect" name="sterilisert" required >
							<option id="velg" value="0">--Velg--</option>
							<option id="ja" value="1">Ja</option>
							<option id="nei" value="0">Nei</option>	
						</select>
					</div>	
					<!-- Labels og input i kolonne 2 -->
					<div class="kolonne2">
						<label id="løpeMedAndre" for="løpeMedAndre">Kan hunden omgås andre hunder:</label>
						<select class="inputSelect" name="løpeMedAndre" required >
							<option id="velg" value="0">--Velg--</option>
							<option id="ja2" value="1">Ja</option>
							<option id="nei2" value="2">Nei</option>
						</select>

						<select class="inputSelect" name="forID" required > 
							<option id="velg" value="0">--Velg--</option>
							<option id="vanlig" value="1">Royal Canin (vanlig)</option>
							<option id="allargi" value="2">Vom (allergi)</option>
						</select>

						<label id="ektraInfo" for="info">Ekstra informasjon:</label>
						<textarea class="tekstboks tekstfelt1" name="info"></textarea>					
					</div>
				</div>
				
				<!-- Knapperad -->
				<div class="knappeRad">
					<div class="knapp1IRad">		
						<!-- Tilbake til Min side -->
						<a href = "minSide.php">
	                		<input class="inputButton hovedKnapp" type="button" value="Tilbake"> 
	            		</a>
					</div>
					<div class="etterKolonnerKnapp">
						<!-- Registrer knapp -->
						<a href = "minSide.php">
	                		<input class="inputSubmit hovedKnapp2" type="submit" value="Registrer hund" name="registrer"> 
	            		</a>	
					</div>
				</div>
			</form>
		</div>
	</main>

	<!-- ************************** Felles bunn **************************-->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>