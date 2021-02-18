
// Hvis skjul passord funksjon
function visPassord() {
    var x = document.getElementById("passord");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
} 

//Passord validation
const passord = document.querySelector("#passord");
const status = document.querySelector("#status");

passord.addEventListener('keyup', melding, false);

function melding(){
  if(passord.value.length >= 8){
    status.innerHTML="Passord er godkjent";
    return true;
  } else{
    status.innerHTML="Passord er ikke godkjent lite";
  } 
}


//Under utvikling!!!!!!

if(passord.includes(/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/)){
  status.innerHTML="Passord er godkjent";
}
else{
  status.innerHTML="Passord er ikke godkjent";
}

// Setter til dato 1 dag mer en fra dato
function tilDato(){
  var x = document.getElementById("fraDato");
  var y= document.getElementById("tilDato");
  if(x.Value<=y.Value){
    y.Value = date.setDate(date.getDate() + 1);
  } 
}



