<?php
include_once "include/funksjoner.php";
include_once "include/funksjonerBestillOpphold.php";
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
	<script src="include/script.js" defer> </script>
	<script src="include/scriptSpraak.js" defer> </script>
	<script src="include/scriptBestillOpphold3.js" defer> </script>
    <!-- **** ikke lagd selv,gratis å bruke: https://cdnjs.com/libraries/jquery/3.3.1  **** -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <!-- ************************** ikke lagd selv slutt ************************** -->

</head>

<body>

	<!-- ************************** Felles topp ************************** -->
	<?php visNav(); ?>

	<!-- ************************** Main ******************************* -->
	<main>
		<!-- erLoggetInn sjekk -->
		<?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>
		
		<!-- ************************ (Gunni) ****************************** -->
		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
			
			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST">
			
				<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>
				
				<!-- Overskrift -->
				<h2 id="bestillOpphold3" class="hovedOverskrift">Bestill opphold</h2>	
				<h2 id="tidsperiode" class="overskrift2">Tidsperiode</h2>

				<div class="skjemaKolonner">
					<div class="kolonne1">	
						<!-- fra dato class="inputDato" -->
                        <label id="fra" for="startDato">Fra</label>
                        <input type="date" id="startDato" class="inputDato" name="startDato" value="<?php echo førsteLedigeDato($dblink); ?>" readonly >
					</div>	
					<div class="kolonne2">	
						<!-- til dato -->  
						<label id="til" for="sluttDato">Til:</label>
						<input type="date" id="sluttDato" class="inputDato" name="sluttDato" value="<?php echo andreLedigeDato($dblink); ?>" readonly >
					</div>	
				</div>

				<!-- Bestill opphold -->
				<?php bekreftDatoer($dblink); ?> 
		
				<!-- Knapperad -->
				<div class="knappeRad heltIBunnKnapp">
					<div class="knapp1IRad">
						<!-- Tilbake-knapp-->
						<a href = "bestillOpphold.php">
							<input class="inputButton hovedKnapp" type="button" value="Tilbake"> 
						</a>
					</div>
					<div class="etterKolonnerKnapp">
						<!-- Neste-knapp -->
						<a href = "bestillOpphold3.php">
							<input class="inputSubmit hovedKnapp" type="submit" value="Bekreft datoer" name="bekreftDatoer">
						</a>
					</div>
				</div>	
			</form>
		</div>	
	</main>

	<!-- ************************** fellesBunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>