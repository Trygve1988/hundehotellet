||<?php
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
    <script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
    <script src="include/script.js" defer> </script>
</head>

<body>

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visBildeBakgrunn(); ?>
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main>

        <div class="body">
            <img class="background" src="bilder/bakgrund.jpg">

            <div class="front">

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

                <div class="miniBilde">
                    <a href="Opphold.html"> <img src="bilder/hunder1.jpg" class="bilder"></a>
                    <a href="Om Oss.html"><img src="bilder/bilder/hunder2.jpg" class="bilder"></a>
                    <a href="Pris.php"><img src="bilder/hunder3.jpg" class="bilder"></a>
                </div>

                <!-- Trygve anmeldelseslider -->
                <div id="anmeldelseBoks">
                    <a id="tilbakeAnmeldelseKnapp" class="anmeldelseBoksKnapp">&#10094;</a>
                    <div id="anmeldelseTekstBoks">
                        <p id="anmeldelseTekst"></p>
                    </div>
                    <a id="nesteAnmeldelseKnapp" class="anmeldelseBoksKnapp">&#10095;</a>
                </div>
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?>

    <!-- Footer lagt til-->
    <footer class="main-footer">
        <div class="venstre">
            <h1>Kontakinformsjon</h1>
            <p>Bø Hundehotell</p>
            <p><strong>Tlf:</strong> 12345678</p>
            <p><strong>E-post:</strong><a href="bøhundehotell@gmail.com">bøhundehotell@gmail.com</a></p>
            <p> <strong>Adresse:</strong>Lektorvegen 91 <br> 3802 Bø i Telemark</p>
        </div>

        <div class="midten sosiale-medier">
            <h1>Sosiale medier</h1>

            <a href="https://www.instagram.com" target="_blank">
                <img src="bilder/Logo/facebook.xcf" alt="Instagram Logo" class="instagram-ikon"></a>

            <a href="https://www.facebook.com" target="_blank">
                <img src="bilder/Logo/facebook.png" alt="Facebook Logo" class="facebook-ikon"></a>

            <a href="https://twitter.com/twitter" target="_blank">
                <img src="bilder/Logo/twitter.png" alt="Twitter Logo" class="twitter-ikon"></a>
        </div>

        <!-- Gratis google kart fra https://maps-website.com-->
        <div class="høyre kart">
            <h1>Besøk oss</h1>
            <iframe width="350" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=350&amp;height=200&amp;hl=en&amp;q=Lektorvegen%2091%20B%C3%B8%20i%20Telemark+()&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
            <a href='https://addmap.net/'>google maps directions embed</a>
            <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=83957d2396c89fcb76438cfa7afc7c07aeee769a'></script>

        </div>

        <div class="høyre">
            <h1>Samarbeidspartnere</h1>
            <p>Royal Canin</p>
        </div>

    </footer>

    <button onclick="toppKnappFunksjon()" id="Knappen" title="Gå til toppen"><i class="fas fa-chevron-up"></i> </button> <!-- gratis Opp ikon fra https://fontawesome.com/icons/chevron-up?style=solid-->

    <script src="./include/javascriptKode/toppknappen.js"></script>



    <?php visToppKnapp(); ?>

</body>

</html>