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
    <link href="include/style.css" rel="stylesheet" type="text/css"> <!-- Problem med mappestrukturen? -->
    <link href="include/KontaktOss.css" rel="stylesheet" type="text/css"> <!-- Problem med mappestrukturen? -->
    
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

        <!-- Demo, funker ikke må kobles med php-->
        <div class="kontaktskjema-info ">
            <form>
                <label for="fnavn">Fornavn</label>
                <input type="text" id="fnavn" name="fornavn" placeholder="Ditt navn">

                <label for="epost">Epost</label>
                <input type="text" id="epost" name="brukerepost" placeholder="epost adresse">

                <label for="emne">Emne</label>
                <input type="text" id="emne" name="brukeremne" placeholder="Emne">

                <label for="melding">Melding</label>
                <textarea id="melding" name="melding" placeholder="Hva lurer du på?"></textarea>
                <input type="submit" value="Send">
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