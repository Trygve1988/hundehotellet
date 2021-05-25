<?php
    include_once "include/funksjoner.php";
    include_once "include/funksjonerMinSide.php";
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

    <!-- ************************** Felles topp **************************** -->
    <?php visNav(); ?>

    <!-- ************************** Main *********************************** -->
    <main>
    	<!-- ************************ (Gunni) ****************************** -->
        <!-- Hvit bakgrunn -->
        <div class="hvitBakgrunn">
            
            <!-- Skjemabakgrunn -->
            <form class="skjemaBakgrunn" method="POST">
            	
                <!-- Avbryt knapp -->
				<a href = "minSide.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

                <!-- Overskrift -->
                <h2 id="skrivAnmeldelse" class="hovedOverskrift" >Skriv anmeldelse</h2>

                <!-- Tekstområde -->
                <div class="anmeldelseTilbakemelding">
                    <textarea name="anmeldelseKundeText" id="skrivAnmeldse" cols="110" rows="20"></textarea>
                </div>

                <!--Knapperad-->
				<div class="knappeRad">
					<div class="knapp1IRad">
						<!-- Tilbake knapp-->
						<a href="minSide.php">
                            <input class="inputButton hovedKnapp" type="button" value="Avbryt" name = "Avbryt">
                        </a>
					</div>
					<div class="etterKolonnerKnapp">
						<!-- Neste knapp-->
						<input class="inputSubmit hovedKnapp2" type="submit" value="Send" name = "sendAnmeldelseKnapp">
					</div>
				</div>

                <!-- Lagre anmeldelse -->
                <?php lagreAnmeldelse($dblink); ?>
            </form> 
        </div>
    </main>

    <!-- ************************** Felles bunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>