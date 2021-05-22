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
                <h2>Kommentar</h2>
                <?php //visAlleHunderPaaOppholdNaaKommentar($dblink); ?>
                <?php visAlleRegistrerteKommentarIDag($dblink); ?>

                <!-- skriv kommentar -->
                <label for="kommentarText">kommentarText:</label>
                <textarea name="kommentarText" rows="10" cols="115"></textarea>

                <!-- velg Hund -->
                <select name="velgHundSelect" class="litenSelect" width="100px">
                    <?php $hunder = lagHunderPaaOppholdNaaTab($dblink);
                    for ($i=0; $i<count($hunder); $i++) {
                        lagOption($hunder[$i]);
                    } ?>
                </select>

                <!-- knapper-->
                <input class="litenKnapp" type="submit" name="registrerKommentarKnapp" value="Lagre">
                <input class="litenKnapp" type="submit" name="slettAlle" value="Slett Alle"> 

                <?php registrerKommentar($dblink); ?>
            </form>

        </div>
        
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>