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

    <!-- ************************** fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** main ******************************* -->
    <main>
        	<!-- ************************ (Even) *********************** -->
        <div class="hvitBakgrunn">

            <!-- Bilde slideren er hentet fra https://www.w3schools.com/howto/howto_js_slideshow.asp -->
                <!-- Slideshow container -->
                <div class="slideshow-container">

                    <div class="mySlides fade">
                        <img src="bilder/hundSlider1.jpg" style="width:100%" alt="Bilde av hund fra bildeslider">
                    </div>

                    <div class="mySlides fade">
                        <img src="bilder/hundSlider2.jpg" style="width:100%" alt="Bilde av hund fra bildeslider">
                    </div>

                    <div class="mySlides fade">
                        <img src="bilder/hundSlider3.jpg" style="width:100%" alt="Bilde av hund fra bildeslider">
                    </div>

                    <!-- Neste og forje bildeknapp-->  
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>    
                    </div>
                    <br>

                    <!-- Rundingene under bilde -->
                    <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                </div>  
                <!--*********** Slutt på hentet kode ***********-->
                
                <div class="velkommenText">
                    <p>Velkommen til Bø Hundehotell</p>
                    <p>Norges BESTE Hundehotell for dine firbente venner</p>
                    <p>Åpningstider: Man-Fre 8-18, Lør-Søn: 10-16</p>
                </div>
                
                <div id="KontrollerBD">

                    <div class="bildeKontroller">
                        <a href="bestillOpphold.php"> <img src="bilder/hunder1.jpg" class="bilder" alt="Bilde av hund, dette bilde fører deg til bestill opphold"></a>
                        <h1> Bestill</h1>
                        <p>Her kan du bestille opphold til hunden(ene) dine.</p>
                    </div>

                    <div class="bildeKontroller">
                        <a href="omOss.php"><img src="bilder/hunder2.jpg" class="bilder" alt="Bilde av hund, dette bilde fører deg til om hundehotellet"></a>
                        <h1>Om Hundehotellet</h1>
                        <p>Her kan du få mer info om Hundehotellet.</p>
                    </div>

                    <div class="bildeKontroller">
                        <a href="priserOgInfo.php"><img src="bilder/hunder3.jpg" class="bilder" alt="Bilde av hund, dette bilde fører deg til pris oversikt siden"></a>
                        <h1>Priser</h1>
                        <p>Her kan du se en oversikt over priser.</p>
                    </div>
                </div>
                <!-- ************************ (Trygve) ****************************** -->
                <div id="anmeldelseBoks">
                    <div id="anmeldelseTekstBoks">
                        <p id="anmeldelseTekst"></p>
                    </div>
                    <a id="tilbakeAnmeldelseKnapp" class="anmeldelseBoksKnapp">&#10094;</a>
                    <a id="nesteAnmeldelseKnapp" class="anmeldelseBoksKnapp">&#10095;</a>
                </div>
        </div>
    </main>

    <!-- ************************** fellesBunn ************************** -->
    <?php visFooter(); ?>
    <?php visToppKnapp(); ?>

    <script src="./include/javascriptKode/toppknappen.js"></script>

</body>

</html>