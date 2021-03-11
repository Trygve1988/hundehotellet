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
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main>
        <!-- anmeldelseSlider --> 
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








