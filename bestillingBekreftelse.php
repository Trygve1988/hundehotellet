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

	<!-- ************************** main  ****************************** -->
	<main>

		<!-- erLoggetInn sjekk -->
		<?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>
		
		<!-- ************************ (Gunni) ************************** -->
		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
			<!-- Skjema -->	
			<form class="skjemaBakgrunn">

				<!-- Avbryt knapp -->
				<input class="inputButton avbrytKnapp" type="button" name="avbryt" value="X">

				<!-- Overskrift -->
				<h2 class="hovedOverskrift">Bekreftelse på bestilling</h2>
			
                <p>SETT IN TEKST FOR BEKREFTELSE PÅ OPPHOLD!!</p> 
				<!-- Tilbake til forsiden- knapp -->
                <a href = "index.php">   
                <input class="inputButton hovedKnapp" type="button" name="tilIndex" value="Tilbake til forsiden">
								
			</form>
		</div>
	</main>

	<!-- ************************** fellesBunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>