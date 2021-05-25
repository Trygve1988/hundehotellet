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

            <div class="skjemaKolonner">
			    <div class="kolonne1">
                <h1 class="hovedOverskrift">Endre bruker</h1>

                    <!-- velgEndreBrukerSelect --> 
                    <label for="velgEndreBrukerselect">Velg bruker:</label>
                    <select name="velgEndreBrukerSelect" class="inputSelect">
                        <?php $brukere = lagBrukereTab($dblink);
                        for ($i=0; $i<count($brukere); $i++) {
                            lagOption($brukere[$i]);
                        } ?>
                    </select>

                    <!-- Knapperad -->
                    <div class="knappeRad">
                        <div class="knapp1IRad">
                            <!-- Avbryt knapp -->
                            <a href="admin.php">
                                <input class="inputButton hovedKnapp" type="button" value="Avbryt">  
                            <a>
                        </div>
                        <div class="etterKolonnerKnapp">
                            <!-- Velg bruker knapp -->
                            <input class="inputSubmit hovedKnapp" type="submit" value="Velg" name="velgEndreBrukerKnapp"> 	
                        </div>
                    </div>
                    
                    <?php velgEndreBruker($dblink); ?>  
                </div> 
            </div> 
        </form> 
    </main>

    <!-- ************************** Felles bunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>