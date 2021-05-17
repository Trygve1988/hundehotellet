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
		
		<!-- ************************ (Gunni) ************************** -->
		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
			<!-- Skjema -->	
			<form class="skjemaBakgrunn">
	
				<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>
				
				<!-- Overskrift -->	
				<h2>Bestill opphold</h2>

				<h2 class="overskrift2">Oppsummering</h2>
				<!-- Her må det refereres til databsen! -->
				<div class="vanligTekst">
					<p><b>Hunder:</b> <span>hund1</span>, <span>hund2</span> </p> 
					<p><b>Dato:</b> <span>(dato)</span> til <span>(dato)</span> 
					<p><b>Bading:</b> <span>hund1</span> </p>
					<p><b><u>Sum å betale: <span> totalPris </span>kr</u></b></p>
				</div>
				
				<h2 class="overskrift2" >Betaling</h2>
				<!-- Valg av betalingsmetode: -->
				<label for="kort">Betalingskort:</label>
				<input class="radiobox" type="radio" name="kort">
				<label for="vipps">VIPPS:</label>
				<input class="radiobox" type="radio" name="vipps">		

				<div class="skjemaKolonner">
					<div class="kolonne1">
						<!-- Labels og input i kolonne 1-->			
						<label for="kortholder">Kortholder:</label>
						<input class="inputTekst" type="text" name="kortholder">		

						<label for="utlopsdato">Utløpsdato:</label>
						<input class="inputDato" type="date" name="utlopsdato">
					</div>
					<div>
						<!-- Labels og input i kolonne 2 -->
						<label for="kortNr">Kortnummer:</label>
						<input  class="inputTekst" type="text" name="til">			

						<label for="ccv">CCV/CVC:</label>
						<!-- ************************** CVC (Kristina) ************************* -->
						<!--CVC modalen -->
						<button id="cvcModalKnapp">?</button>
						<input class="inputTekst" type="text" placeholder="De tre siste sifrene på cvv nummeret" name="cvv" required value>
						<!--CVC modalen -->
						<div id="cvcModal" class="modal">
							<!-- Modal innhold (dette hopper opp i modalen) -->
							<div class="modal-innhold">
								<span class="lukkModal">&times;</span>
								<h1>Hvor finner jeg CVC koden?</h1>
								<img class="cvvkode" src="/bilder/ccv.png" alt="Bilde av hvor du finner CVC koden på visakortet">
							</div>
						</div>
						<!-- ************************ (Gunni) ********************************** -->
						<!-- Godta vilkår -->
						<label for="vilkaar">Kryss av for å <a class="blaaTekst" href="#" >godta vilkår:</a></label> 
						<input class="litenCheckbox" type="checkbox" name="til">		
						
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
						<!-- Registrer bestilling-knapp -->
						<a href = "bestillingBekreftelse.php">
	                		<input class="inputSubmit hovedKnapp2" type="submit" value="Registrer bestilling"> 		            	
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