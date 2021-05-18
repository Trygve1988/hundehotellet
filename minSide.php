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

    <!-- ************************** fellesTop ************************** -->
    <?php visNav(); ?>

    <!-- ************************** main ******************************* -->
    <main> 

    	<!-- erLoggetInn sjekk -->
		<?php if (!erLoggetInn()) { header('Location: loggInn.php'); } ?>

        <!-- ************************ (Gunni) ****************************** -->
		<!-- Hvit bakgrunn-->
		<div class="hvitBakgrunn">
			
            <!-- Skjema-->	
            <form class="skjemaBakgrunn">

                <!-- Avbryt knapp -->
				<a href = "index.php">
					<input class="avbrytKnapp" type="button" value="X">
				</a>
                
                <!-- Overskrift -->
                <h2 class="hovedOverskrift">Min side</h2>
            
                <!-- "Min profil" -->
                <h2 class="overskrift2">Min profil</h2>
                <table class="toKolTab  minSideToKolTab">	
                    <tr>
                        <th class="thKolonne">Navn</th>
                        <td>Fornavn Etternavn</td>
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
         
                <!--Knapperad-->
				<!-- "Rediger / oppdater kunde-info-knapp -->
				<a href = "oppdaterKundeInfo.php">
                	<input class="hovedKnapp inputButton" type="button" value="Rediger"> 
            	</a>
		    
                <!-- "Mine hunder" -->
                
                <h2 class="overskrift2">Mine hunder</h2>
                
                <div class="litenInput">
                <!-- Nedtrekksliste for valg av hund -->
                <label for="velgHund">Velg hund:</label>
                    <select class="inputSelect" name="velgHund">
                        <option value="hund1">Hund1</option>
                        <option value="hund2">Hund2</option>
                        <option value="hund3">Hund3</option>
                    </select>
              </div>
                <table class="toKolTab  minSideToKolTab">	
                    <tr>
                        <th class="thKolonne">Navn</th>
                        <td>navn</td>
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
                        <td>Ja eller nei</td>
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
                        <th class="thKolonne">Fòrtype</th>
                        <td>valg</td>
                    </tr>
                    <tr>
                        <th class="thKolonne">Ekstra informasjon</th>
                        <td>Hunden er allergisk mot blabblabla!</td>
                    </tr>
                </table>
                
                <!--Knapperad-->
				<div class="knapperad">
                    <!-- Registrer ny hund-\knapp-->
                    <a href = "registrerHund.php">
                        <input class="inputButton hovedKnapp ekstraKnapp2" type="button" value="Registrer ny hund">
                    </a>
                      <!-- Endre hundeinfo- knapp -->
                    <a href = "oppdaterHundInfo.php">
                        <input class="inputButton hovedKnapp" type="button" value="Rediger"> 
                    </a>
                <!-- "Mine opphold" -->
                <h2 class="overskrift2">Mine opphold</h2>
                <table class="toKolTab hTab">	
                    <tr>
                        <th>Start</th>
                        <th>Slutt</th>
                        <th>Bestilt</th>
                        <th>Betalt</th>
                        <th>Totalpris</th>
                        <th>Hund</th>
                    </tr>
                    <tr>
                        <td>start</th>
                        <td>slutt</td>
                        <td>bestilt</th>
                        <td>betalt</th>
                        <td>totalpris</th>
                        <td>hund</th>
                    </tr>
                </table>
                    
                <!--Knapperad-->
				<!-- Bestill opphold -->
				<a href="bestillOpphold.php">
                    <input class=" inputButton hovedKnapp" type="button" value="Bestill opphold"> 
                </a>
                <!-- Se eldre, viser alle registrerte opphold -->
                <a href = "alleOppholdforKunde.php">
                    <input class=" inputButton hovedKnapp" type="button" value="Se eldre"> 
            	</a>
                
                <!-- ************************** (Trygve) *************************** -->
                <?php //visBestillinger($dblink); UNDER ARBEID!!!!!?> 
            </form> 
        <div> 
    </main>

    <!-- ************************** 3) fellesBunn ********************************** -->
    <?php visFooter(); ?> 
    <?php visToppKnapp(); ?> 
   
</body>
</html>