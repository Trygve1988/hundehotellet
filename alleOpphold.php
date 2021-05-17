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

    <!-- ************************** main ******************************* -->
    <main>

        <!-- erAnsatt sjekk -->
        <?php if (!erAnsatt()) {
            header('Location: loggInn.php');
        } ?>

        <!-- alle opphold  -->
        <form>
            <div class="hvitBakgrunn">

                <h2 class="hovedOverskrift">Ferdige opphold</h2>
                <table class="opphold FerdigOpphold">
                    <thead>
                        <tr>
                            <th>Bestilling ID</th>
                            <th>Start</th>
                            <th>Slutt</th>
                            <th>Bestilt</th>
                            <th>Betalt</th>

                            <th>Total pris</th>
                            <th>Opphold ID</th>
                            <th>Bade</th>
                            <th>Hunde ID</th>
                            <th>Navn</th>
                            <th>Bur ID</th>



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
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Tabell 2 -->

                <h1>Pågående opphold</h1>
                <table class="opphold Pågående">
                    <thead>
                        <tr>
                            <th>Bestilling ID</th>
                            <th>Start</th>
                            <th>Slutt</th>
                            <th>Bestilt</th>
                            <th>Betalt</th>

                            <th>Total pris</th>
                            <th>Opphold ID</th>
                            <th>Bade</th>
                            <th>Hunde ID</th>
                            <th>Navn</th>
                            <th>Bur ID</th>
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
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Tabell 3 -->
                <h1>Ikke begynte opphold</h1>
                <table class="opphold IkkeBegyntOpphold">
                    <thead>
                        <tr>
                            <th>Bestilling ID</th>
                            <th>Start</th>
                            <th>Slutt</th>
                            <th>Bestilt</th>
                            <th>Betalt</th>

                            <th>Total pris</th>
                            <th>Opphold ID</th>
                            <th>Bade</th>
                            <th>Hunde ID</th>
                            <th>Navn</th>
                            <th>Bur ID</th>
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
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td></td>
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