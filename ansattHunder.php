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

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>
    <?php visNav3() ?>

    <!-- ************************** 2) main **************************-->
    <main> 

        <!-- 2a erAnsatt sjekk-->
        <?php if (!erAnsatt()) { header('Location: loggInn.php'); } ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">
                <h2>Hunder</h2> 

                <!-- velg Hund-->
                <label for="velgHundSelect">Velg Hund:</label>
                <select id="velgInspiserHundSelect" class="litenSelect" name="velgHundSelect" width="100px">
                    <?php $hunder = lagHunderPaaOppholdNaaTab($dblink);
                    $inspiserHund = $_SESSION['inspiserHund']; 
                    for ($i=0; $i<count($hunder); $i++) {
                        lagInspiserHundOption($hunder[$i],$inspiserHund);
                    } ?>
                </select>

                <?php if ( isset($_SESSION['inspiserHund']) ) {  ?>

                    <div class="skjemaKolonner">
                        <div class="kolonne1">
                            <?php visInspiserHundInfo($dblink); ?>
                        </div> 
                        <div class="kolonne2"> 
                            <?php visInspiserHundOppholdInfo($dblink); ?>
                        </div> 
                    </div> 

                    <!-- aktivitet/komentar-->
                    <?php visAlleRegistrerteMatingerDetteOppholdet($dblink); ?>
                    <?php visAlleRegistrerteLuftingerDetteOppholdet($dblink); ?>
                    <?php visAlleRegistrerteKommentarerDetteOppholdet($dblink); ?>  

                <?php } ?>

            </form>

        </div>
        
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>