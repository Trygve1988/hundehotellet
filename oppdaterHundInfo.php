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
    <script src="include/scriptSpraak.js" defer> </script>
</head>

<body>

	<!-- ************************** fellesTop ************************** -->
	<?php visNav(); ?>


	<!-- ************************** main ******************************* -->
	<main>
		<!-- erLoggetInn sjekk -->
		<?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>

        <!-- aktivHundSjekk -->
        <?php $h1 = $_SESSION['aktivHund']; ?>       
        <!-- ************************ (Gunni) ************************** -->
         <!-- Hvit bakgrunn -->  
         <div class="hvitBakgrunn">
            <!-- Skjema -->     
            <form class="skjemaBakgrunn">
            
                <!-- Avbryt knapp -->
                <a href = "minSide.php">
                    <input class="avbrytKnapp" type="button" value="X">
                </a>    

                <!-- Overskrift -->
                <h2 class="hovedOverskrift">Oppdater informasjon</h2> 

                <!-- Nedtrekksliste for valg av hund -->
                <h2>Velg hund</h2>
			
					<div class="litenInput">
                        <label for="velgHund">Velg hund:</label>
                        <select class="inputSelect" id="hund" name="velgHund">
                            <?php $hunder = laghunderTab($dblink);
                                for ($i=0; $i<count($hunder); $i++) {
                                    lagOption($hunder[$i]);
                                } ?>
                        </select>
                        <a href="minSide.php">
                            <input class="litenKnapp" type="button" value="Tilbake">  
                        <a>
                            <input class="litenKnapp" type="submit" value="Velg" name="velgHund">
                    </div>
                </div> 

                <div class="skjemaKolonner">
                    <div class="kolonne1">
                        <!-- Labels og input i kolonne 1 -->
                        <label for="hNavn">Hundens navn:</label>
                        <input  class="inputTekst" type="text" name="hNavn" value= <?php echo $h1->getNavn() ?> required/><!-- Skal det være required her? -->

                        <label for="rase">Rase:</label>
                        <input class="inputTekst" type="text" name="rase" value= <?php echo $h1->getRase() ?> >  
                        <!-- Inputen for fødselsdato er date -->
                        <label for="fDato">Fødselsdato:</label>
                        <input class="inputDato" type="date" name="fDato" value= <?php echo $h1->getFdato() ?> >  

                        <!-- Nedtrekkslister -->
                        <label for="kjonn">Kjønn:</label>
                        <select class="inputSelect" name="kjonn">
                            <option value="velg"><?php echo $h1->getKjønn() ?></option>
                            <option value="hannhund">Hannhund</option>
                            <option value="tispe">Tispe</option>
                        </select>   

                        <label for="steril">Sterilisert:</label>
                        <select class="inputSelect" name="steril">
                            <option value="velg"><?php echo $h1->getSterilisert() ?></option>
                            <option value="ja">Ja</option>
                            <option value="nei">Nei</option>
                        </select>
                    </div>
                    <!-- Labels og input i kolonne 2 -->
                    <div>
                        <label for="lopeMedAndre">Kan hunden omgås andre hunder:</label>
                        <select class="inputSelect" name="lopeMedAndre">
                            <option value="velg"><?php echo $h1->getLøpeMedAndre() ?></option>
                            <option value="ja">Ja</option>
                            <option value="nei">Nei</option>
                        </select>

                        <label for="fortype">Fòrtype:</label>
                        <select class="inputSelect" name="fortype">
                            <option value="velg"><?php echo $h1->getForID() ?></option>
                            <option value="inkludert">Royal Canin (vanlig)</option>
                            <option value="inkludert">Vom (allergi)</option>
                        </select>   

                        <label for="ekstraInfo">Ekstra informasjon:</label>
                        <textarea class="tekstboks tekstfelt1" name="ekstraInfo"><?php echo $h1->getInfo() ?></textarea>
                    </div>
                </div>
                
                <!-- Lagre-knapp -->  
                <div class="etterKolonnerKnapp"> 
                    <a href="hundRegistrertBekreftelse.html">
                        <input class="hovedKnapp inputSubmit" type="submit" name="bekreftHundInfo" value="Lagre"> 
                    </a>
                </div> 
               
                <!-- ************************ (Trygve) ************************** -->
                <!-- Bestill opphold -->
	            <?php velgHund($dblink); ?>  
            </form>
        </div>
        <!-- Oppdater hund -->
        <?php endreHund($dblink); ?> 
    </main>

	<!-- ************************** fellesBunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>