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
    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
    <script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
    <script src="include/script.js" defer> </script>
</head>
<body>

    <!-- ************************** fellesTop **************************** -->
    <?php visNav(); ?>
    <?php visNav3(); ?>

    <!-- ************************** main ********************************** -->
    <main>
    	<!-- ************************ (Gunni) ****************************** -->
        <!-- Anmeldelser -->
        <div class="hvitBakgrunn">
            <form class="skjemaBakgrunn" method="post"> 

            	<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

                <h2>Anmeldelser</h2>
                <!--<div class="anmeldseGodkjenning">
                    <textarea name="skrivAnmeldse" id="skrivAnmeldse" cols="100" rows="20" readonly> </textarea>
                </div>-->
                <?php visNesteIkkeGodkjenteAnmeldelse($dblink); ?> 
                <button class="litenKnapp" type="submit" name="slettAnmeldelseKnapp">Slett</button>
                <button class="litenKnapp" type="submit" name="godkjennAnmeldelseKnapp">Godkjenn</button>
   
            </form> 

            <?php slettAnmeldelse($dblink); ?> 
            <?php godkjennAnmeldelse($dblink); ?> 

        </div>
    </main>

    <!-- ************************** fellesBunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>