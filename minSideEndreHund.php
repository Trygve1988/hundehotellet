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

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main ************************** onchange="this.form.submit()"  -->   
    <main> 

        <!-- 2a erLoggetInn -->
        <?php 
            if (!erLoggetInn()) {
                header('Location: loggInn.php');
            } 
        ?>

        <!-- 2b) Hund info -->
        <?php 
        $minSideHund = $_SESSION['minSideHund']; 
        setAktivHund($dblink,$minSideHund);
        $h1 = $_SESSION['aktivHund']; 
        ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">

                <h2 class="hovedOverskrift">Endre Hund</h2>

                <div class="skjemaKolonner">
                    <div class="kolonne1">
                        <!-- navn --> 
                        Hundens navn <input class="inputTekst" type="text" name="navn" size="20" value= <?php echo $h1->getNavn() ?> required/>
                        <!-- rase --> 
                        Rase <input class="inputTekst" type="text"  name="rase" size="20" value= <?php echo $h1->getRase() ?> />
                        <!-- fdato --> 
                        <label for="fdato">fdato:</label>
                        <input class="inputDato" type="date" name="fdato" value= <?php echo $h1->getFdato() ?> > 
						
                        <!-- kjønn --> 
						<?php $kjonn = $h1->getKjønn(); ?>
						<label id="kjønn" for="kjønn">kjønn:</label>
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

                        <!-- sterilisert --> 
						<?php $sterilisert = $h1->getSterilisert(); ?>
						<label id="sterilisert" for="sterilisert">sterilisert:</label>
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

                    <div>
                        <!-- løpeMedAndre --> 
						<?php $løpeMedAndre = $h1->getLøpeMedAndre(); ?>
						<label id="løpeMedAndre" for="løpeMedAndre">løpeMedAndre:</label>
						<select class="inputSelect" name="løpeMedAndre"> 
							<?php
							if ($løpeMedAndre == "1") { 
								?><option id="ja2" value="1" selected >ja</option><?php
								?><option id="nei2"value="0">nei</option><?php
							} 
							else { 
								?><option value="1">ja</option><?php
								?><option value="0" selected>nei</option><?php
							}
							?>
						<select> 

						<!-- forType --> 
						<?php $forID = $h1->getForID(); ?>
						<label id="forType" for="forID">forType:</label>
						<select class="inputSelect" name="forID"> 
							<?php
							if ($forID == "1") { 
								?><option id="vanlig" value="1" selected >vanlig</option><?php
								?><option id="allargi" value="0">allergi</option><?php
							} 
							else { 
								?><option id="vanlig2" value="1">vanlig</option><?php
								?><option id="allergi2" value="0" selected>allergi</option><?php
							}
							?>
						<select>  
                       
                        <!-- info 
						<label for="info">Ekstra informasjon:</label>-->
						<textarea class=" tekstboks tekstfelt1" name="info"> <?php echo $h1->getInfo() ?> </textarea>	

                    </div>
                </div>

                <!-- bekreftHundInfo --> 
                <a href="minSide.php">
					<input class="litenKnapp" type="button" value="Tilbake"> 
				</a>
                <input class="litenKnapp" type="submit" value="bekreftHundInfo" name="bekreftHundInfo">

            </form> 
        </div>

         <!-- 2b oppdaterBrukerInfo -->
         <?php endreHund($dblink); ?> 

    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>