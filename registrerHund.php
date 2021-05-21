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

	<!-- ************************** main ******************************* -->
	
	<main>
		<!-- erLoggetInn sjekk -->
		<?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>
		
		<!-- ************************* (Gunni) ************************* -->
		<!-- Hvit bakgrunn -->	
		<div class="hvitBakgrunn">

			<!-- Skjema -->		
			<form class="skjemaBakgrunn" method="POST">
			
				<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>	

				<!-- Overskrift -->
				<h2 class="hovedOverskrift">Registrer hund</h2>	

				<div class="skjemaKolonner">
					<div class="kolonne1">
						<!-- Labels og input i kolonne 1 -->
						<label for="hNavn">Hundens navn:</label>
						<input  class="inputTekst" type="text" name="navn" value="pluto">
			
						<label for="rase">Rase:</label>
						<input class="inputTekst" type="text" name="rase" value="labrador">	

						<!-- Inputen for fødselsdato er date -->
						<label for="fDato">Fødselsdato:</label>
						<input class="inputDato" type="date" name="fdato" value="2010-01-01">	

						<!-- Nedtrekkslister -->
						<label for="kjonn">Kjønn:</label>
						<select class="inputSelect" name="kjønn">
							<option value="gutt">gutt</option>
							<option value="jente">jente</option>
							<option value="velg">--Velg--</option>
						</select>	
					
						<label for="sterilisert">Sterilisert:</label>
						<select class="inputSelect" name="sterilisert">
							<option value="1">Ja</option>
							<option value="0">Nei</option>
							<option value="velg">--Velg--</option>
						</select>
						
					<!-- Labels og input i kolonne 2-->
					<div class="kolonne2">
						<label for="løpeMedAndre">Kan hunden omgås andre hunder:</label>
						<select class="inputSelect" name="løpeMedAndre">
							<option value="1">Ja</option>
							<option value="0">Nei</option>
							<option value="velg">--Velg--</option>
						</select>

						<label for="forID">Fòrtype:</label>
						<select class="inputSelect" name="forID"> 
							<option value="1">vanlig</option>
							<option value="2">allergi</option>
							<option value="inkludert">Royal Canin</option>
							<option value="inkludert">Vom</option>
							<option value="medbrakt">Medbrakt</option>	
							<option value="velg">--Velg--</option>
						</select>

						<label for="info">Ekstra informasjon:</label>
						<textarea class="tekstboks tekstfelt1" name="info"></textarea>					
					</div>

				</div>
				<!-- Registrer hund-knappp 
				<div> 
					<a href="minSide.php">
						<input class="inputButton" type="button" value="Tilbake"> 
					</a>
					<a href="hundRegistrertBekreftelse.html">
						<input class="inputSubmit" type="submit" name="registrer" value="Registrer hund"> 
					</a>
				</div>	
				 ************************** (Trygve) ************************** -->	
			</form>
		</div>

		<!-- registrerHund -->
		<?php registrerHund($dblink); ?>

	</main>

	<!-- ************************** fellesBunn **************************-->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>