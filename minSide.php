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

        <!-- erLoggetInn -->
        <?php 
            if (!erLoggetInn()) {
                header('Location: loggInn.php');
            } 
        ?>
        <!-- ************************** (Gunni) ************************* -->
        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">

                <!-- Overskrift -->
                <h2 class="hovedOverskrift">Min side</h2>

                <!-- Min profil -->
                <h2 class="overskrift2">Min profil</h2>
                <?php minProfilTab($dblink); ?>

                <a href="minSideEndreBrukerInfo.php">
                    <input class="litenKnapp" type="button" value="Endre Bruker" name="Endre Bruker">
                </a>
                <a href="minSideEndrePassord.php"> 
                    <input class="litenKnapp" type="button" value="Endre Passord" name="Endre Passord">
                </a>
                <a href="minSideSlettBruker.php"> 
                    <input class="litenKnapp" type="button" value="Slett Bruker">
                </a>
                <br><br><br>

                <!-- ************************** (Trygve) ************************** -->
                <!-- Mine hunder -->
                <h2 class="overskrift2">Mine Hunder</h2>
                <label for="velgHundSelect">Velg Hund</label>
                <select id="velgMinSideHundSelect" class="litenSelect" name="velgHundSelect" width="100px">
                    <?php $hunder = lagHunderTab($dblink);
                    $minSideHund = $_SESSION['minSideHund']; 
                    for ($i=0; $i<count($hunder); $i++) {
                        lagMinSideOption($hunder[$i],$minSideHund);
                    } ?>
                </select>
                <?php minHundTab($dblink); ?>

                <a href="registrerHundMS.php">
                    <input class="litenKnapp" type="button" value="Registrer Hund">
                </a>
                <?php if (harHund($dblink)) { ?>
                    <a href="minSideEndreHund.php">
                        <input class="litenKnapp" type="button" value="Endre Hund">  
                    </a>
                    <a href="minSideSlettHund.php">
                        <input class="litenKnapp" type="button" value="Slett Hund">  
                    </a>
                <?php } ?>
                <br><br><br>

                <!-- Mine opphold --> 
                <h2 class="overskrift2">Mine Opphold</h2>";
                <?php visMineOpphold($dblink); ?> 
                <?php if (harOpphold($dblink)) { ?>
                    <br>
                    <a href="minSideAvbestill.php">
                        <input class="litenKnapp" type="button" value="Avbestill" name="Avbestill"> 
                    </a> 
                    <a href="minSideSkrivAnmeldelse.php">
                        <input class="litenKnapp" type="button" value="Skriv Anmeldelse" name="Skriv Anmeldelse">
                    </a>
                <?php } ?>
            </form> 
        </div>
    </main>

    <!-- ************************** Felles bunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>