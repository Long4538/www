    // Lắng nghe sự kiện submit
    document.getElementById("contactForm").addEventListener("submit", function(e){
      e.preventDefault(); // Ngăn reload trang

      let name = document.getElementById("name").value;
      let email = document.getElementById("email").value;
      let phone = document.getElementById("phone").value;
      let subject = document.getElementById("subject").value;
      let message = document.getElementById("message").value;

      // Kiểm tra rỗng
      if(name === "" || email === "" || phone === "" || subject === "" || message === ""){
        alert("⚠️ Vui lòng nhập đầy đủ thông tin.");
      } else {
        alert("✅ Gửi liên hệ thành công!");
        this.reset(); // Xóa dữ liệu trong form
      }
    });