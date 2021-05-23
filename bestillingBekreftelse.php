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
	<title>Bekreftelse på bestilling</title>
	<link href="include/style.css" rel="stylesheet" type="text/css">
	<link href="include/takkMelding.scss" rel="stylesheet">
	<!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
	<script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
	<script src="include/script.js" defer> </script>
	<script src="include/scriptSpraak.js" defer> </script>
</head>

<body>

	<!-- ************************** fellesTop ************************** -->
	<?php visNav(); ?>

	<!-- ************************** main  ****************************** -->
	<main>

		<!-- erLoggetInn sjekk --> 
		<?php /* if (!erLoggetInn()) { header('Location: loggInn.php'); } Grået ut for å teste*/ ?>
		
		<!-- ************************ (Gunni) ************************** -->
		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
			<!-- Skjema -->	
			 <!--Måtte lage min egen "bakgrunn" der jeg fjernet den grå bakgrunnen for å få meldingen mer i midten -->
			<form class="skjemaBakgrunn1">

	<!-- ************************ (Kristina) ************************** -->
				

					<div class="takkSiden">
						<div class="module">
							<!--Module(fontawesome)  -->
							<!-- gratis Opp ikon fra https://fontawesome.com/icons/check-circle?style=solid -->
							<i class="fas fa-check-circle fa-2x"></i>
							<!-- Overskrift -->
							<h2 class="hovedOverskrift">Bekreftelse på bestilling</h2>

							<p>Din bestilling er nå mottatt!</p>
							<p> Du kan sjekke bestillingen på <a class="link" href="minSide.php">Min Side.</a></p>
								Har du noe spørsmål angående oppholdet kan du ta kontakt med oss enten på tlf 12345678
								eller <a href="mailto:bohundehotell@outlook.com">bohundehotell@outlook.com </a> 
							</p> 
							
							<!-- -->

								<!-- Tilbake til forsiden- knapp (Gunni)-->
								<a href="index.php">
									<input class="inputButton hovedKnapp" type="button" name="tilIndex" value="Tilbake til forsiden"> </a>
							
								
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