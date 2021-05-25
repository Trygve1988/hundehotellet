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
    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
	<script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
    <script src="include/script.js" defer> </script>
    <script src="include/scriptSpraak.js" defer> </script>
</head>
<body>

    <!-- ************************** Felles topp************************** -->
    <?php visNav(); ?>
    <?php visNav3() ?>
    <!-- ************************** Main ******************************** -->
    <main>
 
        <!-- Anmeldelser -->
        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">
                <h2>Anmeldelser</h2>

                <!-- visNesteIkkeGodkjenteAnmeldelse -->
                <?php visNesteIkkeGodkjenteAnmeldelse($dblink); ?> 

                <!-- Knapperad -->
				<div class="knappeRad" id="knappePanel">
					<div class="knapp1IRad">
						<!-- Slett knapp -->			
	                	<button class="inputSubmit hovedKnapp" type="submit" name="slettAnmeldelseKnapp">Slett</button>
					</div>
					<div class="etterKolonnerKnapp">
						<!-- Godkjenn knapp -->
						<button class="inputSubmit hovedKnapp" type="submit" name="godkjennAnmeldelseKnapp">Godkjenn</button>	
					</div>
				</div>

                <?php slettAnmeldelse($dblink); ?> 
                <?php godkjennAnmeldelse($dblink); ?> 
            </form> 
        </div>
    </main>

    <!-- ************************** Felles bunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>