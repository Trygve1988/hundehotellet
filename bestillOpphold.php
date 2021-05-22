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
			<form id="bestillOpphold1Skjema" class="skjemaBakgrunn" method="POST">

				<!-- Overskrift -->
				<h2 class="hovedOverskrift">Bestill opphold</h2>
				<p>Bø Hundehotell har kapastitet til max 3 hunder i samme bur.</p>
            	<p>Vennligst bestill flere ganger viss du ønsker å bestille opphold til flere en 3 hunder.</p><br>
			
				<h3>Velg hund(er):</h3>
				<div>
					<!-- "Velg hund" knapp -->
					<div id="velgHundKnappContainer"></div>  

					<!-- Her må det settes inn valg av hund!! --> 

					<!-- " + Registrer ny hund"- knapp -->
					<a href = "registrerHundBO.php">
						<input class="inputButton ekstraKnapp" type="button" value="+ Registrer ny hund">
					</a>
				</div>

				<!-- Neste-knapp -->
				<div class="etterKolonnerKnapp">
					<a href = "bestillOpphold2.php">
	                	<input class="inputButton hovedKnapp" type="button" value="Neste"> 
	            	</a>
            	</div>
				<!-- Tilbakemelding til bruker -->
				<p id="bestillOpphold1Mld"></p> 	
			</form>
		</div>
	</main>

	<!-- ************************** fellesBunn ************************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>