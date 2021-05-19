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

    <!-- ************************** fellesTop **************************** -->
    <?php visNav(); ?>
    <?php visNav2(); ?>

    <!-- ************************** main ********************************** -->
    <main>
    	<!-- ************************ (Gunni) ****************************** -->
        <!-- Anmeldelser -->
        <div class="hvitBakgrunn">
            <form class="skjemaBakgrunn">
                <h2>Anmeldelser</h2>
                <div class="anmeldseGodkjenning">
                    <textarea name="skrivAnmeldse" id="skrivAnmeldse" cols="100" rows="20" readonly></textarea>
                </div>
                    <input class="litenKnapp" type="button" value="Avbryt" name = "Avbryt">
                    <input class="litenKnapp" type="button" value="Godkjenn" name = "Godkjenn">
            </form> 
        </div>
    </main>

    <!-- ************************** fellesBunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>