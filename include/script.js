/*
// ********************* 0) Felles: tilToppenKnapp (Kristina) ********************* 
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
*/


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



// ************************** 11) Registrer deg: Hvis skjul passord funksjon (Even) **************************
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

// ************************** 11) Registrer deg: Passord validation (Even) **************************
//Passord validation (Even)
const passord = document.querySelector("#passord");
const status = document.querySelector("#status");

passord.addEventListener('keyup', melding, false);

function melding(){
  var paso = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15}$/;  
  //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
  if(passord.value.match(paso)){
    status.innerHTML="Passord er godkjent";
    return true;
  } else{
    status.innerHTML="Passordet må være mellom 8-15 tegn inkludert speseiel tegn.";
    return false;
  } 
}

//Bildeslider  (Even)
//Inspirert og hentet fra https://www.w3schools.com/howto/howto_js_slideshow.asp
var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
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
  setTimeout(showSlide,2000); //Bytter bilde hvert 2sekund 
}


// **************************  Bestill Opphold-knapper (Gunni) **************************

// Bestill opphold 1
// Knappefunksjon for nesteknapp i Bestill opphold 1/4
// Lager button variablel
var tilBO2Knapp = document.getElementById("tilBO2");

// Evemtlistener på knapper som fyrer av en funksjon når knappen blir trykket på
tilBO2.addEventListener('click', tilBO2Funksjon, false);

// Funksjonen
function tilBO2Funksjon() {
    window.location.href = "bestillOpphold2.php";
} 

// Bestill opphold 2
// Knappefunksjon for nesteknapp i Bestill opphold 2/4
// Lager button variablel
var tilBO3Knapp = document.getElementById("tilBO3");

// Evemtlistener på knapper som fyrer av en funksjon når knappen blir trykket på
tilBO3.addEventListener('click', tilBO3Funksjon, false);

// Funksjonen
function tilBO3Funksjon() {
    window.location.href = "bestillOpphold3.php";
}

// Bestill opphold 3
// Knappefunksjon for nesteknapp i Bestill opphold 3/4
// Lager button variablel
var tilBO4Knapp = document.getElementById("tilBO4");

// Evemtlistener på knapper som fyrer av en funksjon når knappen blir trykket på
tilBO4.addEventListener('click', tilBO4Funksjon, false);

// Funksjonen
function tilBO4Funksjon() {
    window.location.href = "bestillOpphold4.php";
}  

// Bestill opphold 4


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
