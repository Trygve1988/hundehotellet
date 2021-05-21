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
                    <h2 id="prisText" class="hovedOverskrift">Pris</h2>
                        <table class="toKolTab">
                            <tr>
                                <th id="prisText1">Pris pr dag for 1 hund</th> 
                                <th id="prisText2">Pris pr dag for 2 hunder</th> 
                                <th id="prisText3">Pris pr dag for 3 hunder</th> 
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>   
                             </tr>
                         </table>
                    <h2 id="informasjonText" class="overskrift2">Informasjon</h2>
                    <div class="info">

                        <div class="informasjon">

                            <p id="overSkrift1" class="overskrift">Ut-/Innsjekking:</p>
                            <p id="infomasjonText1">Utsjekking mellom kl 09.00-12.00, Innsjekking mellom kl 12-00-16.00</p>

                            <p id="overSkrift2" class="overskrift">Mat:</p>
                            <p id="infomasjonText2">- Vi bruker Royal Canin og vom tilpasset hundens alder og aktivitestsnivå. Hvis du vil at hunden skal ha annen mat, vennligst ta kontakt.</p>
                            <p id="infomasjonText3">- Mat inngår i prisen på oppholdet.</p>

                            <p id="overSkrift3" class="overskrift">Seng:</p>
                            <p id="infomasjonText4">- Ta gjenre mednoe hunden kan ligge på for eksempel madrass eller teppe.</p>
                            <p id="infomasjonText5">- Vi har stadr teppe til alle bur.</p>
                        </div>

                        <div class="annenInfo">

                            <p id="overSkrift4" class="overskrift">Vaksinasjonsattest:</p>
                            <p id="infomasjonText6">- Det med fremvises gyldig Vaksinasjonsattest ved ankomst.</p>
                            <p id="infomasjonText7">- Attesten må være nyere en 12 mnd.</p>
                            <p id="infomasjonText8">- Vi krever vaksinasjon mot valpesyke (pravo) og kennelhoste.</p>


                            <p id="overSkrift5" class="overskrift" >Veterinær:</p>
                            <p id="infomasjonText9">Vi samarbeider med:</p>
                            <p id="infomasjonText10">- Anicura Dyreklinkken i Telemark</p>
                            <p id="infomasjonText11">- Seljord Vetrinærkontor AS</p>

                            <p id="overSkrift5" class="overskrift" >Annet:</p>
                            <p id="infomasjonText12">- Vi står ikke økomomisk ansvarlig for personlige eiendler hunden har med seg hit.</p>
                            <p id="infomasjonText13">- Vennligst ikke ta med ting du er redd for at kan bli ødelagt under oppholdet.</p>
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