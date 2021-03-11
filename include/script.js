// ************************** 1) index: anmeldelseSlider (Trygve) ************************** 
var anmeldelseTekst = document.getElementById("anmeldelseTekst");
var nesteAnmeldelseKnapp = document.getElementById("nesteAnmeldelseKnapp");
var tilbakeAnmeldelseKnapp = document.getElementById("tilbakeAnmeldelseKnapp");
var anmeldelsePos = 0;

//er vi på index siden ? 
if (anmeldelseTekst !== null) {
    nesteAnmeldelseKnapp.addEventListener('click',neste,false);
    tilbakeAnmeldelseKnapp.addEventListener('click',tilbake,false);
}

function neste() {
    anmeldelsePos++;
    oppdaterAnmeldelseSlider();
}

function tilbake() {
    anmeldelsePos--;
    oppdaterAnmeldelseSlider();
}

function oppdaterAnmeldelseSlider() { 
    var ajaxRequest = new XMLHttpRequest();  
    ajaxRequest.open("GET", "include/hentUtAnmeldelse.php?q="+anmeldelsePos, true);
    ajaxRequest.send(null); 
    ajaxRequest.onreadystatechange = function() {
        var svar = ajaxRequest.responseText;
        console.log(svar);
        if (svar == -1) {
            anmeldelsePos = 0;
            neste();        
        }
        else {
            anmeldelseTekst.innerHTML = svar;
        }
    }
}

neste();




// Hvis skjul passord funksjon (Even)
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


// Passord validation (Even)
const passord = document.querySelector("#passord");
const status = document.querySelector("#status");

if (passord !== null) {
    passord.addEventListener('keyup', melding, false);
}  

function melding(){
  if(passord.value.length >= 8){
    status.innerHTML="Passord er godkjent";
    return true;
  } else{
    status.innerHTML="Passord er ikke godkjent lite";
  } 
}





// CCV modal (Kristina)
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


// Til toppen knapp (Kristina)
//https://www.w3schools.com/howto/howto_js_scroll_to_top.asp
//Javascript kode fra w3schools, endret navn på variabler, klasser, funksjoner. 
//Var har blitt gjort om til let (fikk streng beskjed av foreleser på NTNU om om å bare bruke let istenfor var og const).

// Henter topp knappen ved hentet elmentet id kalt Knappen
let minKnapp = document.getElementById("Knappen");

// Når brukeren ruller 20 px fra toppen av dokumentet, viser knappen  
window.onscroll = function() {scrolleFunksjon()};

function scrolleFunksjon() {
    // Topp knappen dukker opp når brukeren scroller ned
if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    minKnapp.style.display = "block";
} else {
    minKnapp.style.display = "none";
}
}

// Når brukeren klikker på knappen, scrolles det til toppen av dokumentet 
function toppKnappFunksjon() {
document.body.scrollTop = 0; // Denne koden brukes hvis nettleseren er Safari
document.documentElement.scrollTop = 0; // Denne koden brukes hvis nettleseren er Chrome, Firefox, Opera og IE.
}

