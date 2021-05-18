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
	<script src="include/script.js" defer> </script>
    <!-- **** ikke lagd selv,gratis å bruke: https://cdnjs.com/libraries/jquery/3.3.1  **** -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <!-- ************************** ikke lagd selv slutt ************************** -->

</head>

<body>

	<!-- ************************** fellesTop ************************** -->
	<?php visNav(); ?>

	<!-- ************************** main ******************************* -->
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
				<h2 class="hovedOverskrift">Bestill opphold</h2>	

				<h2 class="overskrift2">Tidsperiode</h2>
				
				<div class="soloKolonne">
					<div class="kolonne1">	
						<!-- fra dato class="inputDato" -->
                        <label for="startDato">Fra</label>
                        <input  type="date" id="startDato" name="startDato" value="<?php echo date("Y-m-d");?>" readonly >
						<!-- til dato -->  
						<label for="sluttDato">Til:</label>
						<input type="date" id="sluttDato" name="sluttDato" value="<?php echo datoIMorgen(); ?>" readonly >
					</div>	
				</div>

			<!-- Knapperad -->
			<div class="knappeRad">
				<div class="knapp1IRad">
					<!-- Tilbake-knapp-->
					<a href = "bestillOpphold.php">
		           		<input class="inputButton hovedKnapp" type="button" value="Tilbake"> 
		       		</a>
				</div>
				<div class="etterKolonnerKnapp">

					<!-- Neste-knapp -->
					<a href = "bestillOpphold3.php">
		            	<input class="inputButton hovedKnapp" type="submit" value="bekreftDatoer" name="bekreftDatoer">
		            </a>

				</div>
			</div>	
			
			<!-- 2g bestillOpphold -->
			<?php bekreftDatoer($dblink); ?> 

			</form>
		</div>	
	</main>

	<!-- ************************** fellesBunn ************************** -->
	<?php visFooter(); ?>
	<?php visToppKnapp(); ?>

</body>
</html>