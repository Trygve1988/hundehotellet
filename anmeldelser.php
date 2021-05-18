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

    <!-- ************************** fellesTop **************************** -->
    <?php visNav(); ?>

    <!-- ************************** main ********************************** -->
    <main>
    	<!-- ************************ (Gunni) ****************************** -->
        <!-- Anmeldelser -->
        <div class="hvitBakgrunn">
        <form class="skjemaBakgrunn">
                <h2>Anmeldelser</h2>
                <p>under arbeid....</p> 
            </div>
        </form> 
    </main>

    <!-- ************************** fellesBunn ************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 

</body>
</html>