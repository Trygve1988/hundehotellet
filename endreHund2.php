<?php
    include_once "include/funksjoner.php";
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
    <script src="include/script.js" defer> </script>
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
        <?php $h1 = $_SESSION['aktivHund']; ?>

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
                        <label for="kjønn">kjønn:</label>
                        <input class="inputTekst" type="text" name="kjønn" value= <?php echo $h1->getKjønn() ?> > 
                    </div>
                    <div>
                        <!-- sterilisert --> 
                        <label for="sterilisert">sterilisert: </label>
                        <input class="inputTekst" type="text" name="sterilisert" value= <?php echo $h1->getSterilisert() ?> > 
                        <!-- løpeMedAndre, -->  
                        <label for="løpeMedAndre">løpeMedAndre:</label>
                        <input class="inputTekst" type="text" name="løpeMedAndre" value= <?php echo $h1->getLøpeMedAndre() ?> > 
                        <!-- forType -->  
                        <label for="forID">forType:</label>
                        <input class="inputTekst" type="text" name="forID" value= <?php echo $h1->getForID() ?>> 
                        <!-- info -->  
                        <label for="info">info:</label>
                        <input class="inputTekst" type="text" name="info" value= <?php echo $h1->getInfo() ?>>
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