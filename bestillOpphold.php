<?php
include_once "include/funksjoner.php";
include_once "include/funksjonerBestillOpphold.php";
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
				<h2 class="bestillOpphold" class="hovedOverskrift">Bestill opphold</h2>
				<p id="bestillOppholdText">Bø Hundehotell har kapastitet til max 3 hunder i samme bur.</p>
            	<p id="bestillOppholdText2">Vennligst bestill flere ganger viss du ønsker å bestille opphold til flere en 3 hunder.</p><br>
			
				<h3 id="velgHunder">Velg hund(er):</h3>
				<div>
					<!-- "Velg hund" knapp -->
					<div id="velgHundKnappContainer"></div>  

					<!-- " + Registrer ny hund"- knapp -->
					<a href = "registrerHundBO.php">
						<input id="registerHund" class="inputButton ekstraKnapp" type="button" value="+ Registrer ny hund">
					</a>
				</div>

				<!-- Neste-knapp -->
				<div class="etterKolonnerKnapp knappeKlyngeHB">
					<!-- <a href = "bestillOpphold2.php"> </a> -->
	                <input id="tilBestillOpphold2Knapp" class="inputButton hovedKnapp" type="button" value="Neste"> 
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