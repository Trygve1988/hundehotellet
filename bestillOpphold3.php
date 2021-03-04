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

    <!-- ************************** 2) main **************************-->
    <main>
		<div class="hovedBakgrunn"> 
			<!-- Form-->	
			<form method="POST">
			<h2>Bestill opphold</h2>
			
			<h3>Oppsummering</h3>
			<p>Vil du bestille opphold til <span>(hund)</span> fra <span>(dato)</span> til <span>(dato)</span> (med <span>(antall badinger og hund)</span>?</p>
			<p>Sum å betale:</p>

			<h3>Betaling</h3>
			<!-- Valg av betalingsmetode: -->
			<label for="kort">Betalingskort:</label>
			<input type="radio" name="kort">
			<label for="vipps">VIPPS:</label>
			<input type="radio" name="vipps">

			<div class="skjemaKolonner">
				<div class="kolonne1">
					<!-- Labels og input i kolonne 1-->			
					<label for="kortholder">Kortholder:</label>
					<input type="text" name="kortholder">

					<label for="utlopsdato">Utløpsdato:</label>
					<input type="date" name="utlopsdato">
				</div>
				<div>
					<!-- Labels og input i kolonne 2-->
					<label for="kortNr">Kortnummer:</label>
					<input type="text" name="til">	
					<label for="ccv">CCV/CVC:</label>
					
					<!--CVC modalen (Kristina) -->
					<button id="cvcModalKnapp">?</button> 
					<input type="text" placeholder="De tre siste sifrene på cvv nummeret" name="cvv" required value>	
                    <!--CVC modalen -->
                    <div id="cvcModal" class="modal">
                        <!-- Modal innhold (dette hopper opp i modalen) -->
                        <div class="modal-innhold">
                            <span class="lukkModal">&times;</span>
                            <h1>Hvor finner jeg CVC koden?</h1>
                            <img class="cvvkode" src="/bilder/ccv.png" alt="Bilde av hvor du finner CVC koden på visakortet" width="auto" height="auto">
                        </div> 
                    </div>
                    

				</div>	
			</div>
			<!--Denne må endres i CSS'en!-->
			<div>
				<input class="leggTillKnapp" type="submit" name="tilbake" value="Tilbake">
				<input type="submit" name="bestill" value="Bekreft bestilling">
				<a href="bestillOpphold2.php">tilbake</a>
			</div>
		</form>
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>








