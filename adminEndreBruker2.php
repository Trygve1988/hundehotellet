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
    <link href="include/style.css" rel="stylesheet" type="text/css">
    <script src="include/script.js" defer> </script>
</head>
<body>

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main>

        <!-- 2a erAdmin sjekk -->
        <?php  if (!erAdmin()) { header('Location: loggInn.php'); } ?>

        <?php $bruker = $_SESSION['endreBruker'] ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">

            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">
                <h3>Endre Bruker</h3>  

                <div class="skjemaKolonner">
                    <div class="kolonne1">
                        <label for="epost">epost:</label>
                        <input class="inputTekst" type="text" id="epost" name="epost" value= <?php echo $bruker->getEpost() ?>>
                        <label for="tlf">tlf:</label>   
                        <input class="inputTekst" type="text" id="tlf" name="tlf" value= <?php echo $bruker->getTlf() ?> >
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

                <a href="admin.php">
                    <input class="litenKnapp" type="button" value="Tilbake">  
                <a>
                <input class="litenKnapp" type="submit" value="Lagre">  
            </div>
        </form>

         <!-- 2b oppdaterBrukerInfo -->
        <?php adminEndreBrukerInfo($dblink) ?> 

    </main>


    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>