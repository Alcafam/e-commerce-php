-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 25, 2024 at 10:45 PM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Dress', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(2, 'Pant', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(3, 'Polo', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(4, 'Jacket', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(5, 'Blouse', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(6, 'Skirt', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(7, 'Cap', '2024-02-26 01:25:05', '2024-02-26 01:25:05'),
(8, 'shoes', '2024-02-26 01:36:26', '2024-02-26 01:36:26'),
(9, 'sweater', '2024-02-26 01:47:41', '2024-02-26 01:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `status_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `billing` varchar(255) DEFAULT NULL,
  `shipping` varchar(255) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orders_users1_idx` (`user_id`),
  KEY `fk_orders_statuses1_idx` (`status_id`),
  KEY `fk_orders_products1_idx` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status_id`, `product_id`, `billing`, `shipping`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 4, '{\"first_name\":\"sdads\",\"last_name\":\"dasda\",\"address_1\":\"sdasdasd\",\"address_2\":\"sdasd\",\"city\":\"sada\",\"state\":\"sdad\",\"zipcode\":\"ad\"}', '{\"first_name\":\"sdads\",\"last_name\":\"dasda\",\"address_1\":\"sdasdasd\",\"address_2\":\"sdasd\",\"city\":\"sada\",\"state\":\"sdad\",\"zipcode\":\"ad\"}', 3, '2024-02-21 00:42:53', '2024-02-25 23:55:45'),
(3, 2, 5, 2, '{\"first_name\":\"Ethel\",\"last_name\":\"Joyce\",\"address_1\":\"Purok 1\", \"address_2\":\"North Sanitary Camp\", \"city\":\"Baguio\", \"state\":\"Benguet\", \"zipcode\":\"2600\"}', '{\"first_name\":\"Ethel\",\"last_name\":\"Joyce\",\"address_1\":\"Purok 1\", \"address_2\":\"North Sanitary Camp\", \"city\":\"Baguio\", \"state\":\"Benguet\", \"zipcode\":\"2600\"}', 1, '2024-02-21 00:42:53', '2024-02-26 01:34:53'),
(4, 2, 5, 1, '{\"first_name\":\"sdads\",\"last_name\":\"dasda\",\"address_1\":\"sdasdasd\",\"address_2\":\"sdasd\",\"city\":\"sada\",\"state\":\"sdad\",\"zipcode\":\"ad\"}', '{\"first_name\":\"sdads\",\"last_name\":\"dasda\",\"address_1\":\"sdasdasd\",\"address_2\":\"sdasd\",\"city\":\"sada\",\"state\":\"sdad\",\"zipcode\":\"ad\"}', 1, '2024-02-21 00:42:53', '2024-02-26 00:14:13'),
(8, 2, 3, 6, '{\"first_name\":\"Ethel\",\"last_name\":\"Joyce\",\"address_1\":\"Purok 1\", \"address_2\":\"North Sanitary Camp\", \"city\":\"Baguio\", \"state\":\"Benguet\", \"zipcode\":\"2600\"}', '{\"first_name\":\"Ethel\",\"last_name\":\"Joyce\",\"address_1\":\"Purok 1\", \"address_2\":\"North Sanitary Camp\", \"city\":\"Baguio\", \"state\":\"Benguet\", \"zipcode\":\"2600\"}', 1, '2024-02-21 00:42:53', '2024-02-21 00:42:53'),
(11, 2, 3, 16, '{\"first_name\":\"Marjy\",\"last_name\":\"Galingan\",\"address_1\":\"dfasfasf\",\"address_2\":\"dsfsadf\",\"city\":\"dfas\",\"state\":\"asfdsa\",\"zipcode\":\"fafa\"}', '{\"first_name\":\"Marjy\",\"last_name\":\"Galingan\",\"address_1\":\"dfasfasf\",\"address_2\":\"dsfsadf\",\"city\":\"dfas\",\"state\":\"asfdsa\",\"zipcode\":\"fafa\"}', 3, '2024-02-25 21:47:54', '2024-02-26 01:34:38'),
(12, 2, 5, 5, '{\"first_name\":\"sdads\",\"last_name\":\"dasda\",\"address_1\":\"sdasdasd\",\"address_2\":\"sdasd\",\"city\":\"sada\",\"state\":\"sdad\",\"zipcode\":\"ad\"}', '{\"first_name\":\"sdads\",\"last_name\":\"dasda\",\"address_1\":\"sdasdasd\",\"address_2\":\"sdasd\",\"city\":\"sada\",\"state\":\"sdad\",\"zipcode\":\"ad\"}', 1, '2024-02-25 23:15:03', '2024-02-26 01:21:05'),
(14, 1, 4, 18, '{\"first_name\":\"Emmo\",\"last_name\":\"Fersan\",\"address_1\":\"gtedf\",\"address_2\":\"dfewf\",\"city\":\"dsfdasf\",\"state\":\"dfsd\",\"zipcode\":\"efwf\"}', '{\"first_name\":\"Emme\",\"last_name\":\"Ferson\",\"address_1\":\"dsads\",\"address_2\":\"sdasdad\",\"city\":\"sdsad\",\"state\":\"sd\",\"zipcode\":\"sdsad\"}', 2, '2024-02-25 23:58:19', '2024-02-26 01:42:56'),
(15, 3, 3, 19, '{\"first_name\":\"Emmo\",\"last_name\":\"Fersan\",\"address_1\":\"gtedf\",\"address_2\":\"dfewf\",\"city\":\"dsfdasf\",\"state\":\"dfsd\",\"zipcode\":\"efwf\"}', '{\"first_name\":\"Emme\",\"last_name\":\"Ferson\",\"address_1\":\"dsads\",\"address_2\":\"sdasdad\",\"city\":\"sdsad\",\"state\":\"sd\",\"zipcode\":\"sdsad\"}', 4, '2024-02-26 00:27:43', '2024-02-26 00:29:01'),
(23, 2, 5, 6, '{\"first_name\":\"Crysta\",\"last_name\":\"Emmer\",\"address_1\":\"fdasfa\",\"address_2\":\"dfsa\",\"city\":\"city\",\"state\":\"afd\",\"zipcode\":\"sfa\"}', '{\"first_name\":\"Crysta\",\"last_name\":\"Emmer\",\"address_1\":\"fdasfa\",\"address_2\":\"dfsa\",\"city\":\"city\",\"state\":\"afd\",\"zipcode\":\"sfa\"}', 1, '2024-02-26 01:40:49', '2024-02-26 01:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int UNSIGNED NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `description` longtext,
  `price` decimal(10,2) DEFAULT NULL,
  `shipping_fee` decimal(10,2) DEFAULT NULL,
  `images` varchar(250) DEFAULT NULL,
  `stock` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_products_categories1_idx` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `description`, `price`, `shipping_fee`, `images`, `stock`, `created_at`, `updated_at`) VALUES
(1, 1, 'Purple Elegant Gown Updated Updated Updated', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '1599.00', '250.00', '{\"extras\": [\"4.png\"], \"main_pic\": \"1.png\"}', '2', '2024-02-17 01:48:42', '2024-02-26 01:46:54'),
(2, 1, 'Dark Blue Elegant Gown Updated', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '1499.00', '250.00', '{\"extras\": [\"3.png\", \"4.png\"], \"main_pic\": \"2.png\"}', '1', '2024-02-17 01:48:42', '2024-02-26 01:23:56'),
(4, 4, 'Winter Jacket', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', '1239.00', '250.00', '{\"extras\": [\"12.png\", \"13.png\"], \"main_pic\": \"14.png\"}', '102', '2024-02-17 01:48:42', '2024-02-24 22:48:25'),
(5, 4, 'Denim Jacket', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', '1599.00', '250.00', '{\"extras\": [], \"main_pic\": \"17.png\"}', '145', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(6, 5, 'White Long Sleeve Blouse', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '469.00', '250.00', '{\"extras\": [], \"main_pic\": \"25.png\"}', '41', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(16, 1, 'Light Casual Dress', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam hendrerit nisi sed sollicitudin pellentesque. Nunc posuere purus rhoncus pulvinar aliquam. Ut aliquet tristique nisl vitae volutpat. Nulla aliquet porttitor venenatis. Donec a dui et dui fringilla consectetur id nec massa. Aliquam erat volutpat. Sed ut dui ut lacus dictum fermentum vel tincidunt neque. Sed sed lacinia lectus. Duis sit amet sodales felis. Duis nunc eros, mattis at dui ac, convallis semper risus. In adipiscing ultrices tellus, in suscipit massa vehicula eu.', '467.00', '250.00', '{\"extras\": [\"10.png\"], \"main_pic\": \"7.png\"}', '121', '2024-02-21 19:56:09', '2024-02-21 19:56:09'),
(17, 2, 'Denim Pant', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '599.00', '250.00', '{\"main_pic\": \"21.png\", \"extras\": []}', '82', '2024-02-21 22:32:41', '2024-02-21 22:32:41'),
(18, 1, 'Dark Casual Dress', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Massa id neque aliquam vestibulum morbi blandit cursus risus. Rutrum quisque non tellus orci. Tempus egestas sed sed risus pretium quam vulputate dignissim. Morbi tristique senectus et netus et malesuada fames ac turpis. Semper risus in hendrerit gravida. Molestie at elementum eu facilisis sed. Justo nec ultrices dui sapien. Purus sit amet volutpat consequat mauris nunc congue nisi vitae. Platea dictumst vestibulum rhoncus est pellentesque elit ullamcorper. Nec sagittis aliquam malesuada bibendum arcu vitae elementum.', '467.00', '250.00', '{\"extras\": [\"6.png\", \"9.png\"], \"main_pic\": \"8.png\"}', '228', '2024-02-21 22:34:45', '2024-02-23 11:13:57'),
(19, 3, 'Casual Polo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Massa id neque aliquam vestibulum morbi blandit cursus risus. Rutrum quisque non tellus orci. Tempus egestas sed sed risus pretium quam vulputate dignissim. Morbi tristique senectus et netus et malesuada fames ac turpis. Semper risus in hendrerit gravida. Molestie at elementum eu facilisis sed. Justo nec ultrices dui sapien. Purus sit amet volutpat consequat mauris nunc congue nisi vitae. Platea dictumst vestibulum rhoncus est pellentesque elit ullamcorper. Nec sagittis aliquam malesuada bibendum arcu vitae elementum.', '355.00', '250.00', '{\"main_pic\": \"24.png\", \"extras\": [\"23.png\"]}', '52', '2024-02-21 22:35:49', '2024-02-21 22:35:49'),
(20, 4, 'Wind Breaker Jacket', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '677.00', '250.00', '{\"main_pic\": \"15.png\", \"extras\": []}', '54', '2024-02-24 22:51:23', '2024-02-24 22:51:23'),
(24, 5, 'New Product', 'fdafdafafsafdsa', '342.00', NULL, '{\"main_pic\": \"27.png\", \"extras\": [\"26.png\"]}', '32', '2024-02-26 01:47:25', '2024-02-26 01:47:25');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `products_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `review` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reviews_products1_idx` (`products_id`),
  KEY `fk_reviews_users1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'On-Cart', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(2, 'Pending', '0000-00-00 00:00:00', '2024-02-17 01:48:42'),
(3, 'On-Process', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(4, 'Shipped', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(5, 'Delivered', '2024-02-17 01:48:42', '2024-02-17 01:48:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `salt` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `is_admin`, `first_name`, `last_name`, `email`, `password`, `salt`, `created_at`, `updated_at`) VALUES
(1, 1, 'Marjy', 'Galingan', 'galinganmarjy61@gmail.com', '25d55ad283aa400af464c76d713c07addef46f86aadf9d1e26b9ccc6d06f30c82b155360f452', 'def46f86aadf9d1e26b9ccc6d06f30c82b155360f452', '2024-02-17 01:48:42', '2024-02-17 01:48:42'),
(2, 0, 'Ethel', 'Joyce', '2201478@slu.edu.ph', '25d55ad283aa400af464c76d713c07add60b7142f4dc7950ceb9fb40d7618c9462e52447f17b', 'd60b7142f4dc7950ceb9fb40d7618c9462e52447f17b', '2024-02-21 00:42:53', '2024-02-21 00:42:53'),
(3, 0, 'Emme', 'Ferson', 'emme@gmail.com', '25d55ad283aa400af464c76d713c07add68b98a4388bd28ac9a13d2c28361b751e0967dd2b1f', 'd68b98a4388bd28ac9a13d2c28361b751e0967dd2b1f', '2024-02-26 00:27:28', '2024-02-26 00:27:28');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_products1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_orders_statuses1` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `fk_orders_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_reviews_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
