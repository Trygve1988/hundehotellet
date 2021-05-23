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

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">

                <!-- InnloggetInfo -->
                <?php visInnloggetInfo($dblink); ?>
                <a href="minSideTestEndreBrukerInfo.php">
                    <input class="litenKnapp" type="button" value="Endre Bruker" name="Endre Bruker">
                </a>
                <a href="minSideTestEndrePassord.php"> 
                    <input class="litenKnapp" type="button" value="Endre Passord" name="Endre Passord">
                </a>
                <a href="minSideTestSlettBruker.php"> 
                    <input class="litenKnapp" type="button" value="Slett Bruker">
                </a>
                <br><br><br>

                <!-- MineHunder -->
                <?php visMineHunder($dblink) ?>
                <a href="registrerHundMS.php">
                    <input class="litenKnapp" type="button" value="Registrer Hund">
                </a>
                <?php if (harHund($dblink)) { ?>
                    <a href="minSideTestEndreHund1.php">
                        <input class="litenKnapp" type="button" value="Endre Hund">  
                    </a>
                    <a href="minSideTestSlettHund.php">
                        <input class="litenKnapp" type="button" value="Slett Hund">  
                    </a>
                <?php } ?>
                <br><br><br>

                <!-- Bestillinger --> 
                <?php visMineOpphold($dblink); ?> 
                <?php if (harOpphold($dblink)) { ?>
                    <br>
                    <a href="minSideTestAvbestill.php">
                        <input class="litenKnapp" type="button" value="Avbestill" name="Avbestill"> 
                    </a> 
                    <a href="minSideTestSkrivAnmeldelse.php">
                        <input class="litenKnapp" type="button" value="Skriv Anmeldelse" name="Skriv Anmeldelse">
                    </a>
                <?php } ?>
                
                <!-- Knappepanel --> 
                <div class="knappePanel">  

                </div>
            </form> 
        </div>
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>