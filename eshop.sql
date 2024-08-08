-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 22, 2023 at 03:19 AM
-- Server version: 8.0.35-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int NOT NULL,
  `identification` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `freight` double(8,2) NOT NULL,
  `is_verified` int NOT NULL DEFAULT '0',
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `delivery_type` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `phone`, `identification`, `email_number`, `area_name`, `building_name`, `freight`, `is_verified`, `read`, `created_at`, `updated_at`, `deleted_at`, `delivery_type`) VALUES
(1, 4, '京和 地址1', 12345678, '936176', '134-0087', '東京都江戸川区清新町１丁目', '１−９ ABCビル 101号室', 0.00, 2, 1, '2023-12-19 23:22:15', '2023-12-20 03:49:49', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `qty` double(8,2) NOT NULL DEFAULT '0.00',
  `unit_id` bigint UNSIGNED NOT NULL,
  `price` double(8,2) NOT NULL,
  `is_irregular` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `qty`, `unit_id`, `price`, `is_irregular`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(185, 4, 1, 0.00, 4, 0.00, 1, 0, '2023-12-20 02:36:28', '2023-12-20 03:31:12', '2023-12-20 03:31:12'),
(186, 4, 2, 5.00, 4, 1250.00, 0, 1, '2023-12-20 02:36:31', '2023-12-21 10:56:19', NULL),
(187, 4, 7, 4.00, 6, 800.00, 0, 0, '2023-12-21 00:04:38', '2023-12-21 00:05:10', '2023-12-21 00:05:10'),
(188, 4, 8, 1.00, 6, 200.00, 0, 1, '2023-12-21 00:04:40', '2023-12-21 10:56:19', NULL),
(189, 4, 1, 0.00, 4, 0.00, 1, 0, '2023-12-21 00:10:13', '2023-12-21 03:18:17', '2023-12-21 03:18:17'),
(190, 4, 3, 5.00, 4, 900.00, 0, 1, '2023-12-21 04:02:23', '2023-12-21 10:56:19', NULL),
(191, 4, 5, 5.00, 6, 3500.00, 0, 0, '2023-12-21 04:02:31', '2023-12-21 10:54:14', '2023-12-21 10:54:14'),
(192, 4, 1, 0.00, 4, 0.00, 1, 0, '2023-12-21 11:10:50', '2023-12-21 11:10:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `p_id` int NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `p_id`, `name`, `parent_name`, `order`, `type`, `is_available`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, '食品类', NULL, 1, 0, 1, '2023-12-20 00:21:37', '2023-12-20 00:21:37', NULL),
(2, 1, '粉类', '食品类', 2, 1, 1, '2023-12-20 00:22:05', '2023-12-20 00:22:05', NULL),
(3, 1, '调料', '食品类', 3, 1, 1, '2023-12-20 00:22:17', '2023-12-20 00:22:17', NULL),
(4, 1, '饮料', '食品类', 4, 1, 1, '2023-12-20 00:55:26', '2023-12-20 00:55:26', NULL),
(5, 0, '服務項目', NULL, 5, 0, 1, '2023-12-20 02:08:18', '2023-12-20 02:08:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `unique` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_one` int NOT NULL,
  `user_two` int NOT NULL DEFAULT '1',
  `removed_users` blob,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `unique`, `user_one`, `user_two`, `removed_users`, `created_at`, `updated_at`) VALUES
(1, 'iXBe7TKMU16EFJqf0', 4, 3, NULL, '2022-03-04 03:15:03', '2022-03-04 03:15:03'),
(3, 'g2JV7TmZXOtWcyepI', 18, 2, NULL, '2022-03-04 00:11:33', '2023-03-12 22:35:11'),
(4, 'j1rcwAnLu25kSCE4p', 19, 1, NULL, '2022-03-10 01:16:54', '2022-03-10 01:16:54'),
(7, 'iXBe7TKMU16EFJqf1', 14, 1, NULL, NULL, NULL),
(8, 'iXBe7TKMU16EFJqf2', 15, 1, NULL, NULL, NULL),
(9, 'iXBe7TKMU16EFJqf3', 16, 1, NULL, NULL, NULL),
(10, 'iXBe7TKMU16EFJqf4', 20, 1, NULL, NULL, NULL),
(11, 'iXBe7TKMU16EFJqf5', 21, 1, NULL, NULL, NULL),
(12, 'iXBe7TKMU16EFJqf6', 22, 1, NULL, NULL, NULL),
(15, 'iXBe7TKMU16EFJqf7', 23, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_method`
--

CREATE TABLE `delivery_method` (
  `id` bigint UNSIGNED NOT NULL,
  `method_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_price` int NOT NULL,
  `max_price` int NOT NULL,
  `delivery_fee` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_method`
--

INSERT INTO `delivery_method` (`id`, `method_name`, `min_price`, `max_price`, `delivery_fee`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '模式1 ', 4000, 6000, 50, '2023-03-09 23:31:49', '2023-03-09 23:31:49', '2023-12-19 19:22:00'),
(2, '模式2', 1000, 4000, 100, '2023-03-09 23:31:49', '2023-03-09 23:31:49', '2023-12-19 19:22:00'),
(3, '模式3', 100, 1000, 150, '2023-03-09 23:31:49', '2023-03-09 23:31:49', '2023-12-19 19:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint UNSIGNED NOT NULL,
  `image_src` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `image_src`, `product_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(40, 'product-6581b95b17f25.JPG', 1, '2023-12-20 00:40:11', '2023-12-20 00:40:11', NULL),
(41, 'product-6581bbe7514fa.JPG', 2, '2023-12-20 00:51:03', '2023-12-20 00:51:03', NULL),
(42, 'product-6581bcace096d.JPG', 3, '2023-12-20 00:54:20', '2023-12-20 00:54:20', NULL),
(43, 'product-6581cc54dde1e.JPG', 4, '2023-12-20 02:01:08', '2023-12-20 02:01:08', NULL),
(44, 'product-6581cc9538d37.JPG', 5, '2023-12-20 02:02:13', '2023-12-20 02:02:13', NULL),
(45, 'product-6581ccfc13efb.JPG', 6, '2023-12-20 02:03:56', '2023-12-20 02:03:56', NULL),
(46, 'product-6581cd3c75e30.JPG', 7, '2023-12-20 02:05:00', '2023-12-20 02:05:00', NULL),
(47, 'product-6581cd615c1dd.JPG', 8, '2023-12-20 02:05:37', '2023-12-20 02:05:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `irregular_comments`
--

CREATE TABLE `irregular_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `irregular_comments`
--

INSERT INTO `irregular_comments` (`id`, `cart_id`, `comment`, `confirm`, `created_at`, `updated_at`, `deleted_at`) VALUES
(42, 189, 'asdfasdf', 0, '2023-12-21 00:13:53', '2023-12-21 03:18:17', '2023-12-21 03:18:17');

-- --------------------------------------------------------

--
-- Table structure for table `medias`
--

CREATE TABLE `medias` (
  `id` bigint UNSIGNED NOT NULL,
  `media_src` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `conversation_unique` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int NOT NULL,
  `content_text` text COLLATE utf8mb4_unicode_ci,
  `content_image` text COLLATE utf8mb4_unicode_ci,
  `content_audio` text COLLATE utf8mb4_unicode_ci,
  `content_video` text COLLATE utf8mb4_unicode_ci,
  `sender_id` bigint NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '0',
  `delete_users` blob,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversation_unique`, `type`, `content_text`, `content_image`, `content_audio`, `content_video`, `sender_id`, `is_show`, `delete_users`, `created_at`, `updated_at`, `deleted_at`) VALUES
(295, 'iXBe7TKMU16EFJqf0', 1, 'ggfg', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:33:32', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(296, 'iXBe7TKMU16EFJqf0', 1, 'fgyy', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:33:35', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(297, 'iXBe7TKMU16EFJqf0', 1, 'gugg', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:33:38', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(298, 'iXBe7TKMU16EFJqf0', 1, 'ftggff', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:33:42', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(299, 'iXBe7TKMU16EFJqf0', 1, 'dhhhhj', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:33:50', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(300, 'iXBe7TKMU16EFJqf0', 1, 'fuhh', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:33:55', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(301, 'iXBe7TKMU16EFJqf0', 1, 'fhjj', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:33:58', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(302, 'iXBe7TKMU16EFJqf0', 1, 'fhhhg', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:34:01', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(303, 'iXBe7TKMU16EFJqf0', 1, 'fgh', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:34:05', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(304, 'iXBe7TKMU16EFJqf0', 1, 'fggfghh', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:34:08', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(305, 'iXBe7TKMU16EFJqf0', 1, 'fhhgg', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:34:10', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(306, 'iXBe7TKMU16EFJqf0', 1, 'fyhggg', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:34:13', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(307, 'iXBe7TKMU16EFJqf0', 1, 'fyyggff', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:34:16', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(308, 'iXBe7TKMU16EFJqf0', 1, 'ftygffff', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:34:19', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(309, 'iXBe7TKMU16EFJqf0', 1, 'ttggfff', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:34:22', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(310, 'iXBe7TKMU16EFJqf0', 1, 'hhh', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:43:00', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(311, 'iXBe7TKMU16EFJqf0', 1, 'gggg', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:43:09', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(312, 'iXBe7TKMU16EFJqf0', 1, 'hrlll', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:44:42', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(313, 'iXBe7TKMU16EFJqf0', 1, 'ggg', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:44:45', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(314, 'iXBe7TKMU16EFJqf0', 1, 'hhhh', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:44:48', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(315, 'iXBe7TKMU16EFJqf0', 1, 'fhhgh', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:44:51', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(316, 'iXBe7TKMU16EFJqf0', 1, 'hhhggh', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:44:53', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(317, 'iXBe7TKMU16EFJqf0', 1, 'fyuhggg', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:44:56', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(318, 'iXBe7TKMU16EFJqf0', 1, 'fuggyyu', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:44:59', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(319, 'iXBe7TKMU16EFJqf0', 1, 'jhggg', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:45:01', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(320, 'iXBe7TKMU16EFJqf0', 1, 'gyjhgg', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:45:04', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(321, 'iXBe7TKMU16EFJqf0', 1, 'fyjhgg', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 05:45:07', '2023-12-21 22:23:45', '2023-12-21 22:23:45'),
(322, 'iXBe7TKMU16EFJqf0', 1, 'nihao', NULL, NULL, NULL, 4, 0, NULL, '2023-12-21 10:53:30', '2023-12-21 22:23:45', '2023-12-21 22:23:45');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2022_01_26_235927_create_categories_table', 1),
(4, '2022_01_27_020617_create_units_table', 1),
(5, '2022_01_27_020620_create_products_table', 1),
(6, '2022_01_27_020957_create_medias_table', 1),
(7, '2022_01_27_023725_create_images_table', 1),
(8, '2022_01_27_031442_create_favorites_table', 1),
(9, '2022_01_28_010224_create_carts_table', 1),
(10, '2022_01_28_062722_create_purse_table', 1),
(11, '2022_01_31_053150_create_irregular_comments_table', 1),
(12, '2022_01_31_090231_create_news_categories_table', 1),
(13, '2022_01_31_090445_create_news_titles_table', 1),
(14, '2022_02_03_034830_create_address_table', 1),
(15, '2022_02_03_040015_create_payments_table', 1),
(16, '2022_02_03_041933_create_orders_table', 1),
(17, '2022_02_03_053313_create_news_contents_table', 1),
(18, '2022_02_03_085045_create_order_details_table', 1),
(19, '2022_02_10_134911_create_wholesales_table', 1),
(20, '2022_02_10_135232_create_retailsales_table', 1),
(21, '2022_02_10_135746_create_read_news_table', 1),
(22, '2022_02_11_020229_create_profits_table', 1),
(23, '2022_03_03_044223_add_column_to_orders_table', 2),
(24, '2022_03_03_061029_add_column_to_address_table', 3),
(25, '2022_03_04_011230_create_conversations_table', 4),
(26, '2022_03_04_011600_create_messages_table', 5),
(27, '2022_03_04_034108_add_column_to_messages_table', 6),
(28, '2022_03_04_061922_add_softdelete_messages_table', 7),
(29, '2022_03_10_152321_create_service_time_table', 8),
(31, '2022_07_18_174526_create_tax_table', 9),
(32, '2023_03_09_224106_create_delivery_method_table', 10),
(33, '2023_03_09_231556_add_delivey_method_to_order_table', 11),
(34, '2023_03_09_232750_add_client_message_to_order_detail', 12),
(36, '2023_03_09_233309_add_delivery_type_to_address', 13),
(37, '2023_03_10_062704_add_delivery_type_to_order', 14);

-- --------------------------------------------------------

--
-- Table structure for table `news_categories`
--

CREATE TABLE `news_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_categories`
--

INSERT INTO `news_categories` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '通知', 0, '2022-02-12 16:49:05', '2022-03-10 02:59:59', NULL),
(2, '用户须知', 0, '2022-02-12 16:49:14', '2022-03-10 03:00:19', NULL),
(3, '关于邮费', 0, '2022-02-12 16:49:20', '2022-03-10 03:00:30', NULL),
(4, '公司简介', 0, '2022-02-12 16:49:24', '2022-03-10 03:00:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news_contents`
--

CREATE TABLE `news_contents` (
  `id` bigint UNSIGNED NOT NULL,
  `title_id` bigint UNSIGNED NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_contents`
--

INSERT INTO `news_contents` (`id`, `title_id`, `content`, `product_id`, `image`, `media`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 2, 'VIP is very important for our shop.\r\nSo manager of our shop have decided to sell beer for free to vip guests.\r\nDuration:2022.2.13-2.14', 4, 'product-6207e993515b8.png', NULL, '2022-02-12 17:08:35', '2022-02-12 17:08:35', NULL),
(7, 3, 'Distance from our shop to the guests\' house makes the freight money!\r\nIf you have located on the same city with our shop,it will be convenient,but if you are far away from our shop,we have to use delivering company.So,the freight money will expensive!', 0, 'product-6207e9fa629b7.png', NULL, '2022-02-12 17:10:18', '2022-02-12 17:10:18', NULL),
(10, 1, '“限时优惠”是指在2021年京和物流10月冬上新的活动期间，参与活动的淘宝卖家于指定时间段内在原活动价基础上对活动单品另设折扣让利的优惠权益。\r\n\r\n*特别注意：限时优惠是单品优惠，可与店铺级优惠(比如店铺券等)、跨店满减叠加，卖家设置的时候切记确认优惠力度，避免出现过度让利风险。', 1, 'news-62296a2706e8a.png', NULL, '2022-03-10 03:01:59', '2022-03-10 03:01:59', NULL),
(11, 1, '活动时间\r\n\r\n活动预热和正式时间请参照下表：\r\n分类目时间安排可能会有所不同，请以招商报名入口说明为准;', 0, 'news-62296a4c33a12.png', NULL, '2022-03-10 03:02:36', '2022-03-10 03:02:36', NULL),
(12, 1, 'MERN study for free.Video!\r\nPlease buy the license..It\'s free for 3 days.', 0, NULL, 'news-62296a9ab5c94.mp4', '2022-03-10 03:03:54', '2022-03-10 03:03:54', NULL),
(13, 19, '一、限时优惠玩法介绍\r\n“限时优惠”是指在2021年京和物流10月冬上新的活动期间，参与活动的淘宝卖家于指定时间段内在原活动价基础上对活动单品另设折扣让利的优惠权益。\r\n\r\n*特别注意：限时优惠是单品优惠，可与店铺级优惠(比如店铺券等)、跨店满减叠加，卖家设置的时候切记确认优惠力度，避免出现过度让利风险。 查看商品详细\r\n\r\n活动时间\r\n\r\n活动预热和正式时间请参照下表：\r\n分类目时间安排可能会有所不同，请以招商报名入口说明为准;', 4, NULL, NULL, '2022-03-10 03:04:46', '2022-03-10 03:04:46', NULL),
(14, 1, 'Our shop belong to international commany.\r\nWe promise good service to you.', 1, 'news-6229fb5523b60.gif', NULL, '2022-03-10 12:56:29', '2022-03-10 13:21:25', NULL),
(15, 1, 'This is our shop.\r\nOur shop is samll now, but our service is top.', 0, NULL, 'news-6229fb92523ba.mp4', '2022-03-10 13:22:26', '2022-03-10 13:22:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news_titles`
--

CREATE TABLE `news_titles` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_titles`
--

INSERT INTO `news_titles` (`id`, `category_id`, `title`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '新商品期间优惠通知', 0, '2022-02-12 16:49:29', '2022-03-10 03:01:00', NULL),
(2, 1, 'From tomorrow,beer is free for vips.', 0, '2022-02-12 17:07:16', '2022-02-14 03:38:51', '2022-02-14 03:38:51'),
(3, 2, 'Freight service will discussed with the admin user.', 0, '2022-02-12 17:08:58', '2022-02-12 17:08:58', NULL),
(4, 3, 'How to signup', 0, '2022-02-12 17:10:38', '2022-02-12 17:10:38', NULL),
(5, 3, 'How to create address', 0, '2022-02-12 17:10:47', '2022-02-12 17:10:47', NULL),
(6, 3, 'How to buy products', 0, '2022-02-12 17:10:56', '2022-02-12 17:10:56', NULL),
(7, 3, 'How to discuss with the admin through chatting', 0, '2022-02-12 17:11:20', '2022-02-12 17:11:20', NULL),
(8, 3, 'What is irregular product?', 0, '2022-02-12 17:11:29', '2022-02-12 17:11:29', NULL),
(9, 3, 'What is the difference between 8% and 10% product?', 0, '2022-02-12 17:11:47', '2022-02-12 17:11:47', NULL),
(10, 3, 'How can i make sure about how many products have remained in our shop?', 0, '2022-02-12 17:12:12', '2022-02-12 17:12:12', NULL),
(11, 4, 'Our company\'s location', 0, '2022-02-12 17:12:26', '2022-02-12 17:12:26', NULL),
(12, 4, 'The manage of our shop', 0, '2022-02-12 17:12:41', '2022-02-12 17:12:41', NULL),
(13, 4, 'When did the shop have started?', 0, '2022-02-12 17:12:51', '2022-02-12 17:12:51', NULL),
(14, 4, 'Our programme works on every devices', 0, '2022-02-12 17:13:10', '2022-02-12 17:13:10', NULL),
(15, 2, 'Freight money will be decreased if you buy more than 5000$.', 0, '2022-02-12 17:13:34', '2022-02-12 17:13:34', NULL),
(16, 2, 'If you buy less than 100$,it will be impossible for us to deliver it.', 0, '2022-02-12 17:13:58', '2022-02-12 17:13:58', NULL),
(17, 2, 'You can use point in our shop.', 0, '2022-02-12 17:14:10', '2022-02-12 17:14:10', NULL),
(18, 1, 'When you buy products,your point will be increased!', 0, '2022-02-12 17:14:31', '2022-02-14 03:38:51', '2022-02-14 03:38:51'),
(19, 1, 'Our shop have started service on last month!', 0, '2022-03-10 03:01:03', '2022-03-10 03:01:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `address_id` bigint UNSIGNED NOT NULL,
  `freight` double(8,2) NOT NULL DEFAULT '0.00',
  `point` double(8,2) NOT NULL DEFAULT '0.00',
  `purse_point` int NOT NULL,
  `payment_id` bigint UNSIGNED NOT NULL,
  `status` int NOT NULL,
  `order_from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_method` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `delivery_type` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `address_id`, `freight`, `point`, `purse_point`, `payment_id`, `status`, `order_from`, `delivery_method`, `created_at`, `updated_at`, `deleted_at`, `delivery_type`) VALUES
(24, '2023.12.21 03:33', 4, 1, 1.00, 0.00, 0, 3, 0, '', 1, '2023-12-21 03:33:53', '2023-12-21 03:33:53', NULL, 1),
(25, '2023.12.21 10:56', 4, 1, 1.00, 0.00, 0, 1, 0, '', 1, '2023-12-21 10:56:19', '2023-12-21 10:56:19', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `qty` double(8,2) NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `price` double(8,2) NOT NULL,
  `tax` double(8,2) NOT NULL DEFAULT '0.00',
  `point` int NOT NULL DEFAULT '0',
  `cal_price` double(8,2) NOT NULL,
  `client_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `user_id`, `order_id`, `product_id`, `qty`, `unit_id`, `price`, `tax`, `point`, `cal_price`, `client_message`, `created_at`, `updated_at`, `deleted_at`) VALUES
(54, 4, 24, 2, 5.00, 4, 1250.00, 0.08, 0, 1350.00, NULL, '2023-12-21 03:33:53', '2023-12-21 03:33:53', NULL),
(55, 4, 24, 8, 1.00, 6, 200.00, 0.08, 10, 216.00, NULL, '2023-12-21 03:33:53', '2023-12-21 03:33:53', NULL),
(56, 4, 25, 3, 5.00, 4, 900.00, 0.08, 0, 972.00, NULL, '2023-12-21 10:56:19', '2023-12-21 10:56:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'paypal', 1, '2022-02-12 16:48:49', '2022-03-02 03:11:51', NULL),
(2, '支付宝支付', 1, '2022-02-12 16:48:54', '2022-02-12 16:48:54', NULL),
(3, '微信支付', 1, '2022-03-02 03:12:03', '2022-03-02 03:12:03', NULL),
(5, 'PAYPAY支付', 1, '2022-03-10 03:06:38', '2022-03-10 03:06:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `codeNo` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `pcategory_id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax` double(8,2) DEFAULT NULL,
  `gauge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` double(8,2) NOT NULL DEFAULT '0.00',
  `point` int NOT NULL DEFAULT '0',
  `mark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `related_id` int DEFAULT NULL,
  `is_irregular` tinyint(1) NOT NULL DEFAULT '0',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `codeNo`, `category_id`, `pcategory_id`, `unit_id`, `name`, `tax`, `gauge`, `qty`, `point`, `mark`, `description`, `order`, `related_id`, `is_irregular`, `is_available`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '00300', 2, 1, 4, 'さつま薯殿粉340ｇ　（東栄）', 0.08, '340g', 10.00, 0, '中国', 'さつま薯殿粉340ｇ　（東栄）', 1, 1, 1, 1, '2023-12-20 00:40:11', '2023-12-20 02:13:07', NULL),
(2, '00301', 2, 1, 4, '台湾再来米粉600ｇ（福鹿牌）', 0.08, '600g', 15.00, 0, '中国', '台湾再来米粉600ｇ（福鹿牌）', 2, 2, 0, 1, '2023-12-20 00:51:03', '2023-12-20 00:51:03', NULL),
(3, '00302', 2, 1, 4, 'タピオカ粉　片栗粉400g*25', 0.08, '400g', 25.00, 0, '中国', 'タピオカ粉　片栗粉400g*25', 3, 3, 0, 1, '2023-12-20 00:54:20', '2023-12-20 00:54:20', NULL),
(4, '00318', 3, 1, 6, '海天味极鲜酱油', 0.08, '750ml', 20.00, 10, '中国', '海天味极鲜酱油', 1, 4, 0, 1, '2023-12-20 02:01:08', '2023-12-20 02:01:08', NULL),
(5, '00319', 3, 1, 6, '李锦记 香味酱油', 0.08, '410ml', 30.00, 10, '中国', '李锦记 香味酱油', 2, 5, 0, 1, '2023-12-20 02:02:13', '2023-12-20 02:02:13', NULL),
(6, '00320', 4, 1, 6, '茶派绿茶', 0.08, '500ml', 30.00, 5, '中国', '茶派绿茶', 1, 6, 0, 1, '2023-12-20 02:03:56', '2023-12-20 02:03:56', NULL),
(7, '00321', 4, 1, 6, '茶派红茶', 0.08, '500ml', 30.00, 10, '中国', '茶派红茶', 2, 7, 0, 1, '2023-12-20 02:05:00', '2023-12-20 02:05:00', NULL),
(8, '00322', 4, 1, 6, '茶派荔枝茶', 0.08, '500ml', 30.00, 10, '中国', '茶派荔枝茶', 3, 8, 0, 1, '2023-12-20 02:05:37', '2023-12-20 02:05:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profits`
--

CREATE TABLE `profits` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double(8,2) NOT NULL,
  `profit` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purse`
--

CREATE TABLE `purse` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `point` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purse`
--

INSERT INTO `purse` (`id`, `user_id`, `point`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 4596, '2022-02-12 16:53:33', '2022-03-10 10:17:35', NULL),
(2, 14, 1000, '2022-03-01 11:36:29', '2022-03-03 07:53:49', NULL),
(3, 15, 100, '2022-03-01 13:09:19', '2022-03-01 13:09:19', NULL),
(4, 16, 20, '2022-03-01 13:35:26', '2022-03-01 13:35:26', NULL),
(6, 18, 35, '2022-03-04 08:11:33', '2022-03-04 08:11:33', NULL),
(7, 19, 0, '2022-03-10 09:16:54', '2022-03-10 09:16:54', NULL),
(8, 20, 0, '2023-03-09 22:25:30', '2023-03-09 22:25:35', NULL),
(9, 21, 0, '2023-03-09 22:25:37', '2023-03-09 22:25:39', NULL),
(10, 22, 0, '2023-03-09 22:25:41', '2023-03-09 22:25:42', NULL),
(11, 23, 0, '2023-03-09 22:25:44', '2023-03-09 22:25:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `read_news`
--

CREATE TABLE `read_news` (
  `id` bigint UNSIGNED NOT NULL,
  `title_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retailsales`
--

CREATE TABLE `retailsales` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `retailsale` double(15,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `retailsales`
--

INSERT INTO `retailsales` (`id`, `product_id`, `retailsale`, `is_available`, `created_at`, `updated_at`) VALUES
(26, 1, 200.00, 1, '2023-12-20 00:40:11', '2023-12-20 00:40:11'),
(27, 2, 250.00, 1, '2023-12-20 00:51:03', '2023-12-20 00:51:03'),
(28, 3, 180.00, 1, '2023-12-20 00:54:20', '2023-12-20 00:54:20'),
(29, 4, 500.00, 1, '2023-12-20 02:01:08', '2023-12-20 02:01:08'),
(30, 5, 700.00, 1, '2023-12-20 02:02:13', '2023-12-20 02:02:13'),
(31, 6, 200.00, 1, '2023-12-20 02:03:56', '2023-12-20 02:03:56'),
(32, 7, 200.00, 1, '2023-12-20 02:05:00', '2023-12-20 02:05:00'),
(33, 8, 200.00, 1, '2023-12-20 02:05:37', '2023-12-20 02:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `service_time`
--

CREATE TABLE `service_time` (
  `id` bigint UNSIGNED NOT NULL,
  `fromtime` time NOT NULL,
  `totime` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_time`
--

INSERT INTO `service_time` (`id`, `fromtime`, `totime`, `created_at`, `updated_at`) VALUES
(1, '01:00:00', '22:00:00', NULL, '2022-03-11 02:10:50');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `id` bigint UNSIGNED NOT NULL,
  `tax` double(15,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`id`, `tax`, `created_at`, `updated_at`) VALUES
(2, 0.080, '2022-07-18 18:15:17', '2022-07-18 18:15:17'),
(3, 0.100, '2022-07-18 18:15:23', '2022-07-18 18:15:23');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '本', '2022-02-12 16:48:30', '2022-02-12 16:48:30', NULL),
(2, 'kg', '2022-02-12 16:48:36', '2022-02-12 16:48:36', NULL),
(3, 'L', '2022-02-12 16:48:40', '2022-02-12 16:48:40', NULL),
(4, 'g', '2022-02-13 17:32:19', '2022-02-13 17:32:19', NULL),
(5, 't', '2022-03-02 03:26:04', '2022-03-02 03:26:04', NULL),
(6, 'gae', '2022-03-10 03:05:29', '2022-03-10 03:05:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int NOT NULL DEFAULT '0',
  `is_verified` int NOT NULL DEFAULT '1',
  `fcm_token` longtext COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_image`, `type`, `is_verified`, `fcm_token`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$8Dag5L3tcN0UdM5.seG4zOHfUgCazpn4Q0NiAGPpSH3qt2KhJHs1.', 'unknown.png', 1, 1, NULL, NULL, '2022-02-13 01:45:51', '2022-02-13 01:45:51', NULL),
(2, 'seller1', 'seller1@gmail.com', '$2y$10$BB0WtzBx.86vMTet8xAVaucQhZ/9HRG3ZGMqaaZwLwEaBiBGHVrNy', NULL, 2, 1, NULL, NULL, '2022-02-13 01:46:21', '2022-07-19 10:56:54', NULL),
(3, 'seller2', 'seller2@gmail.com', '$2y$10$Fya1jFVOJ5RDZjlkfaIyFuLHKm26blDP00jHkXvq404eyGdIjzRIG', NULL, 2, 1, NULL, NULL, '2022-02-13 01:46:21', '2022-03-08 06:28:25', NULL),
(4, 'sug424', 'sug424@gmail.com', '$2y$10$8Dag5L3tcN0UdM5.seG4zOHfUgCazpn4Q0NiAGPpSH3qt2KhJHs1.', 'unknown.png', 0, 1, NULL, NULL, '2022-02-12 16:53:33', '2022-03-03 09:00:35', NULL),
(14, 'jhs1124', 'jhs1124@gmail.com', '$2y$10$t8Z39qlJ1CdTu9C5Es0K.epCd5W52B9r39IzGNK76/.M2MgwY27Cm', 'unknown.png', 0, 1, NULL, NULL, '2022-03-01 11:36:29', '2022-03-01 11:36:29', NULL),
(15, 'rjs75', 'rjs75@gmail.com', '$2y$10$fm9UC.UW0UkTgwXylO/ZFeaNFLMUl77pdsNYHgyycJZGzn1AiQYMK', 'unknown.png', 0, 1, NULL, NULL, '2022-03-01 13:09:19', '2022-03-01 13:09:19', NULL),
(16, 'jsc670312', 'jsc670312@gmail.com', '$2y$10$xYx3GavnjQNIDimJDMD/8OZe2bG732YHOsuMzfLP.8OSROCowOICK', 'unknown.png', 0, 1, NULL, NULL, '2022-03-01 13:35:26', '2022-03-01 13:35:26', NULL),
(18, 'test', 'test@gmail.com', '$2y$10$F5575qEh1KVgSvwrESX0du9TRGSeU.HocDg2bcph4QgQ6BOZ/pHKS', 'unknown.png', 2, 1, NULL, NULL, '2022-03-04 08:11:33', '2022-07-15 09:26:49', NULL),
(19, 'rim0128', 'rim0128@gmail.com', '$2y$10$ZhZ6LZRSskXfYcgpCRTYvOA/J3dHObAJvhyZLwFICby69OwVDOSSu', 'unknown.png', 0, 1, NULL, NULL, '2022-03-10 09:16:54', '2022-03-10 09:16:54', NULL),
(20, 'Justin Talbott', 'zzz.wolf.justin@gmail.com', '$2y$10$61nt9YNpKABso4hj9wEY0.Ms3HcYd3.MogRyabBzOSJfExV7aOTGS', NULL, 0, 1, NULL, NULL, '2023-03-09 01:35:41', '2023-03-09 01:35:41', NULL),
(21, 'bee', 'star.golden.bee@gmail.com', '$2y$10$P2YQ26n4jJIYj1EO1zp4g.NiyDIoy6IsVTuD8.345cW0SBoY30yV6', NULL, 0, 1, NULL, NULL, '2023-03-09 01:35:57', '2023-03-09 01:35:57', NULL),
(22, 'kimura', 'zzz.justin.kimura@gmail.com', '$2y$10$TQPeDCYj6HLn21qTkillBe1UjOKcsn52/sDJtEszSaQEKYzG11WMm', NULL, 0, 1, NULL, NULL, '2023-03-09 01:36:12', '2023-03-09 01:36:12', NULL),
(23, 'sielvory', 'seilivory007@gmail.com', '$2y$10$/lAPegPUaKuZMo2w4TtS8OcxeYHuAhVt3NzooUEbn0WR7Hv5gUj6O', NULL, 0, 1, NULL, NULL, '2023-03-09 01:36:54', '2023-03-09 22:14:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wholesales`
--

CREATE TABLE `wholesales` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `wholesale` double(15,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wholesales`
--

INSERT INTO `wholesales` (`id`, `product_id`, `wholesale`, `is_available`, `created_at`, `updated_at`) VALUES
(27, 1, 150.00, 1, '2023-12-20 00:40:11', '2023-12-20 00:40:11'),
(28, 2, 230.00, 1, '2023-12-20 00:51:03', '2023-12-20 00:51:03'),
(29, 3, 130.00, 1, '2023-12-20 00:54:20', '2023-12-20 00:54:20'),
(30, 4, 400.00, 1, '2023-12-20 02:01:08', '2023-12-20 02:01:08'),
(31, 5, 580.00, 1, '2023-12-20 02:02:13', '2023-12-20 02:02:13'),
(32, 6, 150.00, 1, '2023-12-20 02:03:56', '2023-12-20 02:03:56'),
(33, 7, 150.00, 1, '2023-12-20 02:05:00', '2023-12-20 02:05:00'),
(34, 8, 150.00, 1, '2023-12-20 02:05:37', '2023-12-20 02:05:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_user_id_foreign` (`user_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conversations_unique_unique` (`unique`),
  ADD KEY `user_one` (`user_one`),
  ADD KEY `user_two` (`user_two`);

--
-- Indexes for table `delivery_method`
--
ALTER TABLE `delivery_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_user_id_foreign` (`user_id`),
  ADD KEY `favorites_product_id_foreign` (`product_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_product_id_foreign` (`product_id`);

--
-- Indexes for table `irregular_comments`
--
ALTER TABLE `irregular_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `irregular_comments_cart_id_foreign` (`cart_id`);

--
-- Indexes for table `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medias_product_id_foreign` (`product_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_categories`
--
ALTER TABLE `news_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_categories_name_unique` (`name`);

--
-- Indexes for table `news_contents`
--
ALTER TABLE `news_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_contents_title_id_foreign` (`title_id`);

--
-- Indexes for table `news_titles`
--
ALTER TABLE `news_titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_titles_category_id_foreign` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_address_id_foreign` (`address_id`),
  ADD KEY `orders_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_user_id_foreign` (`user_id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`),
  ADD KEY `order_details_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_name_unique` (`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_pcategory_id_foreign` (`pcategory_id`),
  ADD KEY `products_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `profits`
--
ALTER TABLE `profits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profits_order_id_foreign` (`order_id`);

--
-- Indexes for table `purse`
--
ALTER TABLE `purse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purse_user_id_foreign` (`user_id`);

--
-- Indexes for table `read_news`
--
ALTER TABLE `read_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `read_news_title_id_foreign` (`title_id`),
  ADD KEY `read_news_user_id_foreign` (`user_id`);

--
-- Indexes for table `retailsales`
--
ALTER TABLE `retailsales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `retailsales_product_id_foreign` (`product_id`);

--
-- Indexes for table `service_time`
--
ALTER TABLE `service_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_name_unique` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wholesales`
--
ALTER TABLE `wholesales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wholesales_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `delivery_method`
--
ALTER TABLE `delivery_method`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `irregular_comments`
--
ALTER TABLE `irregular_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `medias`
--
ALTER TABLE `medias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=323;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `news_categories`
--
ALTER TABLE `news_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `news_contents`
--
ALTER TABLE `news_contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `news_titles`
--
ALTER TABLE `news_titles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `profits`
--
ALTER TABLE `profits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `purse`
--
ALTER TABLE `purse`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `read_news`
--
ALTER TABLE `read_news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retailsales`
--
ALTER TABLE `retailsales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `service_time`
--
ALTER TABLE `service_time`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `wholesales`
--
ALTER TABLE `wholesales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `irregular_comments`
--
ALTER TABLE `irregular_comments`
  ADD CONSTRAINT `irregular_comments_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medias`
--
ALTER TABLE `medias`
  ADD CONSTRAINT `medias_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news_contents`
--
ALTER TABLE `news_contents`
  ADD CONSTRAINT `news_contents_title_id_foreign` FOREIGN KEY (`title_id`) REFERENCES `news_titles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news_titles`
--
ALTER TABLE `news_titles`
  ADD CONSTRAINT `news_titles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_pcategory_id_foreign` FOREIGN KEY (`pcategory_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profits`
--
ALTER TABLE `profits`
  ADD CONSTRAINT `profits_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purse`
--
ALTER TABLE `purse`
  ADD CONSTRAINT `purse_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `read_news`
--
ALTER TABLE `read_news`
  ADD CONSTRAINT `read_news_title_id_foreign` FOREIGN KEY (`title_id`) REFERENCES `news_titles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `read_news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `retailsales`
--
ALTER TABLE `retailsales`
  ADD CONSTRAINT `retailsales_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wholesales`
--
ALTER TABLE `wholesales`
  ADD CONSTRAINT `wholesales_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
