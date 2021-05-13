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


	<!-- ************************** 2) main (Gunni) **************************-->
	<main>

		<!-- erLoggetInn sjekk -->
		<?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>

		<!-- Hvit bakgrunn-->
		<div class="hvitBakgrunn">
			<!-- Bildebakgrunn-->
			<img class="bildeBakgrunn" src="bilder/bakgrunn.jpg">
	
			<!-- Skjema-->	
			<form class="skjemaBakgrunn" method="POST">

				<!-- Avbryt knapp -->
				<input class="avbrytKnapp" type="submit" name="avbryt" value="X">

				<!-- Overskrift -->
				<h2>Bestill opphold</h2>
			
				<h3>Velg hund(er):</h3>
				<div>
					<div>
						<div class="soloKolonne">
						<input class="inputTekst" type="text" name="hund1" value="Hund 1">
						<input class="inputTekst" type="text" name="hund2" value="Hund 2">
						<input class="inputTekst" type="text" name="hund3" value="Hund 3">
					</div>
				<!-- " + Registrer ny hund"- knapp -->
				<a href = "registrerHund.php">
					<input class="ekstraKnapp2" type="button" value="+ Registrer ny hund">
				</a>
				</div>

				<!-- Neste-knapp -->
				<a href = "bestillOpphold2.php">
                	<input class="hovedknapp" type="button" value="neste"> 
            	</a>
			</form>
		</div>
	</main>
	<!-- Til-toppen-knapp -->
	<button onclick="toppKnappFunksjon()" id="Knappen" title="Gå til toppen">Top</button>

	<!-- 2g bestillOpphold -->
	<?php velgHund($dblink); ?> 

	<!-- ************************** 3) fellesBunn **************************-->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>