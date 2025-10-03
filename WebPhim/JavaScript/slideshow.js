// Khởi tạo chỉ số slide hiện tại là 1 (slide đầu tiên)
let slideIndex = 1;

// Gọi hàm hiển thị slide đầu tiên
showSlides(slideIndex);

// ----------------- Các hàm điều khiển -----------------

// Hàm chuyển slide bằng nút "Next" hoặc "Prev"
// n có thể là +1 (chuyển tới) hoặc -1 (quay lại)
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Hàm chọn slide bằng chấm tròn (dot)
// n là số thứ tự của slide được chọn
function currentSlide(n) {
  showSlides(slideIndex = n);
}

// ----------------- Hàm hiển thị slide -----------------

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides"); // Lấy tất cả slide
  let dots = document.getElementsByClassName("dot");       // Lấy tất cả chấm tròn

  // Nếu n lớn hơn số lượng slide thì quay về slide đầu
  if (n > slides.length) { slideIndex = 1 }

  // Nếu n nhỏ hơn 1 thì quay về slide cuối
  if (n < 1) { slideIndex = slides.length }

  // Ẩn toàn bộ slide
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }

  // Xóa class "active" khỏi tất cả chấm tròn
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }

  // Hiển thị slide hiện tại (theo slideIndex)
  slides[slideIndex - 1].style.display = "block";

  // Đánh dấu chấm tròn tương ứng với slide hiện tại
  dots[slideIndex - 1].className += " active";
}

// ----------------- Tự động chuyển slide -----------------

// Sau mỗi 3 giây sẽ tự động chuyển sang slide tiếp theo
setInterval(() => {
  plusSlides(1);
}, 3000);
