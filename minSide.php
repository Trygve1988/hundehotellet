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
    <script src="include/script.js" defer> </script>
</head>
<body>

    <!-- ************************** 1) fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** (Gunni) **************************-->
    <main> 
		<!-- Hvit bakgrunn-->
		<div class="hvitBakgrunn">
			<!-- Bildebakgrunn-->
			<img class="bildeBakgrunn" src="bilder/bakgrunn.jpg">
	
			<!-- Skjema-->	
            <form class="skjema"> 
                <!-- Avbryt knapp -->
		        <input class="avbrytKnapp" type="submit" name="avbryt" value="X">

                <!-- Overskrift -->
                <h2>Min side</h2>
                <p>Innlogget som: <span></span></p>
            
                <!-- "Min profil" -->
                <h3>Min profil</h3>
                <table class="kundeTab">	
                    <tr>
                        <th class="thKolonne">Navn</th>
                        <td>SETT INN KUNDENAVN HER!</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Epost</th>
                        <td>epost</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Tlf</th>
                        <td>tlf</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Adresse</th>
                        <td>Adresse</td>
                    </tr>
                </table>

                <input class="hovedKnapp" type="submit" name="redigerKunde" value="Rediger">
            
                <!-- "Mine hunder" -->
                <h3>Mine hunder</h3>
          
                <table class="hundTab">	
                    <tr>
                        <th class="thKolonne">Navn</th>
                        <td>SETT INN HUNDENAVN HER!</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Rase</th>
                        <td>Rase</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Fødselsdato</th>
                        <td>fdato</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Kjønn</th>
                        <td>kjønn</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Sterilisert</th>
                        <td>ja ELLER nei</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Vaksinert</th>
                        <td>Ja eller nei</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Kan hunden omgås andre hunder</th>
                        <td>Ja eller nei</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Kan hunden gå løs på tur</th>
                        <td>Ja eller nei</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Fòrtype</th>
                        <td>valg</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Ekstra informasjon</th>
                        <td>Sett inn informasjonen her!</td>
                    </tr>
                </table>
                <input class="hovedKnapp" type="submit" name="redigerHund" value="Registrer ny hund">
                <input class="hovedKnapp" type="submit" name="redigerHund" value="Rediger">

                <!-- "Mine opphold" -->
                <h3>Mine opphold</h3>
                <table class="oppholdTab">	
                    <tr>
                        <th class="thKolonne">Dato fra</th>
                        <th class="thKolonne">Til</th>
                        <th class="thKolonne">Hunder</th>
                        <th class="thKolonne">Ekstra</th>
                    </tr>
                    <tr>
                        <td>start</th>
                        <td>slutt</td>
                        <td>hund</th>
                        <td>bading?</td>
                    </tr>
                </table>
                    
                <div class="knapperad">
                    <input class="hovedKnapp" type="submit" name="seEldreOpphold" value="Se eldre opphold">
                    <input class="hovedKnapp" type="submit" name="Avbestill opphold" value="Rediger">
                </div>   
                <!-- ************************** 2) main (Trygve) **************************-->        
                    
                <?php visInnloggetInfo($dblink); ?>
                <?php visMineHunder($dblink) ?>

                <!-- registrerHund -->
                <a href="registrerHund.php">registrerHund</a>

                <?php //visBestillinger($dblink); UNDER ARBEID!!!!!?> 
            </form> 
        <div> 
    </main>

    <!-- ************************** 3) fellesBunn **************************-->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>