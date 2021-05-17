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

    <!-- ************************** fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** main ******************************* -->
    <main>

        <div class="hvitBakgrunn">

            <!-- Skjema -->
            <form class="skjemaBakgrunn">
                <div class="aktuelt">
                    <div class="mellomromMellomInnlegg">
                        <!-- Margin-bottom funket ikke, derfor måtte det lages en div som lager luft mellom innleggene -->
                        <h2 class="hovedOverskrift">Aktuelt</h2>
                        <p>Her kan du lese om det som skjer på Bø Hundehotell.</p>
                    </div>
                    <div class="mellomromMellomInnlegg">
                        <h2>COVID-19</h2>
                        <p> Bø Hundehotell følger FHIs smittevernråd og derfor valgt å begrense antall besøkende på hotellet.
                            Det vil si at spørsmål om opphold o.l. må tas over telefon eller mail. God håndhygiene må følges når hunden leveres
                            eller hentes hos oss. Husk munnbind! NB! Personer som er smittet med COVID-19 kan ikke levere kjæledyret sitt til hotellet.</p>
                    </div>
                    <hr>
                    <div class="mellomromMellomInnlegg">
                        <h2>Bø Hundehotell er gjester på god morgen Norge! </h2>
                        <p>Vi ble invert på God morgen Norge for å snakke om hundehotellet og hva vi har å tilby. Se innslaget på tv2.no!
                        </p>
                    </div>
                    <hr>
                    <div class="mellomromMellomInnlegg">
                        <h2>Ledig stilling hos oss! </h2>
                        <p> Bø hundehotell trenger en ny ansatt som kan bade og føne hundene og massere dem etter turgåing. Er dette noe for deg send din søknad til
                            bohundehotell@outlook.com
                        </p>
                    </div>
                </div>
            </form> 
        </div>

        <!-- ************************** 3) fellesBunn **************************-->
        <?php visFooter(); ?>
        <?php visToppKnapp(); ?>

</body>
</html>