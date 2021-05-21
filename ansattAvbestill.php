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

        <!-- 2a erLoggetInn sjekk -->
        <?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>

        <form class="skjema" method="POST"> 
            <h1>Avbestill</h1>

            <!-- 2a) Velg Bestilling MÅ BARE VISE IKKE PÅBEGYNTE OPPHOLD!!!!! -->
            <p>Opphold kan avbestilles intill 24 timer før oppholdet starter.</p>  
            <div class="skjemaFlexBox"> 
                <div> 
                    <!-- velgBestilling select --> 
                    <select id="bestillinger" value="bestillinger" name="bestillinger">
                        <?php $bestillingTab = lagIkkeBegyntBestillingTabForAnsatt($dblink);  
                        for ($i=0; $i<count($bestillingTab); $i++) {
                            lagBestillingOption($bestillingTab[$i]);
                        } ?>
                    </select>
                    <!-- velgBestilling knapp --> 
                    <input type="submit" value="Avbestill" name="Avbestill">

                </div>
            </div> 

        <!-- 2b velgEndreBestilling -->
        <?php avbestill($dblink); ?> 
    
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>