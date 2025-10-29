-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2025 at 05:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `catalogs`
--

CREATE TABLE `catalogs` (
  `catalog_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `catalogs`
--

INSERT INTO `catalogs` (`catalog_id`, `name`, `description`, `parent_id`, `sort_order`, `created_at`) VALUES
(1, 'Thời trang', 'Danh mục chính', NULL, 0, '2025-10-09 23:30:14'),
(2, 'Áo đá banh', 'Sản phẩm áo đá banh', 1, 0, '2025-10-09 23:30:14'),
(3, 'Áo cầu lông', 'Áo cầu lông', 1, 0, '2025-10-09 23:30:14'),
(4, 'Khuyến mãi', 'Sản phẩm giảm giá', NULL, 0, '2025-10-09 23:30:14'),
(5, 'Quần cầu lông', 'Quần cầu lông', 1, 0, '2025-10-09 23:30:14'),
(6, 'Đồng phục bóng rổ', 'Đồng phục bóng rổ', 1, 0, '2025-10-09 23:30:14'),
(7, 'Đồ thể thao bóng chuyền', 'Đồ thể thao bóng chuyền', 1, 0, '2025-10-09 23:30:14'),
(8, 'Phụ kiện', 'Phụ kiện', 1, 0, '2025-10-09 23:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `catalog_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `discount` int(11) DEFAULT 0,
  `image_main` varchar(255) DEFAULT NULL,
  `image_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`image_list`)),
  `view_count` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `catalog_id`, `name`, `description`, `price`, `discount`, `image_main`, `image_list`, `view_count`, `created_at`) VALUES
(1, 2, 'BỘ QUẦN ÁO BÓNG ĐÁ ARSENAL MÀU ĐỎ TRẮNG', 'Chất liệu cotton cao cấp', 350000.00, 10, 'ao-topten-product-1.jpeg', NULL, 0, '2025-10-09 23:30:14'),
(2, 2, 'BỘ QUẦN ÁO BÓNG ĐÁ CLB INTER MIAMI 2023-2024 MÀU ĐEN', 'Áo đá banh đẹp', 580000.00, 15, 'ao-topten-product-4.webp', NULL, 0, '2025-10-09 23:30:14'),
(3, 2, 'BỘ QUẦN ÁO BÓNG ĐÁ ARSENAL MÀU ĐỎ ĐEN', 'Thiết kế trẻ trung, lịch sự', 420000.00, 5, 'ao-topten-product-2.jpeg', NULL, 0, '2025-10-09 23:30:14'),
(4, 2, 'BỘ QUẦN ÁO BÓNG ĐÁ CLB INTER MIAMI 2023-2024 MÀU HỒNG', 'Áo đá banh mẫu 104 đẹp', 950000.00, 0, 'ao-topten-product-3.webp', NULL, 0, '2025-10-10 00:26:48'),
(5, 2, 'BỘ QUẦN ÁO BÓNG ĐÁ CLB JUVENTUS MÀU TRẮNG ĐEN VÀNG', 'Áo đá banh đẹp ', 580000.00, 0, 'ao-topten-product-5.webp', NULL, 0, '2025-10-10 00:47:37'),
(6, 2, 'BỘ QUẦN ÁO BÓNG ĐÁ CLB JUVENTUS MÀU ĐEN', 'Áo đá banh đẹp', 950000.00, 0, 'ao-topten-product-6.webp', NULL, 0, '2025-10-10 00:48:10'),
(7, 2, 'BỘ QUẦN ÁO BÓNG ĐÁ ARSENAL MÀU ĐỎ TRẮNG MẪU 101', 'Áo đá banh đẹp', 350000.00, 0, 'ao-topten-product-7.jpeg', NULL, 0, '2025-10-10 00:56:36'),
(8, 2, 'BỘ QUẦN ÁO BÓNG ĐÁ ARSENAL MÀU ĐỎ ĐEN MẪU 102', 'Áo đá banh đẹp', 420000.00, 0, 'ao-topten-product-8.jpeg', NULL, 0, '2025-10-10 00:57:14'),
(9, 3, 'Áo cầu lông Yonex TRM2966 - Navy Peony chính hãng', 'Áo cầu lông đẹp', 350000.00, 0, 'ao-cau-long-1.webp', NULL, 0, '2025-10-10 01:09:48'),
(10, 3, 'Áo cầu lông Yonex TRM2965 - Seaport chính hãng', 'Áo cầu lông đẹp', 580000.00, 0, 'ao-cau-long-2.webp', NULL, 0, '2025-10-10 01:10:47'),
(11, 3, 'Áo cầu lông Yonex TRM2967 - Mandarin Red chính hãng', 'Áo cầu lông đẹp', 420000.00, 0, 'ao-cau-long-3.webp', NULL, 0, '2025-10-10 01:11:16'),
(12, 5, 'Quần cầu lông Yonex TSM2844 - Hemlock chính hãng', 'Quần cầu lông Yonex', 420000.00, 0, 'quan-cau-long-1.webp', NULL, 0, '2025-10-10 01:14:51'),
(13, 5, 'Quần cầu lông Yonex TSM2910 - White chính hãng', 'Quần cầu lông Yonex', 350000.00, 0, 'quan-cau-long-2.webp', NULL, 0, '2025-10-10 01:15:23'),
(14, 5, 'Quần cầu lông Yonex TSM2913 - Jet Black chính hãng', 'Quần cầu lông Yonex', 580000.00, 0, 'quan-cau-long-3.webp', NULL, 0, '2025-10-10 01:15:54'),
(15, 5, 'Quần cầu lông Mẫu 101 TSM2844 - Hemlock chính hãng', 'Quần cầu lông Mẫu 101 ', 420000.00, 0, 'quan-cau-long-1.webp', NULL, 0, '2025-10-10 01:22:13'),
(16, 3, 'Áo cầu lông mẫu 101 TRM2966 - Navy Peony chính hãng', 'Áo cầu lông mẫu 101', 950000.00, 0, 'ao-cau-long-1.webp', NULL, 0, '2025-10-10 01:22:53'),
(17, 6, 'Đồng phục bóng rổ X24 – Màu đỏ cam cháy nổi bật', 'Đồng phục bóng rổ X24 ', 420000.00, 0, 'ao-bong-ro-1.jpg', NULL, 0, '2025-10-10 01:27:54'),
(18, 6, 'Bộ Đồng Phục Bóng Rổ Màu Xanh Dương Đậm – Phối Trắng', 'Bộ Đồng Phục Bóng Rổ Màu Xanh Dương Đậm', 420000.00, 0, 'ao-bong-ro-2.jpg', NULL, 0, '2025-10-10 01:27:54'),
(19, 6, 'Áo Bóng Rổ Xanh Ngọc Đen Họa Tiết Polygon', 'Áo Bóng Rổ Xanh Ngọc Đen Họa Tiết Polygo', 420000.00, 0, 'ao-bong-ro-3.jpg', NULL, 0, '2025-10-10 01:27:54'),
(20, 6, 'Đồng phục bóng rổ Miami Nights – Tông đen phối hồng & xanh', 'Đồng phục bóng rổ Miami Nights – Tông đen phối hồng & xanh', 420000.00, 0, 'ao-bong-ro-4.jpg', NULL, 0, '2025-10-10 01:27:54'),
(21, 6, 'Áo Bóng Rổ Trắng Họa Tiết Zig-Zag Tím Vàng Năng Động', 'Áo Bóng Rổ Trắng Họa Tiết Zig-Zag Tím Vàng Năng Động', 950000.00, 0, 'ao-bong-ro-5.jpg', NULL, 0, '2025-10-10 01:27:54'),
(22, 6, 'Áo Bóng Rổ Đen Đỏ Trắng – Thiết Kế Skyline Năng Động', 'Áo Bóng Rổ Đen Đỏ Trắng – Thiết Kế Skyline Năng Động', 950000.00, 0, 'ao-bong-ro-6.jpg', NULL, 0, '2025-10-10 01:27:54'),
(23, 6, 'Bộ Đồng Phục Bóng Rổ Màu Xanh Dương Đậm – Phối Trắng Mẫu 101', 'Bộ Đồng Phục Bóng Rổ Màu Xanh Dương Đậm – Phối Trắng Mẫu 101', 580000.00, 0, 'ao-bong-ro-2.jpg', NULL, 0, '2025-10-10 01:27:54'),
(24, 6, 'Áo Bóng Rổ Trắng Họa Tiết Zig-Zag Tím Vàng Năng Động Mẫu 102', 'Áo Bóng Rổ Trắng Họa Tiết Zig-Zag Tím Vàng Năng Động Mẫu 102', 950000.00, 0, 'ao-bong-ro-5.jpg', NULL, 0, '2025-10-10 01:27:54'),
(25, 7, 'Áo Bóng Chuyền BC 03 – Trắng Đen Sọc Vàng', 'Áo Bóng Chuyền BC 03 – Trắng Đen Sọc Vàng', 950000.00, 0, 'ao-bong-chuyen-1.jpg', NULL, 0, '2025-10-10 01:27:54'),
(26, 7, 'Áo bóng chuyền BC-05 đỏ tươi phối xanh ngọc', 'Áo bóng chuyền BC-05 đỏ tươi phối xanh ngọc', 950000.00, 0, 'ao-bong-chuyen-2.jpg', NULL, 0, '2025-10-10 01:27:54'),
(27, 7, 'Áo Bóng Chuyền AURA B200 Màu Trắng – Đơn Giản', 'Áo Bóng Chuyền AURA B200 Màu Trắng – Đơn Giản', 950000.00, 0, 'ao-bong-chuyen-3.jpg', NULL, 0, '2025-10-10 01:27:54'),
(28, 7, 'Áo Bóng Chuyền Hacorio Manya VSF – Đen Trắng', 'Áo Bóng Chuyền Hacorio Manya VSF – Đen Trắng', 950000.00, 0, 'ao-bong-chuyen-4.jpg', NULL, 0, '2025-10-10 01:27:54'),
(29, 7, 'Áo bóng chuyền Aura B200 màu đỏ – Năng lượng', 'Áo bóng chuyền Aura B200 màu đỏ – Năng lượng', 950000.00, 0, 'ao-bong-chuyen-5.jpg', NULL, 0, '2025-10-10 01:27:54'),
(30, 7, 'Áo Bóng Chuyền Luxcara Cam Rực Rỡ – Năng Động', 'Áo Bóng Chuyền Luxcara Cam Rực Rỡ – Năng Động', 950000.00, 0, 'ao-bong-chuyen-6.jpg', NULL, 0, '2025-10-10 01:27:54'),
(31, 7, 'Áo bóng chuyền BC-05 đỏ tươi phối xanh ngọc', 'Áo bóng chuyền BC-05 đỏ tươi phối xanh ngọc', 950000.00, 0, 'ao-bong-chuyen-2.jpg', NULL, 0, '2025-10-10 01:27:54'),
(32, 7, 'Áo bóng chuyền BC-05 đỏ tươi phối xanh ngọc', 'Áo bóng chuyền BC-05 đỏ tươi phối xanh ngọc', 950000.00, 0, 'ao-bong-chuyen-2.jpg', NULL, 0, '2025-10-10 01:27:54'),
(33, 8, 'Quả Bóng Rổ Molten B7G3200 Số 7', 'Quả Bóng Rổ Molten B7G3200 Số 7', 350000.00, 0, 'list-product-1.jpg', NULL, 0, '2025-10-10 01:27:54'),
(34, 8, 'Quả Hải Yến Xanh dương (12 quả)', 'Quả Hải Yến Xanh dương (12 quả)', 950000.00, 0, 'list-product-2.jpg', NULL, 0, '2025-10-10 01:27:54'),
(35, 8, 'Túi Đựng Giày Akka Galaxy', 'Túi Đựng Giày Akka Galaxy', 420000.00, 0, 'list-product-3.jpg', NULL, 0, '2025-10-10 01:27:54'),
(36, 8, 'Túi rút Hacorio Xanh Neon – Nổi bật, năng động', 'Túi rút Hacorio Xanh Neon – Nổi bật, năng động', 950000.00, 0, 'list-accessory-6.jpg', NULL, 0, '2025-10-10 01:27:54'),
(37, 8, 'Balo Thể Thao HACORIO Luxury Xanh Đậm Chống Thấm', 'Balo Thể Thao HACORIO Luxury Xanh Đậm Chống Thấm', 420000.00, 0, 'list-accessory-4.jpg', NULL, 0, '2025-10-10 01:27:54'),
(38, 8, 'Băng Đội Trưởng Màu Đỏ – Chữ ‘C’ Đen Nổi Bật', 'Băng Đội Trưởng Màu Đỏ – Chữ ‘C’ Đen Nổi Bật', 580000.00, 0, 'list-accessory-5.jpg', NULL, 0, '2025-10-10 01:27:54'),
(39, 8, 'Quả Bóng Rổ Molten B7G3200 Số 7', 'Quả Bóng Rổ Molten B7G3200 Số 7', 350000.00, 0, 'list-product-1.jpg', NULL, 0, '2025-10-10 01:27:54'),
(40, 8, 'Túi rút Hacorio Xanh Neon – Nổi bật, năng động', 'Túi rút Hacorio Xanh Neon – Nổi bật, năng động', 950000.00, 0, 'list-accessory-6.jpg', NULL, 0, '2025-10-10 01:27:54');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 3, 5, 'Áo rất đẹp, vải mịn, giao hàng nhanh!', '2025-10-09 23:30:14'),
(2, 2, 3, 4, 'Váy đẹp, form chuẩn nhưng hơi dài.', '2025-10-09 23:30:14'),
(3, 3, 1, 5, 'đẹp quá', '2025-10-13 22:17:22'),
(4, 3, 4, 5, 'hơn rộng nha :))', '2025-10-13 22:19:19');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `payment_method` enum('cod','online') DEFAULT 'cod',
  `status` enum('pending','paid','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('admin','mod','customer') DEFAULT 'customer',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `phone`, `address`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 'admin', '2025-10-09 23:30:14'),
(2, 'Moderator', 'mod@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 'mod', '2025-10-09 23:30:14'),
(3, 'Nguyễn Văn A', 'a@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 'customer', '2025-10-09 23:30:14'),
(4, 'nhanpro', 'nhan@gmail.com', '$2y$10$Ey2bPLz..rRdO/SALzIG9Of5CGAi47nrNo2X1KeM4IktM6SgqAO1i', NULL, NULL, 'customer', '2025-10-13 22:18:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catalogs`
--
ALTER TABLE `catalogs`
  ADD PRIMARY KEY (`catalog_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `catalog_id` (`catalog_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catalogs`
--
ALTER TABLE `catalogs`
  MODIFY `catalog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `catalogs`
--
ALTER TABLE `catalogs`
  ADD CONSTRAINT `catalogs_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `catalogs` (`catalog_id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalogs` (`catalog_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
