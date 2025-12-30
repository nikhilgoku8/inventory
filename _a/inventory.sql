-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 30, 2025 at 09:11 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `role`, `last_login`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$12$vJUO/MhzIeJPm3G8aUgTr.PUhx1niBfYfw8vq3Z8Teb1FPiJ5HOX.', 'superadmin', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `title`, `sort_order`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'Color', 0, 'Admin', 'Admin', '2025-12-23 01:06:48', '2025-12-24 03:29:32'),
(3, 'Shape', 0, 'Admin', 'Admin', '2025-12-23 01:06:53', '2025-12-24 03:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_values`
--

CREATE TABLE `attribute_values` (
  `id` bigint UNSIGNED NOT NULL,
  `attribute_id` bigint UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_values`
--

INSERT INTO `attribute_values` (`id`, `attribute_id`, `value`, `code`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 2, 'Red', 'RED', 'Admin', 'Admin', '2025-12-23 01:34:28', '2025-12-24 03:41:36'),
(5, 3, 'Round', 'RND', 'Admin', 'Admin', '2025-12-23 01:34:55', '2025-12-24 03:32:07'),
(7, 2, 'Green', 'GRN', 'Admin', 'Admin', '2025-12-24 03:31:28', '2025-12-24 03:31:58'),
(8, 3, 'Rectangle', 'RECTANGLE', 'Admin', 'Admin', '2025-12-24 03:32:35', '2025-12-24 03:32:35'),
(9, 2, 'White', 'WHT', 'Admin', 'Admin', '2025-12-24 03:42:02', '2025-12-24 03:42:02'),
(10, 2, 'Black', 'BLK', 'Admin', 'Admin', '2025-12-24 03:42:25', '2025-12-24 03:42:25'),
(11, 2, 'Blue', 'BLU', 'Admin', 'Admin', '2025-12-24 03:42:38', '2025-12-24 03:42:38'),
(12, 2, 'Yellow', 'YEL', 'Admin', 'Admin', '2025-12-24 03:43:11', '2025-12-24 03:43:11'),
(13, 2, 'Orange', 'ORG', 'Admin', 'Admin', '2025-12-24 03:43:23', '2025-12-24 03:43:23'),
(14, 2, 'Pink', 'PNK', 'Admin', 'Admin', '2025-12-24 03:43:36', '2025-12-24 03:43:36'),
(15, 2, 'Purple', 'PRP', 'Admin', 'Admin', '2025-12-24 03:43:49', '2025-12-24 03:43:49'),
(16, 2, 'Brown', 'BRN', 'Admin', 'Admin', '2025-12-24 03:44:05', '2025-12-24 03:44:05'),
(17, 2, 'Grey / Gray', 'GRY', 'Admin', 'Admin', '2025-12-24 03:51:20', '2025-12-24 03:51:20'),
(18, 2, 'Navy Blue', 'NVY', 'Admin', 'Admin', '2025-12-24 03:51:33', '2025-12-24 03:51:33'),
(19, 2, 'Maroon', 'MRN', 'Admin', 'Admin', '2025-12-24 03:51:44', '2025-12-24 03:51:44'),
(20, 2, 'Beige', 'BEG', 'Admin', 'Admin', '2025-12-24 03:51:54', '2025-12-24 03:51:54'),
(21, 2, 'Cream', 'CRM', 'Admin', 'Admin', '2025-12-24 03:52:04', '2025-12-24 03:52:04'),
(22, 2, 'Gold', 'GLD', 'Admin', 'Admin', '2025-12-24 03:52:13', '2025-12-24 03:52:13'),
(23, 2, 'Silver', 'SLV', 'Admin', 'Admin', '2025-12-24 03:52:22', '2025-12-24 03:52:22'),
(40, 2, 'Tricolor', 'TRC', 'Admin', 'Admin', '2025-12-24 06:51:28', '2025-12-24 06:51:28');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Clothing', 'clothing', NULL, NULL, '2025-12-22 07:32:37', '2025-12-22 07:44:33'),
(2, 'Accesories', 'accesories', NULL, NULL, '2025-12-22 07:32:43', '2025-12-22 07:44:40'),
(3, 'Bags & Utility', 'bags-and-utility', NULL, 'Admin', '2025-12-22 07:32:47', '2025-12-23 05:15:54'),
(4, 'Home & Office Decor', 'home-and-office-decor', 'Admin', 'Admin', '2025-12-23 05:16:07', '2025-12-23 05:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_movements`
--

CREATE TABLE `inventory_movements` (
  `id` bigint UNSIGNED NOT NULL,
  `sku_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `movement_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2025_12_19_090740_create_admins_table', 1),
(2, '2025_12_19_090741_create_categories_table', 1),
(3, '2025_12_19_090750_create_sub_categories_table', 1),
(4, '2025_12_19_090800_create_products_table', 1),
(5, '2025_12_19_090810_create_skus_table', 1),
(6, '2025_12_19_090811_create_sku_bundles_table', 1),
(7, '2025_12_19_090825_create_attributes_table', 1),
(8, '2025_12_19_090829_create_attribute_values_table', 1),
(9, '2025_12_19_090830_create_sku_attributes_table', 1),
(10, '2025_12_19_091206_create_inventory_movements_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `sub_category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sub_category_id`, `title`, `slug`, `image`, `description`, `code`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Polo Neck T-shirts', 'polo-neck-t-shirts', 'test_694a722314682_20251223104243.png', NULL, 'PNTS', 'Admin', 'Admin', '2025-12-23 00:38:41', '2025-12-23 05:22:23'),
(2, 1, 'Round Neck T-shirt', 'round-neck-t-shirt', 'round-neck-t-shirt_694a761d674bc_20251223105941.png', NULL, 'RNTS', 'Admin', 'Admin', '2025-12-23 00:39:23', '2025-12-23 05:29:41'),
(3, 1, 'Polo Neck with Tricolor T-shirts', 'polo-neck-with-tricolor-t-shirts', 'polo-neck-with-tricolor-t-shirts_694a74ad7209e_20251223105333.png', NULL, 'PNTTS', 'Admin', 'Admin', '2025-12-23 05:23:33', '2025-12-23 05:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `skus`
--

CREATE TABLE `skus` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int DEFAULT NULL,
  `stock` int NOT NULL,
  `is_bundle` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skus`
--

INSERT INTO `skus` (`id`, `product_id`, `sku_code`, `barcode`, `image`, `price`, `stock`, `is_bundle`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, 1, 'PNTS-RED', 'polo-neck-t-shirts_barcode_6952798210ad5_20251229125218.png', 'polo-neck-t-shirts_695279820f3a3_20251229125218.png', 1, 12, 0, 'Admin', 'Admin', '2025-12-29 07:22:18', '2025-12-29 07:22:18'),
(8, 1, 'PNTS-GRN', 'polo-neck-t-shirts_barcode_69527af0c38e6_20251229125824.png', 'polo-neck-t-shirts_69527af0c140a_20251229125824.png', 1, 12, 0, 'Admin', 'Admin', '2025-12-29 07:28:24', '2025-12-29 07:28:24'),
(11, 1, 'PNTS-GRN-RND', 'polo-neck-t-shirts_barcode_69527ba29b574_20251229010122.png', 'polo-neck-t-shirts_69527ba29a604_20251229010122.png', 1, 12, 0, 'Admin', 'Admin', '2025-12-29 07:31:22', '2025-12-29 07:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `sku_attributes`
--

CREATE TABLE `sku_attributes` (
  `id` bigint UNSIGNED NOT NULL,
  `sku_id` bigint UNSIGNED NOT NULL,
  `attribute_value_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sku_attributes`
--

INSERT INTO `sku_attributes` (`id`, `sku_id`, `attribute_value_id`, `created_at`, `updated_at`) VALUES
(2, 5, 3, '2025-12-29 07:22:18', '2025-12-29 07:22:18'),
(3, 8, 7, '2025-12-29 07:28:24', '2025-12-29 07:28:24'),
(4, 11, 5, '2025-12-29 07:31:22', '2025-12-29 07:31:22'),
(5, 11, 7, '2025-12-29 07:31:22', '2025-12-29 07:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `sku_bundles`
--

CREATE TABLE `sku_bundles` (
  `id` bigint UNSIGNED NOT NULL,
  `bundle_sku_id` bigint UNSIGNED NOT NULL,
  `child_sku_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `title`, `slug`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'T-Shirts', 't-shirts', 'Admin', 'Admin', '2025-12-22 07:32:52', '2025-12-23 05:16:32'),
(2, 1, 'Sarees', 'sarees', 'Admin', 'Admin', '2025-12-22 07:32:57', '2025-12-23 05:16:40'),
(3, 1, 'Stoles', 'stoles', 'Admin', 'Admin', '2025-12-22 07:33:01', '2025-12-23 05:16:46'),
(4, 2, 'Badges', 'badges', 'Admin', 'Admin', '2025-12-22 07:33:07', '2025-12-23 05:17:01'),
(6, 3, 'Bags', 'bags', 'Admin', 'Admin', '2025-12-22 07:33:15', '2025-12-23 05:20:08'),
(8, 4, 'Bookmarks', 'bookmarks', 'Admin', 'Admin', '2025-12-23 05:17:51', '2025-12-23 05:17:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_values_attribute_id_foreign` (`attribute_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_movements_sku_id_foreign` (`sku_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `skus`
--
ALTER TABLE `skus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `skus_sku_code_unique` (`sku_code`),
  ADD KEY `skus_product_id_foreign` (`product_id`);

--
-- Indexes for table `sku_attributes`
--
ALTER TABLE `sku_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sku_attributes_sku_id_foreign` (`sku_id`),
  ADD KEY `sku_attributes_attribute_value_id_foreign` (`attribute_value_id`);

--
-- Indexes for table `sku_bundles`
--
ALTER TABLE `sku_bundles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sku_bundles_bundle_sku_id_foreign` (`bundle_sku_id`),
  ADD KEY `sku_bundles_child_sku_id_foreign` (`child_sku_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attribute_values`
--
ALTER TABLE `attribute_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skus`
--
ALTER TABLE `skus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sku_attributes`
--
ALTER TABLE `sku_attributes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sku_bundles`
--
ALTER TABLE `sku_bundles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD CONSTRAINT `attribute_values_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD CONSTRAINT `inventory_movements_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `skus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `skus`
--
ALTER TABLE `skus`
  ADD CONSTRAINT `skus_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sku_attributes`
--
ALTER TABLE `sku_attributes`
  ADD CONSTRAINT `sku_attributes_attribute_value_id_foreign` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sku_attributes_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `skus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sku_bundles`
--
ALTER TABLE `sku_bundles`
  ADD CONSTRAINT `sku_bundles_bundle_sku_id_foreign` FOREIGN KEY (`bundle_sku_id`) REFERENCES `skus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sku_bundles_child_sku_id_foreign` FOREIGN KEY (`child_sku_id`) REFERENCES `skus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
