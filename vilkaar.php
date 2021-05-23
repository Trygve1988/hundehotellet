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

	<!-- **************************   main    ************************** -->
	<main>
		<!-- ************************ (Gunni) ************************** -->
		<!-- Hvit bakgrunn -->	
		<div class="hvitBakgrunn">		
			
			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST"> 
				
				<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

				<!-- Overskrift -->
				<h2 class="hovedOverskrift">Vilkår og betingelser</h2>

                <!--Tilbake til bestilling-->
                    <div class="etterKolonnerKnapp">
                            <a href="bestillOpphold4.php">
                                <input class="inputButton hovedKnapp2" type="button" value="Tilbake til bekreftelse">
                            </a>
                    </div>
            		
			</form>	
		</div>
			
	</main>

	<!-- ************************** fellesBunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>