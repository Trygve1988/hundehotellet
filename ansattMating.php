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

    <!-- ************************** Felles topp ************************** -->
    <?php visNav(); ?>
    <?php visNav3() ?>

    <!-- ************************** Main **************************-->
    <main> 

        <!-- erAnsatt sjekk-->
        <?php if (!erAnsatt()) { header('Location: loggInn.php'); } ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">

            <?php registrerMatingAlle($dblink); ?>
            <?php slettAlleMatinger($dblink); ?>
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">

                <h2 class="hovedOverskrift">Mating</h2>
                <?php //visAlleHunderPaaOppholdNaa($dblink); ?>
                <?php visAlleRegistrerteMatingerIDag($dblink); ?>

                <input class="inputSubmit mediumKnapp" type="submit" name="registrerMatingAlle" value="Registrer mating (alle)">
                <input class="inputSubmit mediumKnapp" type="submit" name="slettAlle" value="Slett dagens mating"> 

            </form>
        </div>    
    </main>

    <!-- ************************** Felles bunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>