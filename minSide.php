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
        <!-- ************************** Gunni **************************** -->
        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">
      
                <!-- Overskrift -->
                <h2 class="hovedOverskrift">Min side</h2>
            
                <!-- "Min profil" -->
                <h2 class="overskrift2">Min profil</h2>
                
                <!-- Min profil funksjonskall -->
                <?php minProfilTab($dblink); ?>

                <!--Knapperad-->
				<!-- "Rediger / oppdater kunde-info-knapp -->
				<a href = "oppdaterKundeInfo.php">
                	<input class="hovedKnapp inputButton" type="button" value="Rediger"> 
            	</a>
		    
                <!-- "Mine hunder" -->
                <h2 class="overskrift2">Mine hunder</h2>
                
                <div class="litenInput">

                    <!-- Nedtrekksliste for valg av hund -->
                    <label for="velgHund">Velg hund:</label>
                        <select class="inputSelect" id="hund" name="velgHund">
                            <?php $hunder = laghunderTab($dblink);
                                for ($i=0; $i<count($hunder); $i++) {
                                    lagOption($hunder[$i]);
                                } ?>
                        </select>
                </div>  
              
              <!-- Mine hunder funksjonskall -->
                <?php mineHunderTab($dblink); ?>
              
                <!--Knapperad-->
				<div class="knapperad">
                    <!-- Registrer ny hund-\knapp-->
                    <a href = "registrerHundMS.php">
                        <input class="inputButton hovedKnapp ekstraKnapp2" type="button" value="Registrer ny hund">
                    </a>
                      <!-- Endre hundeinfo- knapp -->
                    <a href = "oppdaterHundInfo.php">
                        <input class="inputButton hovedKnapp" type="button" value="Rediger"> 
                    </a>

                <!-- "Mine opphold" -->
                <h2 class="overskrift2">Mine opphold</h2>

                <!-- Mine opphold funksjonskall -->
                <?php mineOppholdTab($dblink); ?>                    
                
                <!--Knapperad-->
				<!-- Bestill opphold -->
				<a href="bestillOpphold.php">
                    <input class=" inputButton hovedKnapp" type="button" value="Bestill opphold"> 
                </a>
                <!-- Se eldre, viser alle registrerte opphold -->
                <a href = "alleOppholdforKunde.php">
                    <input class=" inputButton hovedKnapp" type="button" value="Se eldre"> 
            	</a>
            </form> 
        <div>
        <!-- Valg av hund som skal velges -->
        <?php velgHundSomSkalEndres($dblink); ?>  
    </main>
    <footer></footer>
</body>
</html>