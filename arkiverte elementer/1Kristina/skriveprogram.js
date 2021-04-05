/*Endret variabler funksjoner og endret navnene til norsk
*/

// Lager variablene Viserkildekode og iRedigeringsmodus til funksjonen ToggleSource,
// kan evt fjernes uten at det påvirker resten av programmet
let viserKildeKode = false;
let iRedigeringsModus = true;

// Lager en funksjon som gjør at knappene aktiveres når den trykkes på.
function aktiverRedigeringsmodus() {
    richTextFelt.document.designMode = "On";

}
// Funkjsonen kaller på knappene når de blir trykket på
function execCmd (command) { // Kaller på alle knappene som innholder execCmd i skriveprogram.html
    richTextFelt.document.execCommand(command, false, null); //Kaller på iframen richTextFelt i skriveprogram.html
}

function execCommandWithArg (command, arg) {  // Kaller på alle knappene som innholder execCommandWithArg i skriveprogram.html
    richTextFelt.document.execCommand(command, false, arg); //Kaller på iframen richTextFelt i skriveprogram.html 
}

/*Usikker om vi trenger "toggle Source" dette kan  evt fjernes uten at det påvirker resten av programmet*/
function toggleSource () {
    if(viserKildeKode) {
        richTextFelt.document.getElementByTagName('body')[0].innerHTML = richTextFelt.document.getElementByTagName('body')[0].
        tekstInnhold;
        viserKildeKode = false;
    } else {
        richTextFelt.document.getElementByTagName('body')[0].tekstInnhold = richTextFelt.document.getElementByTagName('body')[0].
        innerHTML;
        viserKildeKode = true;
    }
}

function toggleEdit () {
    if (iRedigeringsModus){
        richTextFelt.document.designMode ='Off';
        iRedigeringsModus = false;
    }else{
        richTextFelt.document.designMode ='On';
        iRedigeringsModus = true;
    }
    
}
    