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
    <script src="include/script.js" defer> </script>
</head>
<body>

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main (Trygve) **************************-->
    
    <main> 
        <div class="body"> 
            <img class="bildeBakgrunn" src="bilder/bakgrunn.jpg">
            
            <!-- 2a omOss -->
            <form class="skjema"> 
                <?php visInnloggetInfo($dblink); ?>
                <?php visMineHunder($dblink) ?>

                <!-- registrerHund -->
                <a href="registrerHund.php">registrerHund</a>

                <?php //visBestillinger($dblink); UNDER ARBEID!!!!!?> 
            </form> 
        <div> 
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>