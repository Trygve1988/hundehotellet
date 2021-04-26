
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
  var paso = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15}$/;  
  //Denne linja er tatt fra https://www.w3resource.com/javascript/form/password-validation.php alt annet er mitt
  if(passord.value.match(paso)){
    status.innerHTML="Passord er godkjent";
    return true;
  } else{
    status.innerHTML="Passordet må være mellom 8-15 tegn inkludert speseiel tegn.";
    return false;
  } 
}

//Under utvikling!!!!!!

//Bilde slider og anmeldelse slider
var stopSlideShow = flase;
function slideShow(caller) {
  var interval = setInterval(function(){
    changeSlide('next');
  }, 3000);
}

function changeSlide(direction){
  var currentImg = $('.active');
  var nextImg = currentImg.next();
  var prevImg = currentImg.prev();

  if(direction == 'next') {
    if(nextImg.length){
      nextImg.addClas('active');
    } else {
      $('.slider img').first().addClas('active');
    }
  } else {
    if(prevImg.length) {
      prevImg.addClas('active');
    } else {
      $('slider img').last().addClas('active');
    }
  }

  currentImg.removeClass('active');

}

//Bildeslider v2
function imgSlider(anything){
  document.getElementById("slider").src = anything;
}

//hentet fra https://www.youtube.com/watch?v=y0XHdEeEevs

// Setter til dato 1 dag mer en fra dato
function tilDato(){
var x = document.getElementById("fraDato");
var y= document.getElementById("tilDato");
if(x.Value<=y.Value){
  y.Value = date.setDate(date.getDate() + 1);
} 
}

var slideIndex = 0;
showSlide();

function showSlide(){
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dots");
  for (i = 0; i<slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if(slideIndex > slides.length) {slideIndex = 1}
  for(i=0; i < dots.length; i++){
    dots[i].className = dots[i].className.replace("active","");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  setTimeout(showSlide,2000); //Bytter bilde hvert 2sekund 
}


function imgSlider(anything){
  document.getElementById("slider").src = anything;
}
//hentet fra https://www.youtube.com/watch?v=y0XHdEeEevs



