/**
 *  Denne klassen har funksjonalitet for å la en bruker velge 
 *  en av sine hunder og få opp info om hunden
 *  @author Trygve Johannessen
 */

var velgMinSideHundSelect = document.getElementById("velgMinSideHundSelect");

velgMinSideHundSelect.addEventListener('change', settMinSideHundSession, false);

/**
 *  Denne funksjonen kjører et ajax kall til php scriptet som setter hunden som brukeren
 *  har valgt i select boksen og lagrer den som en sesionsvariabelen "minSideHund"
 */
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