<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Menu Top CGV</title>
  <!-- <link rel="stylesheet" href="../Css/menu.css"> -->
  <link rel="stylesheet" href="../Css/style.css">
</head>
<body>
  <!-- Thanh menu top -->
  <nav class="topnav">
    <!-- Logo -->
    <div class="logo">
      <a href="../Index.php">
        <img src="../images/logo.png" alt="Logo CJ CGV">
      </a>
    </div>

    <!-- Menu items -->
    <ul>
      <li><a href="../Index.php">Trang chủ</a></li>
      <li><a href="../Page/phim.php">Phim</a></li>
      <li><a href="../Page/lienhe.php" class="active">Liên hệ</a></li>
      <li><a href="../Page/dangnhap.php">Đăng nhập</a></li>
      <li><a href="../Page/datve.php">Đặt vé</a></li>
    </ul>
  </nav>
    <!-- Header -->


  <!-- Contact Section -->
  <section class="contact-container">
    <div class="contact-form">
      <h2>Gửi tin nhắn cho chúng tôi</h2>
      <form>
        <label for="name">Họ và tên</label>
        <input type="text" id="name" placeholder="Nhập họ và tên của bạn">

        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Nhập địa chỉ email">

        <label for="phone">Số điện thoại</label>
        <input type="text" id="phone" placeholder="Nhập số điện thoại">

        <label for="subject">Tiêu đề</label>
        <input type="text" id="subject" placeholder="Nhập tiêu đề liên hệ">

        <label for="message">Nội dung</label>
        <textarea id="message" placeholder="Nhập nội dung liên hệ"></textarea>

        <button type="submit">Gửi liên hệ</button>
      </form>
    </div>

    <div class="contact-info">
      <div class="info-box">
        <h3>Địa chỉ</h3>
        <p>123 Đường Sắc Đẹp, Quận 1, TP. Hồ Chí Minh</p>
      </div>
      <div class="info-box">
        <h3>Điện thoại</h3>
        <p>0707 645 756</p>
      </div>
      <div class="info-box">
        <h3>Email</h3>
        <p>nguyenhuuha9091999@gmail.com</p>
      </div>
      <div class="info-box">
        <h3>Giờ làm việc</h3>
        <p>Thứ 2 - Thứ 6: 9:00 - 23:00</p>
        <p>Thứ 7 - Chủ nhật: 8:00 - 24:00</p>
      </div>
      <div class="info-box map">
        <h3>Bản đồ</h3>
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.505586103211!2d106.7004234153345!3d10.773374692322163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3f81f2fadb%3A0x7e9f3a3cf4b0a6a0!2zQ8O0bmcgVmnDqm4gU2FpZ29u!5e0!3m2!1svi!2s!4v1617873300000!5m2!1svi!2s" 
          width="100%" 
          height="200" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy">
        </iframe>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="footer-container">
      <div>
        <h4>Về chúng tôi</h4>
        <p>Câu chuyện của chúng tôi<br>Phát triển bền vững<br>Tuyển dụng</p>
      </div>
      <div>
        <h4>Chăm sóc khách hàng</h4>
        <p>Liên hệ<br>Vận chuyển & trả lại<br>Câu hỏi thường gặp</p>
      </div>
      <div>
        <h4>Theo dõi chúng tôi</h4>
        <p>Facebook | Instagram | YouTube</p>
      </div>
    </div>
  </footer>

    <script src="../Javascript/lienhe.js"></script>

</body>
</html>
