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
    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
    <script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
    <script src="include/script.js" defer> </script>
</head>

<body>

    <!--***********************  Admin ********************************* -->

    <!-- ************************** fellesTop ************************** -->
    <?php visNav(); ?>
    <?php visNav3() ?>

    <!-- ************************** main ******************************* -->
    <main>

        <!-- erAnsatt sjekk -->
        <?php if (!erAnsatt()) {
            header('Location: loggInn.php');
        } ?>

        <!-- alle opphold  -->
        <div class="hvitBakgrunn">
            <form class="skjemaBakgrunn">

                <h2 class="hovedOverskrift">Ferdige opphold</h2>
                <table class="opphold FerdigOpphold">
                    <thead>
                        <tr>
                            <th>Bestilling ID</th>
                            <th>Start</th>
                            <th>Slutt</th>
                            <th>Bestilt</th>
                            <th>Total pris</th>
                            <th>Bur ID</th>
                            <th>Hunder</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>

                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Tabell 2 -->

                <h2 class="hovedOverskrift">Aktive opphold</h2>
                <table class="opphold aktiv">
                    <thead>
                        <tr>
                            <th>Bestilling ID</th>
                            <th>Start</th>
                            <th>Slutt</th>
                            <th>Bestilt</th>
                            <th>Total pris</th>
                            <th>Bur ID</th>
                            <th>Hunder</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Tabell 3 -->
                <h2 class="hovedOverskrift">Ikke begynte opphold </h2>
                <table class="opphold IkkeBegyntOpphold">
                    <thead>
                        <tr>
                            <th>Bestilling ID</th>
                            <th>Start</th>
                            <th>Slutt</th>
                            <th>Bestilt</th>
                            <th>Total pris</th>
                            <th>Bur ID</th>
                            <th>Hunder</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                    </tbody>
                </table>

        </div>
        </form>
    </main>

    <!-- ************************** fellesBunn **************************** -->
    <?php visFooter(); ?>
    <?php visToppKnapp(); ?>

</body>

</html>