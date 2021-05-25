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
						<label for="fornavn">Fornavn:</label>
						<input  class="inputTekst" type="text" name="fornavn" value=""  required>
						
						<label for="etternavn">Etternavn:</label>
						<input class="inputTekst" type="text" name="etternavn" value="" required>	
						
						<label for="fDato">Fødselsdato:</label>
						<input class="inputDato" type="date" name="fDato" placeholder="YYYY-MM-DD" value="" required>	

						<label for="tlf">Tlf:</label>
						<input class="inputTekst" type="text" name="tlf" pattern="[0-9]{8}" value="" required>	
						
						<label for="adresse">Adresse:</label>
						<input class="inputTekst" type="text" name="adresse"  value="" required>	
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
						<label for="epost">E-post:</label>
						<input class="inputTekst" type="text" name="epost" required pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" value="" required>	
							
						<label for="passord">Ønsket passord:</label>
						<input class="inputPassord" type="password" name="passord" required 
						id="passord" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,15}$" onChange="sjekkPassord()" value="" required>

						
						<!-- Passord rad -->
						<div class="passordRad">
							<!-- Vis passord checkbox -->
							<div class="visPassord">
								<label for="passordCheckbox">Vis Passord</label>
								<input class="inputCheckbox" type="checkbox" name="passordCheckbox" onclick="visPassord()">
							</div>

							<!-- Passord tilbakemelding -->
							<div class="passordKrav">
								<p>Passord krav:</p>
								<p id="status" melding()></p>
								<!-- Engelsk tilbakemelding --->
								<p id="status2" melding2()></p>
							</div>
						</div>	
						<div class="gjentaPKolonne">
							<label for="passordSjekk">Gjenta passord:</label>
							<input class="inputPassord" type="password" name="passordSjekk" id="gjentaPassord" onChange="sjekkPassord()" value="" required>	
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