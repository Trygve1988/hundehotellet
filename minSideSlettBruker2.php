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
                <h2 class="hovedOverskrift">Bekreft sletting av  bruker</h2>

                <p>Er du sikker på at du vil slette brukeren din?</p>  
              
                <!--Knapperad-->
				<div class="knappeRad bunnKnapp">

					<div class="knapp1IRad">
						<!-- Tilbake-knapp-->
						<a href = "minSide.php">
	                		<input class="inputButton hovedKnapp" type="button" value="Tilbake"> 
	            		</a>
					</div>

					<div class="etterKolonnerKnapp">
						<!-- Neste-knapp-->
						<input class="inputSubmit hovedKnapp" type="submit" name="slettBrukerKnapp" value="Slett konto">
					</div>

                </div>

                <!-- Tilbakemelding -->
                <div>
                    <?php slettMinBruker($dblink) ?>
                </div>
            </form>
        </div> 
    </main>

    <!-- ************************** Felles bunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>
