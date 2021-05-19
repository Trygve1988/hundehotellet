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


// ************************** 2) Aktuelt  **************************
// ************************** 3) Om Oss   **************************

// ******************* 6 Bestill Opphold: a) lagVelghundKnapper *******************
var bestillOpphold1Skjema = document.getElementById("bestillOpphold1Skjema");

//er vi på bestillOpphold1 siden ? 
if (bestillOpphold1Skjema !== null) {
  hentUtBrukerSineHunder();   // 1)
  lagVelgHundKnapper();       // 2)
} 

// 1) hentUtBrukerSineHunder
function hentUtBrukerSineHunder() {
  var ajaxRequest = new XMLHttpRequest();  
  ajaxRequest.open("GET", "include/hentUtBrukerSineHunder.php?", true);
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
      location.reload();
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
          console.log("hundID: " + hundID);
          console.log("navn:   " + navn);
          
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
  ajaxRequest.open("GET", "include/settHunderOppholdSession.php?q="+valgteHunder, true);
  ajaxRequest.send(null);
  ajaxRequest.onreadystatechange = function() {
      var test = ajaxRequest.responseText;
  } 
}

// ******************* 6) Bestill Opphold: c) lovligeDatoer *******************
var startDato = document.getElementById("startDato");

if (startDato !== null) {
  hentUtFullbookedeDatoer();
}

function hentUtFullbookedeDatoer() {
  var ajaxRequest = new XMLHttpRequest();  
  ajaxRequest.open("GET", "include/hentUtFullbookedeDatoer.php?", true);
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

// ************************** 6) Bestill Opphold: c) endreSluttDato **************************
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

// ******************* 12) Nesten Alle: deleteHundCoockies *******************
//er vi IKKE på bestillOpphold1 siden ? 
if (bestillOpphold1Skjema == null) {
  deleteHundCoockies();
}

function deleteHundCoockies() {
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


// ********************* 0) Alle: globale spraak variabler (Trygve og ?) ********************* 
var flaggTab        = ['bilder/FlaggNO.png', 'bilder/FlaggGB.png'];
var hjemTab         = ['Hjem', 'Home'];
var aktueltTab      = ['Aktuelt', 'News'];
var omOssTab        = ['Om Oss', 'About us'];
var priserTab       = ['Priser og Info', 'Prices and Info'];
var kontaktOssTab   = ['Kontakt Oss', 'Contact us'];
var bestillTab      = ['Bestill Opphold', 'Make a Booking'];
var anmeldelserTab  = ['Anmeldelser', 'Customer reviews'];
var minSideTab      = ['Min Side', 'My Page'];
var loggUtTab       = ['Logg ut', 'Logg out'];
var registrerDegTab  = ['Registrer Deg', 'Register'];


//får tak i valgt språk fra spraak cookien
var språk = getCookie('spraak'); // 0 Norsk, 1 engelsk
if(!språk) {
    språk = 0;  
}

//setter objekter til valgt språk
var spraakKnapp = document.getElementById("spraakKnapp");
var hjemLink = document.getElementById("hjemLink");
var aktueltLink = document.getElementById("aktueltLink");
var omOssLink = document.getElementById("omOssLink");
var omOssLink = document.getElementById("omOssLink");
var priserLink = document.getElementById("priserLink");
var kontaktOssLink = document.getElementById("kontaktOssLink");
var bestillLink = document.getElementById("bestillLink");
var anmeldelserLink = document.getElementById("anmeldelserLink");
var minSideLink = document.getElementById("minSideLink");
var loggUtLink  = document.getElementById("loggUtLink");
var registrerDegLink = document.getElementById("registrerDegLink");

spraakKnapp.src = flaggTab[språk];
hjemLink.innerHTML = hjemTab[språk];
aktueltLink.innerHTML = aktueltTab[språk];
omOssLink.innerHTML = omOssTab[språk];
priserLink.innerHTML = priserTab[språk];
kontaktOssLink.innerHTML = kontaktOssTab[språk];
bestillLink.innerHTML = bestillTab[språk];
if (anmeldelserLink !== null) {
    anmeldelserLink.innerHTML = anmeldelserTab[språk];
}
if (minSideLink !== null) {
    minSideLink.innerHTML = minSideTab[språk];
}
if (loggUtLink !== null) {
  loggUtLink.innerHTML = loggUtTab[språk];
}
if (registrerDegLink !== null) {
    registrerDegLink.innerHTML = registrerDegTab[språk];
}


// ********************* 0) navbar: spraakKnapp (Trygve)*********************
spraakKnapp.addEventListener('click', endreSpraak, false);

function endreSpraak() {
  var verdi = getCookie('spraak');
  console.log(verdi);
  if (verdi == 0) {
      verdi = 1;
  }
  else {
      verdi = 0;
  }
  document.cookie = "spraak=" + verdi;

  location.reload();
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
    ajaxRequest.open("GET", "include/hentUtAnmeldelse.php?", true);
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


// ************************** Registrer deg: Hvis skjul passord funksjon (Even) **************************
const visPassordKnapp = document.querySelector("#visPassordKnapp");

if (visPassordKnapp !== null) {
    visPassordKnapp.addEventListener('click', visPassord, false);
} 

function visPassord() {
  var x = document.getElementById("passord");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
} 

// ************************** Registrer deg: Passord validation (Even) **************************
//Passord validation (Even)
const passord = document.querySelector("#passord");
const status = document.querySelector("#status");

//er vi på registrerDeg siden ? 
if (passord !== null) {
  passord.addEventListener('keyup', melding, false);
}

function melding(){
  var paso = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15}$/; //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
  if(passord.value.match(paso)){
    status.innerHTML="Passord er godkjent";
    return true;
  } else{
    status.innerHTML="Passordet må være mellom 8-15 tegn inkludert speseiel tegn.";
    return false;
  } 
}

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


// Slutt på hentet kode


// Bestill opphold 4
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