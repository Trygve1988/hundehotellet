/**
 *  Denne siden har funksjonalitet for å la en admin-bruker 
 *  velge brukertype som skal administreres
 */

// variabel med referanse til select boksen
var adminSeBrukertypeSelect = document.getElementById("adminSeBrukertypeSelect");

// Lytter som registrerer
adminSeBrukertypeSelect.addEventListener('change', settAdminSeBrukertypeSession, false);

/**
 *  Denne funksjonen kjører et ajax kall til php scriptet som setter brukertypen som admin-brukeren
 *  har valgt i select boksen og lagrer den som en sesionsvariabelen "adminSeBrukertype"
 */
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

