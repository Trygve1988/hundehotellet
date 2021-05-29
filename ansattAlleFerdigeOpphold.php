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
                <!-- Avbryt knapp -->
			    <a href = "ansattAlleOpphold.php">
				    <input class="avbrytKnapp" type="button" value="X">
			    </a>    

                <!-- 2a alleOpphold -->
                <h2>Alle ferdige Opphold</h2>
                <?php visFerdigeOpphold($dblink); ?>

                <div class="knappeRad">
                    <a href="ansattAlleOpphold.php">
                        <input class="litenKnapp" type="button" value="Tilbake">  
                    <a>
                </div>

            </form>

        </div>
        
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>