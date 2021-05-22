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
        setTimeout(function(){
            location.reload()
        }, 100);
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

// ************************** 9) admin **************************
var adminSeBrukertypeSelect = document.getElementById("adminSeBrukertypeSelect");

//er vi på Registrer deg siden ? 
if (adminSeBrukertypeSelect !== null) {
    adminSeBrukertypeSelect.addEventListener('change', settAdminSeBrukertypeSession, false);
}

function settAdminSeBrukertypeSession() {
    var brukertype = document.getElementById("adminSeBrukertypeSelect").value;
    console.log(brukertype);
    var ajaxRequest = new XMLHttpRequest();  
    ajaxRequest.open("GET", "include/settAdminSeBrukertypeSession.php?q="+brukertype, true);
    ajaxRequest.send(null);
    ajaxRequest.onreadystatechange = function() {
        var test = ajaxRequest.responseText;
        location.reload();
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
var loggInnTab      = ['Logg Inn','Sign In'];
var loggUtTab       = ['Logg ut', 'Logg out'];
var registrerDegTab  = ['Registrer Deg', 'Register'];
// step 1) lag en tabell
var admininOverskriftTab  = ['Admininstrer Brukere', 'Manage Users']; 
var omOssOverskriftTab  = ['Om oss', 'About Us'];
var omOssTextTab       = ['Bø Hundehotell holder til på Lektorvegen 91, i Bø i Telemark. Det er landelige omgivelser med store luftegårder, og fine turområder.Vi seks ansatt som jobber her på Bø Hundehotell, vi har vært i Hundehotell businessen i 6år, vi startet opp for først gang den 12.04.2010. Den gang var det barejeg og mannen min. Vi er alle hunde elskere på her på Bø Hundehotell, og eier eller er vant med hund fra før av. Din hund vil være trygg i våre hender. Vi håper vi ser deg og din hund her.','Bø Hundehotell is located at Lektorvegen 91, in Bø in Telemark. It is a rural setting with large airyards, and nice hiking areas. We six employees who work here at Bø Hundehotell, we have been in the Hundehotell business for 6 years, we started up for the first time on 12.04.2010. That time it was just me and my husband. We are all dog lovers here at Bø Hundehotell, and already own or are used to dogs. Your dog will be safe in our hands. We hope to see you and your dog here.' ];
var velkommenTab1     = ['Velkommen til Bø Hundehotell','Welcome to Bø Hundehotell'];
var velkommenTab2   = ['Norges BESTE Hundehotell for dine firbente venner','Norways BEST Dog Hotel for your four legged friends'];
var velkommenTab3   = ['Åpningstider: Man-Fre 8-18, Lør-Søn: 10-16','Opening hours: Mon-Fri 8-18, Sat-Sun: 10-16'];
var bestillTab      = ['Bestill','Order here'];
var indextTextTab1  = ['Her kan du bestille opphold til hunden(ene) dine.','Here you can book a stay for your dog (s).'];
var omHundehotelletTab = ['Om Hundehotellet','About Hundehotellet'];
var indextTextTab2  = ['Her kan du få mer info om Hundehotellet.','Here you can get more info about Hundehotellet.'];
var priserTab       = ['Priser','Prices'];
var indextTextTab3  = ['Her kan du se en oversikt over priser.','Here you can see an overview of prices.'];
var navnTab1        = ['Navn: Sansa Stark','Name: Sansa Stark'];
var navnTab2        = ['Navn: Jon Snow','Name: Jon Snow'];
var navnTab3        = ['Navn: Daenerys Targaryen','Name: Daenerys Targaryen'];
var navnTab4        = ['Navn: Eddard Stark','Name: Eddard Stark'];
var navnTab5        = ['Navn: Tyrion Lannister','Name: Tyrion Lannister'];
var navnTab6        = ['Navn: Aerys Targaryen','Name: Aerys Targaryen'];
var stillingTab1    = ['Stiling: Daglig leder','Position: General manager'];
var stillingTab2    = ['Stiling: Nestleder','Position: Deputy Chairman'];
var stillingTab3    = ['Stiling: Kontor-ansatt','Position: Office employee'];
var stillingTab4    = ['Stiling: Hundetrener','Position: Dog trainer'];
var stillingTab5    = ['Stiling: Ansatt','Position: Employee'];
var stillingTab6    = ['Stiling: Ansatt','Position: Employee'];
var prisTab         = ['Pris','Price'];
var informasjonTab  = ['Informasjon','Information'];
var prisTab1        = ['Pris pr dag for 1 hund','Price per day for 1 dog'];
var prisTab2        = ['Pris pr dag for 2 hunder','Price per day for 2 dogs'];
var prisTab3        = ['Pris pr dag for 3 hunder','Price per day for 3 dogs'];
var overSkriftTab1  = ['Ut-/Innsjekking:','Check out/Check inn:'];
var overSkriftTab2  = ['Mat:','Food:'];
var overSkriftTab3  = ['Seng:','Bed:'];
var overSkriftTab4  = ['Vaksinasjonsattest:','Vaccination certificate:'];
var overSkriftTab5  = ['Veterinær:','Veterinarian:'];
var overSkriftTab6  = ['Annet:','Other:'];
var infomasjonTab1 = ['Utsjekking mellom kl 09.00-12.00, Innsjekking mellom kl 12-00-16.00','Check-out between 09.00-12.00, Check-in between 12-00-16.00'];
var infomasjonTab2 = ['- Vi bruker Royal Canin og vom tilpasset hundens alder og aktivitestsnivå. Hvis du vil at hunden skal ha annen mat, vennligst ta kontakt.','- We use Royal Canin and rumen adapted to the dogs age and activity test level. If you want the dog to have other food, please get in touch.'];
var infomasjonTab3 = ['- Mat inngår i prisen på oppholdet.','- Food is included in the price'];
var infomasjonTab4 = ['- Ta gjerne med noe hunden kan ligge på for eksempel madrass eller teppe','- Feel free to bring something the dog can lie on, for example, a mattress or blanket'];
var infomasjonTab5 = ['- Vi har stort teppe til alle bur.','- We have large blankets for all our cages.'];
var infomasjonTab6 = ['- Det med fremvises gyldig Vaksinasjonsattest ved ankomst.','- A valid Vaccination Certificate is presented on arrival.'];
var infomasjonTab7 = ['- Attesten må være nyere enn 12 mnd.','- The certificate must be newer than 12 months.'];
var infomasjonTab8 = ['- Vi krever vaksinasjon mot valpesyke (parvo) og kennelhoste.','- We require vaccination against puppy disease (parvo) and kennel cough.'];
var infomasjonTab9 = ['Vi samarbeider med:','We work with:'];
var infomasjonTab10 = ['- Anicura Dyreklinkken i Telemark','- Anicura Dyreklinkken i Telemark'];
var infomasjonTab11 = ['- Seljord Vetrinærkontor AS','- Seljord Vetrinærkontor AS'];
var infomasjonTab12 = ['- Vi står ikke økonomisk ansvarlig for personlige eiendeler hunden har med seg hit.','- We are not financially responsible for personal belongings the dog brings here.'];
var infomasjonTab13 = ['- Vennligst ikke ta med ting du er redd for at kan bli ødelagt under oppholdet.','- Please do not bring things you are afraid of being damaged during your stay.'];
var navkontaktInformasjonTab = ['Kontaktinformasjon','Contact information']; 
var navEpostTab = ['Epost:','Email:']; 
var navAdresseTab = ['Adresse:','Address:'];
var navSosialMedierTab = ['Sosiale medier','Social media'];
var navBøskOssTab = ['Besøk oss','Visit Us'];
var navKlikkTab = ['Klikk her for å se kartet','Click here to see the map'];
var navSamerbeidTab = ['Samarbeidspartnere','Collaborators'];
var kontaktOssTab2 = ['Kontakt oss','Contact Us'];
var kontaktInfoTekstTab = ['Er det noe du lurer på er det bare å kontakte oss enten på mail eller telefon.','If you have any questions, just contact us either by email or phone.'];
var åpningstiderTab = ['Åpningstider: 08:00-18:00 man-tor (10-00-16:00 lør-søn)',"Opening hours: 08: 00-18: 00 Mon-Thu (10-00-16: 00 Sat-Sun)"];

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
var loggInnLink = document.getElementById("loggInnLink"); 
var loggUtLink  = document.getElementById("loggUtLink");
var registrerDegLink = document.getElementById("registrerDegLink");
// step 2) hent ut objektet som skal endre språk
var admininOverskrift = document.getElementById("admininOverskrift"); 
var omOssOverskrift = document.getElementById("omOssOverskrift");
var omOssText = document.getElementById("omOssText");
var velkommenNoText1 = document.getElementById("velkommenNoText1");
var velkommenNoText2 = document.getElementById("velkommenNoText2");
var velkommenNoText3 = document.getElementById("velkommenNoText3");
var bestill = document.getElementById("bestill");
var indextText1 = document.getElementById("indextText1");
var omHundehotellet = document.getElementById("omHundehotellet");
var indextText2 = document.getElementById("indextText2");
var priser = document.getElementById("priser");
var indextText3 = document.getElementById("indextText3");
var navn1 = document.getElementById("navn1");
var navn2 = document.getElementById("navn2");
var navn3 = document.getElementById("navn3");
var navn4 = document.getElementById("navn4");
var navn5 = document.getElementById("navn5");
var navn6 = document.getElementById("navn6");
var stilling1 = document.getElementById("stilling1");
var stilling2 = document.getElementById("stilling2");
var stilling3 = document.getElementById("stilling3");
var stilling4 = document.getElementById("stilling4");
var stilling5 = document.getElementById("stilling5");
var stilling6 = document.getElementById("stilling6");
var prisText = document.getElementById("prisText");
var informasjonText = document.getElementById("informasjonText");
var prisText1 = document.getElementById("prisText1");
var prisText2 = document.getElementById("prisText2");
var prisText3 = document.getElementById("prisText3");
var overSkrift1 = document.getElementById("overSkrift1");
var overSkrift2 = document.getElementById("overSkrift2");
var overSkrift3 = document.getElementById("overSkrift3");
var overSkrift4 = document.getElementById("overSkrift4");
var overSkrift5 = document.getElementById("overSkrift5");
var overSkrift6 = document.getElementById("overSkrift6");
var infomasjonText1 = document.getElementById("infomasjonText1");
var infomasjonText2 = document.getElementById("infomasjonText2");
var infomasjonText3 = document.getElementById("infomasjonText3");
var infomasjonText4 = document.getElementById("infomasjonText4");
var infomasjonText5 = document.getElementById("infomasjonText5");
var infomasjonText6 = document.getElementById("infomasjonText6");
var infomasjonText7 = document.getElementById("infomasjonText7");
var infomasjonText8 = document.getElementById("infomasjonText8");
var infomasjonText9 = document.getElementById("infomasjonText9");
var infomasjonText10 = document.getElementById("infomasjonText10");
var infomasjonText11 = document.getElementById("infomasjonText11");
var infomasjonText12 = document.getElementById("infomasjonText12");
var infomasjonText13 = document.getElementById("infomasjonText13");
var navkontaktInformasjon = document.getElementById("navkontaktInformasjon");
var navEpost = document.getElementById("navEpost");
var navAdresse = document.getElementById("navAdresse");
var navSosialMedier = document.getElementById("navSosialMedier");
var navBøskOss = document.getElementById("navBøskOss");
var navKlikk = document.getElementById("navKlikk");
var navSamerbeid = document.getElementById("navSamerbeid");
var kontaktOss = document.getElementById("kontaktOss");
var kontaktInfoTekst = document.getElementById("kontaktInfoTekst");
var åpningstider = document.getElementById('åpningstider');


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
if (loggInnLink !== null) {
    loggInnLink.innerHTML = loggInnTab[språk];
}
if (loggUtLink !== null) {
  loggUtLink.innerHTML = loggUtTab[språk];
}
if (registrerDegLink !== null) {
    registrerDegLink.innerHTML = registrerDegTab[språk];
}
// step 3) sett objektet til valgt språk i språktabellen
if (admininOverskrift !== null) {
    admininOverskrift.innerHTML = admininOverskriftTab[språk]; //test
}
if (omOssOverskrift !== null) {
    omOssOverskrift.innerHTML = omOssOverskriftTab[språk]; 
}
if (omOssText !== null) {
    omOssText.innerHTML = omOssTextTab[språk]; 
}
if (velkommenNoText1 !== null) {
    velkommenNoText1.innerHTML = velkommenTab1[språk]; 
}
if (velkommenNoText2 !== null) {
    velkommenNoText2.innerHTML = velkommenTab2[språk]; 
}
if (velkommenNoText3 !== null) {
    velkommenNoText3.innerHTML = velkommenTab3[språk]; 
}
if (bestill !== null) {
    bestill.innerHTML = bestillTab[språk]; 
}
if (indextText1 !== null) {
    indextText1.innerHTML = indextTextTab1[språk]; 
}
if (omHundehotellet !== null) {
    omHundehotellet.innerHTML = omHundehotelletTab[språk]; 
}
if (indextText2 !== null) {
    indextText2.innerHTML = indextTextTab2[språk]; 
}
if (priser !== null) {
    priser.innerHTML = priserTab[språk]; 
}navn1
if (indextText3 !== null) {
    indextText3.innerHTML = indextTextTab3[språk]; 
}
if (navn1 !== null) {
    navn1.innerHTML = navnTab1[språk]; 
}
if (navn2 !== null) {
    navn2.innerHTML = navnTab3[språk]; 
}
if (navn3 !== null) {
    navn3.innerHTML = navnTab3[språk]; 
}
if (navn4 !== null) {
    navn4.innerHTML = navnTab4[språk]; 
}
if (navn5 !== null) {
    navn5.innerHTML = navnTab5[språk]; 
}
if (navn6 !== null) {
    navn6.innerHTML = navnTab6[språk]; 
}
if (stilling1 !== null) {
    stilling1.innerHTML = stillingTab1[språk]; 
}
if (stilling2 !== null) {
    stilling2.innerHTML = stillingTab2[språk]; 
}
if (stilling3 !== null) {
    stilling3.innerHTML = stillingTab3[språk]; 
}
if (stilling4 !== null) {
    stilling4.innerHTML = stillingTab4[språk]; 
}
if (stilling5 !== null) {
    stilling5.innerHTML = stillingTab6[språk]; 
}
if (stilling6 !== null) {
    stilling6.innerHTML = stillingTab6[språk]; 
}
if (prisText !== null) {
    prisText.innerHTML = prisTab[språk]; 
} 
if (informasjonText !== null) {
    informasjonText.innerHTML = informasjonTab[språk]; 
}
if (prisText1 !== null) {
    prisText1.innerHTML = prisTab1[språk]; 
}
if (prisText2 !== null) {
    prisText2.innerHTML = prisTab2[språk]; 
}
if (prisText3 !== null) {
    prisText3.innerHTML = prisTab3[språk]; 
}
if (overSkrift1 !== null) {
    overSkrift1.innerHTML = overSkriftTab1[språk]; 
}
if (overSkrift2 !== null) {
    overSkrift2.innerHTML = overSkriftTab2[språk]; 
}
if (overSkrift3 !== null) {
    overSkrift3.innerHTML = overSkriftTab3[språk]; 
}
if (overSkrift4 !== null) {
    overSkrift4.innerHTML = overSkriftTab4[språk]; 
}
if (overSkrift5 !== null) {
    overSkrift5.innerHTML = overSkriftTab5[språk]; 
}
if (overSkrift6 !== null) {
    overSkrift6.innerHTML = overSkriftTab6[språk]; 
}
if (infomasjonText1 !== null) {
    infomasjonText1.innerHTML = infomasjonTab1[språk]; 
}
if (infomasjonText2 !== null) {
    infomasjonText2.innerHTML = infomasjonTab2[språk]; 
}
if (infomasjonText3 !== null) {
    infomasjonText3.innerHTML = infomasjonTab3[språk]; 
}
if (infomasjonText4 !== null) {
    infomasjonText4.innerHTML = infomasjonTab4[språk]; 
}
if (infomasjonText5 !== null) {
    infomasjonText5.innerHTML = infomasjonTab5[språk]; 
}
if (infomasjonText6 !== null) {
    infomasjonText6.innerHTML = infomasjonTab6[språk]; 
}
if (infomasjonText7 !== null) {
    infomasjonText7.innerHTML = infomasjonTab7[språk]; 
}
if (infomasjonText8 !== null) {
    infomasjonText8.innerHTML = infomasjonTab8[språk]; 
}
if (infomasjonText9 !== null) {
    infomasjonText9.innerHTML = infomasjonTab9[språk]; 
}
if (infomasjonText10 !== null) {
    infomasjonText10.innerHTML = infomasjonTab10[språk]; 
}
if (infomasjonText11 !== null) {
    infomasjonText11.innerHTML = infomasjonTab11[språk]; 
}
if (infomasjonText12 !== null) {
    infomasjonText12.innerHTML = infomasjonTab12[språk]; 
}
if (infomasjonText13 !== null) {
    infomasjonText13.innerHTML = infomasjonTab13[språk]; 
} 
if (navkontaktInformasjon !== null) {
    navkontaktInformasjon.innerHTML = navkontaktInformasjonTab[språk]; 
}
if (navEpost !== null) {
    navEpost.innerHTML = navEpostTab[språk]; 
} 
if (navAdresse !== null) {
    navAdresse.innerHTML = navAdresseTab[språk]; 
} 
if (navSosialMedier !== null) {
    navSosialMedier.innerHTML = navSosialMedierTab[språk]; 
} 
if (navBøskOss !== null) {
    navBøskOss.innerHTML = navBøskOssTab[språk]; 
}
if (navKlikk !== null) {
    navKlikk.innerHTML = navKlikkTab[språk];  
} 
if (navSamerbeid !== null) {
    navSamerbeid.innerHTML = navSamerbeidTab[språk];  
} 
if (kontaktOss !== null) {
    kontaktOss.innerHTML = kontaktOssTab2[språk];  
}
if (kontaktInfoTekst !== null) {
    kontaktInfoTekst.innerHTML = kontaktInfoTekstTab[språk];  
}
if (åpningstider !== null) {
    åpningstider.innerHTML = åpningstiderTab[språk];  
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

//Sjekker om man skriver inn passord
if(passord !== null) {
  passord.addEventListener('keyup', melding, false);
} 

function melding(){
  var paso = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15}$/; //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
  if(passord.value.match(paso)){
    status.innerHTML="Passord er godkjent";
    return true;
  } else{
    status.innerHTML="Mellom 8-15 tegn, minst 1 stor bokstav, og  minnst et speseielt tegn.";
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


// ********************** Slutt på hentet kode **********************

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