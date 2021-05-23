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

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** 2) main **************************-->
    <main>

        <!-- 2a erAdmin sjekk -->
        <?php  if (!erAdmin()) { header('Location: loggInn.php'); } ?>

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">
                <h3>Ny Bruker</h3> 

                <div class="skjemaKolonner">
                    <div class="kolonne1">
                        <label for="epost">epost:</label>
                        <input class="inputTekst" type="text" id="epost" name="epost" value="eks@gmail.com" required>
                        <label for="passord">passord:</label>
                        <input class="inputTekst" type="text" id="passord" name="passord" pattern="(?=.*\d)(?=.*[A-Za-z]).{8,}" value="passord123" required >
                        <p id="passordStatus" class="inndataStatus" ></p>
                        <label for="tlf">tlf:</label>   
                        <input class="inputTekst" type="text" id="tlf" name="tlf" value="11166222" required>

                        <!-- brukertype -->
                        <?php $brukertype = $_SESSION['adminSeBrukertype']; ?>
                        <select name="brukertype" class="inputSelect" ><?php
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
                    </div>
                    <div class="kolonne2">
                        <label for="fornavn">fornavn:</label>   
                        <input class="inputTekst" type="text" id="fornavn" name="fornavn" value="ola" required >
                        <label for="etternavn">etternavn:</label>  
                        <input class="inputTekst" type="text" id="etternavn" name="etternavn" value="nordman" required>
                        <label for="adresse">adresse:</label>     
                        <input class="inputTekst" type="text" id="adresse" name="adresse" value="epleveien5" required>     
                    </div> 
                </div>
            
                <a href="admin.php">
                    <input class="litenKnapp" type="button" value="Tilbake">  
                <a>
                <input class="litenKnapp" type="submit" value="Lagre" name="registrerNyBrukerKnapp">  

                <?php registrerNyBruker($dblink); ?> 
            </div> 
        </form>
    </main>










    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>