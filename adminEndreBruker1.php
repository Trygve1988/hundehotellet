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
                <h1 class="hovedOverskrift">Endre bruker</h1>

                    <!-- velgEndreBrukerSelect --> 
                    <select name="velgEndreBrukerSelect" class="inputSelect">
                        <?php $brukere = lagBrukereTab($dblink);
                        for ($i=0; $i<count($brukere); $i++) {
                            lagOption($brukere[$i]);
                        } ?>
                    </select>

                    <a href="admin.php">
                        <input class="litenKnapp" type="button" value="Avbryt">  
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