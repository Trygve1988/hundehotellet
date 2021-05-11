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
    <title>Bø Hundehotell</title>
    <link href="include/style.css" rel="stylesheet" type="text/css">
    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
    <script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
    <script src="include/script.js" defer> </script>
</head>

<body>

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main>

        <!-- 2a omOss -->
        <div class="hvitBakgrunn">
            <img class="bildeBakgrunn" src="bilder/bakgrunn.jpg">
    
             <!-- Form-->    
            <form class="skjemaBakgrunn" method="POST">

                <!-- Avbryt knapp -->
                <input class="avbrytKnapp" type="submit" name="avbryt" value="X">

                <!-- Overskrift -->
                <h2>Om oss</h2>

                <p class="omOssText">Bø Hundehotell holder til på Lektorvegen 91, i Bø i Telemark. Det er landelige omgivelser med store luftegårder, og fine turområder.
                Vi seks ansatt som jobber her på Bø Hundehotell, vi har vært i Hundehotell businessen i 6år, vi startet opp for først gang den 12.04.2010. Den gang var det bare
                jeg og mannen min. Vi er alle hunde elskere på her på Bø Hundehotell, og eier eller er vant med hund fra før av. Din hund vil være trygg i våre hender. 
                Vi håper vi ser deg og din hund her.</p>

                <div id="KontrollerBD2">

                    <div class="bildeKontroller2">
                        <a href="bestillOpphold.php"> <img src="bilder/hunder1.jpg" class="bilder2" alt="Bilde av hund, dette bilde fører deg til bestill opphold"></a>
                        <h1> Bestill</h1>
                        <p>Her kan du bestille opphold til hunden(ene) dine.</p>
                    </div>

                    <div class="bildeKontroller2">
                        <a href="omOss.php"><img src="bilder/hunder2.jpg" class="bilder2" alt="Bilde av hund, dette bilde fører deg til om hundehotellet"></a>
                        <h1>Om Hundehotellet</h1>
                        <p>Her kan du få mer info om Hundehotellet.</p>
                    </div>

                    <div class="bildeKontroller2">
                        <a href="priser.php"><img src="bilder/hunder3.jpg" class="bilder2" alt="Bilde av hund, dette bilde fører deg til pris oversikt siden"></a>
                        <h1>Priser</h1>
                        <p>Her kan du se en oversikt over priser.</p>
                    </div>
                </div>
                
                <div id="KontrollerBD2">

                    <div class="bildeKontroller2">
                        <a href="bestillOpphold.php"> <img src="bilder/hunder1.jpg" class="bilder2" alt="Bilde av hund, dette bilde fører deg til bestill opphold"></a>
                        <h1> Bestill</h1>
                        <p>Her kan du bestille opphold til hunden(ene) dine.</p>
                    </div>

                    <div class="bildeKontroller2">
                        <a href="omOss.php"><img src="bilder/hunder2.jpg" class="bilder2" alt="Bilde av hund, dette bilde fører deg til om hundehotellet"></a>
                        <h1>Om Hundehotellet</h1>
                        <p>Her kan du få mer info om Hundehotellet.</p>
                    </div>

                    <div class="bildeKontroller2">
                        <a href="priser.php"><img src="bilder/hunder3.jpg" class="bilder2" alt="Bilde av hund, dette bilde fører deg til pris oversikt siden"></a>
                        <h1>Priser</h1>
                        <p>Her kan du se en oversikt over priser.</p>
                    </div>
                </div>
            </form>
        </div> 

    </main>


    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?>
    <?php visToppKnapp(); ?>

</body>

</html>