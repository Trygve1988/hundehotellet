//https://www.w3schools.com/howto/howto_js_scroll_to_top.asp
//Javascript kode fra w3schools, endret navn på variabler, klasser, funksjoner.
//Var har blitt gjort om til let (fikk streng beskjed av foreleser på NTNU om om å bare bruke let istenfor var og const).


// Henter topp knappen ved hentet elmentet id kalt Knappen
let minKnapp = document.getElementById("tilToppKnapp");

// Når brukeren ruller 20 px fra toppen av dokumentet, viser knappen  
window.onscroll = function() {scrolleFunksjon()};

// Lager funksjonen som gjør det mulig å skrolle ned på siden
function scrolleFunksjon() {
    // Topp knappen dukker opp når brukeren scroller ned
if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    minKnapp.style.display = "block";
} else { /*Toppknapp forsvinner når bruker skroller opp*/ 
    minKnapp.style.display = "none";
}
}

// Når brukeren klikker på knappen, scrolles det til toppen av dokumentet 
function toppKnappFunksjon() {
document.body.scrollTop = 0; // Denne koden brukes hvis nettleseren er Safari
document.documentElement.scrollTop = 0; // Denne koden brukes hvis nettleseren er Chrome, Firefox, Opera og IE.
}
