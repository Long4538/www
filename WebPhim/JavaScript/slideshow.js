let slideIndex = 1;
showSlides(slideIndex);

// Điều hướng bằng nút
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Điều hướng bằng chấm
function currentSlide(n) {
  showSlides(slideIndex = n);
}

// Hiển thị slide
function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
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

// Tự động chuyển slide sau 4s
setInterval(() => {
  plusSlides(1);
}, 4000);
