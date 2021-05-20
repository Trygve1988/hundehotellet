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
	<link href="include/takkMelding.scss" rel="stylesheet">
	<!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
	<script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
	<script src="include/script.js" defer> </script>
</head>

<body>

	<!-- ************************** Felles topp ************************** -->
	<?php visNav(); ?>

	<!-- ************************** Main ******************************* -->
	<main>

		<!-- erLoggetInn sjekk -->
		<?php /*if (!erLoggetInn()) { header('Location: loggInn.php'); } grået ut for å teste*/ ?>

	<!-- ************************ (Gunni (makert i koden hva som er hennes) og Kristina (makert i koden) ) ************************** -->
		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">

			<!-- Skjema -->
					    <!--Måtte lage min egen "bakgrunn" der jeg fjernet den grå bakgrunnen for å få meldingen mer i midten -->
			<form class="skjemaBakgrunn1">

	<!-- ************************ (Kristinas kode) ************************** -->
	<div class="takkSiden">
					<div class="module">
						<!--Module(fontawesome)  -->
						<!-- gratis Opp ikon fra https://fontawesome.com/icons/check-circle?style=solid -->
						<i class="fas fa-check-circle fa-2x"></i>

						<!-- Overskrift -->
						<h2 class="hovedOverskrift">Hunden er registrert!</h2>

						<div class="RegistrertHundTekst">
						<!-- ************************ (Gunn Ingers  tekst og kode) *********************** -->
							<p>*Hunden* er registrert! Hvis du ønsker å se eller endre informasjonen på de
								registrerte hundene dine, kan du gå inn på <a class="link" href="minSide.php">Min Side.</a></p>
						</div>
						<a href="index.php">
							<input class="hovedKnapp inputButton" type="button" name="oppdaterHund" value="Tilbake til forsiden">
						</a>
						<!-- ************************ (Gunn Ingers kode slutt) *************************** -->

					</div>
				</div>
					<!-- ************************ (Kristinas kode slutt) ************************** -->
			</form>
		</div>
	</main>

	<!-- ************************** fellesBunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>

</html>