<?php
    include_once "include/funksjoner.php";
    include_once "include/funksjonerMinSide.php";
    session_start();
    $dblink = kobleOpp();
    ob_start();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="include/style.css" rel="stylesheet" type="text/css">
    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
    <script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
    <script src="include/script.js" defer> </script>
    <script src="include/scriptSpraak.js" defer> </script>
</head>
<body>

    <!-- ************************** Felles topp ************************** -->
    <?php visNav(); ?>

    <!-- ************************** Main ************************** onchange="this.form.submit()" ?????????????????????????? -->   
    <main> 
        <!-- erLoggetInn sjekk-->
        <?php 
            if (!erLoggetInn()) {
                header('Location: loggInn.php');
            } 
        ?>

        <!-- Hund info -->
		<?php 
        $minSideHund = $_SESSION['minSideHund']; 
        setAktivHund($dblink,$minSideHund);
        $h1 = $_SESSION['aktivHund']; 
        ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">
				 
				<!-- Avbryt knapp -->
				<a href = "minSide.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>	
                
				<!-- Overskrift -->
				<h2 class="hovedOverskrift">Endre Hund</h2>

				<div>
					<label for="velgHundSelect">Velg hund:</label>
					<select id="velgMinSideHundSelect" class="litenSelect" name="velgHundSelect">
						<?php $hunder = lagHunderTab($dblink);
							$minSideHund = $_SESSION['minSideHund']; 
							for ($i=0; $i<count($hunder); $i++) {
								lagMinSideOption($hunder[$i],$minSideHund);
							} ?>
					</select>
				</div>
		
                <div class="skjemaKolonner">
					
					<!-- Labels og input i kolonne 1 -->
                    <div class="kolonne1">
                        <!-- Navn --> 
                        <label for="navn">Navn:</label>
						<input class="inputTekst" type="text" name="navn" size="20" value= <?php echo $h1->getNavn() ?> required/>
                        
						<!-- Rase --> 
						<label for="rase">Rase:</label>
						<input class="inputTekst" type="text"  name="rase" size="20" value= <?php echo $h1->getRase() ?> />
                        
						<!-- Fdato --> 
                        <label for="fdato">Fødselsdato:</label>
                        <input class="inputDato" type="date" name="fdato" value= <?php echo $h1->getFdato() ?> > 
						
                        <!-- Kjønn --> 
						<?php $kjonn = $h1->getKjønn(); ?>
						<label id="kjønn" for="kjønn">Kjønn:</label>
						<select class="inputSelect" name="kjønn"> 
							<?php
							if ($kjonn == "gutt") { 
								?><option id="hann" value="gutt" selected >Hann</option><?php
								?><option id="tispe" value="jente">Tispe</option><?php
							} 
							else { 
								?><option id="hann2" value="gutt">Hann</option><?php
								?><option id="tispe2" value="jente" selected>Tispe</option><?php
							}
							?>
						<select> 

                        <!-- Sterilisert --> 
						<?php $sterilisert = $h1->getSterilisert(); ?>
						<label id="sterilisert" for="sterilisert">Sterilisert:</label>
						<select class="inputSelect" name="sterilisert"> 
							<?php
							if ($sterilisert == "1") { 
								?><option id="ja" value="1" selected >Ja</option><?php
								?><option id="nei" value="0">Nei</option><?php
							} 
							else { 
								?><option  value="1">Ja</option><?php
								?><option  value="0" selected>Nei</option><?php
							}
							?>
						<select> 
                    </div>

					<!-- Labels og input i kolonne 2 -->		
                    <div>
                        <!-- løpeMedAndre --> 
						<?php $løpeMedAndre = $h1->getLøpeMedAndre(); ?>
						<label id="løpeMedAndre" for="løpeMedAndre">Kan hunden omgås andre hunder?:</label>
						<select class="inputSelect" name="løpeMedAndre"> 
							<?php
							if ($løpeMedAndre == "1") { 
								?><option id="ja2" value="1" selected >Ja</option><?php
								?><option id="nei2"value="0">Nei</option><?php
							} 
							else { 
								?><option value="1">Ja</option><?php
								?><option value="0" selected>Nei</option><?php
							}
							?>
						<select> 

						<!-- Fôrtype --> 
						<?php $forID = $h1->getForID(); ?>
						<label id="forType" for="forID">Fôrtype:</label>
						<select class="inputSelect" name="forID"> 
							<?php
							if ($forID == "1") { 
								?><option id="vanlig" value="1" selected >Royal Canin (vanlig)</option><?php
								?><option id="allargi" value="0">Vom (allergi)</option><?php
							} 
							else { 
								?><option id="vanlig2" value="1">Royal Canin (vanlig)</option><?php
								?><option id="allergi2" value="0" selected>Vom (allergi)</option><?php
							}
							?>
						<select>  
                       
                        <!-- Ekstra informasjon 
						<label for="info">Ekstra informasjon:</label>-->
						<textarea class=" tekstboks tekstfelt1" name="info"> <?php echo $h1->getInfo() ?> </textarea>	
                    </div>
                </div>

				<!--Knapperad-->
				<div class="knappeRad">
					<div class="knapp1IRad">
						<!-- Tilbake knapp-->
						<a href="minSide.php">
							<input class="inputButton hovedKnapp" type="button" value="Tilbake"> 
						</a>
					</div>
					<div class="etterKolonnerKnapp">
						<!-- Lagre knapp -->
						<a href = "bestillOpphold3.php">
	                		<input class="inputSubmit hovedKnapp" type="submit" value="Lagre" name="bekreftHundInfo"> 
	            		</a>
					</div>
				</div>
            </form> 
        </div>

         <!-- oppdaterBrukerInfo -->
         <?php endreHund($dblink); ?> 
    </main>

    <!-- ************************** Felles bunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>