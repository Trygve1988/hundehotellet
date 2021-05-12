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

                <!-- Avbryt knapp 
                <input class="avbrytKnapp" type="submit" name="avbryt" value="X">-->

                <!-- Overskrift -->
                <h2>Om oss</h2>

                <p class="omOssText">Bø Hundehotell holder til på Lektorvegen 91, i Bø i Telemark. Det er landelige omgivelser med store luftegårder, og fine turområder.
                Vi seks ansatt som jobber her på Bø Hundehotell, vi har vært i Hundehotell businessen i 6år, vi startet opp for først gang den 12.04.2010. Den gang var det bare
                jeg og mannen min. Vi er alle hunde elskere på her på Bø Hundehotell, og eier eller er vant med hund fra før av. Din hund vil være trygg i våre hender. 
                Vi håper vi ser deg og din hund her.</p>

                <div id="KontrollerBD2">

                    <div class="bildeKontroller2">
                        <img src="bilder/Ansatt/ans1.jfif" class="bilder2" alt="">
                        <p>Navn: Sansa Stark</p>
                        <p>Stiling: Daglig leder</p>
                    </div>

                    <div class="bildeKontroller2">
                        <img src="bilder/Ansatt/ans2.jfif" class="bilder2" alt="">
                        <p>Navn: Jon Snow</p>
                        <p>Stiling: Nestleder</p>
                    </div>

                    <div class="bildeKontroller2">
                        <img src="bilder/Ansatt/ans3.jfif" class="bilder2" alt="">
                        <p>Navn: Daenerys Targaryen</p>
                        <p>Stiling: Kontor-ansatt</p>
                    </div>
                </div>
                
                <div id="KontrollerBD2">

                    <div class="bildeKontroller2">
                        <img src="bilder/Ansatt/ans4.jfif" class="bilder2" alt="">
                        <p>Navn: Eddard Stark.</p>
                        <p>Stiling: Hundetrener</p>
                    </div>

                    <div class="bildeKontroller2">
                        <img src="bilder/Ansatt/ans5.jfif" class="bilder2" alt="">
                        <p>Navn: Tyrion Lannister</p>
                        <p>Stiling: Ansatt</p>
                    </div>

                    <div class="bildeKontroller2">
                        <img src="bilder/Ansatt/ans6.jfif" class="bilder2" alt="">
                        <p>Navn: Aerys Targaryen</p>
                        <p>Navn: Ansatt</p>
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