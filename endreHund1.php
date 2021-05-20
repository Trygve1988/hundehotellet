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

        <!-- 2a erLoggetInn -->
        <?php 
            if (!erLoggetInn()) {
                header('Location: loggInn.php');
            } 
        ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn"> 
			
			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST">
                <h2>Endre Hund</h2>
				<div class="skjemaKolonner">
					<div class="kolonne1">
                        <select id="hund" class="inputSelect" value="hund" name="hund">
                            <?php $hunder = laghunderTab($dblink);
                            for ($i=0; $i<count($hunder); $i++) {
                                lagOption($hunder[$i]);
                            } ?>
                        </select>

                        <a href="minSide.php">
                            <input class="litenKnapp" type="button" value="Tilbake">  
                        <a>
                        <input class="litenKnapp" type="submit" value="Velg" name="velgHund">

                    </div>
                </div> 
            </form> 
        </div> 
                        
        
        <!-- 2g bestillOpphold -->
        <?php velgHundSomSkalEndres($dblink); ?> 

    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>