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

    <link rel="stylesheet" href="./include/style.css">
   

    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
    <script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
    <script src="include/script.js" defer> </script>
 <title>Bø Hundehotell</title>
</head>

<body>
    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>
    <!-- ************************** 2) main ************************** -->
    <main>
        <!-- 2a kontakt oss -->
        <div class="hvitBakgrunn">
            <form class="skjemaBakgrunn">
                <!--********************** Kristina ************************** -->

                <section class="kontakt">
                    <div class="kontakt-info">
                        <h2 class="hovedOverskrift">Kontakt oss</h2>

                        <div class="kontakt-info-tekst">
                            <p>Er det noe du lurer på er det bare å kontakte oss enten på mail eller telefon.</p>
                        </div>

                        <p><strong> Åpningstider:</strong> 08:00-18:00 man-tor (10-00-16:00 lør-søn)</p>
                        <p><strong> E-post: </strong><a href="mailto:bohundehotell@outlook.com">bohundehotell@outlook.com </a> </p>
                        <p> <strong> Adresse: </strong> Lektorvegen 913802 Bø i Telemark </p>
                        <p> <strong> Tlf: </strong> 12345678</p>
                    </div>

                </section>

            </form>

        </div>

    </main>


    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?>
    <?php visToppKnapp(); ?>

</body>

</html>