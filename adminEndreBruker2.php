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

        <?php $bruker = $_SESSION['endreBruker'] ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">

            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">
            
                <!-- Overskrift -->
                <h2 class="hovedOverskrift">Endre bruker</h2>

                <div class="skjemaKolonner">
                    <div class="kolonne1">
                        <label for="fornavn">Fornavn:</label>   
                        <input class="inputTekst" type="text" id="fornavn" name="fornavn" value= <?php echo $bruker->getFornavn() ?> >

                        <label for="tlf">Tlf:</label>   
                        <input class="inputTekst" type="text" id="tlf" name="tlf" pattern="[0-9]{8}" value= <?php echo $bruker->getTlf() ?> >
                        
                        <label for="adresse">Adresse:</label>     
                        <input class="inputTekst" type="text" id="adresse" name="adresse" value= <?php echo $bruker->getAdresse() ?> > 

                    </div>
                    <div>
                        <label for="etternavn">Etternavn:</label>  
                        <input class="inputTekst" type="text" id="etternavn" name="etternavn" value= <?php echo $bruker->getEtternavn() ?> >

                        <label for="epost">Epost:</label>
                        <input class="inputTekst" type="text" id="epost" name="epost" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" 
                        value= <?php echo $bruker->getEpost() ?>>

                    </div>
                </div> 
                <!-- Knapperad -->
                <div class="knappeRad heltIBunnKnapp">
                    <div class="knapp1IRad">
                        <!-- Avbryt knapp -->
                        <a href="admin.php">
                            <input class="inputButton hovedKnapp" type="button" value="Avbryt">  
                        <a>
                    </div>
                    <div class="etterKolonnerKnapp">
                        <!-- Velg bruker knapp -->
                        <input class="inputSubmit hovedKnapp" type="submit" value="Lagre">  
                    </div>
                </div>         
            </div>
        </form>

         <!-- oppdaterBrukerInfo -->
        <?php adminEndreBrukerInfo($dblink) ?> 
    </main>

    <!-- ************************** Felles bunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>