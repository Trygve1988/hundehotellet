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
                
                <!-- Avbryt knapp -->
                <a href = "admin.php">
                    <input class="avbrytKnapp" type="button" value="X">
                </a>
            
                <!-- Overskrift -->
                <h2 class="hovedOverskrift">Endre bruker</h2>

                <div class="skjemaKolonner">
                    <div class="kolonne1">
                        <label for="fornavn">Fornavn:</label>   
                        <input  class="inputTekst" type="text" name="fornavn" placeholder="Ida" minlength="2" maxlength="50" required value= <?php echo $bruker->getFornavn() ?> >

                        <label for="tlf">Tlf:</label>   
                        <input class="inputTekst" type="text" name="tlf" placeholder="+4712345678" required pattern="[+0-9]{10,14}" value= <?php echo $bruker->getTlf() ?> >
                        
                        <label for="adresse">Adresse:</label>     
                        <input class="inputTekst" type="text" name="adresse" placeholder="Epleveien 5" required value= <?php echo $bruker->getAdresse() ?> > 

                    </div>
                    <div>
                        <label for="etternavn">Etternavn:</label>  
                        <input class="inputTekst" type="text" name="etternavn" placeholder="Idasen" minlength="2" maxlength="50" required value= <?php echo $bruker->getEtternavn() ?> >

                        <label for="epost">Epost:</label>
                        <input class="inputMail" type="email" name="epost" placeholder="test@test.com"
                        value= <?php echo $bruker->getEpost() ?>>
                    </div>
                </div> 

                <!-- oppdaterBrukerInfo -->
                <?php adminEndreBrukerInfo($dblink) ?> 

                <!-- Knapperad -->
                <div class="knappeRad bunnKnapp">
                    <div class="knapp1IRad">
                        <!-- Avbryt knapp -->
                        <a href="adminEndreBruker1.php">
                            <input class="inputButton hovedKnapp" type="button" value="Tilbake">  
                        <a>
                    </div>
                    <div class="etterKolonnerKnapp">
                        <!-- Velg bruker knapp -->
                        <input class="inputSubmit hovedKnapp" type="submit" value="Lagre">  
                    </div>
                </div>         
            </div>
        </form>

    </main>

    <!-- ************************** Felles bunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>