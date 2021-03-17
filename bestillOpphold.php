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


    <!-- ************************** 2) main (Gunni) **************************-->
    <main>
		<div class="hovedBakgrunn"> 
			<!-- Form-->	
			<form method="POST">

			<!-- Overskrift -->
			<div id="valgAvEksisterendeHund">
				<h2>Bestill opphold</h2>
			
				<label for="hund">Velg hund:</label>
				<select class="selectTopp" name="hund">
					<option value="velg">--Velg--</option> <!-- Her må det kobles til databasen! -->
				</select>

				<!-- Logg inn link -->
				<p class="ekstraLink"> <a href="registrerHund.php">Registrer ny hund her</a></p>
			
			</div>
			<!--Overskrift over hundeinformasjonen-->
			<h3>Hundeinformasjon</h3>
			
			<div class="skjemaKolonner">
				<div class="kolonne1">
					<!-- Labels og input i kolonne 1 -->
					<label for="hNavn">Hundens navn:</label>
					<input type="text" name="hNavn">
				
					<label for="rase">Rase:</label>
					<input type="text" name="rase">

					<!-- Inputen for fødselsdato er date -->
					<label for="fDato">Fødselsdato:</label>
					<input type="date" name="fDato">

					<!-- Nedtrekkslister! -->
					<label for="kjonn">Kjønn:</label>
					<select name="kjonn">
						<option value="velg">--Velg--</option>
						<option value="hannhund">Hannhund</option>
						<option value="tispe">Tispe</option>
					</select>

					<label for="steril">Sterilisert:</label>
					<select name="steril">
						<option value="velg">--Velg--</option>
						<option value="ja">Ja</option>
						<option value="nei">Nei</option>
					</select>		
			
					<label for="vaksinert">Vaksinert:</label>
					<select name="vaksinert">
						<option value="velg">--Velg--</option>
						<option value="ja">Ja</option>
						<option value="nei">Nei</option>
					</select>

				</div>
				<div>
					<!-- Labels og input i kolonne 2-->
					<label for="lopeMedAndre">Kan hunden omgås andre hunder:</label>
					<select name="lopeMedAndre">
						<option value="velg">--Velg--</option>
						<option value="ja">Ja</option>
						<option value="nei">Nei</option>
					</select>
				
					<label for="losPaaTur">Kan hunden gå løs på tur:</label>
					<select name="losPaaTur">
						<option value="velg">--Velg--</option>
						<option value="ja">Ja</option>
						<option value="nei">Nei</option>
					</select>


					<label for="fortype">Fòrtype:</label>
					<select name="fortype">
						<option value="velg">--Velg--</option>
						<option value="inkludert">Det som er inkludert i oppholdet</option>
						<option value="medbrakt">Medbrakt</option>
					</select>

					<label for="ekstraInfo">Ekstra informasjon:</label>
					<textarea name="ekstraInfo" >
					</textarea>
				</div>
			</div>
			<!--Legg til en hund til-->
			<input class="leggTillKnapp" type="submit" name="leggTillHund" value="Legg til en hund til">
			
			<div id="tilbakeNesteKnapper">
			<input class="leggTillKnapp" type="submit" name="tilbake" value="Tilbake">
			<input class="leggTillKnapp" type="submit" name="neste" value="Neste">
			<a href="bestillOpphold2.php">neste</a>

			</div>
		</div>
    </main>

	<button onclick="toppKnappFunksjon()" id="Knappen" title="Gå til toppen">Top</button>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>