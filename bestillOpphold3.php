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

	<!-- ************************** main ******************************* -->
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

				<h2 class="overskrift2">Tidsperiode</h2>
				
				<div class="soloKolonne">
					<div class="kolonne1">		
						<label for="fra">Fra:</label>
						<input class="inputDato" type="date" name="fra">		
							
						<!-- Labels og input i kolonne 2 -->
						<label for="til">Til:</label>
						<input class="inputDato" type="date" name="til">	
					</div>
				</div>
			<!-- Knapperad -->
			<div class="knappeRad">
				<div class="knapp1IRad">
					<!-- Tilbake-knapp-->
					<a href = "bestillOpphold.php">
		           		<input class="inputButton hovedKnapp" type="button" value="Tilbake"> 
		       		</a>
				</div>
				<div class="etterKolonnerKnapp">
					<!-- Neste-knapp -->
					<a href = "bestillOpphold3.php">
		            	<input class="inputButton hovedKnapp" type="button" value="Neste"> 
		            </a>	
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