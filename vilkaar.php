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
		<!-- Disse vilkårene er inspirert fra: https://www.drobakhundehotell.no/vilkar/ -->
		<!-- Hvit bakgrunn -->	
		<div class="hvitBakgrunn">		
			
			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST"> 
				
				<!-- Avbryt knapp -->
				<a href = "bestillOppphold.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>

				<!-- Overskrift -->
				<h2 class="hovedOverskrift">Vilkår</h2>
				<div class="fullKolonne">
					<h3>Forbehold</h3>
					<p>Vi tar forbehold om eventuelle trykkfeil når det gjelder pris og informasjon om varer/tjenestene på siden.</p>
					<p>Ta kontakt med oss hvis du har spørsmål. Vi ønsker å gi deg en god opplevelse, for både hunden din og deg!</p>

					<h3>Avbestillinger</h3>
					<p>Bestilte opphold som avbestilles mindre enn 2 uker før oppholdets start avkreves fullt innbetalt beløp.</p>
					For avbestilling av alle  bestilte opphold innenfor rammene av våre vilkår,
					vil vi avkreve et gebyr på minimum kr 300,-+ 5% av det innbetalte totalbeløp.</p>

					<h3>Personopplysninger</h3>
					<p>Bø Hundehotell behandler persondata ifølge Lov om Personopplysninger.</p> 
					<p>Opplysninger som kan knyttes til deg som person vil aldri bli gjort tilgjengelig for andre virksomheter eller bli koblet med andre eksterne register.</p>

					<h3>Ditt ansvar</h3>
					<p>Du står selv ansvarlig for at opplysningene du oppgir er korrekte. Ved misbruk av informasjon, brudd på regler,</p>
					<p>vil du måtte stå til ansvar for dette, og vil da risikere å bli politianmeldt.</p>

					
					<h4>For flere tips og råd, se:</h4>
					<ul>
						<li>www.forbrukerombudet.no</li>
						<li>www.forbrukerportalen.no</li>
						<li>www.lovdata.no</li>
					</ul>				
				</div>

                <!-- Tilbake til bestilling -->
                    <div class="etterKolonnerKnapp">
                            <a href="bestillOpphold4.php">
                                <input class="inputButton hovedKnapp2" type="button" value="Tilbake til bekreftelse">
                            </a>
                    </div>
            		
			</form>	
		</div>	
	</main>

	<!-- ************************** Felles bunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>