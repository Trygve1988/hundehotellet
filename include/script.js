/**
 *  Denne klassen inneholder forsjellige javasrict funksjoner 
 *  Skrevet av Trygve, Gunn Inger, Even, Kristina med untak av der vi har oppgitt andre kilder
 */ 


// ************************** 0) Alle Sider (Trygve) **************************

/**
 *  Denne funksjonen tar i mot navnet på en coockie og returnerer verdien til coockien
 *  @param      String      cname       navnet på en coockie
 *  @return     String      cvalue      verdien til coockien
 *  @author     w3schools 
 */ 
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

/**
/*  Denne funksjonen sletter cookies som blir brukt på bestillOpphold.php siden
 *  når brukeren IKKE er på denne siden
 */ 
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



// ************************** 4) ansattHund (Trygve) **************************
// Denne siden har funksjonalitet for å la en ansatt velge en hund som er 
// på opphold og få opp info om hunden og om oppholdet

var velgInspiserHundSelect = document.getElementById("velgInspiserHundSelect");

//er vi på ansattHund siden ? 
if (velgInspiserHundSelect !== null) {
    velgInspiserHundSelect.addEventListener('change', settInspiserHundSession, false);
}

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



// ************************** minSide: settMinSideHundSession (Trygve) **************************
// Denne siden har funksjonalitet for å la en bruker velge en av sine hunder og få opp info om hunden

var velgMinSideHundSelect = document.getElementById("velgMinSideHundSelect");

//er vi på minSide? 
if (velgMinSideHundSelect !== null) {
    velgMinSideHundSelect.addEventListener('change', settMinSideHundSession, false);
}

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



// ************************** 9) admin (Trygve) **************************
// Denne siden har funksjonalitet for å la en admin-bruker velge brukertype som skal administreres

var adminSeBrukertypeSelect = document.getElementById("adminSeBrukertypeSelect");

//er vi på admin siden ? 
if (adminSeBrukertypeSelect !== null) {
    adminSeBrukertypeSelect.addEventListener('change', settAdminSeBrukertypeSession, false);
}

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
  var paso = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,15}$/; //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
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
    var paso = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,15}$/; //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
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
  var paso = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,15}$/; //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
  if(passord2.value.match(paso) ){
    nystatus.innerHTML="Passord er godkjent";
    nystatus.innerHTML=" ";
    return true;
  } else{
    nystatus.innerHTML="Mellom 8-15 tegn. Minst ett tall, stor bokstav, liten bokstav, spesial tegn(@% osv).";
    return false;
  } 
}
  
// Engelsk tilbakemelding 
function nyTTPasomelding2(){
    var paso = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,15}$/; //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
    if( passord2.value.match(paso) ){
      nystatus2.innerHTML="Password has been approved";
      nystatus3.innerHTML=" ";
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
