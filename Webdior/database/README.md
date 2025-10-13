# 🗄️ HƯỚNG DẪN CÀI ĐẶT CƠ SỞ DỮ LIỆU

## 📋 **Tổng quan**

Cơ sở dữ liệu này được thiết kế cho trang web bán nước hoa DIOR với đầy đủ các tính năng:
- Quản lý sản phẩm và danh mục
- Quản lý đơn hàng và giỏ hàng
- Quản lý người dùng
- Quản lý tin tức và liên hệ
- API endpoints cho frontend

## 🛠️ **Cài đặt**

### **1. Yêu cầu hệ thống:**
- MySQL 5.7+ hoặc MariaDB 10.2+
- PHP 7.4+
- PDO MySQL extension

### **2. Tạo database:**

#### **Cách 1: Sử dụng phpMyAdmin**
1. Mở phpMyAdmin
2. Tạo database mới tên `dior_perfume_db`
3. Import file `dior_perfume_database.sql`

#### **Cách 2: Sử dụng MySQL Command Line**
```bash
# Kết nối MySQL
mysql -u root -p

# Tạo và sử dụng database
CREATE DATABASE dior_perfume_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dior_perfume_db;

# Import file SQL
SOURCE /path/to/Webdior/database/dior_perfume_database.sql;
```

#### **Cách 3: Sử dụng Laragon (Windows)**
1. Mở Laragon
2. Click "Database" → "Create Database"
3. Tên: `dior_perfume_db`
4. Mở phpMyAdmin và import file SQL

### **3. Cấu hình kết nối:**

Chỉnh sửa file `config/database.php`:
```php
define('DB_HOST', 'localhost');        // Host database
define('DB_NAME', 'dior_perfume_db');  // Tên database
define('DB_USER', 'root');             // Username
define('DB_PASS', '');                 // Password
```

## 📊 **Cấu trúc Database**

### **Bảng chính:**

#### **🏷️ Categories (Danh mục)**
- `id`: ID danh mục
- `name`: Tên danh mục
- `slug`: URL slug
- `parent_id`: ID danh mục cha (cho danh mục con)

#### **🏢 Brands (Thương hiệu)**
- `id`: ID thương hiệu
- `name`: Tên thương hiệu
- `logo`: Đường dẫn logo
- `description`: Mô tả thương hiệu

#### **🛍️ Products (Sản phẩm)**
- `id`: ID sản phẩm
- `name`: Tên sản phẩm
- `sku`: Mã sản phẩm
- `price`: Giá bán
- `sale_price`: Giá khuyến mãi
- `volume`: Dung tích
- `concentration`: Nồng độ
- `gender`: Giới tính (Nam/Nữ/Unisex)
- `duration`: Thời gian lưu hương
- `sillage`: Độ tỏa hương

#### **🖼️ Product Images (Hình ảnh)**
- `product_id`: ID sản phẩm
- `image_path`: Đường dẫn hình ảnh
- `is_main`: Hình ảnh chính
- `sort_order`: Thứ tự hiển thị

#### **🌸 Fragrance Notes (Hương thơm)**
- `product_id`: ID sản phẩm
- `note_type`: Loại hương (top/middle/base)
- `note_name`: Tên hương thơm

#### **👥 Users (Người dùng)**
- `id`: ID người dùng
- `email`: Email
- `password`: Mật khẩu (đã hash)
- `first_name`, `last_name`: Họ tên
- `phone`: Số điện thoại
- `address`: Địa chỉ

#### **📦 Orders (Đơn hàng)**
- `id`: ID đơn hàng
- `order_number`: Mã đơn hàng
- `user_id`: ID người dùng
- `total_amount`: Tổng tiền
- `status`: Trạng thái đơn hàng
- `payment_method`: Phương thức thanh toán

#### **🛒 Order Items (Chi tiết đơn hàng)**
- `order_id`: ID đơn hàng
- `product_id`: ID sản phẩm
- `quantity`: Số lượng
- `price`: Giá tại thời điểm mua

## 🔌 **API Endpoints**

### **Lấy thông tin sản phẩm:**
```
GET /Webdior/api/get-product.php?id={product_id}
```

### **Lấy danh sách sản phẩm:**
```
GET /Webdior/api/get-products.php?page=1&limit=12&category=1&gender=Nam
```

**Tham số:**
- `page`: Trang hiện tại
- `limit`: Số sản phẩm mỗi trang
- `category`: ID danh mục
- `brand`: ID thương hiệu
- `gender`: Giới tính
- `featured`: Sản phẩm nổi bật (1/0)
- `search`: Tìm kiếm
- `sort`: Sắp xếp (price_asc, price_desc, name_asc, name_desc, newest)

## 📝 **Dữ liệu mẫu**

Database đã bao gồm:
- ✅ 1 thương hiệu: DIOR
- ✅ 3 danh mục: Nước hoa nam, Nước hoa nữ, Nước hoa unisex
- ✅ 8 sản phẩm DIOR với đầy đủ thông tin
- ✅ Hương thơm cho 2 sản phẩm đầu tiên
- ✅ Sản phẩm liên quan
- ✅ Cài đặt hệ thống

## 🧪 **Test Database**

### **1. Test kết nối:**
```php
<?php
require_once 'config/database.php';

if (testDBConnection()) {
    echo "✅ Kết nối database thành công!";
} else {
    echo "❌ Không thể kết nối database!";
}
?>
```

### **2. Test API:**
```bash
# Lấy sản phẩm ID 1
curl "http://localhost/Webdior/api/get-product.php?id=1"

# Lấy danh sách sản phẩm
curl "http://localhost/Webdior/api/get-products.php?limit=4"
```

## 🔧 **Tùy chỉnh**

### **Thêm sản phẩm mới:**
```sql
INSERT INTO products (name, slug, sku, brand_id, category_id, price, volume, concentration, gender, style, duration, sillage, short_description, full_description, main_image, is_featured) 
VALUES ('Tên sản phẩm', 'ten-san-pham', 'SKU001', 1, 1, 2500000, '100ml', 'Eau de Parfum', 'Nam', 'Tươi mát', '6-8h', '1 sải tay', 'Mô tả ngắn', 'Mô tả đầy đủ', '/path/to/image.jpg', 1);
```

### **Thêm hương thơm:**
```sql
INSERT INTO fragrance_notes (product_id, note_type, note_name, sort_order) 
VALUES (1, 'top', 'Cam bergamot', 1);
```

## 🚨 **Lưu ý bảo mật**

1. **Đổi mật khẩu database** trong production
2. **Backup database** thường xuyên
3. **Sử dụng prepared statements** (đã có sẵn)
4. **Validate input** trước khi insert/update
5. **Hash mật khẩu** người dùng với `password_hash()`

## 📞 **Hỗ trợ**

Nếu gặp vấn đề:
1. Kiểm tra kết nối MySQL
2. Kiểm tra quyền user database
3. Kiểm tra file cấu hình `config/database.php`
4. Xem log lỗi PHP và MySQL

---

**🎉 Chúc bạn sử dụng database thành công!**
