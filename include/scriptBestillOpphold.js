/**
 *  Denne klassen har js funksjonalitet for å lage velghundKnapper og registrere valgte hunder
 *  @Author Trygve Johannessen
 */

var bestillOpphold1Mld = document.getElementById("bestillOpphold1Mld");
var tilBestillOpphold2Knapp = document.getElementById("tilBestillOpphold2Knapp");

hentUtBrukerSineHunder();   
lagVelgHundKnapper();       
tilBestillOpphold2Knapp.addEventListener('click',tilBestillOpphold2,false);

/**
 *  Denne funksjonen kjører et ajax kall databasen for å hente ut hundID til alle brukeren sine hunder.
 *  Disse hundene lagres i en coockie
 */ 
function hentUtBrukerSineHunder() {
    var ajaxRequest = new XMLHttpRequest();  
    ajaxRequest.open("GET", "include/ajaxHentUtBrukerSineHunder.php?", true);
    ajaxRequest.send(null);
    ajaxRequest.onreadystatechange = function() {
        var hundIDTab = ajaxRequest.responseText;
        setBrukerHunderCoockie(hundIDTab);
    } 
}

/**
 *  Denne funksjonen kjører et ajax kall databasen for å hente ut hundID til alle brukeren sine hunder.
 *  Disse hundene lagres i en coockien "brukerHunder"
 */ 
function setBrukerHunderCoockie(hundIDTab) {
    document.cookie = "brukerHunder=" + hundIDTab;
}


// Denne funksjonen lager en knapp pr hund i "brukerHunder" coockien
function lagVelgHundKnapper() {
    var brukerHunder = getCookie('brukerHunder'); 
    // må laste inn siden på ny viss ikke vi har fått svar fra ajax kallet ennå
    if (brukerHunder == "") {
        setTimeout(function(){
            location.reload()
        }, 100);
    }

    //har denne brukeren noen hunder som vi kan lage knapper til?
    if (brukerHunder.length > 2) {
        brukerHunder = brukerHunder.substring(1,brukerHunder.length-1); // tar vekk [ og ]
        var hundTab = brukerHunder.split(",");  // leger brukerens hunder inn i en tabell

        //går gjennom alle hundene
        for (var i=0; i<hundTab.length; i++) {
            hund = hundTab[i]; 
            hund = hund.substring(1,hund.length-1); // tar vekk " og "

            //plukker ut hundID'en og navnet til denne hunden
            var dataTab = hund.split(" ");
            var hundID = dataTab[0];
            var navn = dataTab[1];
            
            //lager en velgHundKnapp
            var velgHundKnapp = document.createElement("button");
            velgHundKnapp.innerHTML = navn; // vises på knappen
            velgHundKnapp.name = hundID;    // gjemt verdi (denne skal vi bruke)
            velgHundKnapp.className ="velgHundKnapp";
            velgHundKnapp.type="button";
            velgHundKnapp.style.backgroundColor = "gray";

            //er denne hunden valgt? da må knappen være lyseblå
            var valgteHunder = getCookie('valgteHunder'); // ["23","24","25"]
            var valgteHunderTab = valgteHunder.split(" ");
            for (var j=0; j<valgteHunderTab.length; j++) {
                if (valgteHunderTab[j] == hundID) {
                    velgHundKnapp.style.backgroundColor = "darkblue";
                }
            }
    
            //plasserer knappen
            var bestillOpphold1Skjema = document.getElementById('velgHundKnappContainer');
            bestillOpphold1Skjema.appendChild(velgHundKnapp);
    
            // legger på en velgHund eventHandler
            velgHundKnapp.addEventListener('click', velgHund, false);
        }
    }
}

/**
 *  Denne funksjonen kalles når en bruker trykker på en velgHundKnapp
 *  Den kaller funksjonene "erhundAlleredeValgt" for å sjekke om en hund allerede er valgt
 *  og "settHunderOppholdSession" for å legge til/fjerne denne hunden fra Sessionsvariabelen "valgteHunder"
 */ 
function velgHund(e) {
    // får tak i alle hundID'ene som allerede er valgt
    var valgteHunder = getCookie('valgteHunder'); // ["23","24","25"]

    // får tak i den nye hundID'en
    var nyHund = this.name;

    var dataTab = nyHund.split(" ");
    var nyHundID = dataTab[0];

    //er hund allerede valgt?
    if (!erhundAlleredeValgt(nyHundID)) {
        //da skal hunden legges til coockien

        //er DetAllerede valgt 3 hunder
        var valgteHunder = getCookie('valgteHunder');
        hundIDTab = valgteHunder.split(" ");
        if (hundIDTab.length > 2) {
            bestillOpphold1Mld.innerHTML = "Kan ikke velge mer en 3 hunder!";
        }
        else{
            alleHunder = valgteHunder + " " + nyHundID;
            document.cookie = "valgteHunder=" + alleHunder ;
           
            //endrer stil på knappen
            e.target.style.backgroundColor = "darkblue"; 

            bestillOpphold1Mld.innerHTML = "";
        }
    }
    else {
        // da skal hunden fjernes fra coockien
        var hunderStr = "";
        var valgteHunder = getCookie('valgteHunder');
        hundIDTab = valgteHunder.split(" ");
        for (var i=0; i<hundIDTab.length; i++) {
            var hundID = hundIDTab[i]
            if (hundID != nyHundID) {
                hunderStr += hundID + " ";
            }
        }
        document.cookie = "valgteHunder=" + hunderStr + ";"
        
        //endrer stil på knappen
        e.target.style.backgroundColor = "gray"; 

        bestillOpphold1Mld.innerHTML = "";
    }

    var valgteHunder = getCookie('valgteHunder'); // ["23","24","25"]
    
    //lager en tabell som skal lagres som php SESSION
    valgteHunder = valgteHunder.split(" ");
    settHunderOppholdSession(valgteHunder);
}

/**
 *  Denne funksjonen sjekker om brukeren allerede har valgt denne hunden
 *  Da skal den fjernes fra valgte hunder.
 */ 
function erhundAlleredeValgt(sjekkhundID) {
    var hundAlleredeValgt = false;
    var valgteHunder = getCookie('valgteHunder');
    hundIDTab = valgteHunder.split(" ");
    for (var i=0; i<hundIDTab.length; i++) {
        var hundID = hundIDTab[i]
        if (hundID == sjekkhundID) {
            hundAlleredeValgt = true;
        }
    }
    return hundAlleredeValgt;
}

/**
 *  Denne funksjonen setter valgteHunder inn i sessionsvariabelen "valgteHunder"
 *  Denne sessionsvariablene brukes videre i bestillOpphold prosessen 
 *  for å ta vare på hunder skom skal være med på opphold
 */ 
function settHunderOppholdSession(valgteHunder) {
    var ajaxRequest = new XMLHttpRequest();  
    ajaxRequest.open("GET", "include/ajaxSettHunderOppholdSession.php?q="+valgteHunder, true);
    ajaxRequest.send(null);
    ajaxRequest.onreadystatechange = function() {
        var test = ajaxRequest.responseText;
    } 
}

// Denne funksjonen sender brukeren til bestillOpphold2 viss minst 1 hund er valgt
function tilBestillOpphold2() {
    console.log("tilBestillOpphold2");
    if (getCookie('valgteHunder') == ""){
        bestillOpphold1Mld.innerHTML = "Du må velge hund(er) først!";   
    }
    else {
        window.location.href = "bestillOpphold2.php"; 
    }
} 