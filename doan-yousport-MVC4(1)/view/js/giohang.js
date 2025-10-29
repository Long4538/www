// giohang.js
// Tương tác: tăng/giảm, tính tổng động, popup xác nhận xóa

document.addEventListener('DOMContentLoaded', function () {
    const cartTable = document.getElementById('cart-table');
    const summaryCount = document.getElementById('summary-count');
    const summarySubtotal = document.getElementById('summary-subtotal');
    const summaryDiscount = document.getElementById('summary-discount');
    const summaryTotal = document.getElementById('summary-total');
    const summaryShipping = document.getElementById('summary-shipping');
  
    // Modal
    const modal = document.getElementById('confirm-modal');
    const modalCancel = modal.querySelector('.modal-cancel');
    const modalConfirm = modal.querySelector('.modal-confirm');
  
    let pendingDeleteRow = null; // hàng sắp xóa
  
    // Helper: format số > "1.200.000đ"
    function formatVND(number) {
      return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + 'đ';
    }
  
    // Helper: parse giá từ data-price (number) hoặc text như "1.200.000đ"
    function parseVNDFromData(value) {
      // value expected to be number or numeric string
      return parseInt(value, 10) || 0;
    }
  
    // Cập nhật 1 dòng thành tiền dựa trên giá và qty
    function updateRowTotal(row) {
      const priceCell = row.querySelector('.cell-price');
      const qtyInput = row.querySelector('.qty-input');
      const lineTotalCell = row.querySelector('.cell-line-total');
  
      const price = parseVNDFromData(priceCell.dataset.price); // số nguyên VND
      let qty = parseInt(qtyInput.value, 10);
      if (isNaN(qty) || qty < 1) qty = 1;
      qtyInput.value = qty;
  
      const lineTotal = price * qty;
      lineTotalCell.textContent = formatVND(lineTotal);
    }
  
    // Tính tổng giỏ hàng
    function updateSummary() {
      const rows = Array.from(cartTable.querySelectorAll('tbody tr.cart-row'));
      let subtotal = 0;
      let totalItems = 0;
  
      rows.forEach(r => {
        const price = parseVNDFromData(r.querySelector('.cell-price').dataset.price);
        const qty = parseInt(r.querySelector('.qty-input').value, 10) || 0;
        subtotal += price * qty;
        totalItems += qty;
      });
  
      // Giả sử có 200k giảm giá tĩnh (như mẫu). Bạn có thể thay đổi logic tính giảm giá.
      const discount = 200000; // giữ giống mẫu
      const shipping = 0; // miễn phí ship như mẫu
      const totalAfterDiscount = Math.max(subtotal - discount, 0);
      const finalTotal = totalAfterDiscount + shipping;
  
      summaryCount.textContent = rows.length; // số dòng sản phẩm (theo mẫu ảnh là 1 đơn vị = 1 dòng)
      summarySubtotal.textContent = formatVND(subtotal);
      summaryDiscount.textContent = (discount > 0) ? '-' + formatVND(discount) : formatVND(0);
      summaryTotal.textContent = formatVND(finalTotal);
      summaryShipping.textContent = formatVND(shipping);
    }
  
    // Gắn sự kiện cho nút + - và input qty cho 1 hàng
    function attachRowEvents(row) {
      const btnInc = row.querySelector('.btn-increase');
      const btnDec = row.querySelector('.btn-decrease');
      const qtyInput = row.querySelector('.qty-input');
      const deleteBtn = row.querySelector('.btn-delete');
  
      if (btnInc) {
        btnInc.addEventListener('click', function () {
          qtyInput.value = parseInt(qtyInput.value || '0', 10) + 1;
          updateRowTotal(row);
          updateSummary();
        });
      }
  
      if (btnDec) {
        btnDec.addEventListener('click', function () {
          let v = parseInt(qtyInput.value || '0', 10) - 1;
          if (v < 1) v = 1;
          qtyInput.value = v;
          updateRowTotal(row);
          updateSummary();
        });
      }
  
      // khi nhập trực tiếp
      qtyInput.addEventListener('change', function () {
        let v = parseInt(qtyInput.value, 10);
        if (isNaN(v) || v < 1) v = 1;
        qtyInput.value = v;
        updateRowTotal(row);
        updateSummary();
      });
  
      // Xóa: mở modal
      deleteBtn.addEventListener('click', function () {
        pendingDeleteRow = row;
        openModal();
      });
    }
  
    // Mở modal
    function openModal() {
      modal.style.display = 'flex';
      modal.setAttribute('aria-hidden', 'false');
    }
  
    // Đóng modal
    function closeModal() {
      modal.style.display = 'none';
      modal.setAttribute('aria-hidden', 'true');
      pendingDeleteRow = null;
    }
  
    // Khi xác nhận xóa
    modalConfirm.addEventListener('click', function () {
      if (pendingDeleteRow) {
        pendingDeleteRow.remove();
        pendingDeleteRow = null;
        updateAllRowsIndex();
        updateSummary();
      }
      closeModal();
    });
  
    modalCancel.addEventListener('click', function () {
      closeModal();
    });
  
    // click backdrop cũng đóng modal
    modal.querySelector('.modal-backdrop').addEventListener('click', closeModal);
  
    // Cập nhật STT cho từng hàng sau khi xóa
    function updateAllRowsIndex() {
      const rows = Array.from(cartTable.querySelectorAll('tbody tr.cart-row'));
      rows.forEach((r, i) => {
        const sttCell = r.querySelector('.cell-stt');
        if (sttCell) sttCell.textContent = (i + 1);
      });
    }
  
    // Khởi tạo: gắn events cho hàng hiện có, cập nhật tổng
    function init() {
      const rows = Array.from(cartTable.querySelectorAll('tbody tr.cart-row'));
      rows.forEach(row => {
        updateRowTotal(row);
        attachRowEvents(row);
      });
      updateSummary();
    }
  
    init();
  });
  