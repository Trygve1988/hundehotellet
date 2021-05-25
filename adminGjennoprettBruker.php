<?php
    include_once "include/funksjoner.php";
    include_once "include/funksjonerAdmin.php";
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

    <!-- ************************** Felles topp ************************** -->
    <?php visNav(); ?>

    <!-- ************************** Main ********************************* -->
    <main>

        <!-- erAdmin sjekk -->
        <?php  if (!erAdmin()) { header('Location: loggInn.php'); } ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">

                <!-- Avbryt knapp -->
                <a href = "admin.php">
                    <input class="avbrytKnapp" type="button" value="X">
                </a>

                <!-- Overskrift -->
                <h2 class="hovedOverskrift">Gjennoprett bruker</h2>  
                
                <div class="skjemaKolonner">
                    <div class="kolonne1">
                        <label for="velgGjennoprettBrukerSelect">Velg bruker:</label>
                        <select name="velgGjennoprettBrukerSelect" class="inputSelect minInput">
                            <?php $brukere = lagSlettedeBrukereTab($dblink);
                            for ($i=0; $i<count($brukere); $i++) {
                                lagOption($brukere[$i]);
                            } ?>
                        </select>         
                    </div>
                </div> 
                
                <!-- Knapperad -->
				<div class="knappeRad bunnKnapp">
					<div class="knapp1IRad">
						<!-- Tilbake knapp -->
						<a href="admin.php">
                            <input class="inputButton hovedKnapp" type="button" value="Tilbake">  
                        <a>
					</div>
					<div class="etterKolonnerKnapp">
						<!-- Gjenopprett bruker -->
						<input class="inputSubmit hovedKnapp2" type="submit" value="Gjennoprett bruker" name="velgGjennoprettBrukerKnapp">
					</div>
				</div>
                <?php gjennoprettBruker($dblink); ?>      
            </div>  
           
        </form> 
    </main>

    <!-- ************************** Felles bunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>