// ************************** 0) Alle getCookcie  ************************** 
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

// ********************* 0) navbar: spraakKnapp (Trygve)*********************
var spraakKnapp = document.getElementById("spraakKnapp");

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

// ********************* 0) Alle: globale spraak variabler (Even) ********************* 
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
var omOssOverskriftTab  = ['Om oss', 'About us'];
var omOssTextTab       = ['Bø Hundehotell holder til på Lektorvegen 91, i Bø i Telemark. Det er landelige omgivelser med store luftegårder, og fine turområder.Vi seks ansatt som jobber her på Bø Hundehotell, vi har vært i Hundehotell businessen i 6år, vi startet opp for først gang den 12.04.2010. Den gang var det barejeg og mannen min. Vi er alle hunde elskere på her på Bø Hundehotell, og eier eller er vant med hund fra før av. Din hund vil være trygg i våre hender. Vi håper vi ser deg og din hund her.','Bø Hundehotell is located at Lektorvegen 91, in Bø in Telemark. It is a rural setting with large airyards, and nice hiking areas. We six employees who work here at Bø Hundehotell, we have been in the Hundehotell business for 6 years, we started up for the first time on 12.04.2010. That time it was just me and my husband. We are all dog lovers here at Bø Hundehotell, and already own or are used to dogs. Your dog will be safe in our hands. We hope to see you and your dog here.' ];
var velkommenTab1     = ['Velkommen til Bø Hundehotell','Welcome to Bø Hundehotell'];
var velkommenTab2   = ['Norges BESTE Hundehotell for dine firbente venner','Norways BEST Dog Hotel for your four legged friends'];
var velkommenTab3   = ['Åpningstider: Man-Fre 8-18, Lør-Søn: 10-16','Opening hours: Mon-Fri 8-18, Sat-Sun: 10-16'];
var bestillTab1      = ['Bestill','Order here'];
var indextTextTab1  = ['Her kan du bestille opphold til hunden(ene) dine.','Here you can book a stay for your dog (s).'];
var omHundehotelletTab = ['Om Hundehotellet','About Hundehotellet'];
var indextTextTab2  = ['Her kan du få mer info om Hundehotellet.','Here you can get more info about Hundehotellet.'];
var priserTab1       = ['Priser','Prices'];
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
var infomasjonTab  = ['Utsjekking mellom kl 09.00-12.00','Check-out between 09.00-12.00'];
var infomasjonTab1 = ['Innsjekking mellom kl 12-00-16.00','Check-in between 12-00-16.00'];
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
var kontaktOssTab2 = ['Kontakt oss','Contact us'];
var kontaktInfoTekstTab = ['Er det noe du lurer på er det bare å kontakte oss enten på mail eller telefon.','If you have any questions, just contact us either by email or phone.'];
var åpningstiderTab = ['Åpningstider:',"Opening hours:"];
var åpningstider2Tab = ['08:00-18:00 Man-Tordag (10:00-16:00 Lør-Søndag)','08:00-18:00 Mon-Thuday (10:00-16:00 Sat-Sunday)'];
var epostTab = ['Epost:','Email:']; 
var adresseKontkatossTab = ['Adresse:','Address:'];
var bestillOppholdTab = ['Bestill opphold','Book a stay'];
var bestillOppholdTextTab = ['Bø Hundehotell har kapasitet til max 3 hunder i samme bur.','Bø Hundehotell has a capacity for a maximum of 3 dogs in the same cage.'];
var bestillOppholdTextTab2 = ['Vennligst bestill flere ganger hvis du ønsker å bestille opphold til flere en 3 hunder.','Please book several times if you want to book stays for more than 3 dogs.'];
var velgHunderTab = ['Velg hund(er):','Select dog (s):'];
var registerHundTab = ['Registrer ny hund','Register new dog'];
var bekreftTab = ['Kontroller at informasjon om hunden din er oppdatert:','Make sure your dogs information is up to date:'];
var hundNavnTab = ['Hundens navn:','The Dogs name:'];
var raseTab = ['Rase:','Race:'];
var fdatoTab = [' Fødselsdato:','Date of birth:'];
var kjønnTab = ['Kjønn:','Gender:'];
var hannTab = ['Hann','Male'];
var tispeTab = ['Tispe','Bitch'];
var sterilisertTab = ['Sterilisert:','Sterilized:'];
var jaTab = ['Ja','Yes'];
var neiTab = ['Nei','No'];
var løpeMedAndreTab = ['Løpe Med Andre:','Run With Others:'];
var forTypeTab = ['For type:','Dog food type:'];
var vanligTab = ['Royal Canin (vanlig)','Royal Canin (normal)'];
var allargiTab = ['Vom (allergi)','Vom (allergy)'];
var tidsperiodeTab = ['Tidsperiode','Time period'];
var fraTab = ['Fra','From'];
var tilTab = ['Til','To'];
var oppSummeringTab = ['Oppsummering','Summary'];
var hundTab = ['Hund(er):','Dog(s):'];
var datoTab = ['Dato:','Date:'];
var bestlingTab = ['Betaling','Payment'];
var kortholderTab = ['Korteier:','Cardowner:'];
var utløpsdatoTab = ['Utløpsdato:','Expiration date:'];
var kortNrTab = ['Kortnummer:','Card number:'];
var finneCVCTab = ['Hvor finner jeg CVC koden?','Where can I find the CVC code?'];
var vilkårTab = ['Kryss av for å godtavilkår:','Check to accept terms:'];
var passordTab = ['Passord:','Password:'];
var visPassordTab = ['Vis passord','Show password'];
var glemtPassordTab = ['Glemt passord','Forgot your password']; 
var aktueltTextTab = ['Her kan du lese om det som skjer på Bø Hundehotell.','Here you can read about what is happening at Bø Hundehotell.'];
var minSideTab = ['Min side','My side'];
var minProfilTab = ['Min profil','My profile'];
var minHunderTab = ['Mine hunder','My dogs'];
var registerNyBrukerTab = ['Registrer ny bruker','Register a new user'];
var forNavnRegisterDegTab = ['Fornavn:','First name:'];
var etterNavnRegisterDegTab = ['Etternavn:','Surname:'];
var fødselsdatoRegistrerDegTab = ['Fødselsdato:','Date of birth:'];
var adresseRegistrerDegTab = ['Adresse:','Address:'];
var passordRegisterDegTab = ['Ønsket passord:','Password:'];
var pasokravRegisterDegTab = ['Passord krav:','Password requirements:'];
var gjentaPasoRegisterDegTab = ['Gjenta passord:','Repeat Password:'];
var tlfRegisterDegTab = ['Telefonnummer:','Phone number:'];
var avBestillTab = ['Avbestill opphold','Cancel stay'];
var avBestillTextTab = ['Opphold kan avbestilles inntill 24 timer før oppholdet starter.','Stays can be canceled up to 24 hours before the stay starts.'];
var velgOppholdAvbestillTab = ['Velg opphold:','Select stay:'];
var skrivAnmeldelseTab = ['Skriv anmeldelse','Write a review'];
var slettHundTab = ['Slett hund','Delete dog'];
var slettHundTextTab = ['Denne siden er under arbeid. Du kan for øyeblikket bare slette hunder som ikke har opphold.','This page is under construction. You can currently only delete non-resident dogs.'];
var endreHundTab = ['Endre hund:','Change dog:'];
var velgHundMinTab = ['Velg hund:','Select dog:'];
var ektraInfoTab = ['Ekstra info:','Additional info:'];
var minEndreBrukerInfoTab = ['Endre brukerinformasjon','Change user information'];
var minFornavnTab = ['Fornavn:','First name:'];
var minEtternavnTab = ['Etternavn:','Surname:'];
var minAdresseTab = ['Adresse:','Address:'];
var mailTab = ['Epost:','Email:'];
var endrePassordTab = ['Endre passord','Change password'];
var gammeltPassordTab = ['Gammelt passord:','Old password:'];
var nyttPassordTab = ['Nytt passord:','New password:'];
var slettBrukerTab = ['Slett bruker','Delete user'];
var slettBrukerText1Tab = ['Du må avbestille eventuelle fremtidige opphold før du kan slette kontoen din.',"You must cancel any future stays before you can delete your account."];
var slettBrukerText2Tab = ['Det er mulig å gjenopprette kontoen innen 30 dager er gått. Etter dette blir kontoen slettet.','It is possible to recover the account within 30 days. After this, the account will be deleted.'];
var slettBrukerText3Tab = ['Er det noe du lurer på i forhold til sletting av konto, kontakt oss på epost','If there is anything you are wondering about in relation to deleting an account, contact us by email'];
var bekreftSlettingTab = ['Bekreft sletting av bruker','Confirm user deletion'];
var bekreftSlettingTextTab = ['Er du sikker på at du vil slette brukeren din?','Are you sure you want to delete your user?'];
var bekreftelseBestillingTab = ['Din bestilling er nå mottatt!','Your order has been received'];
var bekreftBestillingTextTab = ['Du kan sjekke bestillingen på','You can check your order at'];
var bekreftMinSideTab = ['Min Side','My side'];
var bekreftBestillingText2Tab = ['Har du noe spørsmål angående oppholdet kan du ta kontakt med oss enten på tlf +4712345678','If you have any questions regarding the stay, you can contact us either on tel +4712345678'];
var bekreftBestillingText3Tab = ['eller','or'];
var harDuKontoRegisterDegTab = ['Har du allerede en bruker? Logg inn her','Do you already have a user? Log her in'];

//får tak i valgt språk fra spraak cookien (Trygve)
var språk = getCookie('spraak'); // 0 Norsk, 1 engelsk
if(!språk) {
    språk = 0;  
}

//setter objekter til valgt språk (Even)
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
var infomasjonText = document.getElementById("infomasjonText");
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
var åpningstider = document.getElementById("åpningstider");
var åpningstider2 = document.getElementById("åpningstider2");
var epost = document.getElementById("epost");
var adresseKontkatoss = document.getElementById("adresseKontkatoss");
var bestillOpphold = document.getElementById("bestillOpphold");
var bestillOppholdText = document.getElementById("bestillOppholdText");
var bestillOppholdText2 = document.getElementById("bestillOppholdText2");
var velgHunder = document.getElementById("velgHunder");
var registerHund = document.getElementById("registerHund");
var bestillOpphold2 = document.getElementById("bestillOpphold2");
var bekreft = document.getElementById("bekreft");
var hundNavn = document.getElementById("hundNavn");
var rase = document.getElementById("rase");
var fdato = document.getElementById("fdato");
var kjønn = document.getElementById("kjønn");
var hann = document.getElementById("hann");
var hann2 = document.getElementById("hann2");
var tispe = document.getElementById("tispe");
var tispe2 = document.getElementById("tispe2");
var sterilisert = document.getElementById("sterilisert");
var ja = document.getElementById("ja");
var ja2 = document.getElementById("ja2");
var nei = document.getElementById("nei");
var nei2 = document.getElementById("nei2");;
var løpeMedAndre = document.getElementById("løpeMedAndre");
var forType = document.getElementById("forType");
var vanlig = document.getElementById("vanlig");
var vanlig2 = document.getElementById("vanlig2");
var allargi = document.getElementById("allargi");
var allargi2 = document.getElementById("allargi2");
var bestillOpphold3 = document.getElementById("bestillOpphold3");
var tidsperiode = document.getElementById("tidsperiode");
var fra = document.getElementById("fra");
var til = document.getElementById("til");
var bestillOpphold4 = document.getElementById("bestillOpphold4");
var oppSummering = document.getElementById("oppSummering");
var hund = document.getElementById("hund");
var dato = document.getElementById("dato");
var bestling = document.getElementById("bestling");
var kortholder = document.getElementById("kortholder");
var utløpsdato = document.getElementById("utløpsdato");
var kortNr = document.getElementById("kortNr");
var finneCVC = document.getElementById("finneCVC");
var vilkår = document.getElementById("vilkår");
var loggInn = document.getElementById("loggInn");
var epostLoggInn = document.getElementById("epostLoggInn");
var passordloggInn = document.getElementById("passordloggInn");
var visPassordLogInn = document.getElementById("visPassordLogInn");
var glemtPassord = document.getElementById("glemtPassord");
var registrerDeg = document.getElementById("registrerDeg");
var aktuelt = document.getElementById("aktuelt");
var aktueltText = document.getElementById("aktueltText");
var minSide = document.getElementById("minSide");
var minProfil = document.getElementById("minProfil");
var minHunder = document.getElementById("minHunder");
var velgHundMinSide = document.getElementById("velgHundMinSide");
var påGåendeOpphold = document.getElementById("påGåendeOpphold");
var registerNyBruker = document.getElementById("registerNyBruker");
var forNavnRegisterDeg = document.getElementById("forNavnRegisterDeg");
var etterNavnRegisterDeg = document.getElementById("etterNavnRegisterDeg");
var fødselsdatoRegistrerDeg = document.getElementById("fødselsdatoRegistrerDeg");
var adresseRegistrerDeg = document.getElementById("adresseRegistrerDeg");
var epostReigsterDeg = document.getElementById("epostReigsterDeg");
var nyttPassord = document.getElementById("nyttPassord");
var visPassordRegisterDeg = document.getElementById("visPassordRegisterDeg");
var pasokravRegisterDeg = document.getElementById("pasokravRegisterDeg");
var gjentaPasoRegisterDeg = document.getElementById("gjentaPasoRegisterDeg");
var tlfRegisterDeg = document.getElementById("tlfRegisterDeg");
var avBestill = document.getElementById("avBestill");
var avBestillText = document.getElementById("avBestillText");
var velgOppholdAvbestill = document.getElementById("velgOppholdAvbestill");
var skrivAnmeldelse = document.getElementById("skrivAnmeldelse");
var slettHund = document.getElementById("slettHund");
var slettHundText = document.getElementById("slettHundText");
var endreHund = document.getElementById("endreHund");
var velgHundMin = document.getElementById("velgHundMin");
var ektraInfo = document.getElementById("ektraInfo");
var minEndreBrukerInfo = document.getElementById("minEndreBrukerInfo");
var minFornavn = document.getElementById("minFornavn");
var minEtternavn = document.getElementById("minEtternavn");
var minAdresse = document.getElementById("minAdresse");
var mail = document.getElementById("mail");
var endrePassord = document.getElementById("endrePassord");
var gammeltPassord = document.getElementById("gammeltPassord");
var visPassord = document.getElementById("visPassord");
var nyttPassord = document.getElementById("nyttPassord");
var passordKrav = document.getElementById("passordKrav");
var visPassordRegisterDeg = document.getElementById("visPassordRegisterDeg");
var slettBruker = document.getElementById("slettBruker");
var slettBrukerText1 = document.getElementById("slettBrukerText1");
var slettBrukerText2 = document.getElementById("slettBrukerText2");
var slettBrukerText3 = document.getElementById("slettBrukerText3");
var bekreftSletting = document.getElementById("bekreftSletting");
var bekreftSlettingText = document.getElementById("bekreftSlettingText");
var bekreftelseBestilling = document.getElementById("bekreftelseBestilling");
var bekreftBestillingText = document.getElementById("bekreftBestillingText");
var bekreftMinSide = document.getElementById("bekreftMinSide");''
var bekreftBestillingText2 = document.getElementById("bekreftBestillingText2");
var bekreftBestillingText3 = document.getElementById("bekreftBestillingText3");

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
    bestill.innerHTML = bestillTab1[språk]; 
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
    priser.innerHTML = priserTab1[språk]; 
}
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
if (infomasjonText !== null) {
    infomasjonText.innerHTML = infomasjonTab[språk]; 
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
if (åpningstider2 !== null) {
    åpningstider2.innerHTML = åpningstider2Tab[språk];  
} 
if (epost !== null) {
    epost.innerHTML = epostTab[språk];  
} 
if (adresseKontkatoss !== null) {
    adresseKontkatoss.innerHTML = adresseKontkatossTab[språk];  
} 
if (bestillOpphold !== null) {
    bestillOpphold.innerHTML = bestillOppholdTab[språk];  
}
if (bestillOppholdText !== null) {
    bestillOppholdText.innerHTML = bestillOppholdTextTab[språk];  
} 
if (bestillOppholdText2 !== null) {
    bestillOppholdText2.innerHTML = bestillOppholdTextTab2[språk];  
} 
if (velgHunder !== null) {
    velgHunder.innerHTML = velgHunderTab[språk];  
}
if (registerHund !== null) {
    registerHund.innerHTML = registerHundTab[språk];  
}
if (bestillOpphold2 !== null) {
    bestillOpphold2.innerHTML = bestillOppholdTab[språk];  
} 
if (bekreft !== null) {
    bekreft.innerHTML = bekreftTab[språk];  
} 
if (hundNavn !== null) {
    hundNavn.innerHTML = hundNavnTab[språk];  
} 
if (rase !== null) {
    rase.innerHTML = raseTab[språk];  
} 
if (fdato !== null) {
    fdato.innerHTML = fdatoTab[språk];  
} 
if (kjønn !== null) {
    kjønn.innerHTML = kjønnTab[språk];  
}
if (hann !== null) {
    hann.innerHTML = hannTab[språk];  
}
if (hann2 !== null) {
    hann2.innerHTML = hannTab[språk];  
}
if (tispe !== null) {
    tispe.innerHTML = tispeTab[språk];  
} 
if (tispe2 !== null) {
    tispe2.innerHTML = tispeTab[språk];  
}
if (sterilisert !== null) {
    sterilisert.innerHTML = sterilisertTab[språk];  
}
if (ja !== null) {
    ja.innerHTML = jaTab[språk];  
}
if (ja2 !== null) {
    ja2.innerHTML = jaTab[språk];  
}
if (nei !== null) {
    nei.innerHTML = neiTab[språk];  
}
if (nei2 !== null) {
    nei2.innerHTML = neiTab[språk];  
}
if (løpeMedAndre !== null) {
    løpeMedAndre.innerHTML = løpeMedAndreTab[språk];  
} 
if (forType !== null) {
    forType.innerHTML = forTypeTab[språk];  
}
if (vanlig !== null) {
    vanlig.innerHTML = vanligTab[språk];  
}
if (vanlig2 !== null) {
    vanlig2.innerHTML = vanligTab[språk];  
}
if (allargi !== null) {
    allargi.innerHTML = allargiTab[språk];  
}
if (allargi2 !== null) {
    allargi2.innerHTML = allargiTab[språk];  
}
if(ektraInfo !== null) {
    ektraInfo.innerHTML = ektraInfoTab[språk];
}
if (bestillOpphold3 !== null) {
    bestillOpphold3.innerHTML = bestillOppholdTab[språk];
    tidsperiode.innerHTML = tidsperiodeTab[språk];
    fra.innerHTML = fraTab[språk];
    til.innerHTML = tilTab[språk];
}
if(bestillOpphold4 !== null) {
    bestillOpphold4.innerHTML = bestillOppholdTab[språk];
    oppSummering.innerHTML = oppSummeringTab[språk];
    hund.innerHTML = hundTab[språk];
    dato.innerHTML = datoTab[språk];
    bestling.innerHTML = bestlingTab[språk];
    kortholder.innerHTML = kortholderTab[språk];
    utløpsdato.innerHTML = utløpsdatoTab[språk];
    kortNr.innerHTML = kortNrTab[språk];
    finneCVC.innerHTML = finneCVCTab[språk];
    vilkår.innerHTML = vilkårTab[språk];
}
if(loggInn !== null) {
    loggInn.innerHTML = loggInnTab[språk];
    epostLoggInn.innerHTML = epostTab[språk];
    passordloggInn.innerHTML = passordTab[språk];
    visPassordLogInn.innerHTML = visPassordTab[språk];
    glemtPassord.innerHTML = glemtPassordTab[språk];
    registrerDeg.innerHTML = registrerDegTab[språk];
}
if(aktuelt !== null){
    aktuelt.innerHTML = aktueltTab[språk];
    aktueltText.innerHTML = aktueltTextTab[språk];
}
if(minSide !== null) {
    minSide.innerHTML = minSideTab[språk];
    minProfil.innerHTML = minProfilTab[språk];
    minHunder.innerHTML = minHunderTab[språk];
    velgHundMinSide.innerHTML = velgHunderTab[språk];
}
if(registerNyBruker !== null){
    registerNyBruker.innerHTML = registerNyBrukerTab[språk];
    forNavnRegisterDeg.innerHTML = forNavnRegisterDegTab[språk];
    etterNavnRegisterDeg.innerHTML = etterNavnRegisterDegTab[språk];
    fødselsdatoRegistrerDeg.innerHTML = fødselsdatoRegistrerDegTab[språk];
    adresseRegistrerDeg.innerHTML = adresseRegistrerDegTab[språk]; 
    epostReigsterDeg.innerHTML = epostTab[språk];
    nyttPassord.innerHTML = nyttPassordTab[språk];
    visPassordRegisterDeg.innerHTML = visPassordTab[språk];
    pasokravRegisterDeg.innerHTML = pasokravRegisterDegTab[språk];
    gjentaPasoRegisterDeg.innerHTML = gjentaPasoRegisterDegTab[språk];
    tlfRegisterDeg.innerHTML = tlfRegisterDegTab[språk];
    harDuKontoRegisterDeg.innerHTML = harDuKontoRegisterDegTab[språk];
}
if(avBestill !== null){
    avBestill.innerHTML = avBestillTab[språk];
    avBestillText.innerHTML = avBestillTextTab[språk];
    velgOppholdAvbestill.innerHTML = velgOppholdAvbestillTab[språk];
}
if(skrivAnmeldelse !== null) {
    skrivAnmeldelse.innerHTML = skrivAnmeldelseTab[språk];
}
if(slettHund !== null) {
    slettHund.innerHTML = slettHundTab[språk];
    slettHundText.innerHTML = slettHundTextTab[språk];
}
if(endreHund !== null) {
    endreHund.innerHTML = endreHundTab[språk];
    velgHundMin.innerHTML = velgHundMinTab[språk];
}
if(minEndreBrukerInfo !== null){
    minEndreBrukerInfo.innerHTML = minEndreBrukerInfoTab[språk];
    minFornavn.innerHTML = minFornavnTab[språk];
    minEtternavn.innerHTML = minEtternavnTab[språk];
    minAdresse.innerHTML = minAdresseTab[språk];
    mail.innerHTML = mailTab[språk];
}
if(endrePassord !== null) {
    endrePassord.innerHTML = endrePassordTab[språk];
    gammeltPassord.innerHTML = gammeltPassordTab[språk];
    visPassord.innerHTML = visPassordTab[språk];
    visPassordRegisterDeg.innerHTML = visPassordTab[språk];
    nyttPassord.innerHTML = nyttPassordTab[språk];
    passordKrav.innerHTML = pasokravRegisterDegTab[språk];
}
if(slettBruker !== null) {
    slettBruker.innerHTML = slettBrukerTab[språk];
    slettBrukerText1.innerHTML = slettBrukerText1Tab[språk];
    slettBrukerText2.innerHTML = slettBrukerText2Tab[språk];
    slettBrukerText3.innerHTML = slettBrukerText3Tab[språk];
}
if(bekreftSletting !== null) {
    bekreftSletting.innerHTML = bekreftSlettingTab[språk];
    bekreftSlettingText.innerHTML = bekreftSlettingTextTab[språk];
}
if(bekreftelseBestilling !==null){
    bekreftelseBestilling.innerHTML = bekreftelseBestillingTab[språk];
    bekreftBestillingText.innerHTML = bekreftBestillingTextTab[språk];
    bekreftMinSide.innerHTML = bekreftMinSideTab[språk];
    bekreftBestillingText2.innerHTML = bekreftBestillingText2Tab[språk];
    bekreftBestillingText3.innerHTML = bekreftBestillingText3Tab[språk];
}