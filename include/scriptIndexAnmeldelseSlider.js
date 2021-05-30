/**
 *  Denne klassen har js funksjonalitet for å vise brukeranmeldelser på index siden
 *  @Author Trygve Johannessen
 */

var anmeldelseTekst = document.getElementById("anmeldelseTekst");
var nesteAnmeldelseKnapp = document.getElementById("nesteAnmeldelseKnapp");
var tilbakeAnmeldelseKnapp = document.getElementById("tilbakeAnmeldelseKnapp");
var anmeldelsePos = 0;

var anmeldelseTab = null;
hentUtAnmeldelser(); // setter anmeldelsene inne i anmeldelseTab
oppdaterAnmeldelseSlider();
nesteAnmeldelseKnapp.addEventListener('click',neste,false);
tilbakeAnmeldelseKnapp.addEventListener('click',tilbake,false);

/**
 *  Denne funksjonen kalles når brukeren navigerer til index siden. 
 *  Den bruker et ajax kall til hente ut alle godkjente anmeldelser fra databasen.
 *  Den kaller funkjsonene "lagAnmeldelseTab" og "oppdaterAnmeldelseSlider" nedenfor
 */ 
function hentUtAnmeldelser() { 
    var ajaxRequest = new XMLHttpRequest();  
    ajaxRequest.open("GET", "include/ajaxHentUtAnmeldelse.php?", true);
    ajaxRequest.send(null); 
    ajaxRequest.onreadystatechange = function() {
        anmeldelseStr = ajaxRequest.responseText; 
        lagAnmeldelseTab(anmeldelseStr);
        oppdaterAnmeldelseSlider();
    }
}

/**
 *  Denne funksjonen tar i mot et alle-Anmeldelser String-objekt og lager en tabell
 *  @param  String  anmeldelseStr
 */ 
function lagAnmeldelseTab(anmeldelseStr) { 
    anmeldelseTab = anmeldelseStr.split(",¤&%#")  // lager tabell
    for (var i=0; i<anmeldelseTab.length; i++) {
        anmeldelseTab[i] = anmeldelseTab[i].split(0,anmeldelseTab.length-3);
    }
}

/**
 *  Denne funksjonen kalles når brukeren trykker på neste-pilen under anmeldelseSlideren.
 *  Da økes variabelen "anmeldelsePos" med 1 og oppdaterAnmeldelseSlider() funksjonen kalles
 */ 
function neste() {
    anmeldelsePos++;
    //er vi gått for langt mot høyre?
    if (anmeldelseTab !== null && anmeldelsePos > anmeldelseTab.length-2) {
        anmeldelsePos = 0;
    }
    oppdaterAnmeldelseSlider();
}

/**
 *  Denne funksjonen kalles når brukeren trykker på tilbake-pilen under anmeldelseSlideren.
 *  Da minsker variabelen "anmeldelsePos" med 1 og oppdaterAnmeldelseSlider() funksjonen kalles
 */ 
function tilbake() {
    anmeldelsePos--;
    //er vi gått for langt mot venstre?
    if(anmeldelseTab !== null && anmeldelsePos < 0) {
        anmeldelsePos = anmeldelseTab.length-3;
    }
    oppdaterAnmeldelseSlider();
}

/**
 *  Denne funksjonen oppdaterer anmeldelseTeksten i index.php i forhold til anmeldelseTab sin posisjon 
 */ 
function oppdaterAnmeldelseSlider() { 
    if (anmeldelseTab !== null ) {
        var text = anmeldelseTab[anmeldelsePos];
        anmeldelseTekst.innerHTML = text;
    }
}