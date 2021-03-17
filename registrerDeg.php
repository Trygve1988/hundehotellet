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
    <link href="include/style.css" rel="stylesheet" type="text/css">
    <script src="include/script.js" defer> </script>
</head>
<body>

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visBildeBakgrunn(); ?>
	<?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main>
		<div class="hovedBakgrunn"> 
		
			<!-- Form-->	
			<form method="POST">

				<!-- Overskrift -->
				<h2>Registrer ny bruker</h2>

				<div class="skjemaKolonner">
					<div class="kolonne 1">
						<!-- Labels og input i kolonne 1 -->
						<label for="epost">E-post:</label>
						<input type="text" name="epost" value="eks@gmail.com">
					
						<label for="passord">Ønsket passord:</label>
						<input id="passord" type="text" name="passord" value="passord123">
						<p id="status" melding()></p>

						<!-- Vis passord checkbox! -->
						<div class="visPassord">
							<label>Vis passord</label>
							<input id="visPassordKnapp" type="checkbox" name="visPassord" value="visPassord">
						</div>

						<!-- Vis passord status (Even) -->
						<p id="status" melding()></p>

						<label for="tlf">Telefonnummer:</label>
						<input type="text" name="tlf" value="11199333">
						
						<!--Registrer knapp-->
						<input type="submit" name="registrer" value="registrer">

						<!-- Logg inn link -->
						<p class="ekstraLink"> <a href="loggInn.php">Har du allerede en bruker? Logg inn her</a></p>
					</div>
					<div class="kolonne2">
						<!-- Labels og input i kolonne 2-->
						<label for="fornavn">Fornavn:</label>
						<input type="text" name="fornavn" value="eksFornavn">
				
						<label for="etternavn">Etternavn:</label>
						<input type="text" name="etternavn" value="eksEtternavn">
					
						<label for="adresse">Adresse:</label>
						<input type="text" name="adresse" value="eksAdresse">
					</div>
				</div>
				<!-- 2b) registrerDeg (Trygve) -->
				<?php registrerDeg($dblink); ?> 
			</form>
		</div>
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>






