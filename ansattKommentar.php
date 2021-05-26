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

    <!-- ************************** Main ********************************* -->
    <main> 

        <!-- erAnsatt sjekk-->
        <?php if (!erAnsatt()) { header('Location: loggInn.php'); } ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">

                <?php registrerKommentar($dblink); ?>
                <?php slettAlleKommentarer($dblink); ?>     

                <h2 class="hovedOverskrift">Kommentarer</h2>

                <?php visAlleRegistrerteKommentarIDag($dblink); ?>

                <!-- Velg Hund -->
                <label for="velgHundSelect">Velg Hund:</label>
                <select name="velgHundSelect" class="litenSelect litenInput">
                    <?php $hunder = lagHunderPaaOppholdNaaTab($dblink);
                    for ($i=0; $i<count($hunder); $i++) {
                        lagOption($hunder[$i]);
                    } ?>
                </select>

                <!-- Skriv kommentar -->
                <br>
                <label for="kommentarText">Skriv inn kommentar:</label>
                <textarea name="kommentarText" rows="10" cols="115"></textarea>



                <!-- Knapper-->
                <input class="inputSubmit mediumKnapp" type="submit" name="registrerKommentarKnapp" value="Lagre">
                <input class="inputSubmit mediumKnapp" type="submit" name="slettAlle" value="Slett alle"> 

            </form>
        </div>  
    </main>

    <!-- ************************** Felles bunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>