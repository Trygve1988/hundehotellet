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

		<!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
			<!-- Skjema -->	
			<form class="skjemaBakgrunn" method="POST">

            <h2 id="admininOverskrift">Administrer Brukere</h2>

            <!-- brukertype -->
            <?php $brukertype = $_SESSION['adminSeBrukertype']; ?>
            Velg Brukertype <select id="adminSeBrukertypeSelect" class="inputSelect"><?php
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

            <?php visAlleBrukere($dblink) ?>
            <a href="adminNyBruker.php">
                <?php $tekst = "Ny_" . $_SESSION['adminSeBrukertype']; ?>
                <input class="litenKnapp" type="button" value= <?php echo $tekst ?> >
            </a>
            <a href="adminEndreBruker1.php">
                <?php $tekst = "Endre_" . $_SESSION['adminSeBrukertype']; ?>
                <input class="litenKnapp" type="button" value= <?php echo $tekst ?> >
            </a>
            <a href="adminSlettBruker.php">
                <?php $tekst = "Slett_" . $_SESSION['adminSeBrukertype']; ?>
                <input class="litenKnapp" type="button" value= <?php echo $tekst ?> >
            </a>
            <a href="adminGjennoprettBruker.php">
                <?php $tekst = "Gjennoprett_" . $_SESSION['adminSeBrukertype']; ?>
                <input class="litenKnapp" type="button" value= <?php echo $tekst ?> >
            </a>
        </form> 

    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>