<?php
include_once "include/funksjoner.php";
include_once "include/funksjonerAktuelt.php";
session_start();
$dblink = kobleOpp();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktuelt</title>
    <link href="include/style.css" rel="stylesheet" type="text/css">
    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
    <script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
    <script src="include/script.js" defer> </script>
    <script src="include/scriptSpraak.js" defer> </script>
</head>

<body>

    <!-- ************************** fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** main ******************************* -->
    <main>

        <div class="hvitBakgrunn">

            <!-- Skjema -->
            <form class="skjemaBakgrunn" method="POST">

                <!--********************** Kristina ************************** -->

                <div class="aktuelt">

                    <h1 id="aktuelt" class="hovedOverskrift">Aktuelt</h2>
                    <p id="aktueltText">Her kan du lese om det som skjer på Bø Hundehotell.</p>

                   <!-- lagreInnlegg -->
                   <?php
                    if (erAnsatt()) { ?>
                        <div class="mellomromMellomInnlegg">
                        
                        <h3>Skriv nytt innlegg</h3>
                            <label for="overskrift">overskrift:</label>
                            <input class="inputTekst" type="text" name="innleggOverskrift" value="overskrift">

                            <label for="text">text:</label>
                            <input class="inputTekst" type="text" name="innleggText" value="text">

                            <input class="litenKnapp" type="submit" value="Publiser" name="lagreInnleggKnapp">
                            <input class="litenKnapp" type="submit" value="Slett siste" name="slettInnleggKnapp">

                            <?php lagreInnlegg($dblink); ?>
                            <?php slettInnlegg($dblink); ?>
                        </div><?php
                    } ?>

                    <!-- visAlleInnlegg -->
                    <?php visAlleInnlegg($dblink); ?>

                </div>
            </form>
        </div>
    </main>
    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?>
    <?php visToppKnapp(); ?>

</body>

</html>