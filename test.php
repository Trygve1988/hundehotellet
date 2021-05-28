<?php
    include_once "include/funksjoner.php";
    include_once "include/funksjonerLagTestData.php";
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

        <!-- Hvit bakgrunn -->
		<div class="hvitBakgrunn">
	
            <!-- Skjema -->	
            <form class="skjemaBakgrunn" method="POST">
                <p>Test ass</p>
                <?php test($dblink) ?> 
            </form> 

        </div>

    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>