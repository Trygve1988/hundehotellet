/**
 *  Denne klassen har js funksjonalitet for å bare la brukeren velge datoer 
 *  fram i tid som ikke er fulbooket på bestillOpphold3 siden. Den har også funksjonalitet 
 *  for å automatisk sette sluttDato etter startdato
 *  Skrevet av Trygve Johannessen med untak av der vi har oppgitt andre kilder
 */

var startDato = document.getElementById("startDato");
var sluttDato = document.querySelector("#sluttDato");

hentUtFullbookedeDatoer();
startDato.addEventListener('click', oppdaterSluttDato, false);

/**
 *  Denne funksjonen bruker et ajax kall for å hente ut alle fullbookede datoer fra databasen
 *  Funkjsonen kaller metoden "taVekkDatoer" for å gjøre "ulovelige" datoer ikke-klikkbare
 */ 
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

// Denne funksjonen tar i mot datoer å gjør dem ikke-klikkbare på bestill opphold 3 siden
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

// Denne funksjonen setter automatisk sluttDato etter startdato
function oppdaterSluttDato() {
    var start = new Date(startDato.value);
    var slutt = new Date(sluttDato.value);
    if (start >= slutt) { 
        slutt.setDate(start.getDate()+1);
        document.getElementById("sluttDato").valueAsDate = slutt; 
    }
}