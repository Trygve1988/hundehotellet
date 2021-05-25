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

    <!-- ************************** Felles topp ************************** -->
    <?php visNav(); ?>

    <!-- ************************** Main ********************************* -->
    <main> 
        <!-- erLoggetInn -->
        <?php 
            if (!erLoggetInn()) {
                header('Location: loggInn.php');
            } 
        ?>
        <!-- Hvit bakgrunn -->
        <div class="hvitBakgrunn">

            <!-- Skjema -->

            <form class="skjemaBakgrunn" method="POST">
                 
                <!-- Avbryt knapp -->
			    <a href = "minSide.php">
				    <input class="avbrytKnapp" type="button" value="X">
			    </a>    
                
                <!-- Overskrift --> 
                <h2 class="hovedOverskrift">Slett bruker</h2>

                <p>Du må avbestille eventuelle fremtidige opphold før du kan slette kontoen din.</p>  
                <p>Det er mulig å gjenoprette kontoen innen 30 dager er gått. Etter dette blir kontoen slettet.</p>
                <p>Er det noe du lurer på i forhold til sletting av konto, kontakt oss på epost: <a href="mailto:bohundehotell@outlook.com">bohundehotell@outlook.com.</p>
                
                <!--Knapperad-->
				<div class="knappeRad heltIBunnKnapp">

					<div class="knapp1IRad">
						<!-- Tilbake-knapp-->
						<a href = "minSide.php">
	                		<input class="inputButton hovedKnapp" type="button" value="Tilbake"> 
	            		</a>
					</div>

					<div class="etterKolonnerKnapp">
						<!-- Neste-knapp-->
                        <a href = "minSideSlettBruker2.php">
	                		<input class="inputButton hovedKnapp" type="button" value="Slett Bruker"> 
	            		</a>
					</div>

                </div>

            </form>
        </div> 
    </main>

    <!-- ************************** Felles bunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>