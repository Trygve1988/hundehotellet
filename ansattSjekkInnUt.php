<?php
    include_once "include/funksjoner.php";
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

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>
    <?php visNav3() ?>

    <!-- ************************** 2) main **************************-->
    <main> 

        <!-- 2a erAnsatt sjekk-->
        <?php if (!erAnsatt()) { header('Location: loggInn.php'); } ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">

                <?php sjekkInn($dblink); ?>
                <?php sjekkUt($dblink); ?>
                <?php nullStillInnsjekkinger($dblink); ?>
                <?php nullStillUtsjekkinger($dblink); ?>
                
                <!-- 2a visSkalSjekkeInnIDag -->
                <?php visSkalSjekkeInnIDag($dblink); ?>

                <!-- skal sjekkes Inn hunder -->
                <select id="sjekkInnSelect" class="litenSelect" name="sjekkInnSelect">
                    <?php $hunder = lagSkalSjekkesInnTab($dblink);
                    for ($i=0; $i<count($hunder); $i++) {
                        lagOption($hunder[$i]->toStringSjekkInn());
                    } ?>
                </select>

                <!-- sjekkInnKnapp --> 
                <input class="litenKnapp" type="submit" value="Sjekk Inn" name="sjekkInnKnapp">

                <!-- test: nullstillKnapp --> 
                <input class="litenKnapp" type="submit" value="Nullstill" name="nullstillInnsjekkingerKnapp">
            
                <!-- *********** SjekkeUt *********** -->
                <?php visSkalSjekkeUtIDag($dblink); ?>
                <!-- skal sjekkes Ut hunder -->
                <select class="litenSelect" name="sjekkUtSelect">
                    <?php $hunder = lagSkalSjekkesUtTab($dblink);
                    for ($i=0; $i<count($hunder); $i++) {
                        lagOption($hunder[$i]->toStringSjekkInn());
                    } ?>
                </select>

                <!-- sjekkUtKnapp --> 
                <input class="litenKnapp" type="submit" value="Sjekk Ut" name="sjekkUtKnapp">
                
                <!-- test: nullstillKnapp --> 
                <input class="litenKnapp" type="submit" value="Nullstill" name="nullStillUtsjekkingerKnapp">

            </form>
        </div>
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>