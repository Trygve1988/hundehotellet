<?php
    include_once "include/funksjoner.php";
    include_once "include/funksjonerAnsatt.php";
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
    <?php visNav3() ?>
    <!-- ************************** 2) main **************************-->
    <main>
 
        <!-- 2a Anmeldelser -->
        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">
                <h2>Anmeldelser</h2>

                <!-- visNesteIkkeGodkjenteAnmeldelse -->
                <?php visNesteIkkeGodkjenteAnmeldelse($dblink); ?> 

                <!-- knappePanel -->
                <div id="knappePanel">
                    <button class="litenKnapp" type="submit" name="slettAnmeldelseKnapp">Slett</button>
                    <button class="litenKnapp" type="submit" name="godkjennAnmeldelseKnapp">Godkjenn</button>
                <div>

                <?php slettAnmeldelse($dblink); ?> 
                <?php godkjennAnmeldelse($dblink); ?> 

            </form> 

        </div>

    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>