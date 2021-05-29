<?php
include_once "include/funksjoner.php";
include_once "include/funksjonerRegistrerDeg.php";
include_once "include/funksjonerLoggInn.php";
session_start();
$dblink = kobleOpp();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bø Hundehotell</title>
	<link href="include/style.css" rel="stylesheet" type="text/css">
	<!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
	<script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
	<script src="include/script.js" defer> </script>
	<script src="include/scriptSpraak.js" defer> </script>
</head>

<body>

	<!-- ************************** Felles topp ************************** -->
	<?php visNav(); ?>

	<!-- **************************   Main    ************************** -->
	<main>
		<!-- ************************ (Gunni) ************************** -->
		<!-- Hvit bakgrunn -->	
		<div class="hvitBakgrunn">		
			
			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST"> 
				
				<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

				<!-- Overskrift -->
				<h2 id="registerNyBruker" class="hovedOverskrift">Registrer ny bruker</h2>

				<!-- registrerDeg (Trygve) -->
				<?php registrerDeg($dblink); ?> 

				<div class="skjemaKolonner">
					
					<!-- Labels og input i kolonne 1 -->
					<div class="kolonne1">
						<label id="forNavnRegisterDeg" for="fornavn">Fornavn:</label>
						<input  class="inputTekst" type="text" name="fornavn" placeholder="Ida" minlength="2" maxlength="50" required  value="peter">

						<label id="fødselsdatoRegistrerDeg" for="fDato">Fødselsdato:</label>
						<input class="inputDato" type="date" name="fDato" placeholder="YYYY-MM-DD" required value="2000-01-01">	
						
						<label id="tlfRegisterDeg" for="tlf">Telefonnummer:</label>
						<input class="inputTekst" type="text" name="tlf" placeholder="+4712345678" required pattern="[+0-9]{10,14}" value="+4712345678">	
						
						<label for="postnummer">Postnummer:</label>
						<input class="inputTekst" type="text" name="postnummer" placeholder="4300" pattern="[0-9]{4}" required value="4265">

						<label for="poststed">Poststed:</label>
						<input class="inputTekst" type="text" name="poststed" required value="Håvik">

						<label id="adresseRegistrerDeg" for="adresse">Adresse:</label>
						<input class="inputTekst" type="text" name="adresse" placeholder="Epleveien 5" required value="Epleveien 5">
					</div>

					<!-- Labels og input i kolonne 2 -->
					<div>	

						<label id="etterNavnRegisterDeg" for="etternavn">Etternavn:</label>
						<input class="inputTekst" type="text" name="etternavn" placeholder="Idasen" minlength="2" maxlength="50" required value="griffin">		

						<label id="epostReigsterDeg" for="epost">E-post:</label>
						<input class="inputMail" type="email" name="epost" placeholder="test@test.com" required value="test@ha.no">	 

						<label id="tlfRegisterDeg" for="tlf">Telefonnummer:</label>
						<input class="inputTekst" type="text" name="tlf" placeholder="+4712345678" required pattern="[+0-9]{10,14}" value="+4712345678">	
						
						<label id="passordRegisterDeg" for="passord">Ønsket passord:</label>
						<input class="inputPassord" type="password" name="passord" required 
						id="passord" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$" onChange="sjekkPassordLike()" value="123Ab%12">

						<!-- Vis passord checkbox -->
						<div class="visPassord">
							<label id="visPassordRegisterDeg" for="passordCheckbox">Vis Passord</label>
							<input class="inputCheckbox" type="checkbox" name="passordCheckbox" onclick="visPassord()">
						</div>
						
						<!-- ************************ (Even) ************************** -->
						<!-- Må være eller så kræsjer Vis passord og Passord krav! --->
						<break>
							<p></p>
						</break>

						<!-- Passord tilbakemelding -->
						<div class="passordKrav">
							<p id="pasokravRegisterDeg">Passord krav:</p>
							<p id="status" melding()></p>
							<!-- Engelsk tilbakemelding --->
							<p id="status2" melding2()></p>
							<p id="status3" melding2()></p>
						</div>
						
						<!-- ************************ (Gunni) ************************** -->						
					</div>
				</div>

				<!-- Knapper -->
				<div class="etterKolonnerKnapp">
					<!--Registrer knapp-->
						<a href="index.php">
							<input class="hovedKnapp2 inputSubmit" type="submit" name="registrerBruker" id="submit" value="Registrer ny bruker">
						</a>

					<!-- Logg inn link -->
					<p class="ekstraLink"> <a id="harDuKontoRegisterDeg" class="link" href="loggInn.php">Har du allerede en bruker? Logg inn her</a></p>
				</div>

			</form>	
		</div>		
	</main>

	<!-- ************************** fellesBunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>