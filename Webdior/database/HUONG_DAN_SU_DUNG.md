# 📚 HƯỚNG DẪN SỬ DỤNG CƠ SỞ DỮ LIỆU LINH HOẠT

## 🎯 **Tổng quan**

Database này được thiết kế để bạn có thể **tự do thêm sản phẩm** qua phpMyAdmin mà không bị giới hạn bởi 8 sản phẩm cố định. Bạn có thể thêm bao nhiêu sản phẩm tùy ý!

## 🗄️ **Cấu trúc bảng sản phẩm**

### **Bảng `products` có các trường:**
- **`product_code`** - Mã sản phẩm (VD: DIOR001, DIOR002...)
- **`name`** - Tên sản phẩm (VD: Dior Sauvage EDT)
- **`price`** - Giá sản phẩm (VD: 2890000)
- **`volume`** - Dung tích (VD: 100ml)
- **`concentration`** - Nồng độ (VD: Eau de Toilette)
- **`gender`** - Giới tính (Nam/Nữ/Unisex)
- **`duration`** - Độ lưu hương (VD: 6-8h)
- **`sillage`** - Độ tỏa hương (VD: 1 sải tay)
- **`description`** - Mô tả sản phẩm
- **`main_image`** - Hình ảnh chính

## 🚀 **Cách thêm sản phẩm**

### **Phương pháp 1: Qua phpMyAdmin (Khuyến nghị)**

1. **Mở phpMyAdmin**
2. **Chọn database** `dior_perfume_db`
3. **Click vào bảng** `products`
4. **Click "Insert"** (Thêm)
5. **Điền thông tin:**

```sql
product_code: DIOR001
name: Dior Sauvage EDT
slug: dior-sauvage-edt
brand_id: 1
category_id: 1
price: 2890000
sale_price: (để trống hoặc 2500000)
volume: 100ml
concentration: Eau de Toilette
gender: Nam
duration: 6-8h
sillage: 1 sải tay
description: Mô tả chi tiết về sản phẩm...
main_image: /Webdior/images/products/sauvage-edt.jpg
is_featured: 1 (nổi bật) hoặc 0
is_active: 1 (hoạt động) hoặc 0
stock_quantity: 100
```

6. **Click "Go"** để lưu

### **Phương pháp 2: Qua giao diện Admin**

1. **Truy cập:** `http://localhost/Webdior/admin/products.php`
2. **Click "Thêm sản phẩm mới"**
3. **Điền form** và click "Lưu sản phẩm"

### **Phương pháp 3: SQL trực tiếp**

```sql
INSERT INTO products (
    product_code, name, slug, brand_id, category_id, 
    price, volume, concentration, gender, duration, 
    sillage, description, main_image, is_featured, 
    is_active, stock_quantity
) VALUES (
    'DIOR001', 'Dior Sauvage EDT', 'dior-sauvage-edt', 
    1, 1, 2890000, '100ml', 'Eau de Toilette', 
    'Nam', '6-8h', '1 sải tay', 
    'Mô tả sản phẩm...', '/Webdior/images/products/sauvage.jpg', 
    1, 1, 100
);
```

## 📋 **Danh sách thương hiệu và danh mục**

### **Thương hiệu có sẵn:**
- **ID 1:** DIOR

### **Danh mục có sẵn:**
- **ID 1:** Nước hoa nam
- **ID 2:** Nước hoa nữ  
- **ID 3:** Nước hoa unisex

## 🖼️ **Quản lý hình ảnh**

### **Cách thêm hình ảnh:**
1. **Upload hình** vào thư mục `/Webdior/images/products/`
2. **Ghi đường dẫn** vào trường `main_image`
3. **Ví dụ:** `/Webdior/images/products/dior-sauvage.jpg`

### **Thêm nhiều hình ảnh:**
```sql
INSERT INTO product_images (product_id, image_path, alt_text, is_main, sort_order) 
VALUES 
(1, '/Webdior/images/products/sauvage-1.jpg', 'Hình 1', 1, 0),
(1, '/Webdior/images/products/sauvage-2.jpg', 'Hình 2', 0, 1),
(1, '/Webdior/images/products/sauvage-3.jpg', 'Hình 3', 0, 2);
```

## 🌸 **Thêm hương thơm**

```sql
INSERT INTO fragrance_notes (product_id, note_type, note_name, sort_order) 
VALUES 
(1, 'top', 'Cam bergamot', 1),
(1, 'top', 'Quả chanh vàng', 2),
(1, 'middle', 'Hoa nhài Sambac', 1),
(1, 'middle', 'Quế', 2),
(1, 'base', 'Cây thuốc lá', 1),
(1, 'base', 'Đậu Tonka', 2);
```

## 🔗 **Thêm sản phẩm liên quan**

```sql
INSERT INTO related_products (product_id, related_product_id, sort_order) 
VALUES 
(1, 2, 1),  -- Sản phẩm 1 liên quan đến sản phẩm 2
(1, 3, 2);  -- Sản phẩm 1 liên quan đến sản phẩm 3
```

## 🧪 **Test sản phẩm**

### **1. Test API:**
```bash
# Lấy sản phẩm theo ID
curl "http://localhost/Webdior/api/get-product.php?id=1"

# Lấy danh sách sản phẩm
curl "http://localhost/Webdior/api/get-products.php?limit=5"
```

### **2. Test trang web:**
```
http://localhost/Webdior/page/san-pham.php?id=1
```

### **3. Test admin:**
```
http://localhost/Webdior/admin/products.php
```

## 📊 **Quản lý sản phẩm**

### **Xem danh sách sản phẩm:**
```sql
SELECT p.*, b.name as brand_name, c.name as category_name
FROM products p
LEFT JOIN brands b ON p.brand_id = b.id
LEFT JOIN categories c ON p.category_id = c.id
ORDER BY p.created_at DESC;
```

### **Tìm sản phẩm theo tên:**
```sql
SELECT * FROM products 
WHERE name LIKE '%Sauvage%' 
AND is_active = 1;
```

### **Sản phẩm nổi bật:**
```sql
SELECT * FROM products 
WHERE is_featured = 1 
AND is_active = 1;
```

### **Cập nhật sản phẩm:**
```sql
UPDATE products 
SET price = 3000000, is_featured = 1 
WHERE id = 1;
```

### **Xóa sản phẩm:**
```sql
DELETE FROM products WHERE id = 1;
```

## ⚠️ **Lưu ý quan trọng**

### **1. Mã sản phẩm phải duy nhất:**
- `product_code` không được trùng lặp
- Ví dụ: DIOR001, DIOR002, DIOR003...

### **2. Slug phải duy nhất:**
- `slug` không được trùng lặp
- Ví dụ: dior-sauvage-edt, dior-homme-intense...

### **3. ID thương hiệu và danh mục:**
- `brand_id` phải tồn tại trong bảng `brands`
- `category_id` phải tồn tại trong bảng `categories`

### **4. Giá sản phẩm:**
- `price` phải là số dương
- `sale_price` có thể để NULL

### **5. Trạng thái:**
- `is_active = 1`: Sản phẩm hiển thị trên website
- `is_active = 0`: Sản phẩm ẩn khỏi website
- `is_featured = 1`: Sản phẩm nổi bật

## 🎉 **Kết luận**

Với database linh hoạt này, bạn có thể:
- ✅ **Thêm bao nhiêu sản phẩm tùy ý**
- ✅ **Quản lý qua phpMyAdmin**
- ✅ **Sử dụng giao diện admin**
- ✅ **Tự động hiển thị trên website**
- ✅ **API hoạt động với tất cả sản phẩm**

**Chúc bạn sử dụng thành công!** 🚀
