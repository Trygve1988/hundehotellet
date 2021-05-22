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
    <script src="include/script.js" defer> </script>
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
                <h2>Luftegård</h2>
                <?php visAlleHunderPaaOppholdNaaLufting($dblink); ?>
                <?php visAlleRegistrerteLuftingerIDag($dblink); ?>

                <input class="litenKnapp" type="submit" name="registrerLuftingStartAlle" value="Registrer Start (alle)">
                <input class="litenKnapp" type="submit" name="registrerLuftingSluttAlle" value="Registrer Slutt (alle)">
                <input class="litenKnapp" type="submit" name="slettAlle" value="Slett Alle"> 

                <?php registrerLuftingStartAlle($dblink); ?>
                <?php registrerLuftingSluttAlle($dblink); ?>
                <?php slettAlleLuftinger($dblink); ?>
            </form>

        </div>
        
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>