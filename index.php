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
    <script src="include/script.js" defer> </script>
</head>
<body>

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visBildeBakgrunn(); ?>
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main>

      <div class="body">
        <img  class="background" src="bilder/bakgrund.jpg">

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
            <p >Åpningstider: Man-Fre 8-18, Lør-Søn: 10-16</p>
          </div>

          <div class="miniBilde">  
            <a href="Opphold.html"> <img src="bilder/hunder1.jpg" class="bilder"></a>
            <a href="Om Oss.html"><img src="bilder/hunder2.jpg" class="bilder"></a>
            <a href="Pris.php"><img  src="bilder/hunder3.jpg" class="bilder"></a>
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
    <?php visToppKnapp(); ?> 

</body>
</html>








