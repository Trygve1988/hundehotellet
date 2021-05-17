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
		
		<!-- ************************ (Gunni) ****************************** -->
		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
			
			<!-- Skjema -->	
			<form class="skjemaBakgrunn">
			
				<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>
				
				<!-- Overskrift -->
				<h2 class="hovedOverskrift">Bestill opphold</h2>	
				<!-- Valg om hundene skal være i samme bur (lagt på is) -->
				<!--<label for="sammeBur">Skal hundene være i samme buret:</label>
				<select class="inputSelect" name="sammeBur">
					<option value="velg">--Velg--</option>
					<option value="hannhund">Ja</option>
					<option value="tispe">Nei</option>
				</select>
				</div>
				-->
				<h2 class="overskrift2">Tidsperiode</h2>
				
				<div class="soloKolonne">
					<div class="kolonne1">		
						<label for="fra">Fra:</label>
						<input class="inputDato" type="date" name="fra">		
							
						<!-- Labels og input i kolonne 2 -->
						<label for="til">Til:</label>
						<input class="inputDato" type="date" name="til">	
					</div>
		
					<h2 class="overskrift2">Tillegstjenester</h2>
					<p>Vi tilbyr bading til hunden(e). Prisen for bading pr. hund pr. bad er 200kr</p>
					<div class="soloKolonne">
						<div class="skjemaKolonner">
							<input class="storCheckbox" type="checkbox" name="hund1">
							<input class="inputTekst" type="text" name="hund1" value="Hund 1">
						</div>
						<div class="skjemaKolonner">
							<input class="storCheckbox" type="checkbox" name="hund2"> 
							<input class="inputTekst" type="text" name="hund1" value="Hund 1">
						</div>
					</div>
				</div>
			<!-- Knapperad -->
			<div class="knappeRad">
				<div class="knapp1IRad">
					<!-- Tilbake-knapp-->
					<a href = "bestillOpphold.php">
		           		<input class="inputButton hovedKnapp" type="button" value="Tilbake"> 
		       		</a>
				</div>
				<div class="etterKolonnerKnapp">
					<!-- Neste-knapp -->
					<a href = "bestillOpphold3.php">
		            	<input class="inputButton hovedKnapp" type="button" value="Neste"> 
		            </a>	
				</div>
			</div>			
			</form>
		</div>	
	</main>

	<!-- ************************** fellesBunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>