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

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main> 

        <!-- 2a erLoggetInn -->
        <?php 
            if (!erLoggetInn()) {
                header('Location: loggInn.php');
            } 
        ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn"> 
			
			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST">
                <h2 id="slettHund">Slett Hund</h2>
                <p id="slettHundText">Denne siden er under arbied. Du kan for øyeblikket bare slette hunder som ikke har opphold. </p>
                <div>
                    <select id="hund" class="litenSelect" value="hund" name="hund">
                        <?php $hunder = laghunderTab($dblink);
                        for ($i=0; $i<count($hunder); $i++) {
                            lagOption($hunder[$i]);
                        } ?>
                    </select>
                </div>


                <!-- Tilbake knapp -->
                <a href="minSide.php">
                    <input class="litenKnapp" type="button" value="Tilbake">  
                <a>

                <!-- slettHund knapp -->
                <input class="litenKnapp" type="submit" value="Slett" name="slettHund"> 	

                <!-- bestillOpphold -->
                <?php slettHund($dblink); ?>  

            </form> 
        </div> 
                           
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>