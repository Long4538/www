-- =====================================================
-- CƠ SỞ DỮ LIỆU TRANG WEB BÁN NƯỚC HOA DIOR - PHIÊN BẢN LINH HOẠT
-- =====================================================
-- Tác giả: AI Assistant
-- Ngày tạo: 2024
-- Mô tả: Database linh hoạt cho website bán nước hoa DIOR
-- Đặc điểm: Có thể thêm sản phẩm trực tiếp qua phpMyAdmin
-- =====================================================

-- Tạo database
CREATE DATABASE IF NOT EXISTS dior_perfume_db 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE dior_perfume_db;

-- =====================================================
-- BẢNG DANH MỤC SẢN PHẨM
-- =====================================================
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    parent_id INT DEFAULT NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- =====================================================
-- BẢNG THƯƠNG HIỆU
-- =====================================================
CREATE TABLE brands (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    logo VARCHAR(255),
    description TEXT,
    website VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- BẢNG SẢN PHẨM (CẬP NHẬT THEO YÊU CẦU)
-- =====================================================
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_code VARCHAR(50) UNIQUE NOT NULL COMMENT 'Mã sản phẩm',
    name VARCHAR(255) NOT NULL COMMENT 'Tên sản phẩm',
    slug VARCHAR(255) UNIQUE NOT NULL,
    brand_id INT NOT NULL,
    category_id INT NOT NULL,
    price DECIMAL(10,2) NOT NULL COMMENT 'Giá sản phẩm',
    sale_price DECIMAL(10,2) DEFAULT NULL COMMENT 'Giá khuyến mãi',
    volume VARCHAR(50) COMMENT 'Dung tích',
    concentration VARCHAR(50) COMMENT 'Nồng độ',
    gender ENUM('Nam', 'Nữ', 'Unisex') NOT NULL COMMENT 'Giới tính',
    duration VARCHAR(100) COMMENT 'Độ lưu hương',
    sillage VARCHAR(100) COMMENT 'Độ tỏa hương',
    description TEXT COMMENT 'Mô tả sản phẩm',
    main_image VARCHAR(255) COMMENT 'Hình ảnh chính',
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    stock_quantity INT DEFAULT 0,
    weight DECIMAL(8,2) DEFAULT 0,
    dimensions VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE RESTRICT,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
);

-- =====================================================
-- BẢNG HÌNH ẢNH SẢN PHẨM
-- =====================================================
CREATE TABLE product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    is_main BOOLEAN DEFAULT FALSE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- =====================================================
-- BẢNG HƯƠNG THƠM
-- =====================================================
CREATE TABLE fragrance_notes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    note_type ENUM('top', 'middle', 'base') NOT NULL,
    note_name VARCHAR(255) NOT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- =====================================================
-- BẢNG SẢN PHẨM LIÊN QUAN
-- =====================================================
CREATE TABLE related_products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    related_product_id INT NOT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (related_product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_relation (product_id, related_product_id)
);

-- =====================================================
-- BẢNG NGƯỜI DÙNG
-- =====================================================
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    district VARCHAR(100),
    ward VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    is_admin BOOLEAN DEFAULT FALSE,
    email_verified_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- BẢNG ĐƠN HÀNG
-- =====================================================
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    user_id INT,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_address TEXT NOT NULL,
    customer_city VARCHAR(100),
    customer_district VARCHAR(100),
    customer_ward VARCHAR(100),
    total_amount DECIMAL(10,2) NOT NULL,
    shipping_fee DECIMAL(10,2) DEFAULT 0,
    discount_amount DECIMAL(10,2) DEFAULT 0,
    status ENUM('pending', 'confirmed', 'shipping', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_method ENUM('cod', 'bank_transfer', 'credit_card') DEFAULT 'cod',
    payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- =====================================================
-- BẢNG CHI TIẾT ĐƠN HÀNG
-- =====================================================
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);

-- =====================================================
-- BẢNG GIỎ HÀNG
-- =====================================================
CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    session_id VARCHAR(255),
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id),
    UNIQUE KEY unique_session_product (session_id, product_id)
);

-- =====================================================
-- BẢNG BÀI VIẾT/TIN TỨC
-- =====================================================
CREATE TABLE posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    excerpt TEXT,
    content TEXT,
    featured_image VARCHAR(255),
    author_id INT,
    category VARCHAR(100),
    tags VARCHAR(255),
    is_published BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- =====================================================
-- BẢNG LIÊN HỆ
-- =====================================================
CREATE TABLE contacts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- BẢNG CÀI ĐẶT HỆ THỐNG
-- =====================================================
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- TẠO INDEXES ĐỂ TỐI ƯU HIỆU SUẤT
-- =====================================================
CREATE INDEX idx_products_brand ON products(brand_id);
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_products_featured ON products(is_featured);
CREATE INDEX idx_products_active ON products(is_active);
CREATE INDEX idx_products_price ON products(price);
CREATE INDEX idx_products_gender ON products(gender);
CREATE INDEX idx_products_created ON products(created_at);
CREATE INDEX idx_products_code ON products(product_code);

CREATE INDEX idx_product_images_product ON product_images(product_id);
CREATE INDEX idx_product_images_main ON product_images(is_main);

CREATE INDEX idx_fragrance_notes_product ON fragrance_notes(product_id);
CREATE INDEX idx_fragrance_notes_type ON fragrance_notes(note_type);

CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_orders_created ON orders(created_at);

CREATE INDEX idx_order_items_order ON order_items(order_id);
CREATE INDEX idx_order_items_product ON order_items(product_id);

CREATE INDEX idx_cart_items_user ON cart_items(user_id);
CREATE INDEX idx_cart_items_session ON cart_items(session_id);

CREATE INDEX idx_posts_published ON posts(is_published);
CREATE INDEX idx_posts_created ON posts(created_at);

-- =====================================================
-- THÊM DỮ LIỆU CƠ BẢN (KHÔNG CÓ SẢN PHẨM MẪU)
-- =====================================================

-- Thêm thương hiệu DIOR
INSERT INTO brands (name, slug, description, website) VALUES
('DIOR', 'dior', 'Christian Dior là một thương hiệu thời trang và nước hoa cao cấp của Pháp, được thành lập vào năm 1946.', 'https://www.dior.com');

-- Thêm danh mục sản phẩm
INSERT INTO categories (name, slug, description, sort_order) VALUES
('Nước hoa nam', 'nuoc-hoa-nam', 'Nước hoa dành cho nam giới', 1),
('Nước hoa nữ', 'nuoc-hoa-nu', 'Nước hoa dành cho nữ giới', 2),
('Nước hoa unisex', 'nuoc-hoa-unisex', 'Nước hoa dành cho cả nam và nữ', 3);

-- Thêm cài đặt hệ thống
INSERT INTO settings (setting_key, setting_value, description) VALUES
('site_name', 'DIOR Perfume Store', 'Tên website'),
('site_description', 'Cửa hàng nước hoa DIOR chính hãng', 'Mô tả website'),
('contact_phone', '058 950 6666', 'Số điện thoại liên hệ'),
('contact_email', 'info@dior.com', 'Email liên hệ'),
('contact_address', '17 Ngõ 236 Khương Đình, Thanh Xuân, Hà Nội', 'Địa chỉ liên hệ'),
('shipping_fee', '50000', 'Phí vận chuyển'),
('free_shipping_threshold', '2000000', 'Ngưỡng miễn phí vận chuyển'),
('currency', 'VND', 'Đơn vị tiền tệ'),
('currency_symbol', '₫', 'Ký hiệu tiền tệ');

-- =====================================================
-- TẠO VIEWS ĐỂ TRUY VẤN DỄ DÀNG
-- =====================================================

-- View sản phẩm với thông tin đầy đủ
CREATE VIEW v_products_full AS
SELECT 
    p.id,
    p.product_code,
    p.name,
    p.slug,
    p.price,
    p.sale_price,
    p.volume,
    p.concentration,
    p.gender,
    p.duration,
    p.sillage,
    p.description,
    p.main_image,
    p.is_featured,
    p.is_active,
    p.stock_quantity,
    p.created_at,
    b.name as brand_name,
    b.slug as brand_slug,
    c.name as category_name,
    c.slug as category_slug
FROM products p
LEFT JOIN brands b ON p.brand_id = b.id
LEFT JOIN categories c ON p.category_id = c.id;

-- View sản phẩm nổi bật
CREATE VIEW v_featured_products AS
SELECT * FROM v_products_full 
WHERE is_featured = TRUE AND is_active = TRUE
ORDER BY created_at DESC;

-- =====================================================
-- HƯỚNG DẪN THÊM SẢN PHẨM QUA PHPMYADMIN
-- =====================================================

/*
ĐỂ THÊM SẢN PHẨM MỚI QUA PHPMYADMIN:

1. Mở phpMyAdmin
2. Chọn database "dior_perfume_db"
3. Click vào bảng "products"
4. Click "Insert" (Thêm)
5. Điền thông tin:

- product_code: Mã sản phẩm (VD: DIOR001, DIOR002...)
- name: Tên sản phẩm (VD: Dior Sauvage EDT)
- slug: URL slug (VD: dior-sauvage-edt)
- brand_id: 1 (DIOR)
- category_id: 1 (Nam), 2 (Nữ), 3 (Unisex)
- price: Giá sản phẩm (VD: 2890000)
- sale_price: Giá khuyến mãi (có thể để NULL)
- volume: Dung tích (VD: 100ml)
- concentration: Nồng độ (VD: Eau de Toilette)
- gender: Nam, Nữ, hoặc Unisex
- duration: Độ lưu hương (VD: 6-8h)
- sillage: Độ tỏa hương (VD: 1 sải tay)
- description: Mô tả sản phẩm
- main_image: Đường dẫn hình ảnh (VD: /Webdior/images/products/product1.jpg)
- is_featured: 1 (nổi bật) hoặc 0 (không nổi bật)
- is_active: 1 (hoạt động) hoặc 0 (không hoạt động)
- stock_quantity: Số lượng tồn kho

6. Click "Go" để lưu

LƯU Ý:
- product_code phải duy nhất
- slug phải duy nhất
- brand_id và category_id phải tồn tại trong bảng brands và categories
- Giá phải là số dương
*/

-- =====================================================
-- KẾT THÚC TẠO DATABASE
-- =====================================================
