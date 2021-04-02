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
			<img class="bildeBakgrunn" src="bilder/bakgrunn.jpg">
			<!-- Form-->
			<form method="POST">

				<h2>Bestill opphold</h2>
				<h3>Tidsperiode</h3>
				<div class="skjemaKolonner">
					<div class="kolonne1">

						<!-- Inputen her er date -->
						<label for="fra">Fra:</label>
						<input type="date" name="fra">

						<p>Jeg ønsker bading til hunden(e) mine under oppholdet (200kr per hund)</p>
						<input type="checkbox" name="bading">
						<input type="text" name="hund">
					</div>
					<div>
						<!-- Labels og input i kolonne 2-->
						<label for="til">Til:</label>
						<input type="date" name="til">
					</div>
				</div>
				<p>Sum å betale:</p>
				<!--Denne må endres i CSS'en!-->
				<div class="leggTillKnapp">
					<input type="submit" name="tilbake" value="Tilbake">
					<input type="submit" name="neste" value="Neste">
					<a href="bestillOpphold.php">tilbake</a>
					<a href="bestillOpphold3.php">neste</a>
				</div>
		</div>
		</form>
	</main>

	<!-- ************************** 3) fellesBunn **************************-->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>

</html>