<?php
include_once "include/funksjoner.php";
include_once "include/funksjonerBestillOpphold.php";
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
			<form class="skjemaBakgrunn" method="POST">

				<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

				<!-- Overskrift -->
				<h2 class="hovedOverskrift">Bestill opphold</h2>
				<h3>Kontroller at informasjon om hunden din er oppdatert:</h3>
				
				<div class="skjemaKolonner">
					<div class="kolonne1">
			
						<!-- Labels og input i kolonne 1 -->
						<label for="hNavn">Hundens navn:</label>
						<input class="inputTekst" type="text" name="navn" value= <?php echo $h1->getNavn() ?> required/>
				
						<label for="rase">Rase:</label>
						<input class="inputTekst" type="text" name="rase" value= <?php echo $h1->getRase() ?> />

						<!-- Inputen for fødselsdato er date -->
						<label for="fDato">Fødselsdato:</label>
						<input class="inputDato" type="date" name="fdato" value= <?php echo $h1->getFdato() ?> > 

						<!-- Kjønn --> 
						<?php $kjonn = $h1->getKjønn(); ?>
						<label for="kjønn">kjønn:</label>
						<select class="inputSelect" name="kjønn"> 
							<?php
							if ($kjonn == "gutt") { 
								?><option value="gutt" selected >Hannhund</option><?php
								?><option value="jente">Tispe</option><?php
							} 
							else { 
								?><option value="gutt">Hannhund</option><?php
								?><option value="jente" selected>Tispe</option><?php
							}
							?>
						<select> 

						<!-- Sterilisert --> 
						<?php $sterilisert = $h1->getSterilisert(); ?>
						<label for="sterilisert">Sterilisert:</label>
						<select class="inputSelect" name="sterilisert"> 
							<?php
							if ($sterilisert == "1") { 
								?><option value="1" selected >Ja</option><?php
								?><option value="0">Nei</option><?php
							} 
							else { 
								?><option value="1">Ja</option><?php
								?><option value="0" selected>Nei</option><?php
							}
							?>
						<select> 

					</div>
					
					<!-- Labels og input i kolonne 2 -->
					<div>
						<!-- løpeMedAndre --> 
						<?php $løpeMedAndre = $h1->getLøpeMedAndre(); ?>
						<label for="løpeMedAndre">Kan hunden omgås andre hunder:</label>
						<select class="inputSelect" name="løpeMedAndre"> 
							<?php
							if ($løpeMedAndre == "1") { 
								?><option value="1" selected >Ja</option><?php
								?><option value="0">Nei</option><?php
							} 
							else { 
								?><option value="1">Ja</option><?php
								?><option value="0" selected>Nei</option><?php
							}
							?>
						<select> 

						<!-- forType --> 
						<?php $forID = $h1->getForID(); ?>
						<label for="forID">Fôrtype:</label>
						<select class="inputSelect" name="forID"> 
							<?php
							if ($forID == "1") { 
								?><option value="1" selected >Royal Canin (vanlig)</option><?php
								?><option value="0">Vom (Allergi)</option><?php
							} 
							else { 
								?><option value="1">Royal Canin (vanlig)</option><?php
								?><option value="0" selected>Vom (allergi)</option><?php
							}
							?>
						<select> 

						<!-- info 
						<label for="info">Ekstra informasjon:</label>-->
						<textarea class=" tekstboks tekstfelt1" name="info"> <?php echo $h1->getInfo() ?> </textarea>	

					</div>
				</div>	
				<!--Knapperad-->
				<div class="knappeRad">
					<div class="knapp1IRad">
						<!-- Tilbake-knapp-->
						<a href = "bestillOpphold.php">
	                		<input class="inputButton hovedKnapp" type="button" value="Tilbake"> 
	            		</a>
					</div>
					<div class="etterKolonnerKnapp">

						<!-- Neste-knapp-->
						<a href = "bestillOpphold3.php">
	                		<input class="inputSubmit hovedKnapp" type="submit" value="bekreftHundInfo" name="bekreftHundInfo"> 
	            		</a>	
					</div>
				</div>
				<!-- ************************** (Trygve) ************************** -->
				<!-- Bestill Opphold -->
				<?php bekreftHundInfo($dblink); ?> 
			</form>
		</div>	
	</main>

	<!-- ************************** fellesBunn ************************************ -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>


<!-- Nedtrekkslister 
<label for="kjonn">Kjønn:</label>
<select class="inputSelect" name="kjonn">
	<option value="velg">--Velg--</option>
	<option value="hannhund">Hannhund</option>
	<option value="tispe">Tispe</option>
</select>--> 
<!-- kjønn --> 

<!--<label for="steril">Sterilisert:</label>
<select class="inputSelect" name="steril">
	<option value="velg">--Velg--</option>
	<option value="ja">Ja</option>
	<option value="nei">Nei</option>
</select>-->
<!-- sterilisert --> 

						<!--<label for="ekstraInfo">Ekstra informasjon:</label>
<textarea class="tekstboks tekstfelt1" name="info" value=--> 

<!-- <label for="lopeMedAndre">Kan hunden omgås andre hunder:</label>
<select class="inputSelect" name="lopeMedAndre">
	<option value="velg">--Velg--</option>
	<option value="ja">Ja</option>
	<option value="nei">Nei</option>
</select> -->
<!-- løpeMedAndre, -->  

<!-- <label for="fortype">Fòrtype:</label>
<select class="inputSelect" name="fortype">
	<option value="velg">--Velg--</option>
	<option value="inkludert">Royal Canin</option>
	<option value="inkludert">Vom</option>
	<option value="medbrakt">Medbrakt</option>
</select>--> 
<!-- forType -->  