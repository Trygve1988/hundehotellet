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

    <!--***********************  Admin ********************************* -->

    <!-- ************************** fellesTop ************************** -->
    <?php visNav(); ?>
    <?php visNav3() ?>

    <!-- ************************** main ******************************* -->
    <main> 

        <!-- 2a erAnsatt sjekk-->
        <?php if (!erAnsatt()) { header('Location: loggInn.php'); } ?>

        <!-- Hvit bakgrunn -->	
        <div class="hvitBakgrunn">

            <!-- Skjema -->		
            <form class="skjemaBakgrunn" method="POST">

                <!-- Overskrift -->
                <h2 class="hovedOverskrift">Alle Opphold</h2>	

                <!-- 2a alleOpphold -->
                <?php visIkkeBegynteOpphold($dblink); ?>
                <?php visAktiveOpphold($dblink); ?>
                <?php vis5SisteFerdigeOpphold($dblink); ?>
                <a href="ansattAlleOppholdEldre.php"> 
                    <input class="litenKnapp" type="button" value="Se Eldre"> 
                </a> 
                <a href="bestillOpphold.php"> 
                    <input class="litenKnapp" type="button" value="Bestill Opphold"> 
                </a> 
                <a href="ansattAvbestill.php">
                    <input class="litenKnapp" type="button" value="Avbestill" name="Avbestill"> 
                </a> 
            </form>

        </div>

    </main>

    <!-- ************************** fellesBunn **************************** -->
    <?php visFooter(); ?>
    <?php visToppKnapp(); ?>

</body>

</html>