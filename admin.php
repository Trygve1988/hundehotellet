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
    <script src="include/scriptAdmin.js" defer> </script>
</head>
<body>

    <!-- ************************** Fellestop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** Main ******************************* -->
    <main>

        <!-- erAdmin sjekk -->
        <?php  if (!erAdmin()) { header('Location: loggInn.php'); } ?>

		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST">

            <h2 id="admininOverskrift" class="hovedOverskrift">Administrer brukere</h2>

            <!-- Brukertype -->
            <?php $brukertype = $_SESSION['adminSeBrukertype']; ?>
            <div class="soloKolonne">
                <label for="brukertype">Velg brukertype:</label>

                <select id="adminSeBrukertypeSelect" class="litenSelect" name="brukertype"><?php
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
           
            <?php visAlleBrukere($dblink) ?>
            <a href="adminNyBruker.php">
                <?php $tekst = "Ny_" . $_SESSION['adminSeBrukertype']; ?>
                <input class="inputButton mediumKnapp bunnKnapp" type="button" value= <?php echo $tekst ?> >
            </a>
            <a href="adminEndreBruker1.php">
                <?php $tekst = "Endre_" . $_SESSION['adminSeBrukertype']; ?>
                <input class="inputButton mediumKnapp bunnKnapp" type="button" value= <?php echo $tekst ?> >
            </a>
            <a href="adminSlettBruker.php">
                <?php $tekst = "Slett_" . $_SESSION['adminSeBrukertype']; ?>
                <input class="inputButton mediumKnapp bunnKnapp" type="button" value= <?php echo $tekst ?> >
            </a>
            <a href="adminGjennoprettBruker.php">
                <?php $tekst = "Gjennoprett_" . $_SESSION['adminSeBrukertype']; ?>
                <input class="inputButton mediumKnapp bunnKnapp" type="button" value= <?php echo $tekst ?> >
            </a>
        </form> 
    </main>

    <!-- ************************** Fellesbunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>