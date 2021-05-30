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
    <script src="include/scriptMinSide.js" defer> </script>
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
                <h2 id="minSide" class="hovedOverskrift">Min side</h2>

                <!-- Min profil -->
                <h2 id="minProfil" class="overskrift2">Min profil</h2>
                <?php minProfilTab($dblink); ?>

                <div class="knapperad">
                    <a href="minSideEndreBrukerInfo.php">
                        <input class="inputButton  mediumKnapp" type="button" value="Endre brukerinfo" name="Endre Bruker">
                    </a>
                    <a href="minSideEndrePassord.php"> 
                        <input class="inputButton  mediumKnapp" type="button" value="Endre passord" name="Endre Passord">
                    </a>
                    <a href="minSideSlettBruker.php"> 
                        <input class="inputButton  mediumKnapp" type="button" value="Slett bruker">
                    </a>
                </div><br>

                <!-- ******************** Mine hunder (Trygve) ******************** -->
                <h2 id="minHunder" class="overskrift2">Mine Hunder</h2>

                <!-- setter minSideHund viss brukeren har hund og minSidehund er tom -->
                <?php if (harHund($dblink)) { 
                    if (isset($_SESSION['minSideHund'])) { 
                        $hunder = lagHunderTab($dblink);
                        $_SESSION['minSideHund'] = $hunder[0];
                    }
                } ?> 
                
                <!-- lager valgboks viss brukeren har hunder -->
                <?php if (harHund($dblink)) { ?>
                    <div>
                        <label id="velgHundMinSide" for="velgHundSelect">Velg hund:</label>
                        <select id="velgMinSideHundSelect" class="litenSelect" name="velgHundSelect">
                            <option>Velg</option>
                            <?php $hunder = lagHunderTab($dblink);
                            for ($i=0; $i<count($hunder); $i++) {
                                lagMinSideOption($hunder[$i],$minSideHund); 
                            } ?>
                        </select>
                    </div>
                    <?php 
                    if ( isset($_SESSION['minSideHund']) ) {  
                        minHundTab($dblink); 
                    } 
                } ?>

                <!-- Registrer hund knapp -->    
                <a href="registrerHundMS.php">
                    <input class="inputButton mediumKnapp" type="button" value="Registrer hund">
                </a>

                <!-- Lager "Endre hund" knapp og "Slett hund" knapp viss brukeren har hunder -->
                <?php if (harHund($dblink)) { ?>
                    <!-- Endre hund knapp -->  
                    <a href="minSideEndreHund1.php">
                        <input class="inputButton mediumKnapp" type="button" value="Endre hund">  
                    </a>
                    <!-- Slett hund knapp -->  
                    <a href="minSideSlettHund.php">
                        <input class="inputButton mediumKnapp" type="button" value="Slett hund">  
                    </a> <?php            
                } ?>

                <!-- Bestillinger -->
                <h2 id="mineOpphold" class="overskrift2">Mine opphold</h2> 
                <?php visMineOpphold($dblink); ?> 
                
                <?php if (harOpphold($dblink)) { ?>              
                    <!--Knapperad-->
                    <div class="knappeRad">
                        <!-- Avbestill knapp -->
                        <a href="minSideAvbestill.php">
                            <input class="inputButton mediumKnapp" type="button" value="Avbestill opphold" name="Avbestill"> 
                        </a> 
                      
                        <!-- Skriv anmneldese knapp-->
                        <a class="" href="minSideSkrivAnmeldelse.php">
                            <input class="inputButton mediumKnapp" type="button" value="Skriv anmeldelse" name="Skriv Anmeldelse">
                        </a>	                  
                    </div>
                    
                <?php } ?>
            </form> 
        </div>
    </main>

    <!-- ************************** Felles bunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>