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

	<!-- ************************** 2) main (gunni) **************************-->
	
	<main>
	<div class="hvitBakgrunn">
        <img class="bildeBakgrunn" src="bilder/bakgrunn.jpg">

				<!-- Form-->	
				<form class="skjemaBakgrunn" method="POST">	

				<!-- Avbryt knapp -->
				<input class="avbrytKnapp" type="submit" name="avbryt" value="X">	

				<!-- Overskrift -->
				<h2>Logg inn</h2>	

				<div class="skjemaKolonner">
					<div>
						<!-- Labels og input i kolonne 1 -->
						<label for="epost">E-post:</label>
						<input type="text" name="epost">

						<label for="passord">Passord:</label>
						<input type="password" name="passord" required id="passord">	

						<!-- Vis passord checkbox! -->
						<div class="visPassord">
							<input type="checkbox" onclick="visPassord()">Vis Passord
						</div>	

					</div>
				</div>

				<!--Logg inn knapp-->
				<div class="knappeKlynge">
					<div class="loggInnKnapp">
						<input class="hovedKnapp" type="submit" name="loggInn" value="Logg Inn">
					</div>	
					<!-- Glemt passord og Registrer deg linker -->
					<div class="ekstraLinker"> 
						<a class="link1" href="#">Glemt passord</a>
						<a href="registrerDeg.php">Registrer deg</a>
					</div>
				</div>	
				</form>
		</div>

		<!-- 2c) loggInn -->
		<?php loggInn($dblink); ?> 
	</main>


	<!-- ************************** 3) fellesBunn **************************-->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>

</html>