var slideIndex = 1;
var slide_con = $('.slideshow-container');
var setTimer = "";


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
  if (n > slides.length) 
  {slideIndex = 1}    
  
  if (n < 1) 
  {slideIndex = slides.length}
  
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = 'none';
      //console.log(slides[i]);
    }
    
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  
  slides[slideIndex-1].style.display = 'block';  
  dots[slideIndex-1].className += " active";
}

function MoveShowSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimer = setTimeout(MoveShowSlides, 2000); // Change image every 2 seconds
}

function stopTimer(){
    clearTimeout(setTimer);
}

slide_con.mouseenter(function(){
    stopTimer();
});

slide_con.mouseleave(
    function(){
        MoveShowSlides();
    }
);

showSlides(slideIndex);
MoveShowSlides();