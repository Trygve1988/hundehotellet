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
		<!-- Hvit bakgrunn-->
		<div class="hvitBakgrunn">
			<!-- Bildebakgrunn-->
            <img class="bildeBakgrunn" src="bilder/bakgrunn.jpg">

			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST">
			
				<!-- Avbryt knapp -->
				<input class="avbrytKnapp" type="submit" name="avbryt" value="X">
				
				<!-- Overskrift-->
				<h2>Bestill opphold</h2>	

				<div>
					<div class="soloKolonne">
						<label for="sammeBur">Skal hundene være i samme buret:</label>
						<select class="inputSelect" name="sammeBur">
							<option value="velg">--Velg--</option>
							<option value="hannhund">Ja</option>
							<option value="tispe">Nei</option>
						</select>
						</div>
						
						<h3>Tidsperiode</h3>
						<div class="enKolonneRad">
							<div class="kolonne1">		
								<label for="fra">Fra:</label>
								<input class="inputDate" type="date" name="fra">		
							</div>
							<div class="kolonne2">
								<!-- Labels og input i kolonne 2-->
								<label for="til">Til:</label>
								<input type="date" name="til">	
							</div>
						</div>	
						<h3>Tillegstjenester</h3>
						<p>Vi tilbyr bading til hunden(e). Prisen for bading pr. hund pr. bad er 200kr</p>
						<div class="soloKolonne">
							<div class="skjemaKolonner">
								<input class="storChecbox" type="checkbox" name="hund1">
								<input class="inputDate" type="text" name="hund1" value="Hund 1">
							</div>
							<div class="skjemaKolonner">
								<input class="storChecbox" type="checkbox" name="hund2">
								<input class="inputDate" type="text" name="hund1" value="Hund 1">
						</div>
					</div>
					<!-- Knapperad -->
					<div class="knapperad">	
						<button onclick="tilBO2Funksjon()" id="tilBO2" class="hovedKnapp"  title="Tilbake">Tilbake</button>
						<div class="nesteKnapp2">
							<button onclick="tilBO4Funksjon()" id="tilBO4" class="hovedKnapp"  title="Neste">Neste</button>
						</div>
					</div>
				</div>	
			</form>
		</div>	
	</main>

	<!-- ************************** 3) fellesBunn **************************-->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>