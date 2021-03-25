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

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main>

        <div class="body">
            <img class="bildeBakgrunn" src="bilder/bakgrunn.jpg">

            <div class="front">

                <div class="text">
                    <p>Velkommen til Bø Hundehotell</p>
                    <p>Norges BESTE Hundehotell for dine firbente venner</p>
                    <p>Åpningstider: Man-Fre 8-18, Lør-Søn: 10-16</p>
                </div>

                <div class="miniBilde">
                    <a href="Opphold.html"> <img src="bilder/hunder1.jpg" class="bilder"></a>
                    <a href="Om Oss.html"><img src="bilder/hunder2.jpg" class="bilder"></a>
                    <a href="Pris.php"><img src="bilder/hunder3.jpg" class="bilder"></a>
                </div>

                <!-- Trygve anmeldelseslider -->
                <div id="anmeldelseBoks">
                    <div id="anmeldelseTekstBoks">
                        <p id="anmeldelseTekst"></p>
                    </div>
                    <a id="tilbakeAnmeldelseKnapp" class="anmeldelseBoksKnapp">&#10094;</a>
                    <a id="nesteAnmeldelseKnapp" class="anmeldelseBoksKnapp">&#10095;</a>
                </div>

            </div>
        </div>
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?>

    <button onclick="toppKnappFunksjon()" id="Knappen" title="Gå til toppen"><i class="fas fa-chevron-up"></i> </button> <!-- gratis Opp ikon fra https://fontawesome.com/icons/chevron-up?style=solid-->

    <script src="./include/javascriptKode/toppknappen.js"></script>

    <?php visToppKnapp(); ?>

</body>

</html>