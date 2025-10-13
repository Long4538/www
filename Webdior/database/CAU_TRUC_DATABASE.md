# 📊 CẤU TRÚC CƠ SỞ DỮ LIỆU DIOR PERFUME

## 🗄️ **TỔNG QUAN**

- **Tên Database:** `dior_perfume_db`
- **Character Set:** `utf8mb4_unicode_ci`
- **Số bảng:** 12 bảng chính
- **Đặc điểm:** Linh hoạt, có thể thêm sản phẩm qua phpMyAdmin
- **Mục đích:** Website bán nước hoa DIOR với đầy đủ tính năng e-commerce

---

## 📋 **CHI TIẾT TỪNG BẢNG**

### **1. 🏷️ `categories` - Danh mục sản phẩm**

**Mục đích:** Phân loại sản phẩm theo danh mục

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID danh mục |
| `name` | VARCHAR(100) | Tên danh mục |
| `slug` | VARCHAR(100) UNIQUE | URL slug |
| `description` | TEXT | Mô tả danh mục |
| `parent_id` | INT | Danh mục cha (hierarchical) |
| `sort_order` | INT | Thứ tự sắp xếp |
| `is_active` | BOOLEAN | Trạng thái hoạt động |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Dữ liệu mẫu:**
- Nước hoa nam
- Nước hoa nữ  
- Nước hoa unisex

---

### **2. 🏢 `brands` - Thương hiệu**

**Mục đích:** Quản lý thương hiệu nước hoa

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID thương hiệu |
| `name` | VARCHAR(100) | Tên thương hiệu |
| `slug` | VARCHAR(100) UNIQUE | URL slug |
| `logo` | VARCHAR(255) | Đường dẫn logo |
| `description` | TEXT | Mô tả thương hiệu |
| `website` | VARCHAR(255) | Website thương hiệu |
| `is_active` | BOOLEAN | Trạng thái hoạt động |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Dữ liệu mẫu:**
- DIOR

---

### **3. 🛍️ `products` - Sản phẩm (BẢNG CHÍNH)**

**Mục đích:** Lưu trữ thông tin sản phẩm chính

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID sản phẩm |
| `product_code` | VARCHAR(50) UNIQUE | Mã sản phẩm (DIOR001, DIOR002...) |
| `name` | VARCHAR(255) | Tên sản phẩm |
| `slug` | VARCHAR(255) UNIQUE | URL slug |
| `brand_id` | INT (FK) | ID thương hiệu |
| `category_id` | INT (FK) | ID danh mục |
| `price` | DECIMAL(10,2) | Giá sản phẩm |
| `sale_price` | DECIMAL(10,2) | Giá khuyến mãi |
| `volume` | VARCHAR(50) | Dung tích (100ml, 50ml...) |
| `concentration` | VARCHAR(50) | Nồng độ (EDT, EDP, Parfum...) |
| `gender` | ENUM('Nam', 'Nữ', 'Unisex') | Giới tính |
| `duration` | VARCHAR(100) | Độ lưu hương (6-8h...) |
| `sillage` | VARCHAR(100) | Độ tỏa hương (1 sải tay...) |
| `description` | TEXT | Mô tả sản phẩm |
| `main_image` | VARCHAR(255) | Hình ảnh chính |
| `is_featured` | BOOLEAN | Sản phẩm nổi bật |
| `is_active` | BOOLEAN | Trạng thái hoạt động |
| `stock_quantity` | INT | Số lượng tồn kho |
| `weight` | DECIMAL(8,2) | Trọng lượng |
| `dimensions` | VARCHAR(100) | Kích thước |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Ví dụ dữ liệu:**
- DIOR001 - Dior Sauvage EDT - 2,890,000₫
- DIOR100 - Long - 11,000₫

---

### **4. 🖼️ `product_images` - Hình ảnh sản phẩm**

**Mục đích:** Quản lý nhiều hình ảnh cho mỗi sản phẩm

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID hình ảnh |
| `product_id` | INT (FK) | ID sản phẩm |
| `image_path` | VARCHAR(255) | Đường dẫn hình ảnh |
| `alt_text` | VARCHAR(255) | Text thay thế |
| `is_main` | BOOLEAN | Hình ảnh chính |
| `sort_order` | INT | Thứ tự sắp xếp |
| `created_at` | TIMESTAMP | Ngày tạo |

---

### **5. 🌸 `fragrance_notes` - Hương thơm**

**Mục đích:** Lưu trữ hương thơm của sản phẩm

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID hương thơm |
| `product_id` | INT (FK) | ID sản phẩm |
| `note_type` | ENUM('top', 'middle', 'base') | Loại hương |
| `note_name` | VARCHAR(255) | Tên hương thơm |
| `sort_order` | INT | Thứ tự sắp xếp |
| `created_at` | TIMESTAMP | Ngày tạo |

**Ví dụ:**
- Top notes: Cam bergamot, Quả chanh vàng
- Middle notes: Hoa nhài Sambac, Quế
- Base notes: Cây thuốc lá, Đậu Tonka

---

### **6. 🔗 `related_products` - Sản phẩm liên quan**

**Mục đích:** Gợi ý sản phẩm liên quan

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID liên kết |
| `product_id` | INT (FK) | ID sản phẩm gốc |
| `related_product_id` | INT (FK) | ID sản phẩm liên quan |
| `sort_order` | INT | Thứ tự sắp xếp |
| `created_at` | TIMESTAMP | Ngày tạo |

---

### **7. 👤 `users` - Người dùng**

**Mục đích:** Quản lý người dùng và admin

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID người dùng |
| `email` | VARCHAR(255) UNIQUE | Email |
| `password` | VARCHAR(255) | Mật khẩu (hashed) |
| `first_name` | VARCHAR(100) | Tên |
| `last_name` | VARCHAR(100) | Họ |
| `phone` | VARCHAR(20) | Số điện thoại |
| `address` | TEXT | Địa chỉ |
| `city` | VARCHAR(100) | Thành phố |
| `district` | VARCHAR(100) | Quận/Huyện |
| `ward` | VARCHAR(100) | Phường/Xã |
| `is_active` | BOOLEAN | Trạng thái hoạt động |
| `is_admin` | BOOLEAN | Quyền admin |
| `email_verified_at` | TIMESTAMP | Xác thực email |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

---

### **8. 📦 `orders` - Đơn hàng**

**Mục đích:** Quản lý đơn hàng

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID đơn hàng |
| `order_number` | VARCHAR(50) UNIQUE | Mã đơn hàng |
| `user_id` | INT (FK) | ID người dùng (nullable) |
| `customer_name` | VARCHAR(255) | Tên khách hàng |
| `customer_email` | VARCHAR(255) | Email khách hàng |
| `customer_phone` | VARCHAR(20) | SĐT khách hàng |
| `customer_address` | TEXT | Địa chỉ giao hàng |
| `customer_city` | VARCHAR(100) | Thành phố |
| `customer_district` | VARCHAR(100) | Quận/Huyện |
| `customer_ward` | VARCHAR(100) | Phường/Xã |
| `total_amount` | DECIMAL(10,2) | Tổng tiền |
| `shipping_fee` | DECIMAL(10,2) | Phí vận chuyển |
| `discount_amount` | DECIMAL(10,2) | Giảm giá |
| `status` | ENUM | Trạng thái đơn hàng |
| `payment_method` | ENUM | Phương thức thanh toán |
| `payment_status` | ENUM | Trạng thái thanh toán |
| `notes` | TEXT | Ghi chú |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Trạng thái đơn hàng:**
- `pending` - Chờ xử lý
- `confirmed` - Đã xác nhận
- `shipping` - Đang giao hàng
- `delivered` - Đã giao hàng
- `cancelled` - Đã hủy

**Phương thức thanh toán:**
- `cod` - Thanh toán khi nhận hàng
- `bank_transfer` - Chuyển khoản
- `credit_card` - Thẻ tín dụng

---

### **9. 📋 `order_items` - Chi tiết đơn hàng**

**Mục đích:** Chi tiết từng sản phẩm trong đơn hàng

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID chi tiết |
| `order_id` | INT (FK) | ID đơn hàng |
| `product_id` | INT (FK) | ID sản phẩm |
| `quantity` | INT | Số lượng |
| `price` | DECIMAL(10,2) | Giá tại thời điểm mua |
| `total_price` | DECIMAL(10,2) | Thành tiền |
| `created_at` | TIMESTAMP | Ngày tạo |

---

### **10. 🛒 `cart_items` - Giỏ hàng**

**Mục đích:** Quản lý giỏ hàng (user + guest)

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID giỏ hàng |
| `user_id` | INT (FK) | ID người dùng (nullable) |
| `session_id` | VARCHAR(255) | Session ID (cho guest) |
| `product_id` | INT (FK) | ID sản phẩm |
| `quantity` | INT | Số lượng |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

---

### **11. 📰 `posts` - Bài viết/Tin tức**

**Mục đích:** Quản lý blog/tin tức

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID bài viết |
| `title` | VARCHAR(255) | Tiêu đề |
| `slug` | VARCHAR(255) UNIQUE | URL slug |
| `excerpt` | TEXT | Tóm tắt |
| `content` | TEXT | Nội dung |
| `featured_image` | VARCHAR(255) | Hình ảnh nổi bật |
| `author_id` | INT (FK) | ID tác giả |
| `category` | VARCHAR(100) | Danh mục bài viết |
| `tags` | VARCHAR(255) | Tags |
| `is_published` | BOOLEAN | Trạng thái xuất bản |
| `published_at` | TIMESTAMP | Ngày xuất bản |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

---

### **12. 📞 `contacts` - Liên hệ**

**Mục đích:** Quản lý tin nhắn liên hệ

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID liên hệ |
| `name` | VARCHAR(255) | Tên người liên hệ |
| `email` | VARCHAR(255) | Email |
| `phone` | VARCHAR(20) | Số điện thoại |
| `subject` | VARCHAR(255) | Chủ đề |
| `message` | TEXT | Nội dung tin nhắn |
| `status` | ENUM | Trạng thái |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Trạng thái:**
- `new` - Mới
- `read` - Đã đọc
- `replied` - Đã trả lời

---

### **13. ⚙️ `settings` - Cài đặt hệ thống**

**Mục đích:** Cài đặt website

| Trường | Kiểu dữ liệu | Mô tả |
|--------|--------------|-------|
| `id` | INT (PK, AI) | ID cài đặt |
| `setting_key` | VARCHAR(100) UNIQUE | Khóa cài đặt |
| `setting_value` | TEXT | Giá trị |
| `description` | VARCHAR(255) | Mô tả |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Ví dụ cài đặt:**
- `site_name` - Tên website
- `contact_phone` - Số điện thoại liên hệ
- `shipping_fee` - Phí vận chuyển

---

## 🔗 **MỐI QUAN HỆ GIỮA CÁC BẢNG**

### **📊 Sơ đồ quan hệ:**

```
brands (1) ←→ (N) products (1) ←→ (N) product_images
categories (1) ←→ (N) products
products (1) ←→ (N) fragrance_notes
products (1) ←→ (N) related_products
users (1) ←→ (N) orders
orders (1) ←→ (N) order_items
products (1) ←→ (N) order_items
users (1) ←→ (N) cart_items
products (1) ←→ (N) cart_items
users (1) ←→ (N) posts
```

### **🎯 Các bảng chính:**
- **`products`** - Trung tâm của hệ thống
- **`users`** - Quản lý người dùng
- **`orders`** - Quản lý bán hàng

### **🔧 Các bảng hỗ trợ:**
- **`categories`, `brands`** - Phân loại sản phẩm
- **`product_images`, `fragrance_notes`** - Chi tiết sản phẩm
- **`settings`** - Cấu hình hệ thống

---

## 🚀 **TÍNH NĂNG HỖ TRỢ**

### **📈 Indexes tối ưu:**
- Index trên `brand_id`, `category_id` trong bảng `products`
- Index trên `is_featured`, `is_active` để lọc sản phẩm
- Index trên `price` để sắp xếp theo giá
- Index trên `created_at` để sắp xếp theo thời gian

### **🔍 Views có sẵn:**
- `v_products_full` - Sản phẩm với thông tin đầy đủ
- `v_featured_products` - Sản phẩm nổi bật

### **🔒 Bảo mật:**
- Foreign Key constraints
- Unique constraints
- Prepared statements trong API
- Input validation

---

## 📝 **GHI CHÚ QUAN TRỌNG**

1. **Database linh hoạt:** Có thể thêm sản phẩm trực tiếp qua phpMyAdmin
2. **Không có dữ liệu mẫu cố định:** Tự do thêm bao nhiêu sản phẩm tùy ý
3. **Hỗ trợ đầy đủ e-commerce:** Giỏ hàng, đơn hàng, thanh toán
4. **SEO friendly:** Slug cho URL thân thiện
5. **Multilingual ready:** UTF8MB4 hỗ trợ emoji và ký tự đặc biệt

---

## 🎉 **KẾT LUẬN**

Database được thiết kế hoàn chỉnh cho website bán nước hoa DIOR với:
- ✅ **12 bảng chính** đầy đủ tính năng
- ✅ **Cấu trúc linh hoạt** dễ mở rộng
- ✅ **Tối ưu hiệu suất** với indexes
- ✅ **Bảo mật cao** với constraints
- ✅ **Hỗ trợ đầy đủ** tính năng e-commerce

**Phù hợp cho website bán nước hoa chuyên nghiệp!** 🚀
