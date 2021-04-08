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
    <link href="./include/style.css" rel="stylesheet" type="text/css">
    <link href="./include/KontaktOss.css" rel="stylesheet" type="text/css">
    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
    <script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>

    <script src="include/script.js" defer> </script>
</head>

<body>
    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main ************************** -->
    <main>

        <!-- 2a kontakt oss -->
        <form method="POST">

            <!--********************** Kristina ************************** -->
            <section class="kontakt">
                <div class="kontakt-info">
                    <h1>Kontakt oss</h1>
                    <p>Er det noe du lurer på er det bare å kontakte oss enten på mail eller telefon.</p>

                    <p><strong> Åpningstider:</strong> 08:00-18:00 man-tor <br>
                        (10-00-16:00 lør-søn)</p> <br>

                    <p><strong> E-post: </strong>bøhundehotell@gmail.com </p> <br>
                    <p> <strong> Adresse: </strong> Lektorvegen 913802 Bø i Telemark </p> <br>
                    <p> <strong> Tlf: </strong> 12345678</p>

                </div>

                <!-- Blir send til hundehotell mailen gjennom tredjepart formsubmit.co som er gratis-->
                <div class="kontaktskjema-info ">
            <form action="https://formsubmit.co/bohundehotell@outlook.com" method="POST">
                <input type="hidden" name="_subject" value="Ny melding!">
                <label for="fnavn">Fornavn</label>
                <input type="text" id="navn" name="fornavn" placeholder="Ditt navn">

                <label for="epost">Epost</label>
                <input type="email" id="email" name="email" placeholder=" Skriv inn din epost adresse" required>

                <input type="hidden" name="_next" value="http://127.0.0.1:5502/takk.html"> <!--Link til takk siden fra nettsiden-->


                <label for="melding">Melding</label>
                <textarea id="message" name="message" placeholder="Hva lurer du på?"> </textarea>
                <button type="submit">Send</button>
           
            </form>
        </div>

            </section>

        </form>


    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?>
    <?php visToppKnapp(); ?>

</body>

</html>