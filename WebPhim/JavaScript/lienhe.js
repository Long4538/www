// Chờ DOM load xong mới chạy
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".contact-form form");
  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault(); // Ngăn reload trang

      // Lấy giá trị từ input
      const name = document.getElementById("name").value.trim();
      const email = document.getElementById("email").value.trim();
      const phone = document.getElementById("phone").value.trim();
      const subject = document.getElementById("subject").value.trim();
      const message = document.getElementById("message").value.trim();

      // Regex kiểm tra email và số điện thoại
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const phoneRegex = /^[0-9]{8,15}$/;

      let errors = [];

      if (name === "") errors.push("⚠️ Vui lòng nhập họ và tên.");
      if (!emailRegex.test(email)) errors.push("⚠️ Email không hợp lệ.");
      if (!phoneRegex.test(phone)) errors.push("⚠️ Số điện thoại phải từ 8-15 chữ số.");
      if (subject === "") errors.push("⚠️ Vui lòng nhập tiêu đề.");
      if (message === "") errors.push("⚠️ Vui lòng nhập nội dung.");

      // Hiển thị kết quả
      if (errors.length > 0) {
        alert(errors.join("\n"));
      } else {
        alert("✅ Gửi liên hệ thành công!\nChúng tôi sẽ phản hồi sớm nhất có thể.");
        form.reset(); // Xóa nội dung form sau khi gửi
      }
    });
  }
});
