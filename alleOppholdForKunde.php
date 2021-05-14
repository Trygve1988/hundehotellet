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
	
			<!-- Skjema-->	
			<form class="skjemaBakgrunn" method="POST">

				<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

				<!-- Overskrift -->
				<h2>Alle opphold</h2>

                <!-- Nedtrekksliste -->
                <label for="sammeBur">Velg år</label>
					<select class="inputSelect" name="velgÅr">
						<option value="2021">2021</option>
						<option value="2020">2020</option>
						<option value="2019">2019</option>
					</select>

                <p>SETT INN TABELL OVER ALLE OPPHOLD</p> 
				<!-- Tilbake til forsiden- knapp -->
                <a href = "index.php">   
                <input class="ekstraKnapp2" type="button" name="tilIndex" value="Tilbake til forsiden">
								
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