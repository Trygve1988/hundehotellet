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
				<h2>Registrer ny hund</h2>

				<div class="skjemaKolonner">
					<div class="kolonne1">
						<!-- Labels og input i kolonne 1 -->
						<label for="navn">Hundens navn:</label>
						<input type="text" name="navn" value="pluto">
					
						<label for="rase">Rase:</label>
						<input type="text" name="rase" value="labrador">

						<!-- Inputen for fødselsdato er date -->
						<label for="fdato">Fødselsdato:</label>
						<input type="date" name="fdato" value="2015-01-01">

						<!-- Nedtrekkslister! -->
						<label for="kjønn">Kjønn:</label>
						<select name="kjønn">
							<option value="gutt">gutt</option>
							<option value="jente">jente</option>
						</select>

						<label for="sterilisert">Sterilisert:</label>
						<select name="sterilisert">
							<option value="1">Ja</option>
							<option value="0">Nei</option>
						</select>
						
						<label for="vaksniert">Vaksinert:</label>
						<select name="vaksniert">
							<option value="1">Ja</option>
							<option value="0">Nei</option>
						</select>
						<!--Registrer knapp-->
						<input type="submit" name="registrerHund" value="Registrer hund">

					</div>
					<div class="kolonne2">
						<!-- Labels og input i kolonne 2-->
						<label for="løpeMedAndre">Kan hunden omgås andre hunder:</label>
						<select name="løpeMedAndre">
							<option value="1">Ja</option>
							<option value="0">Nei</option>
						</select>
						
						<label for="løsPåTur">Kan hunden gå løs på tur:</label>
						<select name="løsPåTur">
							<option value="1">Ja</option>
							<option value="0">Nei</option>
						</select>

						<label for="forID">Fòrtype:</label>
						<select name="forID">
							<option value="1">vanlig</option>
							<option value="2">allergi</option>
						</select>

						<label for="info">Ekstra informasjon:</label>
						<textarea name="info" >
						</textarea>
					</div>
				</div>
				<!-- 2b) registrerHund (Trygve) -->
				<?php registrerHund($dblink); ?> 
			</form>
		</div>
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>