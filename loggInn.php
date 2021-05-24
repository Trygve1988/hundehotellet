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
	<script src="include/scriptSpraak.js" defer> </script>
</head>

<body>

	<!-- ************************** fellesTop ************************** -->
	<?php visNav(); ?>

	<!-- **************************  main  ***************************** -->
	
	<main>
		<!-- ************************ (Gunni) ************************** -->
		<!-- Hvit bakgrunn -->	
		<div class="hvitBakgrunn">

			<!-- Skjema -->		
			<form class="skjemaBakgrunn" method="POST">	

				<!-- Overskrift -->
				<h2 id="loggInn" class="hovedOverskrift">Logg inn</h2>	

				<div class="skjemaKolonner">
					<div>
						<!-- Labels og input i kolonne 1 -->
						<label id="epostLoggInn" for="epost">E-post:</label>
						<input class="inputTekst" type="text" name="epost" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="test@ha.no">

						<label id="passordloggInn" for="passord">Passord:</label>
						<input class="inputPassord" type="password" name="passord" required id="passord" value="123Ab%12">

						<!-- Vis passord checkbox  -->
						<div class="visPassord">
							<label id="visPassordLogInn" for="visPassord">Vis Passord</label> <input class="vanligCheckbox" type="checkbox" onclick="visPassord()">
						</div>	
					</div>
				</div>

				<!--Logg inn knapp-->
				<div class="etterKolonnerKnapp bunnKnapp">
					<div class="loggInnKnapp">
						<input class="inputSubmit hovedKnapp" type="submit" name="loggInn" value="Logg Inn">
					</div>	
					<!-- Glemt passord og Registrer deg linker -->
					<div class="ekstraLinker"> 
						<a id="glemtPassord" class="link link1" href="#">Glemt passord</a>
						<a id="registrerDeg" class="link" href="registrerDeg.php">Registrer deg</a>
					</div>
				</div>
				<!-- ************************** (Trygve)************************** -->
				<!-- loggInn -->
				<?php loggInn($dblink); ?> 	
			</form>
		</div>
		
	</main>

	<!-- ************************** fellesBunn *********************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>