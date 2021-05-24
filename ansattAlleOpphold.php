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
                <!-- 2a alleOpphold -->
                <h2>Alle Opphold</h2>
                <?php visAlleOpphold($dblink); ?>

                <?php //visIkkeBegynteOpphold($dblink); ?>
                <?php //visAktiveOpphold($dblink); ?>
                <?php //vis5SisteFerdigeOpphold($dblink); ?>

                <a href="ansattAlleOppholdEldre.php"> 
                    <input class="litenKnapp" type="button" value="Se Eldre"> 
                </a> 
                <a href="bestillOpphold1.php"> 
                    <input class="litenKnapp" type="button" value="Bestill Opphold"> 
                </a> 
                <a href="ansattAvbestill.php">
                    <input id="avbestillKnapp" class="litenKnapp" type="button" value="Avbestill" name="Avbestill">
                </a>
            </form>
        </div>
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>