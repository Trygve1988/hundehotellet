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
    <!-- ************************** DETTE HAR VI IKKE LAGD SELV ************************** -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
</head>

<body>

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main>

        <div class="hvitBakgrunn">
    
             <!-- Form-->    
            <form class="skjemaBakgrunn" method="POST">

                <!-- Avbryt knapp -->
                <input class="avbrytKnapp" type="submit" name="avbryt" value="X">

                <!-- Overskrift -->
                <h2>Pris</h2>

                <h3>Tekst:</h3>
            </form>
        </div> 
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?>
    <?php visToppKnapp(); ?>

</body>

</html>