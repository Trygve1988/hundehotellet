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
        <!-- ************************ (Gunni) (Trygve) ******************* -->
        <!-- erLoggetInn sjekk -->
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
			    <a href = "minSide.php">
				    <input class="avbrytKnapp" type="button" value="X">
			    </a>    
                
                <h2 class="hovedOverskrift">Endre passord</h2>

				<div class="skjemaKolonner">
					<div class="soloKolonne">
                        <label for="gammeltPassord">Gammelt passord:</label>
                        <input class="inputTekst gjentaPKolonne" type="text" id="gammeltPassord" pattern="[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15})" name="gammeltPassord" >
                        <!-- Vis passord checkbox -->
							<div class="visPassord">
								<label for="passordCheckbox">Vis Passord</label>
								<input class="inputCheckbox" type="checkbox" name="passordCheckbox" onclick="visPassord()">
							</div>

                        <label for="nyttPassord">Nytt passord:</label>   
                        <input class="inputTekst" type="text" id="nyttPassord" name="nyttPassord" pattern="[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15})" required >  
                       
                       <!-- Vis passord checkbox -->
						<div class="visPassord">
							<label for="passordCheckbox">Vis Passord</label>
							<input class="inputCheckbox" type="checkbox" name="passordCheckbox" onclick="visPassord()">
						</div>
						
						<!-- ************************ (Even) ************************** -->
						<!-- Må være eller så kræsjer Vis passord og Passord krav! --->
						<break>
							<p></p>
						</break>

						<!-- Passord tilbakemelding -->
						<div class="passordKrav">
							<p>Passord krav:</p>
							<p id="status" melding()></p>
							<!-- Engelsk tilbakemelding --->
							<p id="status2" melding2()></p>
						</div>

                        <div class="gjentaPKolonne">
                            <label for="bekreftNyttPassord">Bekreft nytt passord:</label>  
                            <input class="inputTekst" type="text" id="bekreftNyttPassord" name="bekreftNyttPassord" pattern="[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15})" required >
                        </div>
                    <!-- oppdaterBrukerInfo -->
                    <?php endrePassord($dblink) ?> 
                    </div>
                </div> 

                <!-- Knapperad -->
				<div class="knappeRad">
					<div class="knapp1IRad">
						<!-- Tilbakeknapp -->
						<a href="minSide.php">
                            <input class="inputButton mediumKnapp" type="button" value="Tilbake">  
                        <a>
					</div>
					<div class="etterKolonnerKnapp">
						<!-- Lagre knapp -->
						 <input class="inputSubmit mediumKnapp" type="submit" value="Lagre"  name="lagre">
					</div>
				</div>
            </form>
        </div> 
    </main>

    <!-- ************************** Felles bunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>