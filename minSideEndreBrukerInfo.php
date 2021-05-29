<?php
    include_once "include/funksjoner.php";
    include_once "include/funksjonerMinSide.php";
    session_start();
    $dblink = kobleOpp();
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

    <!-- ************************** Main ********************************* -->
    <main> 

        <!-- erLoggetInn -->
        <?php 
            if (!erLoggetInn()) {
                header('Location: loggInn.php');
            } 
        ?>

        <?php $bruker = $_SESSION['bruker'] ?>
            
		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn"> 
			
			<!-- Oppdater brukerInfo Skjema -->
			<form class="skjemaBakgrunn" method="POST">

                <!-- Avbryt knapp -->
				<a href = "minSide.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>	
                
                <!-- Overskrift -->
				<h2 id="minEndreBrukerInfo" class="hovedOversikt">Endre brukerinformasjon</h2> 

                <!-- oppdaterBrukerInfo -->
                <?php endreBrukerInfo($dblink) ?>  
				
                <div class="skjemaKolonner">
					<div class="kolonne1">   
                        <label id="minFornavn" for="fornavn">Fornavn:</label>   
                        <input class="inputTekst" type="text" id="fornavn" name="fornavn" placeholder="Ida" value= <?php echo $bruker->getFornavn() ?> >

                        <label for="tlf">Tlf:</label>   
                        <input class="inputTekst" type="text" id="tlf" name="tlf" placeholder="4712456789" value= <?php echo $bruker->getTlf() ?> >
                        
                        <label id="minAdresse" for="adresse">Adresse:</label>     
                        <input class="inputTekst" type="text" id="adresse" name="adresse" placeholder="Epleveien 5" value= <?php echo $bruker->getAdresse() ?> > 

                    </div>
                    <div>
                        <label id="minEtternavn" for="etternavn">Etternavn:</label>  
                        <input class="inputTekst" type="text" id="etternavn" name="etternavn" placeholder="Idasen" value= <?php echo $bruker->getEtternavn() ?> >

                        <label id="mail" for="epost">Epost:</label>
                        <input class="inputMail" type="email" name="epost" placeholder="test@test.com" id="epost" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" value= <?php echo $bruker->getEpost() ?>>

                    </div>
                </div> 

                <!-- Knapperad -->
				<div class="knappeRad bunnKnapp">
					<div class="knapp1IRad">
						<!-- Tilbake knapp -->
						<a href="minSide.php">
                            <input class="inputButton hovedKnapp" type="button" value="Tilbake">  
                        <a>
					</div>
					<div class="etterKolonnerKnapp">
						<!-- Lagre knapp -->
                        <input class="inputSubmit hovedKnapp" type="submit" value="Lagre"  name="lagre">   	
					</div>
				</div>
            </form>
        </div> 

    </main>
    
    <!-- ************************** Felles bunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>