<?php
    include_once "include/funksjoner.php";
    //include_once "include/funksjonerMinSide.php";
    include_once "include/funksjonerAnsatt.php";
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

    <!-- ************************** Main ************************** -->
    <main> 

        <!-- erLoggetInn sjekk -->
        <?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">

                 <!-- Avbryt knapp -->
				<a href = "minSide.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

                <h2 class="hovedOverskrift">Avbestill opphold</h2>

                <!-- Velg Bestilling MÅ BARE VISE IKKE PÅBEGYNTE OPPHOLD!!!!! -->
                <p>Opphold kan avbestilles inntill 24 timer før oppholdet starter.</p>  

                <div class="skjemaKolonner">
                    <div class="kolonne1">
                        
                        <!-- velgBestilling select --> 
                        <label for="bestillinger">Velg opphold:</label>
                        <select id="bestillinger" class="inputSelect minInput" value="bestillinger" name="bestillinger">
                            <?php $bestillingTab = lagIkkeBegyntBestillingTabAnsatt($dblink);  
                            for ($i=0; $i<count($bestillingTab); $i++) {
                                lagBestillingOption($bestillingTab[$i]);
                            } ?>
                        </select>
                    </div>
                </div> 
            
                <!--Knapperad-->
				<div class="knappeRad heltIBunnKnapp">
					<div class="knapp1IRad">
						<!-- Tilbake knapp-->
						<a href="minSide.php">
					        <input class="inputButton hovedKnapp" type="button" value="Avbryt"> 
				        </a>
					</div>
					<div class="etterKolonnerKnapp">
						<!-- Avbestill knapp-->
						<input class="inputSubmit hovedKnapp" type="submit" value="Avbestill" name="Avbestill">	
					</div>
				</div>
                
                <!-- velgEndreBestilling -->
                <?php avbestill($dblink); ?> 

            </form>
        </div> 
    </main>

    <!-- ************************** Felles bunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>