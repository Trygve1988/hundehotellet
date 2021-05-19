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
    <title>Bø Hundehotell</title>
    <link href="include/style.css" rel="stylesheet" type="text/css">
    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
    <script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
    <script src="include/script.js" defer> </script>
    <!-- ************************** DETTE HAR VI IKKE LAGD SELV ************************** -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
</head>

<body>

    <!-- ************************** fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** main **************************-->
    <main>

        <div class="hvitBakgrunn">
    
             <!-- Form-->    
            <form class="skjemaBakgrunn">

                <!-- Overskrift -->
                    <h2 class="hovedOverskrift">Pris</h2>
                        <table class="toKolTab">
                            <tr>
                                <th>Pris pr dag for 1 hund</th> 
                                <th>Pris pr dag for 2 hund</th> 
                                <th>Pris pr dag for 3 hund</th> 
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>   
                             </tr>
                         </table>
                    <h2 class="overskrift2">Informasjon</h2>
                    <div class="info">

                        <div class="informasjon">

                            <p class="overskrift">Inn-/Utlevering:</p>
                            <p>Mellom kl 09.00-11.00/16.00-17.00</p>

                            <p class="overskrift">Mat:</p>
                            <p>- Vi bruker Royal Canin og vom tilpasset hundens alder og aktivitestsnivå. Hvis du vil at hunden skal ha annen mat, vennligst ta kontakt.</p>
                            <p>- Mat inngår i prisen på oppholdet.</p>

                            <p class="overskrift">Seng:</p>
                            <p>- Ta gjenre mednoe hunden kan ligge på for eksempel madrass eller teppe.</p>
                            <p>- Vi har stadr teppe til alle bur.</p>
                        </div>

                        <div class="annenInfo">

                            <p class="overskrift">Vaksinasjonsattest:</p>
                            <p>- Det med fremvises gyldig Vaksinasjonsattest ved ankomst.</p>
                            <p>- Attesten må være nyere en 12 mnd.</p>
                            <p>- Vi krever vaksinasjon mot valpesyke (pravo) og kennelhoste.</p>


                            <p class="overskrift" >Vetrinær:</p>
                            <p>Vi samarbeider med:</p>
                            <p>- Anicura Dyreklinkken i Telemark</p>
                            <p>- Seljord Vetrinærkontor AS</p>

                            <p class="overskrift" >Annet:</p>
                            <p>- Vi står ikke økomomisk ansvarlig for personlige eiendler hunden har med seg hit.</p>
                            <p>- Vennligst ikke ta med ting du er redd for at kan bli ødelagt under oppholdet.</p>
                        </div>
                    </div>  
            </form>
        </div> 
    </main>

    <!-- ************************** fellesBunn **************************-->
    <?php visFooter(); ?>
    <?php visToppKnapp(); ?>

</body>

</html>