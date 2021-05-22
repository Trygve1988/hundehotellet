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
    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
    <script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
    <script src="include/script.js" defer> </script>
</head>
<body>

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main> 

        <!-- 2a erLoggetInn sjekk -->
        <?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">

                <h2 class="hovedOverskrift">Avbestill</h2>
                <!-- 2a) Velg Bestilling MÅ BARE VISE IKKE PÅBEGYNTE OPPHOLD!!!!! -->
                <p>Opphold kan avbestilles intill 24 timer før oppholdet starter.</p>  

                <div class="skjemaKolonner">
                    <div class="kolonne1">
                        <!-- velgBestilling select --> 
                        <select id="bestillinger" class="inputSelect" value="bestillinger" name="bestillinger">
                            <?php $bestillingTab = lagIkkeBegyntBestillingTab($dblink);  
                            for ($i=0; $i<count($bestillingTab); $i++) {
                                lagBestillingOption($bestillingTab[$i]);
                            } ?>
                        </select>
                    </div>
                </div> 

                <!-- velgBestilling knapp --> 
                <a href="minSide.php">
					<input class="litenKnapp" type="button" value="Tilbake"> 
				</a>
                <input class="litenKnapp" type="submit" value="Avbestill" name="Avbestill">
                            
                <!-- 2b velgEndreBestilling -->
                <?php avbestill($dblink); ?> 

            </form>
        </div> 
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>