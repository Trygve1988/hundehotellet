// ************************** 0) Alle getCookcie  ************************** 
//***** ikke lagd selv: https://www.w3schools.com/js/js_cookies.asp **** -->
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
// ************* ikke lagd selv slutt ************* -->


// ******************* 0) Nesten Alle: deleteHundCoockies *******************
var bestillOpphold1Skjema = document.getElementById("bestillOpphold1Skjema");

//er vi IKKE på bestillOpphold1 siden ? 
if (bestillOpphold1Skjema == null) {
    deleteHundCoockies();
}

function deleteHundCoockies() {
    console.log("deleteHundCoockies");
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];

        //er dette en cookie som skal slettes?
        var sjekkCookie = cookies[i];
        var dataTab = sjekkCookie.split("=");
        sjekkCookie = dataTab[0];

        if (sjekkCookie=="brukerHunder" || sjekkCookie==" brukerHunder" || 
        sjekkCookie=="valgteHunder"|| sjekkCookie==" valgteHunder") {
            var eqPos = cookie.indexOf("=");
            var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
    }
}

// ************************** 1) index: anmeldelseSlider (Trygve) ************************** 
var anmeldelseTekst = document.getElementById("anmeldelseTekst");
var nesteAnmeldelseKnapp = document.getElementById("nesteAnmeldelseKnapp");
var tilbakeAnmeldelseKnapp = document.getElementById("tilbakeAnmeldelseKnapp");
var anmeldelsePos = 0;

//er vi på index siden ? 
if (anmeldelseTekst !== null) {
    var anmeldelseTab = null;
    hentUtAnmeldelser(); // setter anmeldelsene inne i anmeldelseTab
    oppdaterAnmeldelseSlider();
    nesteAnmeldelseKnapp.addEventListener('click',neste,false);
    tilbakeAnmeldelseKnapp.addEventListener('click',tilbake,false);
}

function neste() {
    anmeldelsePos++;
    //er vi gått for langt mot høyre?
    if (anmeldelseTab !== null && anmeldelsePos > anmeldelseTab.length-3) {
        anmeldelsePos = 0;
    }
    oppdaterAnmeldelseSlider();
}

function tilbake() {
    anmeldelsePos--;
    //er vi gått for langt mot venstre?
    if(anmeldelseTab !== null && anmeldelsePos < 0) {
        console.log("godzilla");
        anmeldelsePos = anmeldelseTab.length-3;
    }
    oppdaterAnmeldelseSlider();
}

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

function lagAnmeldelseTab(anmeldelseStr) { 
    anmeldelseTab = anmeldelseStr.split(",")  // lager tabell
}

function oppdaterAnmeldelseSlider() { 
    if (anmeldelseTab !== null ) {
        var text = anmeldelseTab[anmeldelsePos];
        anmeldelseTekst.innerHTML = text;
    }
}
// ************************** 2) Aktuelt  **************************
// ************************** 3) Om Oss   **************************

// ******************* 6 Bestill Opphold: a) lagVelghundKnapper *******************

//er vi på bestillOpphold1 siden ? 
if (bestillOpphold1Skjema !== null) {
    hentUtBrukerSineHunder();   // 1)
    lagVelgHundKnapper();       // 2)
} 

// 1) hentUtBrukerSineHunder
function hentUtBrukerSineHunder() {
    var ajaxRequest = new XMLHttpRequest();  
    ajaxRequest.open("GET", "include/ajaxHentUtBrukerSineHunder.php?", true);
    ajaxRequest.send(null);
    ajaxRequest.onreadystatechange = function() {
        var hundIDTab = ajaxRequest.responseText;
        setBrukerHunderCoockie(hundIDTab);
    } 
}

function setBrukerHunderCoockie(hundIDTab) {
    document.cookie = "brukerHunder=" + hundIDTab;
}

// 2) hentUtBrukerSineHunder
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

// ******************* 6) Bestill Opphold: b) velgHund *******************
var bestillOpphold1Mld = document.getElementById("bestillOpphold1Mld");

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

function settHunderOppholdSession(valgteHunder) {
    var ajaxRequest = new XMLHttpRequest();  
    ajaxRequest.open("GET", "include/ajaxSettHunderOppholdSession.php?q="+valgteHunder, true);
    ajaxRequest.send(null);
    ajaxRequest.onreadystatechange = function() {
        var test = ajaxRequest.responseText;
    } 
}


// ******************* 6) Bestill Opphold: c) tilBestillOpphold2 *******************
var tilBestillOpphold2Knapp = document.getElementById("tilBestillOpphold2Knapp");

//er vi på bestillOpphold1 siden ? 
if (tilBestillOpphold2Knapp !== null) {
    tilBestillOpphold2Knapp.addEventListener('click',tilBestillOpphold2,false);
} 

function tilBestillOpphold2() {
    console.log("tilBestillOpphold2");
    if (getCookie('valgteHunder') == ""){
        bestillOpphold1Mld.innerHTML = "Du må velge hund(er) først!";   
    }
    else {
        window.location.href = "bestillOpphold2.php"; 
    }
} 

// ******************* 6) Bestill Opphold: d) lovligeDatoer *******************
var startDato = document.getElementById("startDato");

if (startDato !== null) {
    hentUtFullbookedeDatoer();
}

function hentUtFullbookedeDatoer() {
    var ajaxRequest = new XMLHttpRequest();  
    ajaxRequest.open("GET", "include/ajaxHentUtFullbookedeDatoer.php?", true);
    ajaxRequest.send(null);
    ajaxRequest.onreadystatechange = function() {
        var opptattTab = ajaxRequest.responseText;
        if(opptattTab) {
            taVekkDatoer(opptattTab);
        }
    } 
}

//***** ikke lagd selv,gratis å bruke: https://cdnjs.com/libraries/jquery/3.3.1  **** -->
function taVekkDatoer(opptattTab) {   
    $('input').datepicker({

        showButtonPanel: true,
        changeMonth: true,
        minDate: new Date(),
        maxDate: '+1Y',
        inline: true,

        dateFormat: 'yy-mm-dd',
        beforeShowDay: function(date) {
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [opptattTab.indexOf(string) == -1]
        }
    });
}
// ************* ikke lagd selv slutt ************* -->

// ************************** 6) Bestill Opphold: e) endreSluttDato **************************
var startDato = document.querySelector("#startDato");
var sluttDato = document.querySelector("#sluttDato");

//er vi på Bestill opphold deg siden ? 
if (startDato !== null) {
    startDato.addEventListener('click', oppdaterSluttDato, false);
}

function oppdaterSluttDato() {
    var start = new Date(startDato.value);
    var slutt = new Date(sluttDato.value);
    if (start >= slutt) { 
        slutt.setDate(start.getDate()+1);
        document.getElementById("sluttDato").valueAsDate = slutt; 
    }
}


// ************************** 7) Ansatt: inspiser hund **************************
var velgInspiserHundSelect = document.getElementById("velgInspiserHundSelect");

//er vi på Registrer deg siden ? 
if (velgInspiserHundSelect !== null) {
    velgInspiserHundSelect.addEventListener('change', settInspiserHundSession, false);
}

function settInspiserHundSession() {
    var hundID = document.getElementById("velgInspiserHundSelect").value;
    console.log(hundID);
    var ajaxRequest = new XMLHttpRequest();  
    ajaxRequest.open("GET", "include/ajaxSettInspiserHundSession.php?q="+hundID, true);
    ajaxRequest.send(null);
    ajaxRequest.onreadystatechange = function() {
        var test = ajaxRequest.responseText;
        location.reload();
    }
}


// ************************** settMinSideHundSession **************************
var velgMinSideHundSelect = document.getElementById("velgMinSideHundSelect");

//er vi på Registrer deg siden ? 
if (velgMinSideHundSelect !== null) {
    velgMinSideHundSelect.addEventListener('change', settMinSideHundSession, false);
}

function settMinSideHundSession() {
    var hundID = document.getElementById("velgMinSideHundSelect").value;
    console.log(hundID);
    var ajaxRequest = new XMLHttpRequest();  
    ajaxRequest.open("GET", "include/ajaxSettMinSideHundSession.php?q="+hundID, true);
    ajaxRequest.send(null);
    ajaxRequest.onreadystatechange = function() {
        var test = ajaxRequest.responseText;
        location.reload();
    }
}







// ************************** 9) admin **************************
var adminSeBrukertypeSelect = document.getElementById("adminSeBrukertypeSelect");

//er vi på Registrer deg siden ? 
if (adminSeBrukertypeSelect !== null) {
    adminSeBrukertypeSelect.addEventListener('change', settAdminSeBrukertypeSession, false);
}

function settAdminSeBrukertypeSession() {
    var brukertype = document.getElementById("adminSeBrukertypeSelect").value;
    console.log(brukertype);
    var ajaxRequest = new XMLHttpRequest();  
    ajaxRequest.open("GET", "include/ajaxSettAdminSeBrukertypeSession.php?q="+brukertype, true);
    ajaxRequest.send(null);
    ajaxRequest.onreadystatechange = function() {
        var test = ajaxRequest.responseText;
        location.reload();
    }
}


// ************************** Hvis skjul passord funksjon (Even) **************************
const visPassordKnapp = document.querySelector("#visPassordKnapp");

if (visPassordKnapp !== null) {
    visPassordKnapp.addEventListener('click', visPassord, false);
} 

function visPassord() {
  var x = document.getElementById("passord");
  if ( x.type === "password" ) {
    x.type = "text";
  } else {
    x.type = "password";
  }
} 

// ************************** Passord validation (Even) **************************

//**** Passord validation register deg (Even) ****
const passord = document.querySelector("#passord");

//Satus Norsk
const status = document.querySelector("#status");
const status0 = document.querySelector("#status0");

//Status for engelsk tilbakemelding
const status2 = document.querySelector("#status2");
const status3 = document.querySelector("#status3");

//Sjekker om man skriver inn passord, og skriver ut melding
if(passord !== null) {
  passord.addEventListener('keyup', melding, false);
  passord.addEventListener('keyup', melding2, false);
} 

// Norsk tilbamelding
function melding(){
  var paso = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15}$/; //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
  if( passord.value.match(paso) ){
    status.innerHTML="Norsk: Passord er godkjent";
    status0.innerHTML=" ";
    return true;
  } else{
    status.innerHTML="Norsk: Mellom 8-15 tegn.";
    status0.innerHTML="Minst ett tall, stor bokstav, liten bokstav, spesial tegn(@% osv).";
    return false;
  } 
}

// Engelsk tilbakemelding 
function melding2(){
    var paso = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15}$/; //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
    if( passord.value.match(paso) ){
      status2.innerHTML="English: Password has been approved";
      status3.innerHTML= " ";
      return true;
    } else{
      status2.innerHTML="English: Between 8-15 characters. At least one number, -";
      status3.innerHTML="uppercase letter, lowercase letter, special characters (@%, etc.).";
      return false;
    } 
}






// ********* Nytt passord validering ******

//Nytt passord validator
const passord2 = document.querySelector("#passord2");

//Satus Norsk, nytt passord
const nystatus = document.querySelector("#nystatus");
//Status for engelsk tilbakemelding, nytt passord
const nystatus2 = document.querySelector("#nystatus2");
const nystatus3 = document.querySelector("#nystatus3");

//Sjekker om man skriver inn nytt passord, og skriver ut melding,
if(passord2 !== null) {
    passord2.addEventListener('keyup', nyTTPasomelding, false);
    passord2.addEventListener('keyup', nyTTPasomelding2, false);
} 

// Norsk tilbamelding
function nyTTPasomelding(){
  var paso = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15}$/; //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
  if(passord2.value.match(paso) ){
    nystatus.innerHTML="Passord er godkjent";
    return true;
  } else{
    nystatus.innerHTML="Mellom 8-15 tegn. Minst ett tall, stor bokstav, liten bokstav, spesial tegn(@% osv).";
    return false;
  } 
}
  
// Engelsk tilbakemelding 
function nyTTPasomelding2(){
    var paso = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15}$/; //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
    if( passord2.value.match(paso) ){
      nystatus2.innerHTML="Password has been approved";
      return true;
    } else{
      nystatus2.innerHTML="Between 8-15 characters. At least one number, -";
      nystatus3.innerHTML="uppercase letter, lowercase letter, special characters (@%, etc.).";
      return false;
    } 
}

// ***** Vis skjul nytt passord *******
const visPassordKnapp2 = document.querySelector("#visPassordKnapp2");

if (visPassordKnapp2 !== null) {
    visPassordKnapp2.addEventListener('click', visPassord2, false);
} 

function visPassord2() {
  var y = document.getElementById("passord2");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}




/*


// ********** Skriver ut melding om passord er like eller ikke, og sjekker om passord er like ********** 
const visPassordRegisterDeg = document.querySelector("#visPassordRegisterDeg");
const gjentaPasoRegisterDeg = document.querySelector("#gjentaPasoRegisterDeg");

//Gjent satus på Norsk 
const gjentaPasoRegisterDegSatus = document.querySelector("#gjentaPasoRegisterDegSatus");

//Gjenta status på engelsk 
const gjentaPasoRegisterDegSatus2 = document.querySelector("#gjentaPasoRegisterDegSatus2");

//Sjekker om man skriver inn gjenta passord, og skriver ut melding,
if(gjentaPasoRegisterDeg !== null) {
    gjentaPasoRegisterDeg.addEventListener('keyup', gjentaPasoRegisterDegMelding, false);
} 

if(gjentaPasoRegisterDeg !== null) {
    gjentaPasoRegisterDeg.addEventListener('keyup', gjentaPasoRegisterDegMelding2, false);
} 

// Norsk tilbakemelding 
function gjentaPasoRegisterDegMelding(){
    if( gjentaPasoRegisterDeg.value.match(visPassordRegisterDeg) ){
        gjentaPasoRegisterDegSatus.innerHTML="Passordene er like";
      return true;
    } else{
        gjentaPasoRegisterDegSatus.innerHTML="Passordene er ikke like";
      return false;
    } 
}

// Engelsk tilbakemelding 
function gjentaPasoRegisterDegMelding2(){
    if( gjentaPasoRegisterDeg.value.match(visPassordRegisterDeg) ){
        gjentaPasoRegisterDegSatus2.innerHTML="The passwords are the same";
      return true;
    } else{
        gjentaPasoRegisterDegSatus2.innerHTML="The passwords are not the same";
      return false;
    } 
} 

// Sjekker om passord er like
function sjekkPassordLike(){
    const passord = document.querySelector('input[name=passord]');
    const sjekkPaso = document.querySelector('input[name=passordSjekk]');
    if(sjekkPaso.value == passord.value){
        document.getElementById('submit').disabled = false;
        console.log("like");
    } else{
        document.getElementById('submit').disabled = true;
        console.log("Ikke like passord");
    }
}

*/

// ************************** Bildeslider (Even) **************************

//Bildeslider hentet fra https://www.w3schools.com/howto/howto_js_slideshow.asp
var test = document.getElementsByClassName("mySlides");

var slideIndex = 1;
if (test !== null) {
  showSlides(slideIndex);
}

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1}    
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
}


// ********************** Slutt på hentet kode **********************

/*
// ************************** 5) Bestill Opphold: CCV modal (Kristina) **************************
// https://www.w3schools.com/howto/howto_css_modals.asp
//Javascript kode fra w3schools, endret navn på variabler, klasser, funksjoner. 
//Var har blitt gjort om til let (fikk streng beskjed av foreleser på NTNU om om å bare bruke let istenfor var og const).

// Henter cvc modalen
let modal = document.getElementById("cvcModal");

// Henter knappen som åpner cvv modalen
let modalknapp = document.getElementById("cvcModalKnapp");

// Henter elmentet <span> som lukker cvc modalan
let span = document.getElementsByClassName("lukkModal")[0]; //[0] betyr antall ganger den skal lukkes

// Når brukeren trykker på knappen åpnes modalen
modalknapp.onclick = function() {
  modal.style.display = "block";

  // gjør sånn at det ikke kan scrolles i bakgrunnen
  document.querySelector("body").style.overflow = 'hidden';  //Denne kode linjen er hentet fra denne siden https://usefulangle.com/post/279/hide-page-scrollbar-when-fixed-modal-opened
}

//Når brukeren klikker på (x)så lukkes modulen.
span.onclick = function() {
  modal.style.display = "none";
  // Når modulen er lukket kan brukeren scrolle på siden
  document.querySelector("body").style.overflow = 'visible'; //Denne kode linjen er hentet fra denne siden https://usefulangle.com/post/279/hide-page-scrollbar-when-fixed-modal-opened
}

// Når bruker klikker utenfor modalen så lukkes den
window.onclick = function(hendelse) { //Endret fra e til hendelse.
  if (hendelse.target == modal) {
    modal.style.display = "none";
  }

}
*/