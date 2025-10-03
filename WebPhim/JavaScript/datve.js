// ✅ Giá vé theo loại
const giaThuong = 50000; // Hàng A, B, C
const giaVIP = 80000;    // Hàng D, E

// ✅ Hàm tạo sơ đồ ghế khi người dùng nhập số lượng ghế muốn đặt
function taoGhe() {
  let soluong = document.getElementById("soluong").value; // Số lượng ghế cần chọn
  let sodo = document.getElementById("sodoRap");          // Vùng hiển thị sơ đồ ghế
  sodo.innerHTML = ""; // Xóa sơ đồ cũ trước khi vẽ lại

  if (!soluong) return; // Nếu chưa nhập số lượng thì thoát

  let hang = ["A","B","C","D","E"]; // Các hàng ghế
  for (let h of hang) {
    let row = document.createElement("div"); 
    row.classList.add("hang"); // Thêm class để CSS hàng

    // Mỗi hàng có 8 ghế (A1 → A8, B1 → B8, ...)
    for (let i = 1; i <= 8; i++) {
      let ghe = h+i; // Tạo tên ghế (VD: A1, B5)
      
      // Tạo label chứa checkbox + tên ghế
      let label = document.createElement("label");
      label.classList.add("ghe");

      // Khi click vào ghế → gọi checkLimit để giới hạn số ghế + tính tiền
      label.innerHTML = `
        <input type="checkbox" name="ghe[]" value="${ghe}" onclick="checkLimit(${soluong})"> 
        ${ghe}
      `;
      row.appendChild(label);
    }
    sodo.appendChild(row);
  }
}

// ✅ Hàm giới hạn số ghế được chọn
function checkLimit(max) {
  // Lấy tất cả các checkbox ghế đã được chọn
  let checked = document.querySelectorAll('input[name="ghe[]"]:checked');

  // Nếu chọn quá số lượng cho phép → cảnh báo và bỏ chọn ghế cuối
  if (checked.length > max) {
    alert("Bạn chỉ được chọn " + max + " ghế!");
    checked[checked.length-1].checked = false; // Bỏ tick ghế cuối
  }

  // Sau khi kiểm tra xong thì tính lại tổng tiền
  tinhTien();
}

// ✅ Hàm tính tổng tiền dựa trên ghế được chọn
function tinhTien() {
  let checked = document.querySelectorAll('input[name="ghe[]"]:checked');
  let tong = 0;

  // Duyệt từng ghế được chọn
  checked.forEach(ghe => {
    let ten = ghe.value;        // VD: "A1", "D5"
    let hang = ten.charAt(0);   // Lấy ký tự đầu (A, B, C, D, E)

    // Nếu ghế thuộc hàng D hoặc E → VIP
    if (hang === "D" || hang === "E") {
      tong += giaVIP;
    } else { // Ngược lại là ghế thường
      tong += giaThuong;
    }
  });

  // Hiển thị tổng tiền ra màn hình (có định dạng số VNĐ)
  document.getElementById("tongtien").innerText = tong.toLocaleString("vi-VN");
}
