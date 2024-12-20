-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 17, 2024 at 09:41 AM
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
-- Database: `banhang_aoquan`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) CHARACTER SET utf8mb3 DEFAULT NULL,
  `description` text CHARACTER SET utf8mb3,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
(1, 'T-Shirts', 'Various styles of t-shirts'),
(2, 'Shirts', 'Formal and casual shirts'),
(3, 'Jeans', 'Different styles of jeans'),
(4, 'Jackets', 'Warm and stylish jackets'),
(5, 'Suits', 'Formal suits for all occasions'),
(6, 'Sweaters', 'Cozy and warm sweaters'),
(7, 'Hoodies', 'Comfortable and casual hoodies'),
(8, 'Shorts', 'Variety of shorts'),
(9, 'Accessories', 'Belts, hats, and more'),
(10, 'Footwear', 'Shoes and sandals');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
CREATE TABLE IF NOT EXISTS `colors` (
  `color_id` int NOT NULL AUTO_INCREMENT,
  `color_name` varchar(50) CHARACTER SET utf8mb3 DEFAULT NULL,
  `color_code` varchar(7) CHARACTER SET utf8mb3 NOT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`color_id`, `color_name`, `color_code`) VALUES
(1, 'Red', '#FF0000'),
(2, 'Blue', '#0000FF'),
(3, 'Black', '#000000'),
(4, 'White', '#FFFFFF'),
(5, 'Green', '#008000'),
(6, 'Yellow', '#FFFF00'),
(7, 'Gray', '#808080'),
(8, 'Navy', '#000080'),
(9, 'Maroon', '#800000'),
(10, 'Purple', '#800080');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8mb3 NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `product_id` int NOT NULL,
  `expiry_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_value`, `product_id`, `expiry_date`) VALUES
(1, 'SUMMER20', 20.00, 1, '2024-12-31');

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
  `location` varchar(100) CHARACTER SET utf8mb3 DEFAULT NULL,
  `status` enum('in_stock','out_of_stock','reserved') CHARACTER SET utf8mb3 DEFAULT 'in_stock',
  `quantity_alert` int NOT NULL DEFAULT '10',
  PRIMARY KEY (`inventory_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_id`, `quantity`, `updated_at`, `location`, `status`, `quantity_alert`) VALUES
(1, 1, 100, '2024-12-05 18:18:54', NULL, 'in_stock', 10),
(2, 2, 50, '2024-12-05 18:18:54', NULL, 'in_stock', 10),
(3, 3, 75, '2024-12-05 18:18:54', NULL, 'in_stock', 10),
(4, 4, 25, '2024-12-05 18:18:54', NULL, 'in_stock', 10),
(5, 5, 10, '2024-12-05 18:18:54', NULL, 'in_stock', 10),
(6, 6, 60, '2024-12-05 18:18:54', NULL, 'in_stock', 10),
(7, 7, 80, '2024-12-05 18:18:54', NULL, 'in_stock', 10),
(8, 8, 40, '2024-12-05 18:18:54', NULL, 'in_stock', 10),
(9, 9, 90, '2024-12-05 18:18:54', NULL, 'in_stock', 10),
(10, 10, 30, '2024-12-05 18:18:54', NULL, 'in_stock', 10);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb3 NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`notification_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8mb3 DEFAULT NULL,
  `customer_phone` varchar(20) CHARACTER SET utf8mb3 DEFAULT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_price` decimal(10,2) NOT NULL,
  `order_status` enum('Pending','Processing','Completed','Cancelled') CHARACTER SET utf8mb3 DEFAULT 'Pending',
  `payment_method` varchar(50) CHARACTER SET utf8mb3 NOT NULL DEFAULT 'COD',
  `shipping_address` varchar(255) CHARACTER SET utf8mb3 DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `customer_id_2` (`customer_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_phone`, `order_date`, `total_price`, `order_status`, `payment_method`, `shipping_address`) VALUES
(1, 1, 'john_doe', 'john@example.com', '1234567890', '2024-12-05 18:18:54', 59.99, 'Pending', 'COD', NULL),
(2, 2, 'jane_smith', 'jane@example.com', '0987654321', '2024-12-05 18:18:54', 149.99, 'Cancelled', 'COD', NULL),
(3, 3, 'alice_jones', 'alice@example.com', '1122334455', '2024-12-05 18:18:54', 29.99, 'Pending', 'COD', NULL),
(4, 4, 'bob_brown', 'bob@example.com', '6677889900', '2024-12-05 18:18:54', 99.99, '', 'COD', NULL),
(5, 5, 'chris_white', 'chris@example.com', '5566778899', '2024-12-05 18:18:54', 19.99, 'Completed', 'COD', NULL),
(6, 6, 'david_clark', 'david@example.com', '3344556677', '2024-12-05 18:18:54', 39.99, 'Cancelled', 'COD', NULL),
(7, 7, 'emma_wilson', 'emma@example.com', '4433221100', '2024-12-05 18:18:54', 14.99, 'Pending', 'COD', NULL),
(8, 8, 'frank_adams', 'frank@example.com', '2233445566', '2024-12-05 18:18:54', 24.99, 'Completed', 'COD', NULL),
(9, 9, 'grace_hall', 'grace@example.com', '9988776655', '2024-12-05 18:18:54', 49.99, 'Pending', 'COD', NULL),
(10, 10, 'hannah_lee', 'hannah@example.com', '1100223344', '2024-12-05 18:18:54', 89.99, 'Pending', 'COD', NULL),
(11, 13, 'Võ Nhật Hao', 'vonhathao20082002@gmail.com', '0918726716', '2024-12-16 16:49:11', 9.99, 'Pending', 'COD', '39 cao lỗ'),
(28, 11, 'hoy', 'admin@gmail.com', '0918726716', '2024-12-16 16:57:18', 9.99, 'Pending', 'COD', '123'),
(39, 11, 'hoy', 'admin@gmail.com', '0918726716', '2024-12-16 17:18:56', 9.99, 'Pending', 'COD', '123'),
(40, 15, 'Võ Nhật Hào', 'vonhathao20082002@gmail.com', '0918726716', '2024-12-16 23:34:31', 19.98, 'Pending', 'COD', '39 Cao Lỗ'),
(41, 14, 'Võ Nhật Hào', 'vonhathao20082002@gmail.com', '0918726716', '2024-12-16 23:43:21', 19.98, 'Pending', 'COD', '39 Cao Lỗ');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `detail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb3 NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(1, 1, 'Classic T-Shirt', 2, 9.99),
(2, 2, 'Formal Shirt', 1, 19.99),
(3, 3, 'Blue Jeans', 1, 29.99),
(4, 4, 'Leather Jacket', 1, 99.99),
(5, 5, 'Business Suit', 1, 149.99),
(6, 6, 'Wool Sweater', 1, 39.99),
(7, 7, 'Hooded Sweatshirt', 1, 19.99),
(8, 8, 'Casual Shorts', 1, 14.99),
(9, 9, 'Leather Belt', 1, 24.99),
(10, 10, 'Running Shoes', 1, 49.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb3 DEFAULT NULL,
  `description` text CHARACTER SET utf8mb3,
  `price` decimal(10,2) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb3 DEFAULT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb3 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `discount` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `category_id`, `status`, `image_url`, `created_at`, `discount`) VALUES
(1, 'Classic T-Shirt', 'A plain classic t-shirt.', 9.99, 1, 'Available', 'classic_tshirt.jpg', '2024-12-05 18:18:54', 0.00),
(2, 'Formal Shirt', 'A stylish formal shirt.', 19.99, 2, 'Out of Stock', 'formal_shirt.jpg', '2024-12-05 18:18:54', 0.00),
(3, 'Blue Jeans', 'Comfortable blue jeans.', 29.99, 3, 'Available', 'blue_jeans.jpg', '2024-12-05 18:18:54', 0.00),
(4, 'Leather Jacket', 'A premium leather jacket.', 99.99, 4, 'Available', 'leather_jacket.jpg', '2024-12-05 18:18:54', 0.00),
(5, 'Business Suit', 'A formal business suit.', 149.99, 5, 'Out of Stock', 'business_suit.jpg', '2024-12-05 18:18:54', 0.00),
(6, 'Wool Sweater', 'A warm wool sweater.', 39.99, 6, 'Available', 'wool_sweater.jpg', '2024-12-05 18:18:54', 0.00),
(7, 'Hooded Sweatshirt', 'A cozy hooded sweatshirt.', 19.99, 7, 'Available', 'hooded_sweatshirt.jpg', '2024-12-05 18:18:54', 0.00),
(8, 'Casual Shorts', 'Light and comfortable shorts.', 14.99, 8, 'Out of Stock', 'casual_shorts.jpg', '2024-12-05 18:18:54', 0.00),
(9, 'Leather Belt', 'A stylish leather belt.', 24.99, 9, 'Available', 'leather_belt.jpg', '2024-12-05 18:18:54', 0.00),
(10, 'Running Shoes', 'Comfortable running shoes.', 49.99, 10, 'Available', 'running_shoes.jpg', '2024-12-05 18:18:54', 0.00);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productvariants`
--

INSERT INTO `productvariants` (`variant_id`, `product_id`, `size_id`, `color_id`, `stock_quantity`) VALUES
(1, 1, 1, 1, 10),
(2, 1, 2, 2, 5),
(3, 1, 3, 3, 8),
(4, 1, 1, 1, 50),
(5, 1, 2, 2, 40),
(6, 2, 3, 3, 30),
(7, 2, 4, 4, 20),
(8, 3, 5, 5, 10),
(9, 4, 6, 6, 60),
(10, 5, 7, 7, 70),
(11, 6, 8, 8, 80),
(12, 7, 9, 9, 90),
(13, 8, 10, 10, 100);

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
  `comment` text CHARACTER SET utf8mb3,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 1, 5, 'Great quality!', '2024-12-05 18:18:54'),
(2, 2, 2, 4, 'Very comfortable.', '2024-12-05 18:18:54'),
(3, 3, 3, 3, 'Satisfactory.', '2024-12-05 18:18:54'),
(4, 4, 4, 5, 'Excellent design.', '2024-12-05 18:18:54'),
(5, 5, 5, 4, 'Good value for money.', '2024-12-05 18:18:54'),
(6, 6, 6, 5, 'Very warm and cozy.', '2024-12-05 18:18:54'),
(7, 7, 7, 4, 'Nice fit.', '2024-12-05 18:18:54'),
(8, 8, 8, 5, 'Perfect for summer.', '2024-12-05 18:18:54'),
(9, 9, 9, 3, 'Decent product.', '2024-12-05 18:18:54'),
(10, 10, 10, 4, 'Comfortable shoes.', '2024-12-05 18:18:54');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

DROP TABLE IF EXISTS `sizes`;
CREATE TABLE IF NOT EXISTS `sizes` (
  `size_id` int NOT NULL AUTO_INCREMENT,
  `size_name` varchar(50) CHARACTER SET utf8mb3 DEFAULT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_name`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL'),
(5, 'XXL'),
(6, 'XS'),
(7, 'XXXL'),
(8, '4XL'),
(9, '5XL'),
(10, '6XL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb3 DEFAULT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb3 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb3 DEFAULT NULL,
  `address` text CHARACTER SET utf8mb3,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','user') CHARACTER SET utf8mb3 DEFAULT 'user',
  `status` enum('active','blocked') CHARACTER SET utf8mb3 DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `fullname`, `password`, `email`, `phone`, `address`, `created_at`, `role`, `status`, `last_login`) VALUES
(1, 'john_doe', NULL, 'password1', 'john@example.com', '1234567890', '123 Main St', '2024-12-05 18:18:54', 'user', 'active', NULL),
(2, 'jane_smith', NULL, 'password2', 'jane@example.com', '0987654321', '456 Oak St', '2024-12-05 18:18:54', 'user', 'active', NULL),
(3, 'alice_jones', NULL, 'password3', 'alice@example.com', '1122334455', '789 Pine St', '2024-12-05 18:18:54', 'user', 'active', NULL),
(4, 'bob_brown', NULL, 'password4', 'bob@example.com', '6677889900', '321 Birch St', '2024-12-05 18:18:54', 'user', 'active', NULL),
(5, 'chris_white', NULL, 'password5', 'chris@example.com', '5566778899', '654 Cedar St', '2024-12-05 18:18:54', 'user', 'blocked', NULL),
(6, 'david_clark', NULL, 'password6', 'david@example.com', '3344556677', '987 Elm St', '2024-12-05 18:18:54', 'user', 'active', NULL),
(7, 'emma_wilson', NULL, 'password7', 'emma@example.com', '4433221100', '654 Maple St', '2024-12-05 18:18:54', 'user', 'active', NULL),
(8, 'frank_adams', NULL, 'password8', 'frank@example.com', '2233445566', '321 Spruce St', '2024-12-05 18:18:54', 'user', 'active', NULL),
(9, 'grace_hall', NULL, 'password9', 'grace@example.com', '9988776655', '789 Willow St', '2024-12-05 18:18:54', 'user', 'active', NULL),
(10, 'hannah_lee', NULL, 'password10', 'hannah@example.com', '1100223344', '123 Chestnut St', '2024-12-05 18:18:54', 'user', 'active', NULL),
(11, 'hoy', 'Võ Nhật Hào', '$2y$10$JAxMHZOw0rp1CVeIAb.OhOQAgx0bpwrFor6YZqa/UKbywPHhNxJlK', 'vonhathao20082002@gmail.com', '0918726716', 'aaa', '2024-12-12 17:49:59', 'admin', 'active', NULL),
(12, 'hoy1', NULL, '$2y$10$R6WzrmxDi0SABWMqLTLkHeat9e84WRKPi5V2TEjmosyQgshQxdEFK', 'admin@gmail.com', '0918726716', NULL, '2024-12-14 14:46:04', 'admin', 'active', NULL),
(13, '', 'Võ Nhật Hào', '$2y$10$dzwfN/jNO/Nr/GCfd/WbsutDWw7Fckho6S3iBHnFMhP5PzA6gtMCu', 'von2002@gmail.com', '0918726711', '39 Cao Lỗ', '2024-12-15 17:58:12', 'user', 'active', NULL),
(14, 'hoy2', NULL, '$2y$10$lMlyHnrnE3hO6/Ex4RcYTu8dWMuVxMX/XbTbTs9/H1aiKqs7fyIoq', 'vonhat@gmail.com', '0918726716', NULL, '2024-12-16 15:53:07', 'admin', 'active', NULL),
(15, 'NhaatHao1', 'Võ Nhật Hao', '$2y$10$8x6dw5SlUK.VxWyN6G.yzepZ59h54uO6XtfuQEdaBfp6Lv49GwDgO', 'vonhathao20@gmail.com', '0918726716', '39 Cao Lỗ', '2024-12-16 16:31:42', 'user', 'active', NULL);

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
