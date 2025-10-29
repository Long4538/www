
<?php
require_once __DIR__ . "/../../controller/UserController.php";
$controller = new UserController();
$controller->handleRegister();
?>
  <div class="auth-container">
    <div class="auth-box">
      <img src="../view/images/header/header-logo.png" alt="Bitis Logo" class="logo-login">

      <h2>Đăng ký</h2>

      <form action="" method="post">
        <div class="form-group">
          <label for="name">Họ và tên</label>
          <input type="text" id="full_name" name="full_name" placeholder="Nhập tên đăng nhâp" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Nhập email" required>
        </div>

        <div class="form-group">
          <label for="password">Mật khẩu</label>
          <input type="password" id="password" name="password" placeholder="Tạo mật khẩu" required>
        </div>

        <div class="form-group">
          <label for="confirm">Nhập lại mật khẩu</label>
          <input type="password" id="confirm" name="confirm" placeholder="Xác nhận mật khẩu" required>
        </div>

        <button type="submit" class="btn">Đăng ký</button>

        <p class="redirect">Đã có tài khoản? 
          <a href="index.php?act=login" class="redirect-link">Đăng nhập</a>
        </p>

        <div style="text-align:center;margin-top:24px;">
          <a href="../index.php" class="home-link">
            &larr; Trở về trang chủ
          </a>
        </div>
      </form>
    </div>
  </div>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>

