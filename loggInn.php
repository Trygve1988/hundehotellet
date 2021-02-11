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
    <?php visNav(); ?>

    <!-- ************************** 2) main (gunni) **************************-->
    <main>
		<div class="hovedBakgrunn"> 
			<!-- Form-->	
			<form method="POST">

				<!-- Overskrift -->
				<h2>Logg inn</h2>

				<div class="regForm">
					<div class="regFormKol1">
						<!-- Labels og input i kolonne 1 -->
						<label for="epost">E-post:</label>
						<input type="text" name="epost" value="eks@gmail.com">
					
						<label for="passord">Passord:</label>
						<input id="passord" type="text" name="passord" value="passord123">

						<!-- Vis passord radio knapp! -->
						<div class="visPassord">
							<label>Vis passord</label>
							<input id="visPassordKnapp" type="radio" name="visPassord" value="visPassord">
						</div>
						
						<!-- Vis passord status (Even) -->
						<p id="status" melding()></p>

						<!--Logg inn knapp-->
						<input type="submit" name="loggInn" value="loggInn">
						

						<!-- Glemt passord og Registrer deg linker -->
						<div class="ekstraLink"> 
							<a href="loggInn.php">Glemt passord</a>
							<a href="registrerDeg.php">Registrer deg</a>
						</div>
					</div>
				</div>
				<!-- 2b) loggInn (Trygve) -->
				<?php loggInn($dblink); ?> 
			</form>
		</div>
    </main>


    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>