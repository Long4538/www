// Hỗ trợ submenu trên mobile: nhấn vào item có submenu để mở/đóng
document.addEventListener('DOMContentLoaded', function () {
  var dropdownSubmenus = document.querySelectorAll('.dropdown-submenu > a.dropdown-toggle');
  dropdownSubmenus.forEach(function (el) {
    el.addEventListener('click', function (e) {
      var nextMenu = this.nextElementSibling;
      if (nextMenu && window.getComputedStyle(nextMenu).display === 'none') {
        e.preventDefault();
        // Đóng các submenu cùng cấp trước khi mở cái mới
        var siblings = this.parentElement.parentElement.querySelectorAll('.dropdown-menu');
        siblings.forEach(function (m) { if (m !== nextMenu) m.style.display = 'none'; });
        nextMenu.style.display = 'block';
      }
    });
  });

  // Đóng submenu khi dropdown chính đóng
  document.querySelectorAll('.dropdown').forEach(function (dd) {
    dd.addEventListener('hide.bs.dropdown', function () {
      this.querySelectorAll('.dropdown-menu').forEach(function (m) { m.style.display = ''; });
    });
  });
});


