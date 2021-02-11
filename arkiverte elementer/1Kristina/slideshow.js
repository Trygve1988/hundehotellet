var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides"); //Deklarer slides og Henter klasse elementet mySlides
    var dotter = document.getElementsByClassName("dott"); // Deklarer dotter og henter klasse elementet dott
    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dotter.length; i++) {
        dotter[i].className = dotter[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dotter[slideIndex - 1].className += " active";
}

// Gjør slideshow automatisk
/*var slideIndex = 0;
showSlides();

function showSlides() {
    var j;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (j = 0; j < slides.length; j++) {
        slides[j].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 }
    for (j = 0; j < dots.length; j++) {
        dots[j].className = dots[j].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
    setTimeout(showSlides, 5000); // Change image every 2 seconds
}

*/