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

        <div class="hovedBakgrunn">
            <img class="bildeBakgrunn" src="bilder/bakgrunn.jpg">

            <!--<div class="front"> -->

            <section>
                <img src="bilder/hundSlider1.jpg" id="slider">
        
                <ul class="navigation">
                    <li onclick="imgSlider('bilder/hundSlider1.jpg')"><img src="bilder/hundSlider1.jpg"></li>
                    <li onclick="imgSlider('bilder/hundSlider2.jpg')"><img src="bilder/hundSlider2.jpg"></li>
                    <li onclick="imgSlider('bilder/hundSlider3.jpg')"><img src="bilder/hundSlider3.jpg"></li>
                </ul>
            </section>                

                <div class="text">
                    <p>Velkommen til Bø Hundehotell</p>
                    <p>Norges BESTE Hundehotell for dine firbente venner</p>
                    <p>Åpningstider: Man-Fre 8-18, Lør-Søn: 10-16</p>
                </div>
                
                <div id="KontrollerBD">

                    <div class="bildeKontroller">
                        <a href="bestillOpphold.php"> <img src="bilder/hunder1.jpg" class="bilder"></a>
                        <h1> Bestill</h1>
                        <p>Her kan du bestille opphold til hunden(ene) dine.</p>
                    </div>

                    <div class="bildeKontroller">
                        <a href="Om Oss.html"><img src="bilder/hunder2.jpg" class="bilder"></a>
                        <h1>Om Hundehotellet</h1>
                        <p>Her kan du få mer info om Hundehotellet.</p>
                    </div>

                    <div class="bildeKontroller">
                        <a href="Pris.php"><img src="bilder/hunder3.jpg" class="bilder"></a>
                        <h1>Priser</h1>
                        <p>Her kan du se en oversikt over priser.</p>
                    </div>
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