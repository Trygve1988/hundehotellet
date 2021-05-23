<?php
    include_once "include/funksjoner.php";
    include_once "include/funksjonerMinSide.php";
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
    <script src="include/scriptSpraak.js" defer> </script>
</head>
<body>

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main> 

        <!-- 2a erLoggetInn -->
        <?php 
            if (!erLoggetInn()) {
                header('Location: loggInn.php');
            } 
        ?>

        <!-- 2a admin -->
        <div class="hvitBakgrunn">
            <form class="skjemaBakgrunn" method="POST">
                <h2>Slett Bruker</h2>
                <p>Du må avbestille eventuelle fremtidige opphold før du kan slette kontoen din.</p>  
                <input class="litenKnapp" type="submit" name="slettBrukerKnapp" value="Slett Min Konto">
                <?php slettMinBruker($dblink) ?> 
            </form>
        </div> 
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>