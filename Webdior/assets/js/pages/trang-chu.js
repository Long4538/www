document.addEventListener('DOMContentLoaded', function() {
  const buttons = document.querySelectorAll('.js-add-to-cart');
  if (buttons.length === 0) return;
  buttons.forEach(btn => {
    btn.addEventListener('click', function() {
      const productId = this.getAttribute('data-product-id');
      const fd = new FormData();
      fd.append('csrf_token', window.CART_CSRF || '');
      fd.append('product_id', productId);
      fd.append('quantity', '1');
      fetch('/Webdior/api/cart-add.php', { method: 'POST', body: fd, headers: { 'X-CSRF-Token': window.CART_CSRF || '' } })
        .then(r => r.json())
        .then(res => {
          if (res.requires_login) {
            window.location.href = '/Webdior/page/dang-nhap.php';
            return;
          }
          if (!res.success) {
            alert(res.message || 'Không thể thêm vào giỏ hàng');
            return;
          }
          const badge = document.querySelector('[data-cart-badge]');
          if (badge) badge.textContent = res.count ?? 0;
          this.classList.remove('btn-outline-dark');
          this.classList.add('btn-success');
          this.textContent = 'Đã thêm';
          setTimeout(() => {
            // Điều hướng sang giỏ hàng giống trang sản phẩm
            window.location.href = '/Webdior/page/gio-hang.php';
          }, 600);
        })
        .catch(() => alert('Lỗi mạng. Vui lòng thử lại.'));
    });
  });
});

