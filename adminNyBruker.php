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

    <!-- ************************** Felles topp ************************** -->
    <?php visNav(); ?>

    <!-- ************************** Main ********************************* -->
    <main>

        <!-- erAdmin sjekk -->
        <?php  if (!erAdmin()) { header('Location: loggInn.php'); } ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">
            
            <!-- Avbryt knapp -->
			<a href = "admin.php">
				<input class="avbrytKnapp" type="button" value="X">
			</a>

            <!-- Overskrift -->
                <h2 class="hovedOverskrift">Ny bruker</h3> 
                
                <div class="skjemaKolonner">
                    <!-- Labels og input i kolonne 1 -->
					<div class="kolonne1">
                        <label id="forNavnRegisterDeg" for="fornavn">Fornavn:</label>
						<input  class="inputTekst" type="text" name="fornavn" placeholder="Ida" minlength="2" maxlength="50" required>
						
                        <label id="etterNavnRegisterDeg" for="etternavn">Etternavn:</label>
						<input class="inputTekst" type="text" name="etternavn" placeholder="Idasen" minlength="2" maxlength="50" required>		
						
                        <label id="fødselsdatoRegistrerDeg" for="fDato">Fødselsdato:</label>
						<input class="inputDato" type="date" name="fDato" placeholder="YYYY-MM-DD" required>	

                        <label id="tlfRegisterDeg" for="tlf">Telefonnummer:</label>
						<input class="inputTekst" type="text" name="tlf" placeholder="+4712345678" required pattern="[+0-9]{10,14}">	
						
						<label id="adresseRegistrerDeg" for="adresse">Adresse:</label>
						<input class="inputTekst" type="text" name="adresse" placeholder="Epleveien 5" required >
					</div>

					<!-- Labels og input i kolonne 2 -->
					<div>	
                        <!-- Brukertype -->
                        <?php $brukertype = $_SESSION['adminSeBrukertype']; ?>
                        <label for="brukertype">Brukertype:</label>
                        <select name="brukertype" class="inputSelect"><?php
                            // kunde
                            if ($brukertype == "kunde") { 
                                ?><option value="kunde" selected>Kunde</option><?php
                            } 
                            else { 
                                ?><option value="kunde">Kunde</option><?php
                            }

                            // ansatt
                            if ($brukertype == "ansatt") { 
                                ?><option value="ansatt" selected>Ansatt</option><?php
                            } 
                            else { 
                                ?><option value="ansatt">Ansatt</option><?php
                            } 

                            // admin
                            if ($brukertype == "admin") { 
                                ?><option value="admin" selected>Admin</option><?php
                            } 
                            else { 
                                ?><option value="admin">Admin</option><?php
                            } ?>
                        </select>
                           
                        <!-- Epost -->
						<label id="epostReigsterDeg" for="epost">E-post:</label>
						<input class="inputMail" type="email" name="epost" placeholder="test@test.com" required>	 
						
						<label id="passordRegisterDeg" for="passord">Ønsket passord:</label>
						<input class="inputPassord" type="password" name="passord" required 
						id="passord" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$">

						    <!-- Vis passord checkbox -->
						    <div class="visPassord">
						    	<label id="visPassordRegisterDeg" for="passordCheckbox">Vis Passord</label>
						    	<input class="inputCheckbox" type="checkbox" name="passordCheckbox" onclick="visPassord()">
						    </div>
					
						    	<!-- Passord tilbakemelding -->
						    <div class="passordKrav">
						    	<p id="pasokravRegisterDeg">Passord krav:</p>
						    	<p id="status" melding()></p>
						    	<!-- Engelsk tilbakemelding --->
						    	<p id="status2" melding2()></p>
						    	<p id="status3" melding2()></p>
						    </div>		
					</div>
				</div>    
                
                <!--Knapperad-->
				<div class="knappeRad">
					<div class="knapp1IRad">
						<!-- Tilbake knapp-->
						<a href="admin.php">
                            <input class="inputButton hovedKnapp" type="button" value="Tilbake">  
                        <a>
					</div>
					<div class="etterKolonnerKnapp">

						<!-- Opprett ny bruker -->
						<input class="inputSubmit hovedKnapp2" type="submit" value="Opprett ny bruker" name="registrerNyBrukerKnapp"> 	
					</div>
				</div>

                <?php registrerNyBruker($dblink); ?> 
            </div> 
        </form>
    </main>

    <!-- ************************** Felles bunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>