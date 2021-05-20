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

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main>

        <!-- 2a erAdmin sjekk -->
        <?php  if (!erAdmin()) { header('Location: loggInn.php'); } ?>

		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST">

            <div class="skjemaKolonner">
			    <div class="kolonne1">

                    <h3>Endre Bruker</h3>  

                    <!-- velgEndreBrukerSelect --> 
                    <select name="velgEndreBrukerSelect" class="inputSelect">
                        <?php $brukere = lagBrukereTab($dblink);
                        for ($i=0; $i<count($brukere); $i++) {
                            lagOption($brukere[$i]);
                        } ?>
                    </select>

                    <a href="admin.php">
                        <input class="litenKnapp" type="button" value="Tilbake">  
                     <a>
                    <input class="litenKnapp" type="submit" value="Velg" name="velgEndreBrukerKnapp">
        
                    <?php velgEndreBruker($dblink); ?>  
                </div> 
            </div> 
        </form> 
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>