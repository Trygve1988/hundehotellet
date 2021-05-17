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


	<!-- ************************** main  ************************** -->
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
					<input class="inputButton ekstraKnapp" type="button" value="+ Registrer ny hund">
				</a>
				</div>

				<!-- Neste-knapp -->
				<div class="etterKolonnerKnapp">
					<a href = "bestillOpphold2.php">
	                	<input class="inputButton hovedKnapp" type="button" value="Neste"> 
	            	</a>
            	</div>	
				
				<!-- ************************ (Trygve) ****************************** -->
				<!-- bestillOpphold -->
				<?php velgHund($dblink); ?> 
			</form>
		</div>
	</main>

	<!-- ************************** fellesBunn ************************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>