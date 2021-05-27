/**
 *  Denne siden har funksjonalitet for å la en ansatt velge en hund som er 
 *  på opphold og få opp info om hunden og om oppholdet
 */

 var velgInspiserHundSelect = document.getElementById("velgInspiserHundSelect");

 velgInspiserHundSelect.addEventListener('change', settInspiserHundSession, false);
 
 /**
  *  Denne funksjonen kjører et ajax kall til php scriptet som setter hunden som ansatt-brukeren 
  *  har valgt i select boksen og lagrer den som en sesionsvariabelen "inspiserHund"
  */
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