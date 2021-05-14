<?php
include_once "include/funksjoner.php";
session_start();
$dblink = kobleOpp();
?>

<!DOCTYPE html>
<html>
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
	<!-- ************************** 1) fellesTop ************************** -->
	<?php visNav(); ?>

	<!-- ************************** 2) main (Gunni) **************************-->
	<main>

		<!-- erLoggetInn sjekk -->
		<?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>

		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn"> 
			
			<!-- Bildebakgrunn -->
			
			<!-- Skjema -->	
			<form class="skjemaBakgrunn">
			
				<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

				<!-- Overskrift -->
				<h2>Bestill opphold</h2>
				<h3>Kontroller at informasjon om hunden din er oppdatert:</h3>
				
				<div class="skjemaKolonner">
					<div class="kolonne1">
			
						<!-- Labels og input i kolonne 1 -->
						<label for="hNavn">Hundens navn:</label>
						<input class="inputTekst" type="text" name="hNavn">
				
						<label for="rase">Rase:</label>
						<input class="inputTekst" type="text" name="rase">

						<!-- Inputen for fødselsdato er date -->
						<label for="fDato">Fødselsdato:</label>
						<input class="inputDato" type="date" name="fDato">

						<!-- Nedtrekkslister! -->
						<label for="kjonn">Kjønn:</label>
						<select class="inputSelect" name="kjonn">
							<option value="velg">--Velg--</option>
							<option value="hannhund">Hannhund</option>
							<option value="tispe">Tispe</option>
						</select>

						<label for="steril">Sterilisert:</label>
						<select class="inputSelect" name="steril">
							<option value="velg">--Velg--</option>
							<option value="ja">Ja</option>
							<option value="nei">Nei</option>
						</select>
			
						<label for="vaksinert">Vaksinert:</label>
						<select class="inputSelect" name="vaksinert">
							<option value="velg">--Velg--</option>
							<option value="ja">Ja</option>
							<option value="nei">Nei</option>
						</select>
						<div class="visPassord3">
							<a class="link" href="#">Trykk her for mer informasjon om krav til vaksinering</a>			
						</div>
					</div>
					
					<!-- Labels og input i kolonne 2-->
					<div>
						<label for="lopeMedAndre">Kan hunden omgås andre hunder:</label>
						<select class="inputSelect" name="lopeMedAndre">
							<option value="velg">--Velg--</option>
							<option value="ja">Ja</option>
							<option value="nei">Nei</option>
						</select>
			
						<label for="losPaaTur">Kan hunden gå løs på tur:</label>
						<select class="inputSelect" name="losPaaTur">
							<option value="velg">--Velg--</option>
							<option value="ja">Ja</option>
							<option value="nei">Nei</option>
						</select>

						<label for="fortype">Fòrtype:</label>
						<select class="inputSelect" name="fortype">
							<option value="velg">--Velg--</option>
							<option value="inkludert">Royal Canin</option>
							<option value="inkludert">Vom</option>
							<option value="medbrakt">Medbrakt</option>
						</select>

						<label for="ekstraInfo">Ekstra informasjon:</label>
						<textarea class="tekstboks tekstfelt1" name="ekstraInfo"></textarea>
				
						<!--Knapperad-->
						<div class="knapperad">
							<!-- Tilbake-knapp-->
							<a href = "bestillOpphold.php">
                				<input class="inputSubmit hovedknapp" type="button" value="Tilbake"> 
            				</a>

							<!-- Neste-knapp-->
							<a href = "bestillOpphold3.php">
                				<input class="inputSubmit hovedknapp" type="button" value="Neste"> 
            				</a>
						</div>
					</div>	
			</form>
		</div>	
	</main>

	<button onclick="toppKnappFunksjon()" id="Knappen" title="Gå til toppen">Top</button>

	<!-- ************************** (Trygve) **************************-->
	<!-- 2g bestillOpphold -->
	<?php velgHund($dblink); ?> 

	<!-- ************************** 3) fellesBunn **************************-->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>