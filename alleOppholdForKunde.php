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

	<!-- ************************** main ******************************* -->
	<main>

		<!-- erLoggetInn sjekk -->
		<?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>

		<!-- ************************ (Gunni) **************************  -->
		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">

			<!-- Skjema -->	
			<form class="skjemaBakgrunn">

				<!-- Avbryt knapp -->
				<a href = "minSide.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

				<!-- Overskrift -->
				<h2 class="hovedOverskrift">Alle opphold</h2>

                <!-- Nedtrekksliste -->
                <label for="sammeBur">Velg år</label>
					<select class="inputSelect litenInput" name="velgÅr">
						<option value="2021">2021</option>
						<option value="2020">2020</option>
						<option value="2019">2019</option>
					</select>
				<div class="soloKolonne">
                <p>SETT INN TABELL OVER ALLE OPPHOLD</p> 
				
				<!-- Tilbake til forsiden- knapp -->
				</div>
               <div class="etterKolonnerKnapp"> 
               		<a href = "index.php">   
                		<input class=" inputButton hovedKnapp" type="button" name="tilIndex" value="Tilbake til forsiden">
            		</a>
				</div>				
			</form>
		</div>
	</main>

	<!-- ************************** fellesBunn **************************-->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>