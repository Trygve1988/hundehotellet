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

                <!-- InnloggetInfo -->
                <?php visInnloggetInfo($dblink); ?>
                <a href="endreBrukerInfo.php">
                    <input class="litenKnapp" type="button" value="Endre Bruker" name="Endre Bruker">
                </a>
                <a href="endrePassord.php"> 
                    <input class="litenKnapp" type="button" value="Endre Passord" name="Endre Passord">
                </a>
                <br><br><br>

                <!-- MineHunder -->
                <?php visMineHunder($dblink) ?>
                <a href="registrerHund.php">
                    <input class="litenKnapp" type="button" value="Registrer Hund" name="Registrer Hund">
                </a>
                <?php if (harHund($dblink)) { ?>
                    <a href="endreHund1.php">
                        <input class="litenKnapp" type="button" value="Endre Hund" name="Endre Hund">  
                    </a>
                <?php } ?>
                <br><br><br>

                <!-- Bestillinger --> 
                <?php visMineOpphold($dblink); ?> 
                <?php if (harOpphold($dblink)) { ?>
                    <br>
                    <a href="Avbestill.php">
                        <input class="litenKnapp" type="button" value="Avbestill" name="Avbestill"> 
                    </a> 
                    <a href="skrivAnmeldelse.php">
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