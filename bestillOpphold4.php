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

	<!-- ************************** main ******************************* -->

	<main>
		<!-- erLoggetInn sjekk -->
		<?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>
		
		<?php
			$bestilling = $_SESSION['bestilling'];
			$startDato = $bestilling->getStartDato();
			$sluttDato = $bestilling->getSluttDato();
			$totalPris = $bestilling->getTotalPris();
		?>

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
				<h2 id="bestillOpphold4" class="hovedOverskrift">Bestill opphold</h2>

				<!-- Bestill opphold -->
				<?php bestilling($dblink); ?> 

				<h2 id="oppSummering" class="overskrift2">Oppsummering</h2>
				<!-- Her må det refereres til databsen! -->
				<div class="mindreTekst">
					<p><b id="hund">Hund(er):</b> <?php echo getValgteHunderNavn($dblink); ?> </p> 
					<p><b id="dato">Dato:</b> <span>(<?php echo $startDato ?>)</span> - <span>(<?php echo $sluttDato ?>)</span> 
					<p><b><u id="sumÅbetale">Sum å betale: <span> <?php echo $totalPris ?> </span>kr</u></b></p>
				</div>

				<h2 id="bestling" class="overskrift2" >Betaling</h2>

				<div class="skjemaKolonner">
					<div class="kolonne1">
						<!-- Labels og input i kolonne 1 -->			
						<label id="kortholder" for="kortholder">Kortholder:</label>
						<input class="inputTekst" type="text" name="kortholder">		

						<label id="utløpsdato" for="utlopsdato">Utløpsdato:</label>
						<input class="inputDato" type="date" name="utlopsdato">
					</div>
					<div>
						<!-- Labels og input i kolonne 2 -->
						<label id="kortNr" for="kortNr">Kortnummer:</label>
						<input class="inputTekst" type="text" pattern="[0-9]{16}" name="til">			

						<label for="ccv">CCV/CVC:</label>
						<!-- ************************** CVC (Kristina) ************************* -->
						<!--CVC modalen -->
						<button id="cvcModalKnapp">?</button>
						<input class="inputTekst" type="text" pattern="[0-9]{3}" name="cvv">
						<!--CVC modalen -->
						<div id="cvcModal" class="modal">
							<!-- Modal innhold (dette hopper opp i modalen) -->
							<div class="modal-innhold">
								<span class="lukkModal">&times;</span>
								<h1 id="finneCVC">Hvor finner jeg CVC koden?</h1>
								<img class="cvvkode" src="/bilder/ccv.png" alt="Bilde av hvor du finner CVC koden på visakortet">
							</div>
						</div>
						<!-- ************************ (Gunni) ********************************** -->
						<!-- Godta vilkår -->
						<a id="vilkår" class="blaaTekst" href="vilkaar.php"> Kryss av for å godta vilkår:</a></label> 
						<input class="litenCheckbox" type="checkbox" name="til" required>		
						
					</div>
				</div>	

				<!-- Knapperad -->
				<div class="knappeRad">
					<div class="knapp1IRad">
						<!-- Tilbake-knapp -->
						<a href = "bestillOpphold3.php">
							<input class="inputButton hovedKnapp" type="button" value="Tilbake"> 
		            	</a>
					</div>
					<div class="etterKolonnerKnapp">
                     	<a href="bestillingBekreftelse">
						 	<!-- Bekreft bestilling --> 
                     		<input class="inputSubmit hovedKnapp" type="submit" value="bestill" name="bestill">
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