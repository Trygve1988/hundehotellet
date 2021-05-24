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
                <!-- Avbryt knapp -->
			    <a href = "index.php">
				    <input class="avbrytKnapp" type="button" value="X">
			    </a>    
                
                <h2>Endre Passord</h2>
				<div class="skjemaKolonner">
					<div class="kolonne1">
                        <label for="gammeltPassord">Gammelt Passord:</label>
                        <input class="inputTekst" type="text" id="gammeltPassord" pattern="[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15})" name="gammeltPassord" >
                        <label for="nyttPassord">Nytt Passord:</label>   
                        <input class="inputTekst" type="text" id="nyttPassord" name="nyttPassord" pattern="[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15})" required >  
                        <label for="bekreftNyttPassord">Bekreft Nytt Passord:</label>  
                        <input class="inputTekst" type="text" id="bekreftNyttPassord" name="bekreftNyttPassord" pattern="[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15})" required >
                    </div>
                </div> 

                <a href="minSide.php">
                    <input class="litenKnapp" type="button" value="Tilbake">  
                 <a>
                 <input class="litenKnapp" type="submit" value="Lagre"  name="lagre">

            </form>
        </div> 
         <!-- 2b oppdaterBrukerInfo -->
        <?php endrePassord($dblink) ?> 

    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>