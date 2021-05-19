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


    <!-- ************************** fellesTop ************************** -->
        <?php visNav(); ?>
        <?php visNav2() ?>
        <?php visNav3() ?>

    <!-- ************************** main **************************-->
    <main>

        <!-- erAnsatt sjekk -->
        <?php if (!erAnsatt()) {
            header('Location: loggInn.php');
        } ?>

        <!-- 2a admin -->
        <div class="hvitBakgrunn">
            <form class="skjemaBakgrunn">
            </form> 
        </div> 

    </main>

    <!-- ************************** fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>