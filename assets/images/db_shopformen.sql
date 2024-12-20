-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 17, 2024 at 11:14 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_shopformen`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
(1, 'Áo thun', 'Các loại áo thun nam phong cách, đa dạng mẫu mã'),
(2, 'Áo sơ mi', 'Áo sơ mi nam lịch lãm, nhiều màu sắc'),
(3, 'Quần jeans', 'Quần jeans nam chất lượng cao'),
(4, 'Quần kaki', 'Quần kaki nam thoải mái, thời trang'),
(5, 'Áo khoác', 'Áo khoác nam giữ ấm và thời trang'),
(6, 'Phụ kiện', 'Các loại phụ kiện như thắt lưng, ví nam'),
(7, 'Giày dép', 'Giày dép nam đa dạng kiểu dáng'),
(8, 'Đồ lót', 'Đồ lót nam thoáng mát và bền đẹp'),
(9, 'Quần short', 'Quần short nam năng động, trẻ trung'),
(10, 'Áo len', 'Áo len nam giữ ấm vào mùa đông');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
CREATE TABLE IF NOT EXISTS `colors` (
  `color_id` int NOT NULL AUTO_INCREMENT,
  `color_name` varchar(50) DEFAULT NULL,
  `color_code` varchar(7) NOT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`color_id`, `color_name`, `color_code`) VALUES
(1, 'Đen', '#000000'),
(2, 'Trắng', '#FFFFFF'),
(3, 'Xám', '#808080'),
(4, 'Xanh dương', '#0000FF'),
(5, 'Đỏ', '#FF0000'),
(6, 'Nâu', '#A52A2A'),
(7, 'Xanh lá', '#008000'),
(8, 'Vàng', '#FFFF00'),
(9, 'Cam', '#FFA500'),
(10, 'Hồng', '#FFC0CB');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `product_id` int NOT NULL,
  `expiry_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_value`, `product_id`, `expiry_date`) VALUES
(1, 'GIA50K', 50000.00, 1, '2024-12-31'),
(2, 'GIAM10%', 10.00, 2, '2024-11-30'),
(3, 'SALE20%', 20.00, 3, '2024-10-15'),
(4, 'FREESHIP', 0.00, 4, '2024-12-31'),
(5, 'GIAM30K', 30000.00, 5, '2024-09-30'),
(6, 'XMAS50%', 50.00, 6, '2024-12-25'),
(7, 'HE2024', 100000.00, 7, '2024-06-30'),
(8, 'QUAN5%', 5.00, 8, '2024-07-15'),
(9, 'VIP100K', 100000.00, 9, '2024-12-31'),
(10, 'BLACKFRI', 25.00, 10, '2024-11-25');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `inventory_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `location` varchar(100) DEFAULT NULL,
  `status` enum('in_stock','out_of_stock','reserved') DEFAULT 'in_stock',
  `quantity_alert` int NOT NULL DEFAULT '10',
  PRIMARY KEY (`inventory_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_id`, `quantity`, `updated_at`, `location`, `status`, `quantity_alert`) VALUES
(1, 1, 50, '2024-12-15 10:58:03', 'Kho Hà Nội', 'in_stock', 10),
(2, 2, 30, '2024-12-15 10:58:03', 'Kho Hồ Chí Minh', 'in_stock', 5),
(3, 3, 20, '2024-12-15 10:58:03', 'Kho Đà Nẵng', 'reserved', 5),
(4, 4, 100, '2024-12-15 10:58:03', 'Kho Cần Thơ', 'in_stock', 20),
(5, 5, 5, '2024-12-15 10:58:03', 'Kho Hải Phòng', 'out_of_stock', 5),
(6, 6, 75, '2024-12-15 10:58:03', 'Kho Hà Nội', 'in_stock', 15),
(7, 7, 10, '2024-12-15 10:58:03', 'Kho Vũng Tàu', 'reserved', 5),
(8, 8, 40, '2024-12-15 10:58:03', 'Kho Nghệ An', 'in_stock', 10),
(9, 9, 15, '2024-12-15 10:58:03', 'Kho Huế', 'reserved', 5),
(10, 10, 0, '2024-12-15 10:58:03', 'Kho Quảng Ninh', 'out_of_stock', 10);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`notification_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `order_id`, `message`, `created_at`, `is_read`) VALUES
(1, 1, 'Đơn hàng của bạn đang được xử lý', '2024-12-15 17:57:24', 0),
(2, 2, 'Đơn hàng của bạn đã hoàn thành', '2024-12-15 17:57:24', 1),
(3, 3, 'Đơn hàng của bạn đã bị hủy', '2024-12-15 17:57:24', 1),
(4, 1, 'Đơn hàng đang được chuẩn bị giao', '2024-12-15 17:57:24', 0),
(5, 2, 'Cảm ơn bạn đã mua hàng, chúc bạn một ngày tốt lành', '2024-12-15 17:57:24', 1),
(6, 3, 'Chúng tôi sẽ liên hệ lại để giải quyết vấn đề', '2024-12-15 17:57:24', 0),
(7, 1, 'Đơn hàng của bạn đã xuất kho', '2024-12-15 17:57:24', 1),
(8, 2, 'Đơn hàng được giao thành công', '2024-12-15 17:57:24', 1),
(9, 3, 'Đơn hàng đang chờ xác nhận', '2024-12-15 17:57:24', 0),
(10, 1, 'Đơn hàng đã được cập nhật trạng thái mới', '2024-12-15 17:57:24', 0),
(11, 1, 'Đơn hàng của bạn đang được xử lý', '2024-12-15 17:58:18', 0),
(12, 2, 'Đơn hàng của bạn đã hoàn thành', '2024-12-15 17:58:18', 1),
(13, 3, 'Đơn hàng của bạn đã bị hủy', '2024-12-15 17:58:18', 1),
(14, 1, 'Đơn hàng đang được chuẩn bị giao', '2024-12-15 17:58:18', 0),
(15, 2, 'Cảm ơn bạn đã mua hàng, chúc bạn một ngày tốt lành', '2024-12-15 17:58:18', 1),
(16, 3, 'Chúng tôi sẽ liên hệ lại để giải quyết vấn đề', '2024-12-15 17:58:18', 0),
(17, 1, 'Đơn hàng của bạn đã xuất kho', '2024-12-15 17:58:18', 1),
(18, 2, 'Đơn hàng được giao thành công', '2024-12-15 17:58:18', 1),
(19, 3, 'Đơn hàng đang chờ xác nhận', '2024-12-15 17:58:18', 0),
(20, 1, 'Đơn hàng đã được cập nhật trạng thái mới', '2024-12-15 17:58:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_price` decimal(10,2) NOT NULL,
  `order_status` enum('Pending','Processing','Completed','Cancelled') DEFAULT 'Pending',
  `payment_method` varchar(50) NOT NULL DEFAULT 'COD',
  `shipping_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_phone`, `order_date`, `total_price`, `order_status`, `payment_method`, `shipping_address`) VALUES
(1, 1, 'Nguyễn Anh', 'nguyenanh@gmail.com', '0987654321', '2024-12-15 17:52:52', 750000.00, 'Processing', 'COD', 'Hà Nội, Việt Nam'),
(2, 2, 'Trần Bình', 'tranbinh@gmail.com', '0912345678', '2024-12-15 17:52:52', 1200000.00, 'Completed', 'COD', 'Hồ Chí Minh, Việt Nam'),
(3, 3, 'Hoàng Minh', 'hoangminh@gmail.com', '0909876543', '2024-12-15 17:52:52', 500000.00, 'Pending', 'COD', 'Đà Nẵng, Việt Nam');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `detail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(1, 1, 'Áo thun cotton nam', 2, 200000.00),
(2, 1, 'Quần short kaki', 1, 300000.00),
(3, 2, 'Áo sơ mi trắng dài tay', 3, 350000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `discount` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `category_id`, `status`, `image_url`, `created_at`, `discount`) VALUES
(1, 'Áo thun cotton nam', 'Áo thun nam chất liệu cotton mềm mại', 200000.00, 1, 'active', 'aothun.jpg', '2024-12-15 10:48:07', 10.00),
(2, 'Áo sơ mi dài tay', 'Áo sơ mi trắng lịch lãm cho nam', 350000.00, 2, 'active', 'ao_somi.jpg', '2024-12-15 10:48:07', 5.00),
(3, 'Quần jeans slimfit', 'Quần jeans nam dáng ôm phong cách', 500000.00, 3, 'active', 'jeans.jpg', '2024-12-15 10:48:07', 15.00),
(4, 'Quần kaki', 'Quần kaki nam thoáng mát', 450000.00, 4, 'active', 'Pant_kaki.jpg', '2024-12-15 10:48:07', 10.00),
(5, 'Áo khoác', 'Áo khoác nam chất liệu dù', 600000.00, 5, 'active', 'aokhoac.jpg', '2024-12-15 10:48:07', 0.00),
(6, 'Thắt lưng da bò', 'Thắt lưng nam làm từ da bò thật', 250000.00, 6, 'active', 'thatlung.jpg', '2024-12-15 10:48:07', 0.00),
(7, 'Giày sneaker trắng', 'Giày sneaker nam màu trắng trẻ trung', 800000.00, 7, 'active', 'running_shoes.jpg', '2024-12-15 10:48:07', 20.00),
(8, 'Đồ lót cotton nam', 'Đồ lót nam chất liệu cotton co giãn', 150000.00, 8, 'active', 'underwear.jpg', '2024-12-15 10:48:07', 5.00),
(9, 'Quần short kaki', 'Quần short nam cho ngày hè thoải mái', 300000.00, 9, 'active', 'quan_short.jpg', '2024-12-15 10:48:07', 10.00),
(10, 'Áo len cổ tròn', 'Áo len giữ ấm cho mùa đông', 400000.00, 10, 'active', 'Lifewear.jpg', '2024-12-15 10:48:07', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `productvariants`
--

DROP TABLE IF EXISTS `productvariants`;
CREATE TABLE IF NOT EXISTS `productvariants` (
  `variant_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `size_id` int DEFAULT NULL,
  `color_id` int DEFAULT NULL,
  `stock_quantity` int DEFAULT NULL,
  PRIMARY KEY (`variant_id`),
  KEY `size_id` (`size_id`),
  KEY `product_id` (`product_id`),
  KEY `color_id` (`color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `productvariants`
--

INSERT INTO `productvariants` (`variant_id`, `product_id`, `size_id`, `color_id`, `stock_quantity`) VALUES
(11, 1, 3, 1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 1, 5, 'Áo thun rất đẹp, chất liệu mềm mịn', '2024-12-15 10:53:22'),
(2, 2, 2, 4, 'Áo sơ mi lịch sự, phù hợp đi làm', '2024-12-15 10:53:22'),
(3, 3, 3, 5, 'Quần jeans vừa vặn, chất lượng tốt', '2024-12-15 10:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

DROP TABLE IF EXISTS `sizes`;
CREATE TABLE IF NOT EXISTS `sizes` (
  `size_id` int NOT NULL AUTO_INCREMENT,
  `size_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_name`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL'),
(5, 'XXL'),
(6, '28'),
(7, '30'),
(8, '32'),
(9, '34'),
(10, '36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('active','blocked') DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `phone`, `address`, `created_at`, `role`, `status`, `last_login`) VALUES
(1, 'nguyenanh', '$2y$10$E9ndXz3Q7x4.eCxXzMJET.GKJlgW/kFrzH5Qn/UqfJwBdMJKPqD42\r\n', 'nguyenanh@gmail.com', '0987654321', 'Hà Nội, Việt Nam', '2024-12-15 10:49:11', 'user', 'active', NULL),
(2, 'tranbinh', '$2y$10$E9ndXz3Q7x4.eCxXzMJET.GKJlgW/kFrzH5Qn/UqfJwBdMJKPqD42\r\n', 'tranbinh@gmail.com', '0912345678', 'Hồ Chí Minh, Việt Nam', '2024-12-15 10:49:11', 'user', 'active', NULL),
(3, 'hoangminh', '$2y$10$E9ndXz3Q7x4.eCxXzMJET.GKJlgW/kFrzH5Qn/UqfJwBdMJKPqD42\r\n', 'hoangminh@gmail.com', '0909876543', 'Đà Nẵng, Việt Nam', '2024-12-15 10:49:11', 'user', 'active', NULL),
(4, 'phamquang', '$2y$10$E9ndXz3Q7x4.eCxXzMJET.GKJlgW/kFrzH5Qn/UqfJwBdMJKPqD42\r\n', 'phamquang@admin.com', '0934567890', 'Hà Nội, Việt Nam', '2024-12-15 10:49:11', 'admin', 'active', NULL),
(5, 'lethanh', '$2y$10$E9ndXz3Q7x4.eCxXzMJET.GKJlgW/kFrzH5Qn/UqfJwBdMJKPqD42\r\n', 'lethanh@gmail.com', '0965432109', 'Cần Thơ, Việt Nam', '2024-12-15 10:49:11', 'user', 'active', NULL),
(6, 'domanh', '$2y$10$E9ndXz3Q7x4.eCxXzMJET.GKJlgW/kFrzH5Qn/UqfJwBdMJKPqD42\r\n', 'domanh@gmail.com', '0971234567', 'Hải Phòng, Việt Nam', '2024-12-15 10:49:11', 'user', 'active', NULL),
(7, 'ngocson', '$2y$10$E9ndXz3Q7x4.eCxXzMJET.GKJlgW/kFrzH5Qn/UqfJwBdMJKPqD42\r\n', 'ngocson@gmail.com', '0923456789', 'Huế, Việt Nam', '2024-12-15 10:49:11', 'user', 'active', NULL),
(8, 'phongnguyen', '$2y$10$E9ndXz3Q7x4.eCxXzMJET.GKJlgW/kFrzH5Qn/UqfJwBdMJKPqD42\r\n', 'phongnguyen@gmail.com', '0956781234', 'Vũng Tàu, Việt Nam', '2024-12-15 10:49:11', 'user', 'active', NULL),
(9, 'vuthinh', '$2y$10$E9ndXz3Q7x4.eCxXzMJET.GKJlgW/kFrzH5Qn/UqfJwBdMJKPqD42\r\n', 'vuthinh@gmail.com', '0945678910', 'Nghệ An, Việt Nam', '2024-12-15 10:49:11', 'user', 'active', NULL),
(10, 'thienbao', '$2y$10$E9ndXz3Q7x4.eCxXzMJET.GKJlgW/kFrzH5Qn/UqfJwBdMJKPqD42\r\n', 'thienbao@gmail.com', '0998765432', 'Quảng Ninh, Việt Nam', '2024-12-15 10:49:11', 'user', 'active', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`detail_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `productvariants`
--
ALTER TABLE `productvariants`
  ADD CONSTRAINT `productvariants_ibfk_1` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`size_id`),
  ADD CONSTRAINT `productvariants_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `productvariants_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `colors` (`color_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
