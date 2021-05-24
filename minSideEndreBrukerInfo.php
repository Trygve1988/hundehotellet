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

        <?php $bruker = $_SESSION['bruker'] ?>
       
        <!-- 2a oppdater brukerInfo Skjema -->
		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn"> 
			
			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST">

                	<!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>	

                <h2>Endre BrukerInfo</h2>  
				<div class="skjemaKolonner">
					<div class="kolonne1">
                        <label for="epost">epost:</label>
                        <input class="inputTekst" type="text" id="epost" name="epost" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" value= <?php echo $bruker->getEpost() ?>>
                        <label for="tlf">tlf:</label>   
                        <input class="inputTekst" type="text" id="tlf" name="tlf" pattern="[0-9]{8}" value= <?php echo $bruker->getTlf() ?> >
                        <label for="adresse">adresse:</label>     
                        <input class="inputTekst" type="text" id="adresse" name="adresse" value= <?php echo $bruker->getAdresse() ?> > 

                    </div>
                    <div class="kolonne2">
                        <label for="fornavn">fornavn:</label>   
                        <input class="inputTekst" type="text" id="fornavn" name="fornavn" value= <?php echo $bruker->getFornavn() ?> >
                        <label for="etternavn">etternavn:</label>  
                        <input class="inputTekst" type="text" id="etternavn" name="etternavn" value= <?php echo $bruker->getEtternavn() ?> >
                    </div>
                </div> 

                <a href="minSide.php">
                    <input class="litenKnapp" type="button" value="Tilbake">  
                 <a>
                 <input class="litenKnapp" type="submit" value="Lagre"  name="lagre">

            </form>
        </div> 
         <!-- 2b oppdaterBrukerInfo -->
        <?php endreBrukerInfo($dblink) ?> 

    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>