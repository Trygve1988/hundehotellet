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

<<<<<<< HEAD
      <div class="body">
        <img  class="background" src="bakgrund.jpg">

        <div class="front">

          <section>
            <img src="hundSlider1.jpg" id="slider">
            
            <ul class="navigation">
              <li onclick="imgSlider('hundSlider1.jpg')"><img src="hundSlider1.jpg"></li>
              <li onclick="imgSlider('hundSlider2.jpg')"><img src="hundSlider2.jpg"></li>
              <li onclick="imgSlider('hundSlider3.jpg')"><img src="hundSlider3.jpg"></li>
            </ul>
          </section>
          
          <div class="text">
            <p>Velkommen til Bø Hundehotell</p>
            <p>Norges BESTE Hundehotell for dine firbente venner</p>
            <p >Åpningstider: Man-Fre 8-18, Lør-Søn: 10-16</p>
          </div>

          <div class="miniBilde">  
            <a href="Opphold.html"> <img src="hunder1.jpg" class="bilder"></a>
            <a href="Om Oss.html"><img src="hunder2.jpg" class="bilder"></a>
            <a href="Pris.php"><img  src="hunder3.jpg" class="bilder"></a>
          </div>

          <!-- Trygve anmeldelseslider -->
          <div id="anmeldelseBoks"> 
            <a id="tilbakeAnmeldelseKnapp" class="anmeldelseBoksKnapp">&#10094;</a>  
            <div id="anmeldelseTekstBoks">
                <p id="anmeldelseTekst"></p>
            </div>
            <a id="nesteAnmeldelseKnapp" class="anmeldelseBoksKnapp">&#10095;</a>
        </div>


=======
  <div class="body">
    <img  class="background" src="bilder/bakgrunn.jpg"> 

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
>>>>>>> d297ced4c792e8221c95b326911d67e3946c1323
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>








