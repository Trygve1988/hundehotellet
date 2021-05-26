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

                <!--Overskrift -->
                <h2 id="endrePassord" class="hovedOverskrift">Endre passord</h2>

				<div class="skjemaKolonner">
					
                    <div class="soloKolonne">
                        
                    <label id="gammeltPassord" for="gammeltPassord">Gammelt passord:</label>
						<input class="inputPassord" type="password" name="gammeltPassord" required 
						id="passord" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,15}$" value="" required> <!--onChange="sjekkPassord()" --> 

						<!-- Vis passord checkbox -->
						<div class="visPassord">
							<label id="visPassord" id="visPassordRegisterDeg" for="passordCheckbox">Vis passord</label>
							<input class="inputCheckbox" type="checkbox" name="passordCheckbox" onclick="visPassord()">
						</div>

                        <label id="nyttPassord" for="passord">Nytt passord:</label>
						<input class="inputPassord" type="password" name="passord" 
						id="passord2" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,15}$" onChange="sjekkPassordLike()" value="" required >

						<!-- Vis passord checkbox -->
						<div class="visPassord">
							<label id="visPassordRegisterDeg" for="passordCheckbox">Vis passord</label>
							<input class="inputCheckbox" type="checkbox" name="passordCheckbox" onclick="visPassord2()">
						</div>
						
						<!-- ************************ (Even) ************************** -->
						<!-- Må være eller så kræsjer Vis passord og Passord krav! --->
						<break>
							<p></p>
						</break>

						<!-- Passord tilbakemelding -->
						<div class="passordKrav">
							<p id="passordKrav" id="pasokravRegisterDeg">Passord krav:</p>
							<p id="nystatus" nyTTPasomelding2()></p>
							<!-- Engelsk tilbakemelding --->
							<p id="nystatus2" nyTTPasomelding()></p>
							<p id="nystatus3" nyTTPasomelding()></p>
						</div>
						
						<!-- ************************ (Gunni) ************************** -->
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